# Laravel Booking System

A Laravel-powered API with a Vue single-page frontend for browsing rentable/bookable items, checking availability, calculating prices, collecting bookings, and gathering post-stay reviews.

## Core features
- **Bookable catalog** – list and detail endpoints return item metadata (title, description, price) for the frontend catalog views.
- **Availability checks** – validates date ranges for a bookable and returns 200/404 responses depending on whether existing bookings overlap the requested window.
- **Price calculation** – computes stay length in days, multiplies by the bookable daily price, and returns the total alongside a simple breakdown.
- **Basket & checkout** – Vuex-powered basket persists to localStorage; checkout revalidates availability, computes booking totals, stores customer address data, and creates bookings linked to bookables.
- **Review flow** – bookings are issued a unique review key; guests can submit a review using that key, which is then cleared to prevent reuse.

## Architecture at a glance
- **Backend (Laravel API)**
  - `routes/api.php` defines REST endpoints for bookables, availability, pricing, reviews, and checkout.
  - Controllers in `app/Http/Controllers/Api` handle read APIs, date validation, price calculation, and checkout orchestration.
  - Eloquent models (`app/Bookable.php`, `app/Booking.php`, `app/Review.php`, `app/Address.php`) encapsulate availability checks, price math, booking relations, and review-key creation.

- **Frontend (Vue SPA)**
  - Bootstrapped in `resources/js/app.js` with Vue Router, Vuex, Axios, Moment, and shared UI components (star rating, error/success banners, validation errors).
  - `resources/js/routes.js` defines catalog, bookable detail, review, basket, checkout, and auth routes mounted into the SPA shell.
  - Vuex store (`resources/js/store.js`) manages last search dates, basket contents, and auth/user state, persisting data to localStorage and syncing with `/api/user`.

## Getting started
1. Install PHP dependencies with `composer install` and JavaScript dependencies with `npm install` or `yarn`.
2. Copy `.env.example` to `.env`, update database credentials, and run `php artisan key:generate`.
3. Run database migrations with `php artisan migrate`.
4. Build frontend assets with `npm run dev` (or `npm run watch` during development).
5. Start the API with `php artisan serve` and, optionally, run a separate asset watcher via `npm run watch` while developing the SPA.

## Key workflows
- **Searching & browsing:** The SPA fetches bookable listings and details, then shows availability and pricing widgets for the selected date range.
- **Booking:** Users add items to the basket, proceed to checkout, confirm availability, and create bookings with associated address records.
- **Reviewing:** After a stay, guests follow a review link containing their `review_key` to submit feedback tied to their booking and bookable.

## Extending the project
- Expand pricing rules (seasonal rates, taxes, coupons) by extending `Bookable::priceFor` and its API response.
- Integrate payments and booking statuses into `CheckoutController` for real-world checkout flows.
- Strengthen availability logic in `Booking::scopeBetweenDates` to handle time zones, buffers, or minimum/maximum stay rules.
- Replace placeholder reviewer names with authenticated user data and add moderation or verification for submitted reviews.
