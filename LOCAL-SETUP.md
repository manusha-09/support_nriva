# Run locally with XAMPP

Open http://localhost/support.nriva.org/ in your browser.

Double-click start-local.cmd in this folder to start Apache and MySQL if stopped, clear Laravel's configuration/view caches, check the homepage, and open the site. These processes continue after the launcher closes. After restarting Windows, run the launcher again or start Apache and MySQL in the XAMPP Control Panel.

Local Apache maps /support.nriva.org to this project's public directory using D:/xampp/apache/conf/extra/httpd-vhosts.conf. The original configuration is backed up alongside it as httpd-vhosts.conf.nriva-backup. public/.htaccess uses RewriteBase /support.nriva.org/ for this local alias; adjust or remove that directive when deploying under another URL.

Laravel asset() paths must start with plugins/, dist/, or storage/, without a public/ prefix. public/storage is already linked to storage/app/public. No npm build is required for the bundled AdminLTE assets.

The existing local database and application key are preserved. No database reset or seed is performed. APP_URL is http://localhost/support.nriva.org. The existing PHP development server at http://127.0.0.1:8000 also serves the corrected assets, but runs only while its process is alive. Prefer the XAMPP URL for routine use.

Sign in again at the new localhost address; browser sessions from 127.0.0.1 are separate. Use Ctrl+F5 once after this update. Some optional fonts/editors/icons still use third-party CDNs and need internet access.
Database integration: DB_DATABASE=nriva_new is the only application database. config(nriva.database) follows DB_DATABASE. Authentication uses users; chapter and committee lookups use chapters, committees, and committeemembers directly. Separate user/chapter/committee management routes and registration are disabled. Ticketing continues to use tbl_ticketing_system_tickets and the copied prefixed categories, comments, projects, logodata, notifications, and password reset tables. Existing support_tickets and other NRIVA tables were not replaced. The original db_support_system tables remain as a backup; runtime does not query them.

Ticket submission schema: migration 2026_11_05_110000 adds the nullable ticket_created_by_id field expected by creator tracking. Local notifications use MAIL_MAILER=log and are written to storage/logs/laravel.log; configure a working mail transport explicitly for external delivery.

Local transfer on 2026-11-06 preserved all 16 legacy tickets. Old user references were mapped by email and chapter references by exact name, never by assuming IDs match. All 16 ticket owners and six nonzero chapter references were unmatched; the corresponding active references are NULL. Original references remain in legacy_created_by, legacy_chapter_id, legacy_ticket_created_by_id, and comments.legacy_user_id for reconciliation. Unmatched comment users use ID 0 and display Former user. Review these mappings before production. Admin access follows the Admin role (roles.slug=admin) assigned through nriva_new.role_users; no fixed user ID grants access.
