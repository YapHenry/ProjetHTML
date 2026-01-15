# University Library Management System

## Project Overview
This project is a dynamic web application designed to manage the daily operations of a university library. It handles book loans, study space reservations, and user management.

The system relies on a **Client-Server architecture**, where the server (PHP) dynamically generates HTML content based on data retrieved from a relational database (MySQL).


## Technical Architecture

### 1. Technology Stack
* **Backend:** Native PHP (Procedural). We chose not to use frameworks to demonstrate a deep understanding of core server-side logic and HTTP handling.
* **Database:** MySQL.
* **Database Access:** **PDO (PHP Data Objects)**. This was chosen to ensure security against SQL Injections via prepared statements and to abstract database interactions.
* **Frontend:** HTML5, CSS3 (using CSS Variables `:root` for consistent theming), and Native JavaScript.

### 2. Modular Structure
To ensure code maintainability and avoid redundancy (`DRY` principle), the project is structured as follows:
* **`db.php`**: A centralized database connection file included via `require` in all scripts.
* **`header.php` / `footer.php`**: Contains common HTML structures (navigation, metadata, cookie scripts). Changes here reflect instantly across the entire application.
* **`style.css`**: A global stylesheet handling the responsive design and visual feedback.


## Core Logic & Data Flow

### 1. Catalog & Real-Time Availability
The application uses **conditional rendering** based on database states.
* **Logic:** The PHP script fetches items (`SELECT *`). For each item, it checks the boolean column `is_available` (0 or 1).
* **Visual Output:**
    * If `1`: A **Green** CSS class (`status-free`) is injected.
    * If `0`: A **Red** CSS class (`status-busy`) is injected, and the interaction is disabled.

### 2. Reservation System (Transactional Logic)
When a user reserves a book or space (`traitement-emprunt.php`), the backend performs a sequence of critical actions:
1.  **Session Check:** Verifies `$_SESSION['user_id']`.
2.  **Concurrency Check:** Re-verifies if the item is *still* available in the DB (to prevent double booking).
3.  **Update:** Marks the item as unavailable (`UPDATE ... SET is_available = 0`).
4.  **Logging:** Inserts a record into the transaction table (`INSERT INTO loans ...`).

### 3. User Dashboard & SQL Joins
The dashboard reconstructs complex data using **SQL JOINS**.
* Since the `loans` table only stores IDs (e.g., `user_id`, `book_id`), the system performs an **INNER JOIN** with the `books` table to display human-readable data (Book Title, Cover Image) alongside the loan date.


## Security & Administration

### 1. Role-Based Access Control (RBAC)
Security is managed via a `role` column in the users table.
* **Logic:** On every protected page (e.g., `admin.php`), the script checks if the connected user has the role `'admin'`.
* If the role is not `'admin'`, the script immediately redirects the user to the public dashboard.

### 2. Secure File Uploads
The "Add Book" feature handles image uploads securely:
* Files are processed via `$_FILES`.
* The system generates a **unique ID** (`uniqid()`) for every file to prevent overwriting existing images.
* The file path is stored in the database, while the physical file is moved to the `medias/` folder.


## GDPR & Cookie Management
The project implements a **Native JavaScript Cookie Consent** system (No external libraries).

* **Mechanism:** On page load, JS checks for the existence of the `accept_cookies` token.
* **Persistence:**
    * **Accept:** A persistent HTTP cookie is created (`document.cookie`) with a 30-day expiration.
    * **Refuse:** No tracking cookie is set. The banner is simply hidden.


## HTTP Methods Justification

The application strictly follows REST principles regarding HTTP methods:

* **POST Method:** Used for **Login, Registration, Reservations, and Updates**.
    * *Reason 1:* **Security**. Credentials (passwords) are not exposed in the URL.
    * *Reason 2:* **State Change**. According to HTTP standards, any request that modifies the server's state (INSERT/UPDATE) must use POST.
    * *Reason 3:* **Payload**. Necessary for sending larger data (like image uploads).

* **GET Method:** Used for **Navigation and Detail Views** (e.g., `detail_book.php?id=12`).
    * *Reason:* It allows users to bookmark or share specific URLs, as the resource identifier is passed via the query string.


## Installation Instructions

1.  **Database Setup:**
    * Import the provided `database.sql` file into your MySQL server.
    * Configure your credentials in `db.php`.

2.  **Server Setup:**
    * Place the project files in your local server directory (`www` or `htdocs`).
    * Ensure the `medias/` folder has write permissions.


