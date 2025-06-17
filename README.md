# 04 - Booking

This branch introduces the ** Booking ** feature for each property.  
It allows hosts to control which dates are available for booking.

---

## ✅ Objectives

- Create a model and table for `Booking`.
- Create Api CRUD
- Define a relationship between `Property` and its Booking dates.
- Allow setting whether a property is available on a given day.
- 30 days of availability per property.

---

## 🏗️ Features Implemented

### 1. Migration: `Booking` table
{
  "property_id": 1,
  "user_id": 2,
  "start_date": "2025-06-20",
  "end_date": "2025-06-25",
  "status": "paid",
  "special_request": "إطلالة على البحر"
}
