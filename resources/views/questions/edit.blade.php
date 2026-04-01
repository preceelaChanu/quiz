<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Edit Question</h1>
            <a href="{{ route('quizzes.show', $quiz->id) }}" class="text-gray-500 hover:underline">Cancel</a>
        </div>

        <form action="{{ route('quizzes.questions.update', [$quiz->id, $question->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Question Type</label>
                    <input type="text" value="{{ str_replace('_', ' ', $question->type) }}" class="w-full border p-2 rounded bg-gray-100 text-gray-500 uppercase" readonly>
                    <input type="hidden" name="type" value="{{ $question->type }}">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Marks</label>
                    <input type="number" name="marks" value="{{ $question->marks }}" min="1" class="w-full border p-2 rounded" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Question Content</label>
                <textarea name="content" rows="4" class="w-full border p-2 rounded" required>{{ $question->content }}</textarea>
            </div>

            <hr class="my-6">

            <div class="mb-4">
                <h2 class="text-xl font-bold mb-4">Update Options / Answer</h2>
                <div class="space-y-4">
                    @foreach($question->options as $index => $option)
                        <div class="flex items-center gap-4 p-3 border rounded bg-white shadow-sm">
                            <div class="flex flex-col items-center justify-center bg-blue-50 p-2 rounded border border-blue-200">
                                <label class="text-[10px] font-black text-blue-800 tracking-wider mb-1 uppercase">Correct?</label>
                                <input type="{{ $question->type === 'multiple_choice' ? 'checkbox' : 'radio' }}" 
                                       name="options[{{ $index }}][is_correct]" 
                                       value="1" 
                                       class="w-5 h-5 accent-blue-600"
                                       {{ $option->is_correct ? 'checked' : '' }}>
                            </div>
                            <input type="text" name="options[{{ $index }}][text]" value="{{ $option->option_text }}" class="flex-1 border-gray-300 p-2 rounded">
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="mt-8 bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 font-bold w-full">
                Update Question
            </button>
        </form>
    </div>
    <script>
        // Ensure only one radio button can be checked at a time
        document.addEventListener('change', function(e) {
            if (e.target.type === 'radio') {
                document.querySelectorAll('input[type="radio"]').forEach(radio => {
                    if (radio !== e.target) {
                        radio.checked = false;
                    }
                });
            }
        });
    </script>
</body>
</html>