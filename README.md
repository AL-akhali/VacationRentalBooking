## 09 - Booking Payments (Fake)

### 🔹 Database
- Added `payment_status` (pending, paid, failed)
- Added `payment_reference`

### 🔹 Model
- `markAsPaid()` method updates payment info and status to paid

### 🔹 API
- POST `/api/bookings/{booking}/pay`
- Body: `{ "payment_reference": "some_reference" }`
- Marks booking as paid and updates status
