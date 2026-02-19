# 🍔 Multi-Restaurant Marketplace (Hobby Project)

Welcome to the **Multi-Restaurant Marketplace**, a hobby project inspired by apps like Grab and Foodpanda.  
This system allows restaurants or store owners to register, manage their products, and receive orders, while customers can browse stores and place orders seamlessly.

---

## 🎯 Purpose

The goal of this system is to build a **full-stack e-commerce marketplace** that demonstrates:

- Multi-store (multi-tenant) architecture
- Role-based access (Admin, Store Owner, Customer)
- Order and commission handling
- Dashboard for both store owners and platform admin

This is a **hobby / learning project**, designed to experiment with Laravel, Vue, and headless e-commerce concepts.

---

## 🛠 Tech Stack

| Layer             | Technology / Framework                   |
|------------------|-----------------------------------------|
| Backend           | Laravel 11                               |
| E-Commerce Engine | Lunar PHP                                |
| Frontend          | Vue 3 + Inertia.js + Tailwind CSS       |
| Database          | PostgreSQL                               |
| Payments          | Stripe / PayMongo                        |
| Hosting / Dev     | Local Docker / VPS / Cloud Hosting       |

---

## 👥 User Roles

- **Admin**
  - Approves and manages stores
  - Views all orders and revenue
  - Sets platform commission rates

- **Store Owner**
  - Registers their store
  - Adds and manages products
  - Views orders and revenue dashboard

- **Customer**
  - Browses stores
  - Adds items to cart (one store at a time)
  - Places orders

---

## 🗄 Database Overview

Key tables:

- `users` – all users with roles
- `stores` – registered stores
- `products` – products belonging to each store
- `orders` – customer orders, with commission and store earnings
- `payouts` – records of payouts to stores

**Notes:**
- All tables use `store_id` for multi-store filtering
- `JSONB` columns are used for dynamic attributes and order items
- PostgreSQL transactions handle order placement and commission calculation safely

---

## 🚀 Features

- Multi-store marketplace (one platform, multiple restaurants)
- Dynamic product management with Lunar PHP
- Role-based dashboards
- Commission & payout tracking
- Cart system restricted per store
- Checkout and payment integration

---

## ⚙️ Development Notes

1. **Setup**
   - Clone repository
   - Run `composer install` and `npm install`
   - Configure `.env` for PostgreSQL connection
   - Run migrations: `php artisan migrate`
   - Seed initial data if needed: `php artisan db:seed`

2. **Development**
   - Backend logic in Laravel (Controllers, Policies, Services)
   - Frontend using Vue + Inertia (Pages, Components, Forms)
   - Orders and commission logic handled via dedicated services

3. **Testing**
   - PHPUnit for backend
   - Vue Test Utils for frontend components

---

## 📈 Roadmap (Optional Features)

- Rider / delivery assignment system
- Automatic payouts using Stripe Connect
- Multi-city support
- Promo codes & discounts
- Analytics dashboards for store owners

---

## 📝 Notes for Contributors

- Follow **PSR-12 coding standards** for PHP
- Use **SOLID principles** in Services, Controllers, and Policies
- All multi-store logic must respect `store_id` filtering
- Document new features in this README

---

## 🔗 Resources

- Lunar PHP: [https://lunarphp.com](https://lunarphp.com)
- Laravel Docs: [https://laravel.com/docs](https://laravel.com/docs)
- Vue 3 Docs: [https://vuejs.org](https://vuejs.org)
- PostgreSQL Docs: [https://www.postgresql.org/docs](https://www.postgresql.org/docs)

---

**Happy building!** 🚀
