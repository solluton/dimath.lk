# Dimath Group Website

A modern, SEO-friendly corporate website for Dimath Group (Sri Lanka) - a diversified business group with a simple PHP backend and an admin panel to manage content, legal pages, and contact leads.

## Overview

- Public site (clean URLs, no .php): Home, About Us, Our Companies, Contact Us, Legal pages
- Admin site: Contact Leads, Email Queue, Legal Pages, Settings, URL Redirects
- Branding and UI aligned with Dimath Group green theme
- Responsive design with Lenis smooth scrolling

Live domain: `https://dimathgroup.lk/`

## Key Features

- Clean URLs via lightweight router (`router.php`) and `url()` helper
- Global includes for navbar, footer; links powered by `url()` and `asset()` helpers
- Company details loaded from `config/company_details.json`
- Legal pages (Privacy Policy, Terms of Service, Cookies Policy) read from `legal_pages` table and editable in admin
- Contact form with AJAX submission, success messages, and email queue system
- Lenis smooth scrolling implementation across the entire site
- Navbar scroll shadow effect and active state highlighting
- Secure sessions, CSRF protection, basic hardening
- Dynamic `sitemap.xml` generator that uses SITE_URL
- Responsive design with proper mobile padding

## Tech Stack

- PHP 7.4+ (no framework), MySQL 5.7+
- HTML, CSS, JS (Webflow-derived frontend + Lenis smooth scrolling)
- PHPMailer for email queue system

## Prerequisites

- PHP 7.4+ with PDO MySQL
- MySQL 5.7+
- Web server (Apache/Nginx). If using Apache, enable mod_rewrite

## Setup

1) Clone
```bash
git clone https://github.com/solluton/dimath.lk.git
cd dimath.lk
```

2) Environment
```bash
cp env.example .env
# Edit .env
# SITE_URL=dimathgroup.lk
# DB_HOST=127.0.0.1
# DB_USER=your_user
# DB_PASS=your_pass
# DB_NAME=your_db
```

3) Database
- Create an empty database (DB_NAME) and grant user permissions
- Open the site once to allow `initializeDatabase()` to create/align tables, or import your existing data

4) Company details
- Update `config/company_details.json` (name, email, phone, socials, business hours). Socials control footer icons.

5) Web server
- Point document root to the project path
- Route traffic to `router.php` (or use `.htaccess` to index into `index.php` and includes)

## Admin Panel

- Navigate to `/admin/` and create the first admin user directly in DB if none exists
- Modules: Contact Leads, Email Queue, Legal Pages, Settings, URL Redirects
- Green color scheme matching the main site branding

## Sitemaps & Robots

- Generate sitemap (uses SITE_URL):
```bash
php -d detect_unicode=0 -r "putenv('SITE_URL=dimathgroup.lk'); include 'generate-sitemap.php';" > sitemap.xml
```
- `robots.txt` is included at project root

## Deployment Notes

- Set `SITE_URL=dimathgroup.lk` in `.env` on the server
- Ensure write access for `uploads/` directory
- Remove any dev-only seed/migration scripts before production (already removed)

## Security

- CSRF protection, secure sessions (httponly, samesite)
- Input validation on server side; image upload checks
- Avoid exposing admin endpoints publicly; use strong passwords

## License

Proprietary software for Dimath Group. All rights reserved.

## Support

- Email: info@dimathgroup.lk
- Developer: https://solluton.com
