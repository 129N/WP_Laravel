# Waypoint Tracker — Backend

Brief: Laravel-based backend for the Waypoint Tracker app (used by React web and React Native clients).

---

## 🚀 Quick start — Activate the backend

1. Clone the repo and install PHP dependencies

```bash
git clone <repo-url>
cd waypoint_tracker
composer install
```

2. Copy `.env` and set environment variables

```bash
cp .env.example .env
php artisan key:generate
```

- Set database credentials (`DB_CONNECTION`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
- Optionally set `APP_URL` to a local network URL if you want to test from a phone (e.g. `http://192.168.0.101:8000`).

3. Run migrations and (optional) seeders

```bash
php artisan migrate
php artisan db:seed # optional
```

4. (Optional) Create a public storage link

```bash
php artisan storage:link
```

5. Start the server (local network accessible)

```bash
php artisan serve --host=0.0.0.0 --port=8000
# or run with default: php artisan serve
```

Tip: For mobile testing over the internet use ngrok or similar and set `APP_URL` to the forwarded https url.

---

## 🔐 Authentication

- The API uses Laravel Sanctum token-based auth for mobile/SPA usage.
- Public endpoints: `/ping`, `/status`, `/register`, `/login_react`, `/events` (GET) and GPX read endpoints.
- Login (`POST /login_react`) returns a plain text token. Use it as a Bearer token in requests:

Header:

```
Authorization: Bearer <token>
```

Logout endpoint (`POST /logout`) will delete the current token.

---

## 📄 Important API endpoints (summary)

- Health
  - `GET /api/ping`
  - `GET /api/status`

- Auth
  - `POST /api/register` (body: `name`, `email`, `password`, `role` = `admin|competitor`)
  - `POST /api/login_react` (body: `email`, `password`) → returns `token`
  - `POST /api/logout` (auth required)

- Events
  - `GET /api/events` (public) — list events
  - `GET /api/events/{event_code}` (public) — event details
  - `POST /api/events` (auth: admin) — create event
  - `POST /api/events/{event_code}/register` (auth) — register participant (body: `user_id`, optional `group_name`)
  - `GET /api/events/{event_code}/participants` — list participants

- GPX / Waypoints
  - `GET /api/filefetch` — get all stored waypoints & trackpoints
  - `POST /api/gpx-upload` — upload GPX (mobile legacy)
  - `POST /api/events/{event_code}/gpx-upload` — upload GPX linked to an event (multipart: `gpx_file`)
  - `GET /api/events/{event_code}/waypoints` — waypoints for event
  - `GET /api/events/{event_code}/trackpoints` — trackpoints for event

- Live location & notifications
  - `POST /api/events/{event_code}/location` (auth) — send location (body: `user_id`, `lat`, `lon`, [`speed`, `heading`])
  - `GET /api/events/{event_code}/locations` — latest locations for event
  - `POST /api/events/{event_code}/notifications` (auth) — create notification (body: `participant_id`, `type`, `message`)
  - `GET /api/events/{event_code}/notifications` — list notifications

- Emergency chat (auth)
  - `POST /api/event/{event_code}/emergency/{participant_id}/create`
  - `POST /api/event/{event_code}/emergency/{participant_id}/message`

Notes: many write endpoints require `auth:sanctum` middleware.

---

## 🧪 Example curl requests

Register:

```bash
curl -X POST https://<host>/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Alice","email":"alice@example.com","password":"secret","role":"competitor"}'
```

Login (get token):

```bash
curl -X POST https://<host>/api/login_react \
  -H "Content-Type: application/json" \
  -d '{"email":"alice@example.com","password":"secret"}'
```

Authenticated request (example):

```bash
curl -H "Authorization: Bearer <token>" https://<host>/api/events
```

Upload a GPX for an event (multipart):

```bash
curl -X POST "https://<host>/api/events/EV01/gpx-upload" \
  -H "Authorization: Bearer <token>" \
  -F "gpx_file=@/path/to/file.gpx"
```

Send live GPS update:

```bash
curl -X POST "https://<host>/api/events/EV01/location" \
  -H "Authorization: Bearer <token>" \
  -H "Content-Type: application/json" \
  -d '{"user_id":1,"lat":35.12345,"lon":139.12345,"speed":2.5}'
```

---

## ⚛️ Usage in React (web)

- Store token in `localStorage` and add `Authorization: Bearer <token>` header to API calls (or use axios interceptors).
- Example login + request using fetch:

```js
// login
const res = await fetch(`${BASE_URL}/login_react`, {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({ email, password })
});
const data = await res.json();
localStorage.setItem('token', data.token);

// fetch events
const events = await fetch(`${BASE_URL}/events`, {
  headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
}).then(r => r.json());
```

- File upload (GPX): create a FormData and send as `multipart/form-data` with auth header.

---

## 📱 Usage in React Native

- Use `@react-native-async-storage/async-storage` to save the token securely (for more security, prefer SecureStore/Keychain).
- Use device IP or ngrok URL for `BASE_URL`. If using `http://` (not https) on iOS, you may need to allow ATS exceptions or use a secure tunnel.

Example (login + send GPS):

```js
// after login
await AsyncStorage.setItem('token', token);

// send location
await fetch(`${BASE_URL}/events/EV01/location`, {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'Authorization': `Bearer ${await AsyncStorage.getItem('token')}`
  },
  body: JSON.stringify({ user_id: myUserId, lat, lon, speed })
});
```

- For continuous tracking: run a background geolocation task and POST to `/events/{event_code}/location` periodically.

---

## 🔧 Notes & best practices

- Use HTTPS in production and secure token storage in clients.
- The `delete` / cleanup endpoints may be dangerous—limit to admin only or remove in production.
- Broadcast / realtime features use the Laravel `broadcasting/auth` endpoint; configure Pusher/Laravel Echo if you need live emergency chat.
- If you get `401` or `403`, confirm the `Authorization` header and token validity.

---

## ✅ Development & testing

- Run PHPUnit/Pest tests:

```bash
php artisan test
```

- Logs: `storage/logs/laravel.log`

---

If you'd like, I can add a short example React app or a Postman collection with ready-to-use requests. Let me know which you'd prefer. ✨
