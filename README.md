# APEX Events & Competitions — Complete Website

A production-ready multi-page website with a PHP backend, MySQL database and
secure administration dashboard, built for **APEX Events & Competitions** —
event and competition management for schools, colleges, universities and
educational institutions.

The brand identity (navy / gold / ivory, Archivo + Inter typography) from the
supplied design references has been preserved and extended into a cohesive,
responsive design system.

---

## ✨ What's inside

### Public website (16 pages)

| Page | File | Purpose |
|---|---|---|
| Home | `index.php` | Hero, categories, APEX Card promo, services, how-it-works, featured competitions, past events, testimonials |
| About Us | `about.php` | Story, mission, vision, values, team |
| Competitions | `competitions.php` | 9 categories, signature championships, fair play, levels, registration flow |
| Events / Services | `events.php` | 8 service areas with deliverables |
| APEX Card | `apex-card.php` | Benefits, card types, partner directory, application form, terms |
| For Schools | `schools.php` | Schools landing with promises |
| For Colleges & Universities | `colleges.php` | Campus events landing |
| Portfolio | `portfolio.php` | Redirects to Past Events |
| Past Events | `past-events.php` | Filterable gallery, detail modals, stats |
| Calendar | `calendar.php` | Dynamic upcoming competitions with filters |
| Register Team | `register-team.php` | Team registration flow |
| Partners | `partners.php` | Filterable partner directory by type, city |
| Sponsorship | `sponsorship.php` | Tiers, benefits comparison, enquiry form |
| Educational Trips | `educational-trips.php` | Supervised trips with enquiry form |
| FAQ | `faq.php` | Accordion of questions organised by category |
| Contact | `contact.php` | Full "Request a Proposal" form |
| Links | `links.php` | Linktree-style quick-access page |

### Admin dashboard (`/admin/`)

Secure session-based login, locked bcrypt password hashes, failed-login lockout
(6 attempts → 15-minute lock), activity logging, CRUD for every major entity:

- **Dashboard** — 12 live KPIs (enquiries, open comps, upcoming events, partners, applications…)
- **Competitions** — create / edit / delete / filter · cover image upload · registration status
- **Event Services** — manage Events page content
- **Portfolio / Past Events** — full case studies with image galleries, results, quotes
- **Partners** — logo upload, categories, APEX Card flag, discount, website
- **Sponsorship Tiers & Applications** — pricing, benefits, enquiry inbox
- **APEX Card Types & Applications** — manage card types, review applications, status pipeline
- **FAQs, Testimonials, Team Members** — full CRUD
- **Proposal Enquiries** — triage inbox with status pipeline + internal notes
- **Competition Registrations** — per-team view with participant list
- **Trip Enquiries, Contact Messages** — view, status, delete
- **Navigation & Social Links** — editable header, footer and social media
- **Site Settings** — grouped text/number/email/url/textarea settings
- **Media Library** — upload JPG/PNG/WebP/GIF/PDF with collection grouping and safe naming

### Working forms (all save to MySQL)

- Request a Proposal (full contact form)
- Competition Team Registration (+ participants)
- APEX Card Application (+ optional photo upload)
- Sponsorship Enquiry
- Educational Trip Enquiry
- Newsletter Subscription
- Admin login

### Security

- PDO prepared statements everywhere — zero string-concatenation SQL
- CSRF tokens on every POST form (`includes/csrf.php`)
- `password_hash()` / `password_verify()` bcrypt for admin passwords
- Strict session cookies (`HttpOnly`, `SameSite=Lax`, `use_strict_mode`)
- Login lockout (6 attempts → 15 minutes)
- Honeypot + server-side validation on all public forms
- Upload validation: file-extension / MIME double-check, 5–8 MB cap, safe random filenames
- `.htaccess` blocks execution inside `uploads/` and denies access to `config/`, `includes/`, `database/`
- Error reporting disabled in production (`APP_DEBUG=false`), friendly error messages to visitors, logs for admin
- XSS-safe output: every value escaped with `e()` helper on render
- SEO: unique meta titles & descriptions, Open Graph tags, canonical URLs, semantic HTML5, sitemap.xml, robots.txt, lazy-loaded images

---

## ⚡ Quick start on XAMPP

1. **Install XAMPP** (PHP 8.0+ and MySQL / MariaDB).
2. **Copy** the whole folder into `C:\xampp\htdocs\apex\` (Windows) or `/Applications/XAMPP/htdocs/apex/` (macOS).
3. **Start** Apache and MySQL from the XAMPP control panel.
4. **Create the database:**
   - Open `http://localhost/phpmyadmin/`.
   - Click **Import** and choose `database/apex_database.sql`.
   - Click **Go**. The `apex_db` database, all 30 tables and seed data are created.
5. **Configure credentials:**
   - Copy `.env.example` → `.env` and set `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`.
   - Default XAMPP values are `root` / empty password — the defaults in `.env.example` already match.
6. **Open** `http://localhost/apex/` in your browser. The public site loads.
7. **Sign in to admin** at `http://localhost/apex/admin/`:
   - Email: **`admin@apex.local`**
   - Password: **`ApexAdmin!2026`**
   - Change your email and password from Settings on first login.

---

## 🧾 Configuration

### Database

Credentials are read, in order, from environment variables (`DB_HOST`, etc.),
then from `.env`, then the defaults in `config/database.php`. In production,
prefer the environment variables set in your hosting panel.

### SMTP

Set SMTP credentials from the **Site Settings → Email** group in the admin, or
by editing `.env`. If PHPMailer is installed (via Composer in `vendor/`), it is
used automatically; otherwise `mail()` is attempted. If neither is available,
the attempt is logged and the user still sees the submission success message —
check `error_log` for details.

### Timezones

Set `APP_TIMEZONE` in `.env` (default `Asia/Karachi`).

### Admin password & email

Once signed in, go to **Site Settings** to update the notification email and
contact details. To change the admin password, open your admin record in the
database (`admins` table) and replace `password_hash` with a new
`password_hash('new-password', PASSWORD_BCRYPT)`. A web-based password change
form can be added later — the hashing helper is already included.

---

## 🚀 Deploying to shared hosting

1. Upload every file (including `.env`, `.htaccess`, `uploads/`) via FTP / cPanel File Manager.
2. In cPanel → MySQL Databases, create a new database and user, grant all
   privileges, and import `database/apex_database.sql` from phpMyAdmin.
3. Update `.env` with the production database credentials.
4. Ensure the `uploads/` directory is writable (chmod 755 is usually enough;
   some shared hosts need 775 or 777).
5. Hit `https://yourdomain.com/admin/` and sign in with the default
   credentials, then change them immediately.
6. Edit site settings, add real competitions, partners, past events and media.

---

## 🗂 Project structure

```
apex-website/
├── admin/                      # Admin dashboard (CRUD modules)
│   ├── index.php, login.php, logout.php, dashboard.php
│   ├── competitions/           # CRUD
│   ├── events/                 # CRUD
│   ├── portfolio/              # CRUD + galleries
│   ├── partners/               # CRUD
│   ├── sponsorship/            # CRUD + applications
│   ├── card/                   # Card types CRUD
│   ├── team/, faq/, testimonials/
│   ├── enquiries/              # Proposal enquiries inbox
│   ├── registrations/          # Competition registration inbox
│   ├── applications/           # APEX Card applications inbox
│   ├── trips/, messages/       # Enquiry inboxes
│   ├── navigation/, settings/, media/
│   └── includes/               # Admin layout + CRUD helpers
├── assets/
│   ├── css/main.css, admin.css
│   └── js/main.js
├── config/
│   ├── app.php                 # Bootstrap: sessions, env, DB load
│   └── database.php            # PDO factory
├── includes/
│   ├── header.php, footer.php  # Public layout
│   ├── functions.php           # Shared helpers (e, old, flash, upload…)
│   ├── auth.php                # Admin session + login + lockout
│   ├── csrf.php                # CSRF token helpers
│   └── email.php               # Mail dispatcher (SMTP or mail())
├── handlers/
│   ├── proposal.php, register_team.php, card_apply.php
│   ├── sponsor.php, trip.php, newsletter.php
├── uploads/                    # Media (events, portfolio, partners, team…)
├── database/
│   └── apex_database.sql       # Full schema + seed data
├── index.php … links.php       # 16 public pages
├── register-team.php           # Competition registration form
├── .htaccess                   # Clean URLs + security headers
├── .env.example                # Environment template
├── robots.txt, sitemap.xml
└── README.md
```

---

## 🛡 Testing checklist (what was verified)

- [x] Every public page opens and renders
- [x] All navigation links work and highlight the active page
- [x] Mobile navigation (hamburger toggle) works
- [x] Responsive layouts at 360px / 768px / 1024px / 1440px
- [x] All forms validate client-side AND server-side
- [x] CSRF protection on every POST
- [x] Successful submissions write to MySQL
- [x] Admin login requires valid credentials
- [x] Unauthorised users cannot access `/admin/*`
- [x] Login lockout kicks in after 6 failed attempts
- [x] CRUD operations work for every module
- [x] Calendar data loads from MySQL and filters by category / month / status
- [x] Portfolio details render in a modal with results, gallery and quote
- [x] Partner directory filters by type and city
- [x] Image uploads validate type + size, rename files, land under `uploads/`
- [x] No PHP warnings or notices with `APP_DEBUG=false`
- [x] `php -l` linting passes for all 77 PHP files
- [x] `.htaccess` blocks execution in `uploads/`
- [x] Settings table drives dynamic contact details / response time site-wide

---

## 📝 Content rules honoured (from the supplied PDF)

- Every bracketed placeholder (`[City]`, `[PKR ___]`, `[Year]`) kept as a
  placeholder, never replaced with invented data.
- Partner records are seeded with `[Partner Name]` placeholders — real partner
  names and discounts should only be added once agreed in writing.
- Portfolio / past events are seeded as unconfirmed samples.
- Testimonials are empty by default — add only real, signed quotes.
- APEX Card application for anyone under 18 asks for a guardian name.
- Competition registration for school students collects coordinator details,
  not minors' direct contact.

---

## 📞 Support & customisation

The codebase is deliberately framework-free (no Composer dependency required
for core functionality) so it runs on any PHP 8+ / MySQL 5.7+ shared host. To
extend:

- Add a new page: copy `about.php`, change `$pageTitle`, write the content,
  include `includes/header.php` / `includes/footer.php`.
- Add a new form: create a handler under `handlers/`, add a table in the SQL,
  wire up CSRF + validation (follow `handlers/proposal.php`).
- Add a new admin module: duplicate a CRUD folder under `admin/` (e.g.
  `faq/`), adjust the table name and fields.

---

**Default admin credentials (change on first login):**

```
URL:      /admin/
Email:    admin@apex.local
Password: ApexAdmin!2026
```

> Creating Experiences. Managing Competitions. Celebrating Excellence.
