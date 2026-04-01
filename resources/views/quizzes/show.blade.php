<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->title }} - Manage Quiz</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $quiz->title }}</h1>
                    <p class="text-gray-600 mt-2">{{ $quiz->description }}</p>
                </div>

                <div class="flex flex-col items-end space-y-3">
                    <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-2.5 py-0.5 rounded">Draft
                        Mode</span>
                    <a href="{{ route('quizzes.index') }}"
                        class="bg-blue-600 text-white px-5 py-2 rounded shadow hover:bg-blue-700 font-bold transition text-sm">
                        Save & Exit
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Questions</h2>
                <a href="{{ route('quizzes.questions.create', $quiz->id) }}"
                    class="bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600 transition">
                    + Add New Question
                </a>
            </div>

            @if($quiz->questions->isEmpty())
                <div class="text-center py-8 bg-gray-50 rounded border-2 border-dashed border-gray-300">
                    <p class="text-gray-500 italic">No questions added yet. Click the button above to start building your
                        quiz!</p>
                </div>
            @else
                <ul class="space-y-4">
                    @foreach($quiz->questions as $index => $question)
                        <li class="border border-gray-200 p-6 rounded-md bg-white hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="font-bold text-lg mr-2 text-blue-600">Q{{ $index + 1 }}.</span>
                                    <span class="text-gray-800 text-lg font-medium">{!! $question->content !!}</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span
                                        class="bg-gray-200 text-gray-700 text-xs font-bold px-3 py-1 rounded uppercase tracking-wider">
                                        {{ str_replace('_', ' ', $question->type) }}
                                    </span>

                                    <a href="{{ route('quizzes.questions.edit', [$quiz->id, $question->id]) }}"
                                        class="text-blue-500 hover:text-blue-700 font-semibold text-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('quizzes.questions.destroy', [$quiz->id, $question->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this question?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="mt-4 pl-8 border-l-2 border-gray-100 space-y-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Options & Answer Key
                                </p>
                                @foreach($question->options as $option)
                                    <div
                                        class="flex items-center text-sm {{ $option->is_correct ? 'text-green-700 font-bold bg-green-50 p-2 rounded border border-green-200 inline-flex pr-4' : 'text-gray-600 pl-2' }}">

                                        @if($option->is_correct)
                                            <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <span class="w-4 h-4 mr-2 inline-block border-2 border-gray-300 rounded-full"></span>
                                        @endif

                                        {{ $option->option_text }}
                                    </div><br>
                                @endforeach
                            </div>

                            <div class="mt-4 text-sm text-gray-500 font-semibold pl-8">
                                Points: {{ $question->marks }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>
</body>

</html>