# ✅ User Model Test - `02-user-model-test` Branch

This branch adds automated tests for the `User` model in the `laravel-property-booking` package, including support for both `host` and `guest` roles using a factory.

---

## ✅ What Was Added

### 1. **User Factory Setup**
- Updated the `UserFactory` to work with the custom `User` model inside the package.
- Ensured the factory supports the `host` and `guest` roles.

**Path:** `database/factories/UserFactory.php`

```php
public function modelName(): string
{
    return \Anas\PropertyBooking\Models\User::class;
}
