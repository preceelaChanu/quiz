<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Create a New Quiz</h1>

        <form action="{{ route('quizzes.store') }}" method="POST">
            @csrf <div class="mb-4">
                <label for="title" class="block text-gray-700 font-bold mb-2">Quiz Title</label>
                <input type="text" name="title" id="title" class="w-full border-gray-300 rounded-md shadow-sm border p-2" required>
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 font-bold mb-2">Description (Optional)</label>
                <textarea name="description" id="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm border p-2"></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                Save Quiz & Continue
            </button>
        </form>
    </div>
</body>
</html>