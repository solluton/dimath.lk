# Dimath Sports Website

A modern, SEO-friendly sports goods website for Dimath Sports (Sri Lanka) with a simple PHP backend and an admin panel to manage products, categories, and legal pages.

## Overview

- Public site (clean URLs, no .php): Home, About, Our Products (with AJAX filters), Single Product, Process, Contact, Legal pages
- Admin site: Products CRUD, Categories CRUD, Contact Leads, Email Queue, Legal Pages, Settings, URL Redirects
- Branding and UI aligned with Dimath Sports green theme

Live domain: `http://dimathsports.lk/`

## Key Features

- Clean URLs via lightweight router (`router.php`) and `url()` helper
- Product gallery with 2/4/6 image rule and main image
- Featured products slider support
- Our Products page with category + keyword search (AJAX), dynamic counts, clear buttons
- Global includes for navbar, footer, CTA; links powered by `url()` and `asset()`
- Company details loaded from `config/company_details.json`
- Legal pages (Privacy, Cookies, Terms) read from `legal_pages` table and editable in admin
- Contact form with queue + email notifications (PHPMailer)
- Secure sessions, CSRF, basic hardening
- Dynamic `sitemap.xml` generator that uses SITE_URL

## Tech Stack

- PHP 7.4+ (no framework), MySQL 5.7+
- HTML, CSS, JS (Webflow-derived frontend + small custom JS)
- PHPMailer for email

## Prerequisites

- PHP 7.4+ with PDO MySQL
- MySQL 5.7+
- Web server (Apache/Nginx). If using Apache, enable mod_rewrite

## Setup

1) Clone
```bash
git clone https://github.com/solluton/dimathsports.lk.git
cd dimathsports.lk
```

2) Environment
```bash
cp env.example .env
# Edit .env
# SITE_URL=dimathsports.lk
# DB_HOST=127.0.0.1
# DB_USER=your_user
# DB_PASS=your_pass
# DB_NAME=your_db
```

3) Database
- Create an empty database (DB_NAME) and grant user permissions
- Open the site once to allow `initializeDatabase()` to create/align tables, or import your existing data

4) Company details
- Update `config/company_details.json` (name, email, phone, socials). Socials control footer icons.

5) Web server
- Point document root to the project path
- Route traffic to `router.php` (or use `.htaccess` to index into `index.php` and includes)

## Admin Panel

- Navigate to `/admin/` and create the first admin user directly in DB if none exists
- Modules: Products, Categories, Contact Leads, Email Queue, Legal Pages, Settings, URL Redirects

## Sitemaps & Robots

- Generate sitemap (uses SITE_URL):
```bash
php -d detect_unicode=0 -r "putenv('SITE_URL=dimathsports.lk'); include 'generate-sitemap.php';" > sitemap.xml
```
- `robots.txt` is included at project root

## Deployment Notes

- Set `SITE_URL=dimathsports.lk` in `.env` on the server
- Ensure write access for `uploads/`
- Remove any dev-only seed/migration scripts before production (already removed)

## Security

- CSRF, secure sessions (httponly, samesite)
- Input validation on server side; image upload checks
- Avoid exposing admin endpoints publicly; use strong passwords

## License

Proprietary software for Dimath Sports. All rights reserved.

## Support

- Email: info@dimathsports.lk
- Developer: https://solluton.com
