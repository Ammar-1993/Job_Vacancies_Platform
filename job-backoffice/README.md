🏢 Job Backoffice - Admin & HR Portal

📖 Project Overview

Job Backoffice is the administrative command center of the Job Vacancies Platform. It serves as the operational hub for System Administrators and Company Owners/HR Managers.

While the Job App focuses on the candidate experience, the Backoffice is dedicated to content management, operational oversight, and decision-making. It ensures that job listings are accurate, applications are processed efficiently, and the platform remains secure and organized.

🎯 Objectives & Mechanism

Centralized Control: A single dashboard to manage Users, Companies, and Jobs.

RBAC & OBAC: Implements Role-Based Access Control (Admins vs. Owners) and Ownership-Based Access Control (Owners can only manage their own companies/jobs).

Data Integrity: acts as the gatekeeper for the data displayed on the public Job App.

🏗️ Project Structure & Architecture

This project operates within a Monorepo ecosystem, sharing the core domain logic with the job-app.

job-backoffice/
├── app/
│   ├── Http/Controllers/  # Admin logic (CRUD operations, Stats)
│   ├── Middleware/        # Role verification (Admin vs Company Owner)
│   └── Models/            # (Empty - Models are loaded from job-shared)
├── resources/
│   ├── views/             # Blade templates for Admin UI (Tables, Forms)
│   └── js/                # Asset configuration
├── routes/                # Protected admin routes
├── config/                # Auth guards and system settings
└── composer.json          # Dependency manager (Links to job-shared)


Key Architectural Concepts

Shared Models: Uses ../job-shared for Eloquent Models (Company, JobVacancy, JobApplication) to ensure data consistency across the platform.

Blade Components: Utilizes reusable UI components for standardized Admin tables, modals, and alerts.

Soft Deletes: Implements non-destructive deletion for Companies, Jobs, and Users to maintain historical data.

💻 Operating Requirements

Ensure your environment meets the following specifications:

PHP: Version 8.2 or higher.

Database: MySQL 8.0+ / MariaDB 10.10+ (Dockerized).

Web Server: Nginx or Apache (or Laravel built-in server for dev).

Composer: Latest version.

Node.js & NPM: For compiling Tailwind CSS assets.

🛠️ Installation & Commissioning

Follow these steps to deploy the backoffice portal.

1. Clone & Navigate

git clone [https://github.com/Ammar-1993/Job_Vacancies_Platform.git](https://github.com/Ammar-1993/Job_Vacancies_Platform.git)
cd Job_Vacancies_Platform/job-backoffice


2. Install Dependencies

This step helps register the shared library path.

composer install
composer dump-autoload


3. Environment Configuration

Duplicate the example environment file:

cp .env.example .env


Update the .env file to connect to the shared Docker database:

APP_NAME="Job Backoffice"
APP_URL=http://localhost:8001  # Distinct port from Job App

# Shared Database Credentials
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jobs_db
DB_USERNAME=root
DB_PASSWORD=root


4. Database Migration & Seeding

Populate the database with initial Admin accounts and Roles.

php artisan migrate
php artisan db:seed --class=DatabaseSeeder


5. Frontend Assets

npm install
npm run build


6. Run the Application

php artisan serve --port=8001
