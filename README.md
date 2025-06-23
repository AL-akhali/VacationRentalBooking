## 08 - Booking Validation

### ✅ Purpose:
Prevent bookings on unavailable dates.

### 🧠 Property Model:
- `isAvailableForDates($start, $end)` checks that all days are available (is_available = true).

### 🔐 Booking API:
- On booking creation, the system checks availability.
- If dates are unavailable, a validation error is thrown.

### 🚫 Error example:
```json
{
  "message": "The property is not available for the selected dates.",
  "errors": {
    "date_range": [
      "The property is not available for the selected dates."
    ]
  }
}
