# Laravel To Do List by Dominik Gawenda

## Chapter 1: Environment Configuration

This chapter details the environment setup for the Laravel To-Do-List project, based on all visible commits on the develop branch, with a focus on Laravel Sail and supporting tooling for local development.

---

### 1. Laravel Sail: The Foundation

The project is built and developed locally using Laravel Sail, Laravel's official Docker-based environment.  
Sail provides a seamless way to run PHP, MySQL, Mailpit, and other services with no system dependencies except Docker.

Project initialization included setting up Sail support, and the repository contains the necessary Docker Compose file, Sail scripts, and service definitions.

---

### 2. Database Configuration

MySQL is provided via Sail's Docker stack.  
Connection parameters are managed in the environment configuration, ensuring database access and migrations are handled within the containerized setup.

---

### 3. Mail: Mailpit Integration

Mailpit is included as a service to allow local testing of email sending functionality.  
The Mailpit UI is available for inspecting outgoing mail, and SMTP integration is handled through environment variables.  
A Mailpit container was added to the Sail stack to streamline this process.

---

### 4. Authentication

Laravel Breeze provides basic authentication scaffolding and has been installed and configured for the project.  
Laravel Sanctum enables API token authentication and is also set up for secure API access.

---

### 5. Developer Experience

Laravel Debugbar and IDE Helper are included for easier debugging and improved IDE support.  
Debugbar artifacts are excluded from version control to keep the repository clean.

---

### 6. Logging & External Integrations

Spatie Activity Log and Spatie Google Calendar are installed and configured for audit logging and calendar integration, providing advanced features for tracking activity and external event management.

---

### 7. General Notes

All major environment services such as PHP, MySQL and Mailpit are managed through Sail and Docker.  
Additional packages and tools are included to improve development, debugging, and integration capabilities.  
Further configuration and integration details can be found in the commit history of the develop branch.

---
