<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">

        <div class="text-center border-b pb-6 mb-6">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Quiz Complete!</h1>
            <p class="text-xl text-gray-600">You scored</p>
            <div
                class="mt-4 text-5xl font-black {{ $attempt->total_score >= ($maxPossibleScore / 2) ? 'text-green-600' : 'text-red-600' }}">
                {{ $attempt->total_score }} / {{ $maxPossibleScore }}
            </div>
        </div>

        <h2 class="text-2xl font-bold mb-4 text-gray-800">Review Your Answers</h2>

        <div class="space-y-6">
            @foreach($attempt->answers as $index => $answer)
                <div
                    class="p-4 border rounded-lg {{ $answer->is_correct ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">

                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-semibold text-lg text-gray-800">
                            Q{{ $index + 1 }}. {!! $answer->question->content !!}
                        </h3>
                        <span class="font-bold {{ $answer->is_correct ? 'text-green-600' : 'text-red-600' }}">
                            {{ $answer->marks_awarded }} / {{ $answer->question->marks }} Marks
                        </span>
                    </div>

                    <div class="mt-2 text-sm text-gray-700">
                        @if($answer->is_correct)
                            <p class="text-green-700 font-bold flex items-center">
                                <svg style="width: 20px; height: 20px;" class="mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Correct
                            </p>
                        @else
                            <p class="text-red-700 font-bold flex items-center">
                                <svg style="width: 20px; height: 20px;" class="mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Incorrect
                            </p>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('quizzes.index') }}" class="text-blue-600 hover:underline font-semibold">Back to
                Quizzes</a>
        </div>

    </div>
</body>

</html>