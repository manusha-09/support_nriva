# Run locally with XAMPP

Open http://localhost/support.nriva.org/ in your browser.

Double-click start-local.cmd in this folder to start Apache and MySQL if stopped, clear Laravel's configuration/view caches, check the homepage, and open the site. These processes continue after the launcher closes. After restarting Windows, run the launcher again or start Apache and MySQL in the XAMPP Control Panel.

Local Apache maps /support.nriva.org to this project's public directory using D:/xampp/apache/conf/extra/httpd-vhosts.conf. The original configuration is backed up alongside it as httpd-vhosts.conf.nriva-backup. public/.htaccess uses RewriteBase /support.nriva.org/ for this local alias; adjust or remove that directive when deploying under another URL.

Laravel asset() paths must start with plugins/, dist/, or storage/, without a public/ prefix. public/storage is already linked to storage/app/public. No npm build is required for the bundled AdminLTE assets.

The existing local database and application key are preserved. No database reset or seed is performed. APP_URL is http://localhost/support.nriva.org. The existing PHP development server at http://127.0.0.1:8000 also serves the corrected assets, but runs only while its process is alive. Prefer the XAMPP URL for routine use.

Sign in again at the new localhost address; browser sessions from 127.0.0.1 are separate. Use Ctrl+F5 once after this update. Some optional fonts/editors/icons still use third-party CDNs and need internet access.
Committee integration: NRIVA_DATABASE=nriva_new selects the existing local committees and committeemembers tables on the configured MySQL server. Set NRIVA_DATABASE to the appropriate database when deploying elsewhere, then run php artisan config:clear. The ticket database remains DB_DATABASE=db_support_system.

Ticket submission schema: migration 2026_11_05_110000 adds the nullable ticket_created_by_id field expected by creator tracking. Local notifications use MAIL_MAILER=log and are written to storage/logs/laravel.log; configure a working mail transport explicitly for external delivery.
