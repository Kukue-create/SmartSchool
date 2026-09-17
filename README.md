# SmartSchool Zimbabwe

A secure, role-based Web School Management Information System built for
**Seke 1 High School**, in **PHP (Laravel 10) + PostgreSQL**, as specified in
the project brief.

## What's inside

**Core (fully implemented, matches the brief precisely):**
- Two-step registration: shared Step 1 (full name, username, password +
  confirm, role radio: Student / Teacher / School Admin) → role-specific
  Step 2 that greets the person by name and shows their auto-generated
  school email *before* they submit.
- Auto-generated emails: first letter of first name + full surname, e.g.
  **Bethel Jengwa** → `bjengwa@students.seke1.ac.zw` (teachers get
  `@staff.seke1.ac.zw`, school admins get `@admin.ac.zw`). Collisions are
  auto-suffixed (`bjengwa2@...`).
- Student registration: level (Form 1 – Upper 6), the exact class list from
  the brief (1.1–1.12 … Upper 6 Arts), unlimited subject selection, gender,
  date of birth, nationality.
- Teacher registration: up to 10 classes taught, subjects taught, gender,
  nationality.
- School Admin registration: gender, nationality; can view every student and
  teacher record but **cannot edit** any of it (enforced in the UI and in
  `DirectoryController`, which never exposes an edit route).
- A single **System Administrator (owner)** login at `/system-admin/login`,
  gated by one shared secret (`SYSTEM_ADMIN_PASSWORD` in `.env`) rather than
  a normal account — matches "only the owners of the system should just
  login straight with System admin password." The owner can view and edit
  **any** record; edits go straight to the shared `users` table, so they are
  instantly visible to every other role.
- Login is email + password only, and only ever succeeds for an account that
  was actually registered — there is no way to reach a dashboard without
  registering first.
- Marks/results: a teacher can only upload a mark for a student who (a) is
  in one of the teacher's own classes and (b) takes a subject the teacher
  teaches — enforced server-side in `Teacher::canGradeStudentInSubject()`,
  not just hidden in the UI. Students only ever see their own results.
- Design: dark brown / yellow / light green theme (`public/css/theme.css`),
  Bootstrap 5, applied consistently across every screen.

**Scaffolded modules** (present end-to-end — migration, model, controller,
routes, views — kept intentionally simpler than the core flows above):
Fees & payment verification, Attendance, Class & Exam Timetables, School
Notices, Library (physical books + digital past papers/notes), Online
Enrollment applications, and an audit log that records every write request.

## Tech stack

- PHP 8.1+, Laravel 10
- PostgreSQL (primary), SQLite supported for quick local testing
- Blade + Bootstrap 5
- Session-based auth (Laravel's built-in guard) for the three registered
  roles, plus a separate signed-session flag for the System Administrator

## ⚠️ About this zip — please read before you run it

This project was generated in a sandboxed environment with **no access to
Packagist** (Composer's package registry), so `composer install` could not
be run or tested here, and the app has **not** been booted end-to-end.
What *was* done to protect quality:
- Every PHP file (`app/`, `routes/`, `database/`, `config/`, `bootstrap/`)
  was checked with `php -l` and has **no syntax errors**.
- The route list, model relationships, and Blade `route()`/`@csrf` calls
  were cross-checked by hand against the controllers that define them.

Please run `composer install`, then the smoke-test steps below, and treat
any error you hit as an ordinary bug report back to me — I'm glad to fix it.

## Setup

```bash
composer install
cp .env.example .env      # already done in this zip, but re-check values
php artisan key:generate

# Option A — PostgreSQL (matches the brief)
# Edit .env: DB_CONNECTION=pgsql and set DB_DATABASE/DB_USERNAME/DB_PASSWORD
createdb smartschool_zimbabwe

# Option B — quick local test with SQLite instead
# In .env set DB_CONNECTION=sqlite and: touch database/database.sqlite

php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Then:
- Visit `/register` to create a Student, Teacher, and School Admin account
  and try the flows described above.
- Visit `/system-admin/login` and log in with the `SYSTEM_ADMIN_PASSWORD`
  value from your `.env` (**change it from the placeholder before you
  deploy**) to see the owner's full view/edit dashboard.

## Known simplifications (given the brief's very large scope)

- Fee, attendance, timetable, notice, library and enrollment screens are
  functional but intentionally simpler than the registration/results core —
  no soft-delete history, no email notifications (mail is set to the `log`
  driver), no PDF report cards.
- The System Administrator's edit access currently covers every user's core
  profile fields (name, email, gender, nationality) from one screen
  (`/system-admin/users`); extending the same full-edit screen to fee
  structures, notices, and enrollment records would be the natural next
  step and follows the same pattern already used in
  `Admin\UserManagementController`.
- Grades use a simple fixed A–U scale (`Result::gradeFor()`) — swap this for
  Seke 1's actual grade boundaries if different.

## Project structure highlights

- `app/Services/EmailGenerator.php` — the email-generation rule from the brief
- `app/Models/Teacher.php` — `canGradeStudentInSubject()`, the core access rule
- `app/Http/Middleware/RoleMiddleware.php` — per-role route protection
- `app/Http/Middleware/EnsureSystemAdmin.php` — the owner-only guard
- `config/school.php` — every class, subject, level and email domain, in one
  place, so the school's actual data can be adjusted without touching code
