<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Quizzes</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-5xl mx-auto">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">My Quizzes</h1>
            <a href="{{ route('quizzes.create') }}"
                class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 font-bold transition">
                + Create New Quiz
            </a>
        </div>

        @if($quizzes->isEmpty())
            <div class="bg-white p-12 text-center rounded-lg shadow-md border border-gray-200">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No quizzes</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new quiz.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($quizzes as $quiz)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                        <div class="p-6 flex-grow">
                            <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $quiz->title }}</h2>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $quiz->description ?: 'No description provided.' }}
                            </p>
                            <span class="inline-block bg-gray-100 rounded-full px-3 py-1 text-xs font-semibold text-gray-600">
                                {{ $quiz->questions()->count() }} Questions
                            </span>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 border-t flex justify-between items-center">
                            <div class="flex space-x-4 items-center">
                                <a href="{{ route('quizzes.show', $quiz) }}"
                                    class="text-blue-600 hover:text-blue-900 font-semibold text-sm">
                                    Manage
                                </a>

                                <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this entire quiz? All questions and attempts will be lost forever.');"
                                    class="m-0 p-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>

                            <a href="{{ route('quizzes.attempt', $quiz) }}"
                                class="bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600 text-sm font-bold transition">
                                Take Quiz
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</body>

</html>