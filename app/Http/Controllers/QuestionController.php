<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController
{
    public function create(Quiz $quiz)
    {
        // Show the form to add a question
        return view('questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        // 1. Validate the basic question data
        $validated = $request->validate([
            'type' => 'required|string|in:binary,single_choice,multiple_choice,number_input,text_input',
            'content' => 'required|string',
            'marks' => 'required|integer|min:1',
            'media' => 'nullable|file|image|max:2048',
            'media_url' => 'nullable|url',
        ]);

        // 2. Handle Question Media Upload
        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('question_media', 'public');
        } elseif ($request->filled('media_url')) {
            $mediaPath = $request->media_url;
        }

        // 3. Create the Question
        $question = $quiz->questions()->create([
            'type' => $validated['type'],
            'content' => $validated['content'],
            'marks' => $validated['marks'],
            'media_url' => $mediaPath,
        ]);

        // 4. Handle the dynamic Options
        if ($request->has('options')) {
            foreach ($request->options as $index => $optionData) {
                $optionMediaPath = null;

                if ($request->hasFile("options.{$index}.media")) {
                    $optionMediaPath = $request->file("options.{$index}.media")->store('option_media', 'public');
                }

                $question->options()->create([
                    'option_text' => $optionData['text'] ?? null,
                    'media_url' => $optionMediaPath,
                    'is_correct' => isset($optionData['is_correct']) ? true : false,
                ]);
            }
        }

        return redirect()->route('quizzes.show', $quiz)
            ->with('success', 'Question added successfully!');
    }

    public function edit(Quiz $quiz, Question $question)
    {
        // Load the question and its options for the edit form
        $question->load('options');
        return view('questions.edit', compact('quiz', 'question'));
    }

    public function update(Request $request, Quiz $quiz, Question $question)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'content' => 'required|string',
            'marks' => 'required|integer|min:1',
            'media' => 'nullable|file|image|max:2048',
            'media_url' => 'nullable|url',
        ]);

        // Update Media if new file is uploaded
        if ($request->hasFile('media')) {
            $validated['media_url'] = $request->file('media')->store('question_media', 'public');
        } elseif ($request->filled('media_url')) {
            $validated['media_url'] = $request->media_url;
        } else {
            // Keep existing media if nothing new is provided
            $validated['media_url'] = $question->media_url;
        }

        $question->update([
            'type' => $validated['type'],
            'content' => $validated['content'],
            'marks' => $validated['marks'],
            'media_url' => $validated['media_url'],
        ]);

        // To handle dynamic options simply: wipe old ones and save the new ones
        if ($request->has('options')) {
            $question->options()->delete();

            foreach ($request->options as $index => $optionData) {
                $question->options()->create([
                    'option_text' => $optionData['text'] ?? null,
                    'is_correct' => isset($optionData['is_correct']) ? true : false,
                ]);
            }
        }

        return redirect()->route('quizzes.show', $quiz)
            ->with('success', 'Question updated successfully!');
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        $question->delete();
        return redirect()->route('quizzes.show', $quiz)
            ->with('success', 'Question deleted successfully!');
    }
}