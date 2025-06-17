# Branch: 05-pricing-rules

## ميزة قواعد التسعير للعقارات (Property Pricing Rules)

### الوصف
تمت إضافة نظام لإدارة قواعد التسعير لكل عقار، بحيث يمكن تحديد:

- الحد الأدنى للأيام للحجز (min_stay)
- الحد الأقصى للأيام للحجز (max_stay)
- وقت تسجيل الوصول (check_in_time)
- وقت تسجيل المغادرة (check_out_time)

---

### التعديلات التي تم تنفيذها:

1. **Migration**  
   تم إنشاء جدول `property_pricing_rules` يحتوي على الحقول الأساسية وربطها بالعقار (`property_id`).

2. **موديل PropertyPricingRule**  
   يحتوي على العلاقات والحقول القابلة للكتابة (`fillable`).

3. **تعديل موديل Property**  
   إضافة علاقة `pricingRule` لربط العقار بقواعد التسعير الخاصة به.

4. **Seeder**  
   تمت إضافة Seeder يقوم بتوليد بيانات افتراضية لقواعد التسعير لكل عقار موجود في قاعدة البيانات.

5. **Livewire Component**  
   تم تطوير مكون Livewire باسم `PropertyPricingRuleManager` يمكن المضيف من تعديل قواعد التسعير عبر واجهة مستخدم سهلة الاستخدام.

---

### طريقة الاستخدام:

- يمكن عرض وإدارة قواعد التسعير في صفحة عرض العقار عبر تضمين:

```blade
<livewire:property-pricing-rule-manager :property="$property" />
