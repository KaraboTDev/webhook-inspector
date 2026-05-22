# WebhookInspector 🔗

A developer tool for capturing, inspecting and replaying 
incoming HTTP webhook payloads in real time.

Built specifically for developers integrating South African 
payment gateways like PayFast who need to debug webhook 
notifications during local development.

## Features
- Generate unique public endpoints in seconds
- Captures every incoming request in real time
- Stores full payload — method, headers, body, content type
- One click replay of any captured webhook
- Delete individual logs or entire endpoints
- Clean dashboard UI

## The Problem It Solves
Standard GPS treats Pretoria at 12:00 PM and 7:00 PM the same.
PayFast can't send webhooks to your localhost during development.
This tool gives you a public URL to capture everything PayFast 
sends, so you can inspect and replay it without triggering 
real payments.

## Tech Stack
- PHP Laravel 12
- SQLite
- Blade templating
- Eloquent ORM
- Laravel MVC architecture

## How To Run
1. Clone the repo
2. Run `composer install`
3. Copy `.env.example` to `.env`
4. Run `php artisan key:generate`
5. Run `php artisan migrate`
6. Run `php artisan serve`
7. Visit `http://localhost:8000`

## Author
Built by Karabo Tshivhase — Final year Software Development
student 🇿🇦
