<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        // Fetch all quizzes, latest first
        $quizzes = Quiz::latest()->get();
        return view('quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        // Show the form to create a new quiz
        return view('quizzes.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Save it to the database
        $quiz = Quiz::create($validated);

        // Redirect to the quiz details page
        return redirect()->route('quizzes.show', $quiz)
                         ->with('success', 'Quiz created successfully! Now add some questions.');
    }

    public function show(Quiz $quiz)
    {
        // Load the quiz and its questions
        $quiz->load('questions.options');
        return view('quizzes.show', compact('quiz'));
    }

    public function destroy(Quiz $quiz)
    {
        // Because we set up 'cascadeOnDelete' in our database migrations,
        // deleting this quiz automatically deletes all its questions, options, and attempts!
        $quiz->delete();
        
        return redirect()->route('quizzes.index')
                         ->with('success', 'Quiz deleted successfully!');
    }
}