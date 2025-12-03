🚀 Job App - Candidate Portal

📖 Project Overview

Job App is the public-facing interface of the Job Vacancies Platform. It is a modern, responsive web application designed specifically for Job Seekers.

The primary objective of this application is to bridge the gap between talent and opportunity by providing a seamless, AI-enhanced recruitment experience. Unlike traditional job boards, Job App integrates Artificial Intelligence to analyze candidate resumes in real-time, providing compatibility scores and actionable feedback before an application reaches the employer.

⚙️ Mechanism of Action

Browse: Candidates search and filter job vacancies fetched from the central database.

Apply: Users submit applications by uploading their Resume (PDF).

Analyze: The system (via Background Queues) parses the resume using OpenAI, comparing skills against the job description.

Feedback: The candidate receives an AI-generated compatibility score and tips for improvement.

🏗️ Project Structure & Architecture

This project operates within a Monorepo ecosystem, sharing resources with the job-backoffice.

job-app/
├── app/
│   ├── Http/Controllers/  # Handles requests (Jobs, Applications, Auth)
│   ├── Services/          # Business logic (e.g., ResumeAnalysisService)
│   └── Models/            # (Empty - Models are loaded from job-shared)
├── resources/
│   ├── views/             # Blade templates (UI)
│   └── js/                # Vue/Alpine.js & Tailwind configuration
├── routes/                # Web & Auth routes
├── config/                # App configuration (Filesystems, Services)
└── composer.json          # Dependency manager (Links to job-shared)


Key Architectural Concepts

Shared Kernel: The application relies on ../job-shared for Eloquent Models (User, JobVacancy, Resume) and Enums to ensure a Single Source of Truth.

Secure Storage: Resumes are stored in a private disk (storage/app/resumes) to ensure GDPR compliance and user privacy.

UUIDs: All primary keys use UUIDs for enhanced security and scalability.

💻 Operating Requirements

Ensure your environment meets the following specifications before installation:

PHP: Version 8.2 or higher.

Database: MySQL 8.0+ or MariaDB 10.10+ (Dockerized).

Extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML.

Composer: Latest version.

Node.js & NPM: For compiling frontend assets.

OpenAI API Key: For the AI analysis features.

🛠️ Installation & Commissioning

Follow these steps to get the project running from scratch.

1. Clone & Navigate

git clone [https://github.com/Ammar-1993/Job_Vacancies_Platform.git](https://github.com/Ammar-1993/Job_Vacancies_Platform.git)
cd Job_Vacancies_Platform/job-app


2. Install Backend Dependencies

Since this app depends on job-shared, ensure the path is accessible.

composer install
composer dump-autoload


3. Environment Configuration

Duplicate the example environment file:

cp .env.example .env


Update the .env file with your configuration:

APP_NAME="Job App"
APP_URL=http://localhost:8000

# Database (Must match Docker Container credentials)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jobs_db
DB_USERNAME=root
DB_PASSWORD=root

# OpenAI Integration
OPENAI_API_KEY=sk-your-api-key-here


4. Install Frontend Dependencies

npm install
npm run build


5. Link Storage

Create the symbolic link for public assets (Images/CSS), while keeping resumes private.

php artisan storage:link


6. Run the Application

php artisan serve


The application will be accessible at http://localhost:8000.

🧠 Technologies Used

Technology

Rationale

Laravel 11

Chosen for its robust MVC architecture, security features, and powerful Queue system for handling AI tasks.

Tailwind CSS

Facilitates rapid UI development with a utility-first approach, ensuring a modern and responsive design.

OpenAI API

The core of the "Smart Evaluation" feature, providing natural language processing capabilities to analyze resumes.

MySQL + UUID

Ensures data integrity and security by preventing sequential ID enumeration attacks.

Docker

Provides a consistent development environment across different machines.

✨ Key Features

Smart Job Search: Filter jobs by type (Remote, Full-time), location, and salary.

One-Click Apply: Streamlined application process with PDF upload validation.

AI Compatibility Score: Get instant feedback on how well your resume matches the job description.

Application Tracking: Monitor the status of your applications (Pending, Accepted, Rejected).

Secure Profile: Manage personal information and password securely.

🤝 How to Contribute

We welcome contributions! Please follow these steps:

Fork the repository.

Create a Feature Branch (git checkout -b feature/AmazingFeature).

Commit your changes (git commit -m 'Add some AmazingFeature').

Push to the branch (git push origin feature/AmazingFeature).

Open a Pull Request.

Note: When modifying Database Models, please edit them in the job-shared directory, not locally in job-app.

❓ Common Issues & Solutions

🔴 Error: Class "App\Models\User" not found

Cause: The application cannot locate the models in the shared folder.
Solution: Ensure your composer.json has the correct path mapped in autoload and run:

composer dump-autoload


🔴 Error: 403 Forbidden on Resume Upload

Cause: Permissions on the storage folder.
Solution: Ensure the storage and bootstrap/cache directories are writable:

chmod -R 775 storage bootstrap/cache


🔴 Error: Database Connection Refused

Cause: Docker container might not be running or port mapping is incorrect.
Solution: Check Docker status and ensure DB_PORT in .env matches your Docker configuration (default 3306).

💡 Feedback & Tips

For Users 👤

Resume Format: Ensure your resume is in PDF format and does not exceed 2MB.

Content: To get the best AI score, ensure your resume text is selectable (not an image scan).

For Developers 👨‍💻

Queues: The AI analysis runs in the background. Ensure you run php artisan queue:work locally to process resume analysis jobs.

Security: Never commit your .env file or OPENAI_API_KEY to version control.

<p align="center">
Built with ❤️ by the Job Platform Team
</p>
