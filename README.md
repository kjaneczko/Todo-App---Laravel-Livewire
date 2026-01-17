[![Tests](https://github.com/kjaneczko/Todo-App---Laravel-Livewire/actions/workflows/laravel.yml/badge.svg)](https://github.com/kjaneczko/Todo-App---Laravel-Livewire/actions/workflows/laravel.yml)
![PHP](https://img.shields.io/badge/php-%3E%3D8.3-8892BF)
![Laravel](https://img.shields.io/badge/Laravel-12-red)
![Tests](https://img.shields.io/badge/tests-Pest-5C2D91)
[![License](https://img.shields.io/github/license/kjaneczko/Todo-App---Laravel-Livewire)](https://github.com/kjaneczko/Todo-App---Laravel-Livewire/blob/master/LICENSE)




# Todo App – Laravel + Livewire

This is a simple **Todo application** built with **Laravel** and **Livewire**.  
The project demonstrates how to build a small, interactive CRUD application without writing custom JavaScript frameworks, while keeping the code clean and close to the “Laravel way”.

The app allows managing projects and tasks with real-time UI updates powered by Livewire.

---

## Features

- Create, edit and delete **projects**
- Create, edit and delete **tasks** within a project
- Inline task name editing
- Mark tasks as completed
- Automatically move completed tasks to the bottom of the list
- Drag & drop task reordering
- Server-side validation
- No authentication (intentionally kept simple)
- No API layer – classic Laravel + Livewire architecture

---

## Tech Stack

- **Laravel**
- **Livewire**
- **Blade**
- **Bootstrap**
- **SortableJS** (for drag & drop)
- **SQLite** (default, easy to switch to MySQL/PostgreSQL)

---

## Project Structure (Overview)

- `app/Livewire` – Livewire components (projects, tasks, lists)
- `app/Models` – Eloquent models (`Project`, `Task`)
- `app/Services` – small domain services (e.g. task priority handling)
- `resources/views/livewire` – component views
- `database/migrations` – database schema
- `tests/Feature` – feature and Livewire tests (Pest)

The database is treated as the **source of truth**.  
After create/update/delete operations, lists are refreshed from the database to avoid UI state inconsistencies.

---

## Installation

```bash
git clone <repository-url>
cd todo
composer install
```

Create the database and run migrations:

```bash
php artisan migrate
```

Start the development server:

```bash
php artisan serve
```

Then open:

```
http://127.0.0.1:8000
```

---

## Testing

The project includes **feature tests** for core functionality.

Run tests with:

```bash
php artisan test
```

---

## Design Decisions

- **Livewire instead of a frontend framework**  
  The goal was to keep everything in Laravel without Vue or React.

- **No authentication**  
  This is a focused demo project, not a full production app.

- **Simple domain logic**  
  Task ordering and priorities are handled explicitly to keep behavior predictable.

- **Minimal JavaScript**  
  Only used where necessary (Bootstrap modals and drag & drop).

---

## Possible Improvements

- User authentication and multi-user support
- Authorization (policies)
- Optimized task reordering queries
- UI enhancements and accessibility improvements
- API version for mobile or external clients

---

## What This Project Demonstrates

This project demonstrates practical experience with:

- Building a full CRUD application using **Laravel and Livewire** without a frontend framework
- Managing UI state and server-side logic in a **Livewire-first architecture**
- Structuring small applications in a **clean, maintainable, and Laravel-idiomatic way**
- Handling real-time interactions (inline editing, drag & drop, modal forms) with minimal JavaScript
- Implementing **server-side validation** and keeping validation rules centralized
- Treating the **database as the source of truth** and avoiding inconsistent UI state
- Designing predictable domain logic (task ordering, priorities, completed state)
- Writing **feature and Livewire tests** to verify core behavior
- Solving common Livewire challenges such as:
    - modal state and validation resets
    - list reordering and DOM diffing
    - syncing UI interactions with persisted data
- Making conscious trade-offs between simplicity and extensibility in a small project

The project is intentionally kept simple and framework-focused to clearly show
how Laravel and Livewire can be used together to build interactive applications
without additional frontend complexity.

---

## License

This project is provided as a learning/demo project.  
You are free to use, modify and adapt it for your own purposes.
