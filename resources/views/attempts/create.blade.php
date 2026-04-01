<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Quiz: {{ $quiz->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
        
        <div class="border-b pb-4 mb-6 text-center">
            <h1 class="text-3xl font-bold text-gray-800">{{ $quiz->title }}</h1>
            <p class="text-gray-600 mt-2">{{ $quiz->description }}</p>
        </div>

        <form action="{{ route('quizzes.submit', $quiz->id) }}" method="POST">
            @csrf

            <div class="space-y-8">
                @foreach($quiz->questions as $index => $question)
                    <div class="p-6 bg-gray-50 border rounded-lg shadow-sm">
                        
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">
                                {{ $index + 1 }}. {!! $question->content !!}
                            </h3>
                            <span class="text-sm text-gray-500 font-bold bg-gray-200 px-2 py-1 rounded">
                                {{ $question->marks }} Mark(s)
                            </span>
                        </div>

                        @if($question->media_url)
                            <div class="mb-4">
                                @if(Str::contains($question->media_url, ['youtube.com', 'youtu.be']))
                                    <a href="{{ $question->media_url }}" target="_blank" class="text-blue-500 underline">View Attached Video</a>
                                @else
                                    <img src="{{ asset('storage/' . $question->media_url) }}" alt="Question Image" class="max-h-64 rounded-md shadow">
                                @endif
                            </div>
                        @endif

                        <div class="mt-4 space-y-3">
                            @switch($question->type)
                                @case('single_choice')
                                @case('binary')
                                    @foreach($question->options as $option)
                                        <label class="flex items-center space-x-3 p-3 border rounded bg-white hover:bg-blue-50 cursor-pointer transition">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" class="w-5 h-5 text-blue-600" required>
                                            <span class="text-gray-700 font-medium">{{ $option->option_text }}</span>
                                            @if($option->media_url)
                                                <img src="{{ asset('storage/' . $option->media_url) }}" class="h-10 ml-4 rounded">
                                            @endif
                                        </label>
                                    @endforeach
                                    @break

                                @case('multiple_choice')
                                    <p class="text-sm text-gray-500 mb-2 italic">Select all that apply.</p>
                                    @foreach($question->options as $option)
                                        <label class="flex items-center space-x-3 p-3 border rounded bg-white hover:bg-blue-50 cursor-pointer transition">
                                            <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option->id }}" class="w-5 h-5 text-blue-600">
                                            <span class="text-gray-700 font-medium">{{ $option->option_text }}</span>
                                        </label>
                                    @endforeach
                                    @break

                                @case('text_input')
                                    <input type="text" name="answers[{{ $question->id }}]" class="w-full border-gray-300 rounded-md shadow-sm border p-3" placeholder="Type your answer..." required>
                                    @break

                                @case('number_input')
                                    <input type="number" name="answers[{{ $question->id }}]" step="any" class="w-full border-gray-300 rounded-md shadow-sm border p-3" placeholder="Enter a number..." required>
                                    @break
                            @endswitch
                        </div>

                    </div>
                @endforeach
            </div>

            <button type="submit" class="mt-8 bg-green-600 text-white px-8 py-3 rounded-lg shadow hover:bg-green-700 font-bold w-full text-lg">
                Submit Quiz
            </button>
        </form>

    </div>
</body>
</html>