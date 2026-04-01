# System Architecture & Design Decisions

This document outlines the architectural decisions, data modeling strategies, and evaluation logic implemented in the Laravel Dynamic Quiz System. [cite_start]The primary goal of this architecture is to fulfill the core constraints: ensuring the system is highly extensible for future question types and strictly avoiding hardcoded evaluation logic scattered across multiple locations[cite: 42, 43].

## 1. Data Modeling Strategy: The Unified Schema Approach

[cite_start]To support multiple, distinct question types (Binary, Single Choice, Multiple Choice, Number Input, Text Input) [cite: 14-19] without creating a fragmented database, this application utilizes a **Unified Schema**. 

Instead of relying on polymorphic tables or creating separate database tables for every specific question type (e.g., `text_questions`, `multiple_choice_questions`), all questions and options share the same structural foundation.

* **`questions` Table:** Acts as the single source of truth. It utilizes a standardized `type` string column to define its behavior.
* **`options` Table:** This table acts dynamically based on its parent question's `type`. 
    * For selection-based questions (Single Choice, Multiple Choice, Binary), it stores the selectable choices and a boolean `is_correct` flag.
    * For input-based questions (Text Input, Number Input), a single record in the `options` table stores the exact correct text or numerical value expected from the user.
* **`answers` Table:** Bridges the user's `attempt` with the `question`. It contains both an `option_id` (for selected answers) and an `input_value` text column (to capture typed text or numbers).

### Why this satisfies Extensibility Constraints:
[cite_start]If a new question type (e.g., "Fill in the Blanks" or "Matching") needs to be added in the future, **zero database migrations are required**. A developer simply needs to add the new string to the frontend dropdown, create the corresponding HTML input in the Blade view, and add one new case to the centralized evaluation engine.

## 2. Centralized Evaluation Logic

[cite_start]A strict constraint of this project was to "avoid hardcoded logic for each type in multiple places". 

To solve this, the application isolates the entire evaluation engine strictly within the `AttemptController@store` method. It operates as a single source of truth using a structured `switch` statement based on `$question->type`. 

* **Binary / Single Choice:** Verifies if the user's submitted `option_id` matches the database option flagged as `is_correct`.
* **Multiple Choice:** Extracts all correct option IDs into an array, sorts them, and compares them against the user's submitted array of IDs. This strict comparison ensures the user selected *all* correct options and *zero* incorrect options.
* **Text / Number Input:** Performs a case-insensitive, whitespace-trimmed string comparison (`strcasecmp`) against the stored correct value in the `options` table.

This architecture keeps the codebase DRY (Don't Repeat Yourself). Adding a new evaluation rule for future question types is incredibly localized, safe, and prevents the fragmentation of grading logic across the application.

## 3. Media and Asset Management

[cite_start]Following the technical requirements, all uploaded images are stored locally using Laravel's public storage disk (`storage/app/public`)[cite: 9, 22]. [cite_start]Video URLs (such as YouTube links) are stored as simple text strings within the `media_url` column on both the `questions` and `options` tables [cite: 23-25]. The frontend Blade views conditionally render either an `<img>` tag or an `<a>`/`<iframe>` tag depending on the presence and format of this URL.