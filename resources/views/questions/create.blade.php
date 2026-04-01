<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question to {{ $quiz->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Add New Question</h1>

        <form action="{{ route('quizzes.questions.store', $quiz->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Question Type</label>
                    <select name="type" id="question_type" class="w-full border p-2 rounded" onchange="renderOptionsUI()">
                        <option value="single_choice">Single Choice</option>
                        <option value="multiple_choice">Multiple Choice</option>
                        <option value="binary">Binary (True/False)</option>
                        <option value="text_input">Text Input</option>
                        <option value="number_input">Number Input</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Marks</label>
                    <input type="number" name="marks" value="1" min="1" class="w-full border p-2 rounded" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Question Content (Supports HTML)</label>
                <textarea name="content" rows="4" class="w-full border p-2 rounded" placeholder="What is the capital of France?" required></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 border rounded">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Upload Image (Optional)</label>
                    <input type="file" name="media" accept="image/*" class="w-full text-sm">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">OR Video URL (Optional)</label>
                    <input type="url" name="media_url" placeholder="https://youtube.com/..." class="w-full border p-2 rounded text-sm">
                </div>
            </div>

            <hr class="my-6">

            <div id="options_wrapper">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Options / Answer</h2>
                    <button type="button" id="add_option_btn" onclick="addOptionRow()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded text-sm font-bold">
                        + Add Option
                    </button>
                </div>
                
                <div id="options_container" class="space-y-4"></div>
            </div>

            <button type="submit" class="mt-8 bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 font-bold w-full">
                Save Question
            </button>
        </form>
    </div>

    <script>
        let optionCount = 0;

        function renderOptionsUI() {
            const type = document.getElementById('question_type').value;
            const container = document.getElementById('options_container');
            const addBtn = document.getElementById('add_option_btn');
            
            container.innerHTML = ''; // Clear current options
            optionCount = 0;

            if (type === 'binary') {
                addBtn.style.display = 'none';
                addBinaryOptions();
            } else if (type === 'text_input' || type === 'number_input') {
                addBtn.style.display = 'none';
                addInputOption(type);
            } else {
                addBtn.style.display = 'block';
                addOptionRow(); // Add one blank row by default
                addOptionRow(); // Add second blank row by default
            }
        }

        function addOptionRow() {
            const type = document.getElementById('question_type').value;
            const inputType = type === 'multiple_choice' ? 'checkbox' : 'radio';
            
            const html = `
                <div class="flex items-center gap-4 p-3 border rounded bg-white shadow-sm hover:bg-gray-50 transition">
                    <div class="flex flex-col items-center justify-center bg-blue-50 p-2 rounded border border-blue-200">
                        <label class="text-[10px] font-black text-blue-800 tracking-wider mb-1 uppercase">Correct?</label>
                        <input type="${inputType}" name="options[${optionCount}][is_correct]" value="1" class="w-5 h-5 cursor-pointer accent-blue-600">
                    </div>
                    <input type="text" name="options[${optionCount}][text]" placeholder="Type option text here..." class="flex-1 border-gray-300 p-2 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    <input type="file" name="options[${optionCount}][media]" accept="image/*" class="w-48 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            `;
            document.getElementById('options_container').insertAdjacentHTML('beforeend', html);
            optionCount++;
        }

        function addBinaryOptions() {
            const options = ['True', 'False'];
            options.forEach((opt) => {
                const html = `
                    <div class="flex items-center gap-4 p-3 border rounded bg-white shadow-sm">
                        <div class="flex flex-col items-center justify-center bg-blue-50 p-2 rounded border border-blue-200">
                            <label class="text-[10px] font-black text-blue-800 tracking-wider mb-1 uppercase">Correct?</label>
                            <input type="radio" name="options[${optionCount}][is_correct]" value="1" class="w-5 h-5 cursor-pointer accent-blue-600">
                        </div>
                        <input type="text" name="options[${optionCount}][text]" value="${opt}" class="flex-1 border p-2 rounded bg-gray-100 font-bold text-gray-700" readonly>
                    </div>
                `;
                document.getElementById('options_container').insertAdjacentHTML('beforeend', html);
                optionCount++;
            });
        }

        function addInputOption(type) {
            const inputType = type === 'number_input' ? 'number' : 'text';
            const html = `
                <div class="flex items-center gap-4 p-3 border rounded border-green-400 bg-green-50 shadow-sm">
                    <span class="font-bold text-green-700">Correct Answer:</span>
                    <input type="hidden" name="options[0][is_correct]" value="1">
                    <input type="${inputType}" name="options[0][text]" placeholder="Type correct answer here..." class="flex-1 border p-2 rounded" required>
                </div>
            `;
            document.getElementById('options_container').innerHTML = html;
        }

        // Initialize UI on load
        renderOptionsUI();

        // Ensure only one radio button can be checked at a time for Single/Binary choices
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