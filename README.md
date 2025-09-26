# Exam (Shopping CMS)

- **Backend:** Laravel
- **Frontend:** Vue.js
- **Database:** SQLite
- **Styling:** Tailwind CSS

---

## Requirements

- PHP 8.2+
- Composer
- Node.js & npm

---

## Setup Instructions

1.  **Clone the repository**

    ```bash
    git clone <repository-url>
    cd <project-folder>
    ```

2.  **Install dependencies**

    ```bash
    composer install
    npm install
    ```

3.  **Configure the environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    touch database/database.sqlite
    ```

4.  **Migrate and seed the database**
    This command builds the database schema and creates the default admin user and product samples.
    ```bash
    php artisan migrate:fresh --seed
    ```

---

## Running the Application

1.  **Start the backend server**

    ```bash
    php artisan serve
    ```

2.  **In a new terminal, start the frontend server**
    ```bash
    npm run dev
    ```

The application is available at `http://127.0.0.1:8000`.

---

## Admin Account

- **Email:** `admin@pb.com`
- **Password:** `password`

---

## Running Tests

To execute the automated test suite, run the following command:

```bash
php artisan test
```
