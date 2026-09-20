# 🚀 Job Vacancies Platform

<p align="center">
  <strong>AI-powered recruitment infrastructure for smarter hiring decisions</strong>
</p>

<p align="center">
  A Laravel monorepo that connects job seekers, employers, and administrators through intelligent job discovery, resume analysis, compatibility scoring, and streamlined hiring workflows.
</p>

<p align="center">
  <a href="https://github.com/Ammar-1993/Job_Vacancies_Platform">Repository</a> ·
  <a href="#-system-architecture">Architecture</a> ·
  <a href="#-core-features">Features</a> ·
  <a href="#-getting-started">Getting Started</a>
</p>

---

## 📖 Project Overview

**Job Vacancies Platform** is a next-generation recruitment ecosystem designed to improve the way talent and employers connect. Instead of acting as a traditional job board, the platform combines structured vacancy management with AI-assisted resume evaluation to help candidates understand their fit and help employers prioritize relevant applications.

The system is delivered as a **Laravel monorepo** with clearly separated application responsibilities:

- **Candidate experience:** Discover opportunities, submit applications, and receive AI-powered feedback.
- **Employer experience:** Manage companies and vacancies, review applicants, and make informed hiring decisions.
- **Administrative governance:** Control users, platform data, access permissions, and operational workflows.
- **Shared domain foundation:** Maintain consistent models, enums, relationships, and business rules across applications.

### 🎯 Product Goals

1. Reduce friction throughout the candidate application journey.
2. Provide employers with structured, actionable applicant insights.
3. Automate the first stage of resume-to-vacancy comparison.
4. Protect sensitive candidate information through private storage and access control.
5. Preserve a single source of truth for shared recruitment data.

## ✨ Core Features

### For Job Seekers

- Search and filter vacancies by employment type, location, salary, and other attributes.
- Create and manage a secure candidate profile.
- Submit applications with PDF resume validation.
- Receive an AI-generated compatibility score and improvement recommendations.
- Track application progress through statuses such as pending, accepted, and rejected.

### For Employers and HR Teams

- Create and manage company profiles and job vacancies.
- Review applications from a centralized management portal.
- Use AI-generated compatibility insights to support applicant prioritization.
- Manage vacancy and application workflows with ownership-based restrictions.
- Access operational information through management dashboards and analytics.

### For Administrators

- Manage users, companies, vacancies, and applications.
- Enforce Role-Based Access Control (RBAC).
- Enforce Ownership-Based Access Control (OBAC) for company owners.
- Preserve historical records through soft deletion strategies.
- Maintain data quality for the public candidate portal.

## 🧭 System Architecture

The platform is organized as a Laravel monorepo composed of a public candidate portal, a protected employer/admin backoffice, and a shared domain kernel. Both applications use the same database and shared models while keeping their responsibilities and access boundaries separated.

```mermaid
flowchart TB
    subgraph Clients[Client Layer]
        Candidate[Job Seeker<br/>Web Browser]
        Employer[Company Owner / HR<br/>Web Browser]
        Admin[System Administrator<br/>Web Browser]
    end

    subgraph Apps[Application Layer - Laravel]
        subgraph JobApp[job-app - Candidate Portal]
            PublicUI[Public Job UI<br/>Blade / Tailwind]
            CandidateAuth[Authentication & Profile]
            JobSearch[Job Search & Filtering]
            ApplicationFlow[Application & Resume Upload]
            Tracking[Application Tracking]
        end

        subgraph Backoffice[job-backoffice - Management Portal]
            AdminUI[Management UI<br/>Blade / Tailwind]
            RBAC[RBAC / OBAC Middleware]
            CompanyManagement[Company & User Management]
            VacancyManagement[Job Vacancy CRUD]
            ReviewWorkflow[Application Review Workflow]
            Analytics[Dashboard & Analytics]
        end
    end

    subgraph Shared[job-shared - Shared Kernel]
        Models[Eloquent Models<br/>User, Company, JobVacancy, Resume, JobApplication]
        Enums[Enums & Domain Constants]
        Policies[Policies, Relationships & Shared Business Rules]
    end

    subgraph Infra[Infrastructure Layer]
        DB[(MySQL / MariaDB<br/>Shared Database)]
        Queue[(Queue Backend<br/>Redis / Database Queue)]
        Worker[Laravel Queue Worker]
        Storage[(Private Resume Storage<br/>storage/app/resumes)]
        Cache[(Application Cache)]
    end

    subgraph External[External Services]
        OpenAI[OpenAI API<br/>Resume & Job Analysis]
        Mail[Mail / Notification Service]
    end

    Candidate --> PublicUI
    Candidate --> CandidateAuth
    Candidate --> JobSearch
    Candidate --> ApplicationFlow
    Candidate --> Tracking

    Employer --> AdminUI
    Admin --> AdminUI

    AdminUI --> RBAC
    RBAC --> CompanyManagement
    RBAC --> VacancyManagement
    RBAC --> ReviewWorkflow
    RBAC --> Analytics

    PublicUI --> JobSearch
    CandidateAuth --> Models
    JobSearch --> Models
    ApplicationFlow --> Models
    Tracking --> Models

    CompanyManagement --> Models
    VacancyManagement --> Models
    ReviewWorkflow --> Models
    Analytics --> Models
    RBAC --> Policies

    Models --> Policies
    Models --> Enums
    Models --> DB
    Policies --> DB

    ApplicationFlow --> Storage
    ApplicationFlow --> Queue
    Queue --> Worker
    Worker --> Storage
    Worker --> OpenAI
    Worker --> Models
    OpenAI --> Worker
    Worker --> Mail
    Tracking --> Mail

    JobSearch --> Cache
    Analytics --> Cache
```

### 🔄 Core Resume Analysis Flow

```mermaid
sequenceDiagram
    actor Candidate as Job Seeker
    participant App as job-app
    participant Storage as Private Storage
    participant DB as MySQL / MariaDB
    participant Queue as Laravel Queue
    participant Worker as Queue Worker
    participant AI as OpenAI API
    participant Backoffice as job-backoffice

    Candidate->>App: Upload PDF resume and apply
    App->>Storage: Store resume privately
    App->>DB: Create application with pending analysis status
    App->>Queue: Dispatch resume analysis job
    App-->>Candidate: Confirm application submission

    Queue->>Worker: Process analysis job
    Worker->>Storage: Read private resume
    Worker->>DB: Load resume and job description
    Worker->>AI: Submit extracted resume and vacancy context
    AI-->>Worker: Return score, strengths, gaps, and recommendations
    Worker->>DB: Save compatibility analysis and update status

    Candidate->>App: View application status and feedback
    App->>DB: Retrieve result
    App-->>Candidate: Display score and improvement guidance
    Backoffice->>DB: Review ranked applications
```

### 🧩 Architectural Responsibilities

| Component | Responsibility |
| --- | --- |
| `job-app` | Candidate registration, job discovery, filtering, resume upload, applications, and status tracking. |
| `job-backoffice` | Administration, company management, vacancy management, applicant review, and platform analytics. |
| `job-shared` | Single source of truth for Eloquent models, enums, relationships, policies, and shared domain rules. |
| MySQL / MariaDB | Persistent storage for users, companies, vacancies, resumes, applications, and AI analysis results. |
| Laravel Queue Worker | Asynchronous processing of resume parsing and AI compatibility analysis. |
| Private Resume Storage | Keeps uploaded resumes inaccessible to the public web root and protects candidate data. |
| OpenAI API | Performs natural-language analysis of resumes against job descriptions. |

### 🔐 Security and Data Boundaries

- Role-Based Access Control separates administrators from company owners and candidates.
- Ownership-Based Access Control limits company owners to their own companies, vacancies, and applications.
- Resumes are stored on a private disk rather than public web storage.
- UUID primary keys reduce predictable identifier enumeration.
- Soft deletes preserve historical records without immediately destroying business data.
- AI processing is asynchronous so external API calls do not block the application request.
- Secrets such as `OPENAI_API_KEY` must remain in environment configuration and must never be committed.

## 🏗️ Repository Structure

```text
Job_Vacancies_Platform/
├── job-app/          # Public candidate portal
├── job-backoffice/   # Admin and employer management portal
├── job-shared/       # Shared models, enums, and domain logic
└── README.md
```

## ⚙️ Technology Stack

| Layer | Technology | Purpose |
| --- | --- | --- |
| Backend | Laravel 12, PHP 8.2+ | MVC application framework and domain workflows |
| Presentation | Blade, Tailwind CSS, JavaScript | Responsive candidate and management interfaces |
| Persistence | MySQL 8.0+ / MariaDB 10.10+ | Shared relational recruitment data store |
| AI integration | OpenAI API | Resume analysis and vacancy compatibility insights |
| Background processing | Laravel Queues | Non-blocking AI analysis and asynchronous jobs |
| Dependency management | Composer, NPM | PHP packages and frontend asset tooling |
| Development environment | Docker-compatible setup | Reproducible local infrastructure |

## 🚀 Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL 8.0+ or MariaDB 10.10+
- Required PHP extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, and XML
- OpenAI API key for AI analysis features

### Candidate Portal

```bash
git clone https://github.com/Ammar-1993/Job_Vacancies_Platform.git
cd Job_Vacancies_Platform/job-app
composer install
composer dump-autoload
cp .env.example .env
npm install
npm run build
php artisan storage:link
php artisan serve
```

### Management Portal

```bash
cd ../job-backoffice
composer install
composer dump-autoload
cp .env.example .env
npm install
npm run build
php artisan migrate --seed
php artisan serve --port=8001
```

Configure both `.env` files to use the shared database. Set `OPENAI_API_KEY` in the candidate portal environment and never commit secrets to version control.

### Background Processing

Run a queue worker so resume analysis jobs can be processed:

```bash
php artisan queue:work
```

## 🧪 Development and Contribution Guidelines

1. Fork the repository.
2. Create a focused feature branch.
3. Implement and test the change in the relevant application.
4. Update `job-shared` when changing shared models, enums, or domain rules.
5. Run formatting, automated tests, and relevant application checks.
6. Push the branch and open a pull request with a clear technical description.

## ⚠️ Security Notes

- Development seed credentials are for local demonstration only and must be changed before production deployment.
- Do not commit `.env`, API keys, database passwords, or uploaded resumes.
- Keep resume files on private storage and expose them only through authorized application flows.
- Review OpenAI data-handling requirements before using the platform with production candidate data.

---

<div align="center">

Developed with ❤️ by Engineer Ammar Al-Najjar

</div>
