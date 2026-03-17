# Laravel Joke Challenge

This project is a high-performance Laravel application that fetches programming jokes from an external API. It was built for the technical assessment, featuring a decoupled architecture with a TypeScript-powered frontend and a robust Service Layer backend.

## Setup Instructions

The project is fully dockerized. To get everything running, follow these steps:

1.  **To start:**
    ```
    git clone git@github.com:markmarilag27/laravel-mvc-jokes.git
    cd laravel-mvc-jokes
    cp .env.example .env
    docker compose build app
    ```
2.  **Start the containers:**
    ```
    bash ./run-start-container.sh
    ```

3.  **Open the container shell:**
    ```
    bash ./run-ssh-container.sh
    ```

4.  **Run the setup command:**
    Inside the container, run the automated setup script to handle dependencies, environment keys, and migrations:
    ```
    composer install
    php artisan key:generate
    php artisan migrate
    ```

5.  **Compile Assets:**
    Since the UI uses TypeScript, ensure the assets are compiled:
    ```
    bun install && bun run build
    ```

Once finished, the app will be live at `http://localhost`.

---

## Features

* **Service Layer Architecture:** Uses a `JokeService` with Data Transfer Objects (DTOs) to ensure data integrity and thin controllers.
* **TypeScript Frontend:** The UI is built with **TypeScript** and **Axios**, providing a type-safe, SPA-like experience for fetching and rendering jokes.
* **Dynamic Refresh:** A "Refresh" button allows users to fetch 3 new jokes without a full page reload, hitting the internal API endpoint.
* **REST API:** A dedicated `GET /api/jokes` endpoint is available, returning structured JSON with configurable limits.
* **Code Quality:** Strictly linted using **Laravel Pint** to ensure PSR-12 compliance.

---

## How to Run Tests

The application follows TDD principles. I used **Mockery** to stub external API calls, ensuring the test suite is fast, deterministic, and independent of external service uptime.

Run the tests inside the container using:
```bash
composer test
```

---

## Other Useful Commands

* **Shut down the project:** `bash ./run-stop-container.sh`
* **Fix code styling:** `composer fix-style` (runs Laravel Pint)
* **Watch Assets:** `bun run dev` (for real-time TypeScript/Tailwind compilation)

