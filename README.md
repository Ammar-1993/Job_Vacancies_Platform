🚀 Job Vacancies Platform (Monorepo)

🌟 Comprehensive Overview

Job Vacancies Platform is an enterprise-grade recruitment ecosystem designed to streamline the entire hiring lifecycle. It connects talented job seekers with employers through a seamless, intelligent, and secure interface.

The platform distinguishes itself by integrating Artificial Intelligence into the recruitment process, offering real-time resume analysis and compatibility scoring. Built on a robust Monorepo Architecture, it ensures code reusability, consistency, and scalability across its multiple applications.

🎯 Core Objectives

For Job Seekers: Simplify job discovery and provide actionable, AI-driven feedback on applications.

For Employers: Automate initial screening and provide a centralized dashboard for managing vacancies and applicants.

For Administrators: Maintain platform integrity through rigorous role-based and ownership-based access controls (RBAC/OBAC).

🏗️ Project Structure & Architecture

This repository adopts a Monorepo strategy to manage three distinct but interconnected components efficiently:

Job_Vacancies_Platform/
├── 📂 job-app/          # (Public) Candidate Portal
│   ├── User Interface for Job Seekers
│   ├── AI Resume Analysis Integration
│   └── Application Tracking System
│
├── 📂 job-backoffice/   # (Private) Admin & HR Dashboard
│   ├── Company & Job Management
│   ├── Application Review Workflow
│   └── System Analytics
│
└── 📂 job-shared/       # (Core) Shared Kernel
    ├── Eloquent Models (User, JobVacancy, Resume)
    ├── Database Migrations & Seeders
    └── Enums & Shared Logic


🧠 Why This Architecture?

Single Source of Truth: Database schemas and logic (job-shared) are defined once and used everywhere, preventing data inconsistencies.

Separation of Concerns: The public-facing app is physically separated from the administrative backend, enhancing security and allowing independent scaling.

Micro-Service Ready: The structure allows for easy decoupling into separate services or containers in the future if needed.

💻 Operating Requirements

To run the full suite of applications, ensure your environment meets these specifications:

Runtime: PHP 8.2+ with extensions (BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML).

Containerization: Docker Desktop (Recommended for Database & Services).

Dependency Managers: Composer (PHP) & NPM (Node.js).

Database: MySQL 8.0+ or MariaDB 10.10+ (Running on Port 3306).

AI Service: OpenAI API Key (Required for Resume Analysis).

🚀 Installation & Commissioning

Follow this straightforward guide to get the entire platform up and running.

1. Clone the Repository

git clone [https://github.com/Ammar-1993/Job_Vacancies_Platform.git](https://github.com/Ammar-1993/Job_Vacancies_Platform.git)
cd Job_Vacancies_Platform


2. Initialize the Shared Library


This is critical as both apps depend on this folder.

cd job-shared
composer install
cd ..


3. Setup the Database (Docker)

Ensure Docker Desktop is running, then verify your database container is active.

# Verify connection
docker ps 
# Expected: mysql-server running on port 3306


4. Setup Job Backoffice (Admin Portal)

cd job-backoffice
cp .env.example .env      # Configure DB credentials in .env
composer install          # Installs dependencies + job-shared
php artisan migrate:fresh --seed # Sets up the Database Schema
npm install && npm run build
php artisan serve --port=8001


Admin Portal will be live at http://localhost:8001

5. Setup Job App (Candidate Portal)

Open a new terminal:

cd job-app
cp .env.example .env      # Configure DB credentials & OpenAI Key
composer install
npm install && npm run build
php artisan storage:link  # Important for asset loading
php artisan serve --port=8000
