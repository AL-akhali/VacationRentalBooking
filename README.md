## 07 - Booking Status Flow

This step adds support for managing the full booking lifecycle.

### ✅ Booking Statuses Added:
- pending
- confirmed
- paid
- checked_in
- cancelled
- rejected

### 🧠 Model Enhancements
- `Booking::statuses()` returns available status options.
- `advanceStatus()` method allows progressing a booking to the next step.

### 📦 API
- `PATCH /api/bookings/{booking}/status`
- Requires `status` field in request body.
- Uses `auth:sanctum` middleware.

### 🧪 Factory
- `BookingFactory` for creating test bookings with random dates and guests.
