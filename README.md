## 10 - Booking Management

### 🔹 API Endpoints:
- GET `/api/bookings/host` — List bookings for host's properties
- PATCH `/api/bookings/{booking}` — Update booking (host only)
- DELETE `/api/bookings/{booking}` — Cancel booking (host or guest)

### 🔹 Authorization:
- Only property owner (host) can update booking
- Only host or guest can cancel booking

### 🔹 Response:
- JSON with booking details and messages
