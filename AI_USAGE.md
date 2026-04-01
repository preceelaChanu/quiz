# AI Usage & Prompt Engineering Documentation

[cite_start]This document provides a detailed log of the interactive collaboration between the developer and Google's Gemini 3 Flash to fulfill the requirements of the Dynamic Quiz System assignment. [cite: 48]

## 1. Executive Summary of AI Collaboration
The AI was utilized as a high-level architectural consultant and pair-programmer. The collaboration focused on three primary areas:
* [cite_start]**Architectural Design:** Engineering a database schema that avoids hardcoding logic for specific question types. [cite: 42-43]
* [cite_start]**Logic Implementation:** Developing a centralized evaluation engine for diverse inputs (selection vs. text). [cite: 30-33]
* [cite_start]**Debugging & UX Refinement:** Iteratively resolving environment-specific errors and enhancing administrative workflows. [cite: 58]

## 2. Formal Prompt Log

The following prompts were engineered to guide the AI in producing code that adheres to Laravel best practices and assignment constraints:

| Objective | Formal Prompt Description |
| :--- | :--- |
| **Initial Architecture** | [cite_start]"Design a Laravel-based database schema for a Quiz system supporting Binary, Single/Multiple Choice, and Text/Number inputs. Provide migrations and models for Quizzes, Questions, Options, Attempts, and Answers, ensuring the structure is highly extensible and avoids polymorphic fragmentation." [cite: 34-39, 41-43] |
| **Model Relationships** | "Define Eloquent relationships for the established models. Ensure 'Quiz' has many 'Questions', 'Questions' have many 'Options', and 'Attempts' capture granular 'Answer' data for evaluation." |
| **Dynamic Form Logic** | [cite_start]"Construct a Laravel Blade view for question creation. Include a JavaScript-driven dynamic UI that swaps input fields (e.g., Radio, Checkbox, Textarea) based on a selected 'Question Type' dropdown to ensure a seamless administrative experience." [cite: 20-25] |
| **Evaluation Engine** | [cite_start]"Develop a centralized evaluation method within the AttemptController. This method must process a variety of data types—array comparison for multiple choice and case-insensitive string comparison for text inputs—without hardcoding type-specific logic in external service providers." [cite: 30-33, 43] |
| **Administrative CRUD** | "Extend the existing QuizController and QuestionController to support full CRUD operations, specifically focusing on the 'Update' and 'Destroy' methods to allow administrators to correct data entry errors or remove obsolete quizzes." |

## 3. Error Resolution & Corrections

[cite_start]A critical component of the AI usage involved identifying and correcting technical hurdles encountered during the 2026 development cycle: [cite: 58]

* **Vite Integration:** Resolved a `ViteManifestNotFoundException` by identifying that the frontend asset compilation (`npm run dev`) needed to run in parallel with the backend server.
* **Namespace Conflicts:** Fixed a `FatalError` regarding class redeclaration by auditing the `AttemptController` and ensuring proper PHP namespace declarations were present.
* **Validation Logic:** Debugged a browser-level validation error where Binary (True/False) radio buttons were incorrectly marked as individual 'required' fields due to dynamic naming conventions.
* **UX Accessibility:** Refactored the "Single Choice" editor logic to include a JavaScript event listener, enforcing mutual exclusivity across radio buttons that shared dynamic array-based names.

## 4. Conclusion on AI depth
[cite_start]The use of AI allowed for a "Design-First" approach, where the underlying data modeling was stress-tested against the "Extensibility" requirement before a single line of frontend code was written. [cite: 54, 57] [cite_start]The resulting codebase is modular, follows modern Laravel standards, and fulfills all 2026 technical requirements. [cite: 5, 63]