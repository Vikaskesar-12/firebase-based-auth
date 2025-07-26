# ✅ Laravel Firebase Task Manager App

This is a simple task manager built with **Laravel** backend and **Firebase Authentication + Firestore** for user login and task storage.

---

## 🚀 Features

- Firebase Authentication (Email/Password)
- Task CRUD operations via Firestore
- Protected dashboard with middleware
- Responsive Bootstrap UI

---

## 🛠 Tech Stack

- Laravel 10+
- Firebase Auth + Firestore
- Bootstrap 5
- JQuery / AJAX
- Deployed via **Railway** / **Render**

---

## 📁 Folder Structure

├── app/
├── config/
├── public/
├── resources/
│ └── views/
│ ├── login.blade.php
│ ├── dashboard.blade.php
│ └── add-task.blade.php
├── routes/
│ └── web.php
├── .env
├── composer.json
└── README.md



---

## 🔐 Firebase Setup

1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Create a new project.
3. Enable **Email/Password Auth** in **Authentication → Sign-in method**
4. Go to **Firestore Database**, click **Create Database** (start in test mode).
5. Get Firebase config from `Project Settings → General`.

Replace it in your Blade template (dashboard):

```js
const firebaseConfig = {
  apiKey: "YOUR_API_KEY",
  authDomain: "your-project.firebaseapp.com",
  projectId: "your-project",
  ...
};


# 1. Clone the repo
git clone https://github.com/your-name/laravel-firebase-taskapp.git
cd laravel-firebase-taskapp

# 2. Install dependencies
composer install

# 3. Create env file
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Install Firestore SDK
composer require google/cloud-firestore

# 6. Serve
php artisan serve
    