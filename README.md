# 🚀 Job Vacancies Platform

An AI-powered recruitment ecosystem that connects job seekers with employers through intelligent job matching, resume analysis, compatibility scoring, and end-to-end hiring management.

## 🧭 System Architecture

The platform is organized as a Laravel monorepo composed of a public candidate portal, a protected employer/admin backoffice, and a shared domain kernel. Both applications use the same database and shared models while keeping their responsibilities and access boundaries separated.

```mermaid
flowchart TB
    %% Client layer
    subgraph Clients[Client Layer]
        Candidate[Job Seeker<br/>Web Browser]
        Employer[Company Owner / HR<br/>Web Browser]
        Admin[System Administrator<br/>Web Browser]
    end

    %% Presentation and application layer
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

    %% Shared domain layer
    subgraph Shared[job-shared - Shared Kernel]
        Models[Eloquent Models<br/>User, Company, JobVacancy, Resume, JobApplication]
        Enums[Enums & Domain Constants]
        Policies[Policies, Relationships & Shared Business Rules]
    end

    %% Infrastructure layer
    subgraph Infra[Infrastructure Layer]
        DB[(MySQL / MariaDB<br/>Shared Database)]
        Queue[(Queue Backend<br/>Redis / Database Queue)]
        Worker[Laravel Queue Worker]
        Storage[(Private Resume Storage<br/>storage/app/resumes)]
        Cache[(Application Cache)]
    end

    %% External services
    subgraph External[External Services]
        OpenAI[OpenAI API<br/>Resume & Job Analysis]
        Mail[Mail / Notification Service]
    end

    %% Client to applications
    Candidate --> PublicUI
    Candidate --> CandidateAuth
    Candidate --> JobSearch
    Candidate --> ApplicationFlow
    Candidate --> Tracking

    Employer --> AdminUI
    Admin --> AdminUI

    %% Backoffice security and features
    AdminUI --> RBAC
    RBAC --> CompanyManagement
    RBAC --> VacancyManagement
    RBAC --> ReviewWorkflow
    RBAC --> Analytics

    %% Candidate workflows
    PublicUI --> JobSearch
    CandidateAuth --> Models
    JobSearch --> Models
    ApplicationFlow --> Models
    Tracking --> Models

    %% Backoffice to shared kernel
    CompanyManagement --> Models
    VacancyManagement --> Models
    ReviewWorkflow --> Models
    Analytics --> Models
    RBAC --> Policies

    %% Shared kernel to infrastructure
    Models --> Policies
    Models --> Enums
    Models --> DB
    Policies --> DB

    %% Resume processing pipeline
    ApplicationFlow --> Storage
    ApplicationFlow --> Queue
    Queue --> Worker
    Worker --> Storage
    Worker --> OpenAI
    Worker --> Models
    OpenAI --> Worker
    Worker --> Mail
    Tracking --> Mail

    %% Supporting infrastructure
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

## ✨ Main Capabilities

- Smart job search by type, location, salary, and other vacancy attributes.
- One-click applications with PDF resume validation.
- AI-generated compatibility score and actionable feedback.
- Candidate application tracking with pending, accepted, and rejected states.
- Company and vacancy management for employers and administrators.
- Centralized application review and operational analytics.
- Shared domain models across both Laravel applications.

## ⚙️ Technology Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Blade, Tailwind CSS, JavaScript
- **Database:** MySQL 8.0+ or MariaDB 10.10+
- **AI:** OpenAI API
- **Asynchronous processing:** Laravel Queues
- **Environment:** Docker-compatible development setup

## 🚀 Development Notes

Install dependencies independently inside `job-app` and `job-backoffice`, configure each `.env` file to use the shared database, build frontend assets, and run a queue worker for AI analysis:

```bash
php artisan queue:work
```

Never use the development seed credentials in production. Change all default passwords and configure production secrets before deployment.

## 🤝 Contribution

1. Fork the repository.
2. Create a feature branch.
3. Implement and test your changes.
4. Push the branch and open a pull request.
5. When changing shared models or domain rules, update `job-shared` so both applications remain consistent.

---

<div align="center">

Developed with ❤️ by Engineer Ammar Al-Najjar

</div>
