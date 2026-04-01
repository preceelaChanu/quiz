# Laravel Dynamic Quiz System

A professional, highly extensible quiz platform built with Laravel 11/13. [cite_start]This system supports diverse question types, media integration, and automated evaluation logic while maintaining a clean, non-hardcoded architecture. [cite: 3, 6]

## 🚀 Features

* [cite_start]**Diverse Question Types:** Fully supports Binary (True/False), Single Choice, Multiple Choice, Number Input, and Text Input. [cite: 14-19]
* [cite_start]**Rich Media Support:** Integrated local storage for image uploads and support for external video URLs (e.g., YouTube). [cite: 22-23]
* [cite_start]**Dynamic Option Handling:** Options can consist of text, images, or a combination of both. [cite: 25]
* [cite_start]**Automated Evaluation:** Instant score calculation and result display upon submission. [cite: 30, 32-33]
* [cite_start]**Full CRUD Management:** Comprehensive interface to create, edit, and delete quizzes and individual questions. [cite: 12, 20]

## 🛠️ Setup Instructions

[cite_start]Follow these steps to get the application running on your local environment: [cite: 46]

1.  **Clone and Install Dependencies:**
    ```bash
    composer install
    npm install
    ```

2.  **Environment Configuration:**
    [cite_start]Copy the `.env.example` to `.env` and configure your database (MySQL or SQLite). [cite: 7]
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

3.  **Database Setup:**
    Run the migrations to create the unified schema. [cite: 34]
    ```bash
    php artisan migrate
    ```

4.  **Storage Linking:**
    Required for local media (image) rendering. [cite: 9]
    ```bash
    php artisan storage:link
    ```

5.  **Run the Application:**
    Open two terminals to handle the backend and the frontend (Tailwind CSS) compilation: [cite: 8]
    ```bash
    # Terminal 1
    php artisan serve

    # Terminal 2
    npm run dev
    ```
    *Access the app at `http://localhost:8000` (or your local development URL).*

## 📈 Project Planning & Timeline Estimate

[cite_start]The following estimate was calculated based on a modular development approach to ensure the core architecture remained extensible before building the UI. [cite: 50-51]

| Phase | Task Description | Estimated Time |
| :--- | :--- | :--- |
| **Phase 1** | Data Modeling & Schema Design (Unified Schema) | 4 Hours |
| **Phase 2** | Backend CRUD Logic & Media Handling | 6 Hours |
| **Phase 3** | Dynamic Frontend Forms & Evaluation Engine | 6 Hours |
| **Phase 4** | Testing, Bug Fixing, & Documentation | 4 Hours |
| **Total** | | **20 Hours** |

### Estimation Rationale
[cite_start]My estimate of **20 hours** was derived by prioritizing the **Unified Schema** first. [cite: 51] By spending more time on the database design in Phase 1, I reduced the complexity of Phase 3, as the evaluation logic could rely on a predictable, non-hardcoded data structure. [cite_start]This plan allowed for iterative testing of each question type as it was integrated into the centralized evaluation engine. [cite: 43]