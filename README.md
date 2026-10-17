# Saksham Bhandari Portfolio

A responsive portfolio built with HTML5, CSS, vanilla JavaScript, PHP, and MySQL. No front-end framework is required. This starter includes database-driven public content, project detail pages, theme switching, responsive navigation, social links, and a CSRF-protected contact form that stores messages in MySQL.

## Requirements

- XAMPP with Apache, PHP 8+, and MySQL/MariaDB
- PHP extensions: `pdo_mysql` and `mbstring`
- Internet access for Google Fonts, Devicon technology icons, and the supplied institution logo images (you can download and host assets locally if desired)

## Run locally with XAMPP

1. Start **Apache** and **MySQL** in the XAMPP Control Panel.
2. Copy this `saksham-portfolio` folder to `C:\xampp\htdocs\saksham-portfolio\`.
3. Open `http://localhost/phpmyadmin/`.
4. Select **Import**, choose `database.sql`, and import it. The script creates `saksham_portfolio` and its tables.
5. Open `config/database.php`. The default local settings are `localhost`, database `saksham_portfolio`, user `root`, and an empty password. Change these only if your local MySQL setup differs.
6. Visit `http://localhost/saksham-portfolio/`.
7. Test navigation, theme switching, project details, outbound links, and a contact-form submission. Confirm the test message appears in the `contact_messages` table in phpMyAdmin.

If you get a database connection error, check that MySQL is running, the database was imported, and the credentials match your XAMPP configuration. Do not expose detailed database errors to public visitors.

## Updating content

Most public content is read from MySQL:

- `personal_details`: name, title, biography, degree, and graduation year.
- `education`: institution details and logo URLs.
- `skills`: categories, icon classes, and descriptions. Devicon classes are available through the stylesheet included in `includes/header.php`.
- `projects`: descriptions, tags, live/repository URLs, screenshots, and publication status.
- `social_links`: social profiles and their order.
- `achievements`: certificates and milestones.
- `site_settings`: editable configuration values.

For example, configure Tilottama Connect's live website only after its URL is known:

```sql
UPDATE site_settings
SET setting_value = 'https://your-real-project-url.example'
WHERE setting_key = 'tilottama_connect_url';
```

Leave `setting_value` empty to keep the card visible without a live-project link. A repository URL can be configured independently in the `projects.repository_url` field.

To add a screenshot, put the image in `assets/images/` and set the relevant project's `screenshot_path` to a relative path such as `assets/images/horizone-preview.webp`. Use images you own or have permission to publish. To add a résumé, place the PDF in `assets/documents/` and add a navigation button only after the PDF exists.

The supplied logo URLs are stored in `education.logo_url`. If a remote logo stops working, save a permitted copy in `assets/images/` and update that row to use the local path.

## Contact form and security

The contact form validates fields in JavaScript and again on the server, uses a CSRF token, includes a honeypot field, uses a PDO prepared statement, escapes displayed database values, and stores messages in `contact_messages`. It does **not** send email. Configure and test an email delivery service separately if email notifications are required. For public deployment, consider a rate limiter or CAPTCHA and configure `IP_HASH_SALT` as a strong environment secret.

The form hashes the sender's IP address with a configurable salt rather than storing the raw address. Change the fallback salt in `submit_contact.php` by setting the `IP_HASH_SALT` environment variable on the server.

This starter does not include the optional admin dashboard. Do not add public CRUD routes without authentication, authorization, CSRF protection, validation, and safe upload handling. An admin system should be implemented and security-reviewed separately before public use.

## Deployment to PHP/MySQL hosting

1. Create a MySQL database and a database user in your hosting control panel. Grant the user only the privileges needed for the portfolio database.
2. Import `database.sql` using phpMyAdmin or the provider's database tool.
3. Upload the project files to the domain's document root (often `public_html/`). Keep configuration and other non-public files outside the document root when your host supports that layout.
4. Configure `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASS` as server environment variables. If environment variables are unavailable, update `config/database.php` with the host-provided values and ensure the file is not exposed or committed to a public repository.
5. Set `IP_HASH_SALT` to a long random secret. Do not commit secrets to GitHub.
6. Enable HTTPS in the hosting panel and redirect HTTP to HTTPS. Use restrictive file permissions and avoid making PHP files writable by the web server unless required.
7. Test every page, remote logo, external link, project URL, and contact submission. Confirm messages appear in the database. Email notifications require a separately configured mail service.
8. Remove test messages and verify that database errors are logged privately rather than shown to visitors.

## Notes / known configuration

- Expected graduation is displayed as 2030.
- Tilottama Connect is clearly described as a student concept, not an official municipal service. Its website and repository URLs are blank until configured.
- HORIZ.ONE links to the supplied live website. A screenshot placeholder is used until an actual screenshot is provided.
- The achievements section intentionally remains empty until verified certificates or achievements are added.
- No résumé or profile photo is invented; add your own assets when ready.
- This project has not been deployed online. Test in your target hosting environment before publication.

## Testing checklist

- [ ] Apache and MySQL start successfully
- [ ] SQL import completes without errors
- [ ] Homepage loads and content is read from MySQL
- [ ] Both institution logos load or fall back to the placeholder
- [ ] Theme toggle persists after refresh
- [ ] Mobile navigation opens, closes, and follows links
- [ ] Project detail pages load and invalid IDs show a 404-style message
- [ ] HORIZ.ONE opens in a new tab
- [ ] Tilottama Connect has no live link while its URL setting is blank
- [ ] Social links use safe external-link attributes
- [ ] Copy-email button reports success or fallback feedback
- [ ] Contact form rejects invalid inputs and stores valid messages
- [ ] Contact form does not claim to deliver email
- [ ] Production credentials and secrets are not committed to version control
- [ ] HTTPS is enabled before public launch
