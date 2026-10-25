# Security Findings

The issues I found in the original app, how I fixed them, and how I checked the fixes.

## Fixed

### 1. No HTTPS
Everything went over plain HTTP, so anyone on the network could read logins and passwords.

- **Fix:** OpenSSL certificate signed by a private root CA, Nginx serving HTTPS on port 443, and an HSTS header
- **Checked:** Pytest test that the app responds over HTTPS

### 2. No logging
There was no way to know if someone was attacking the app.

- **Fix:** Monolog sends failed logins, vault creates and deletes, and logouts to Loggly
- **Checked:** the events show up in Loggly

### 3. No access control
Everyone shared one login and could see everything.

- **Fix:** role-based access for admins, regular users, vault owners, and editors/viewers

### 4. SQL injection and XSS
The login page and forms passed user input straight through.

- **Fix:** input validation and sanitization, plus a Content-Security-Policy header
- **Checked:** Pytest scripts that send SQL injection and `<script>` payloads and confirm they fail

### 5. Login state stored in cookies
The app set `authenticated=<username>` and `isSiteAdministrator=1` as cookies. Anyone could edit them in the browser to log in as someone else or make themselves an admin.

- **Fix:** moved both into server-side PHP sessions
- **Checked:** Selenium tests confirming a valid login works and a bad one fails

### 6. MIME sniffing allowed
- **Fix:** `X-Content-Type-Options: nosniff` header

## Not fixed yet

### 7. Stored credentials aren't encrypted
Passwords in the MySQL database are stored as-is, so anyone who gets into the database can read them. Next step is encrypting vault passwords before they're saved.

### 8. Docker containers use default settings
The containers still run with their default configs. Next step is reviewing them, for example running as a non-root user and not exposing the database port.

### 9. Session cookie could be stronger
The session cookie should have the HttpOnly, Secure, and SameSite flags. The app should also call `session_regenerate_id()` after login and `session_destroy()` on logout.

### 10. Database password in the code
The MySQL password is hard-coded in login.php. It should move to the .env file like the Loggly token.
