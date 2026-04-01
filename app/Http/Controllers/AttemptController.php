<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Attempt;
use Illuminate\Http\Request;

class AttemptController
{
    public function create(Quiz $quiz)
    {
        // Load questions and their options
        $quiz->load('questions.options');

        // Optional: Shuffle the options so the correct answer isn't always in the same spot
        foreach ($quiz->questions as $question) {
            $question->setRelation('options', $question->options->shuffle());
        }

        return view('attempts.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $quiz->load('questions.options');
        $submittedAnswers = $request->input('answers', []);
        $totalScore = 0;

        // 1. Create the Attempt Record
        $attempt = $quiz->attempts()->create([
            'session_id' => session()->getId(),
            'total_score' => 0,
            'completed_at' => now(),
        ]);

        // 2. Evaluate Each Question
        foreach ($quiz->questions as $question) {
            $userAnswer = $submittedAnswers[$question->id] ?? null;
            $isCorrect = false;
            $marksAwarded = 0;
            $optionId = null;
            $inputValue = null;

            if ($userAnswer !== null) {
                switch ($question->type) {
                    case 'single_choice':
                    case 'binary':
                        $correctOption = $question->options->where('is_correct', true)->first();
                        if ($correctOption && $correctOption->id == $userAnswer) {
                            $isCorrect = true;
                        }
                        $optionId = $userAnswer;
                        break;

                    case 'multiple_choice':
                        // For multiple choice, they must select ALL correct options and NO incorrect ones.
                        $correctOptionIds = $question->options->where('is_correct', true)->pluck('id')->toArray();
                        $submittedArray = (array) $userAnswer;
                        
                        sort($correctOptionIds);
                        sort($submittedArray);

                        if ($correctOptionIds === $submittedArray) {
                            $isCorrect = true;
                        }
                        // Save the array of selected IDs as JSON since we only have one input_value column
                        $inputValue = json_encode($submittedArray);
                        break;

                    case 'text_input':
                    case 'number_input':
                        // For text/number, we stored the correct answer in the first option's text
                        $correctOption = $question->options->first();
                        // strcasecmp does a case-insensitive string comparison
                        if ($correctOption && strcasecmp(trim($correctOption->option_text), trim($userAnswer)) === 0) {
                            $isCorrect = true;
                        }
                        $inputValue = $userAnswer;
                        break;
                }
            }

            // 3. Assign Marks
            if ($isCorrect) {
                $marksAwarded = $question->marks;
                $totalScore += $marksAwarded;
            }

            // 4. Save the individual Answer record
            $attempt->answers()->create([
                'question_id' => $question->id,
                'option_id' => $optionId,
                'input_value' => $inputValue,
                'is_correct' => $isCorrect,
                'marks_awarded' => $marksAwarded,
            ]);
        }

        // 5. Update final score
        $attempt->update(['total_score' => $totalScore]);

        return redirect()->route('attempts.show', $attempt)
                         ->with('success', 'Quiz submitted successfully!');
    }

    public function show(Attempt $attempt)
    {
        // Load the attempt with all its answers, questions, and options
        $attempt->load('quiz', 'answers.question.options');
        
        // Calculate max possible score
        $maxPossibleScore = $attempt->quiz->questions->sum('marks');

        return view('attempts.show', compact('attempt', 'maxPossibleScore'));
    }
}
