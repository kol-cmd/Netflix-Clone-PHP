# 🎬 Netflix Clone (PHP & MySQL)

A fully functional, responsive Netflix Clone built from scratch using pure **PHP**, **MySQL**, and **JavaScript**. Features a dynamic video player, profile switching, "My List" functionality, and a responsive design that works on mobile and desktop.

![Project Preview](assets/images/background.jpg) 


## 🚀 Features

* **User Authentication:** Secure Login/Signup system with password hashing.
* **Profile System:** Create multiple user profiles (Kids, Adults) with custom avatars.
* **Dynamic Content:** Movies are fetched from a MySQL database via a custom PHP API.
* **Video Player:**
    * Supports Google Drive & YouTube embeds.
    * Auto-play trailers in the Hero section.
    * Fullscreen toggle and Mute/Unmute controls.
* **"My List" Feature:** Add/Remove movies to your personal watchlist using AJAX (no page reload).
* **Responsive Design:** optimized for Mobile, Tablet, and Desktop.

## 🛠️ Tech Stack

* **Frontend:** HTML5, CSS3, JavaScript (Vanilla ES6)
* **Backend:** PHP (Native)
* **Database:** MySQL
* **API:** REST-style PHP endpoints (JSON)

## 📦 Installation Guide

### 1. Setup the Database
1.  Create a database named `netflix_db` in phpMyAdmin.
2.  Import the file `sql/netflix_db.sql` (found in this repo).

### 2. Configure the Project
1.  Clone this repository to your local server folder (e.g., `htdocs` or `www`).
2.  Navigate to `includes/`.
3.  Rename `db_connection_example.php` to `db_connection.php`.
4.  Open it and enter your database credentials:
    ```php
    $servername = "localhost";
    $username = "root";
    $password = ""; // Your password
    $dbname = "netflix_db";
    ```

### 3. Run the Project
* Open your browser and go to: `http://localhost/Netflix-Clone/`

## 📂 Project Structure

```text
Netflix-Clone/
├── api/             # JSON Endpoints (get_movies.php, add_profile.php)
├── assets/          # CSS, JS, and Images
├── includes/        # DB Connection & Auth Helpers
├── sql/             # Database Import File (.sql)
├── index.php        # Main Application
└── login.php        # Authentication Page
