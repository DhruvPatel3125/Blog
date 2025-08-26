# Blog Website

This is a simple blogging website built with PHP and MySQL. It allows users to create, read, update, and delete blog posts. The administrative interface is protected by a login system.

## Features

*   **Public Post Listing**: Display of the latest blog posts on the homepage.
*   **Individual Post View**: Detailed view of each blog post.
*   **Admin Panel**:
    *   Secure login for administrators.
    *   Management of blog posts (create, edit, delete).
*   **Image Uploads**: Support for uploading images for blog posts.
*   **Slug Generation**: Automatic generation of SEO-friendly slugs for post titles.
*   **Flash Messages**: User-friendly feedback messages after actions.

## Project Structure

*   `admin/`: Contains files for the administrative interface (login, post management).
*   `assets/`: Stores static assets like CSS, and uploaded images.
    *   `assets/css/`: Contains custom CSS styles.
    *   `assets/uploads/`: Stores images uploaded for blog posts.
*   `config/`: Contains the main configuration file (`config.php`).
*   `includes/`: Contains reusable PHP components like `header.php` and `footer.php`.
*   `migrations/`: Contains SQL scripts for database schema management.
*   `index.php`: The main homepage displaying recent blog posts.
*   `post.php`: Displays a single blog post.

## Database Schema

The application uses a MySQL database with the following tables:

### `users` table

| Column        | Type         | Description                       |
| :------------ | :----------- | :-------------------------------- |
| `id`          | INT          | Primary Key, Auto-Increment       |
| `name`        | VARCHAR(100) | User's full name                  |
| `email`       | VARCHAR(190) | User's email, unique              |
| `password_hash` | VARCHAR(255) | Hashed password for security      |
| `created_at`  | TIMESTAMP    | Timestamp of user creation        |

### `posts` table

| Column       | Type         | Description                             |
| :----------- | :----------- | :-------------------------------------- |
| `id`         | INT          | Primary Key, Auto-Increment             |
| `title`      | VARCHAR(200) | Title of the blog post                  |
| `slug`       | VARCHAR(220) | URL-friendly slug, unique               |
| `image_path` | VARCHAR(255) | Path to the post's featured image (NULLABLE) |
| `excerpt`    | TEXT         | Short summary or preview of the post (NULLABLE) |
| `content`    | MEDIUMTEXT   | Full content of the blog post           |
| `created_at` | TIMESTAMP    | Timestamp of post creation              |

## Setup Instructions

1.  **Clone the Repository**:
    ```bash
    git clone [repository_url]
    cd Blog
    ```

2.  **Web Server Setup**:
    *   Place the `Blog` folder in your web server's document root (e.g., `htdocs` for XAMPP, `www` for WAMP, or `/var/www/html` for Apache on Linux).
    *   Ensure your web server (Apache, Nginx) and PHP are correctly configured.

3.  **Database Configuration**:
    *   Create a MySQL database named `blog_db` (or whatever you prefer, but remember to update `config/config.php`).
    *   Update the database connection details in `config/config.php`:
        ```php
        const DB_HOST = 'localhost';
        const DB_NAME = 'blog_db'; // Your database name
        const DB_USER = 'root';    // Your database username
        const DB_PASS = '';        // Your database password
        ```

4.  **Run Migrations**:
    *   Execute the SQL files in the `migrations/` directory to set up your database tables. You can do this using a MySQL client (like phpMyAdmin, MySQL Workbench, or the command line):
        ```sql
        -- Execute 001_init.sql
        SOURCE path/to/Blog/migrations/001_init.sql;

        -- Execute 003_add_post_image.sql
        SOURCE path/to/Blog/migrations/003_add_post_image.sql;
        ```
    *   Alternatively, you can copy the content of these files into your MySQL client and run them.

5.  **Base URL Configuration**:
    *   Adjust `$BASE_URL` in `config/config.php` to match your project's URL. For XAMPP, if your folder is directly in `htdocs`, it might be `'/Blog'`.
        ```php
        $BASE_URL = '/Blog'; // Example: if your project is at http://localhost/Blog
        ```

## Usage

### Public Interface

*   **Homepage**: Access the main page at `http://localhost/Blog` (or your configured `$BASE_URL`). This will show the latest blog posts.
*   **View Post**: Click on a post title on the homepage to view the full post. The URL will look something like `http://localhost/Blog/post.php?slug=your-post-slug`.

### Admin Interface

*   **Login**: Navigate to `http://localhost/Blog/admin/login.php` to log in as an administrator.
    *   *Note*: There is no registration page for users by default. You will need to manually insert an admin user into the `users` table after setting up the database. For example:
        ```sql
        INSERT INTO users (name, email, password_hash) VALUES ('Admin', 'admin@example.com', '\$2y\$10\$YOUR_HASHED_PASSWORD_HERE');
        ```
        c:\xampp\php\php.exe c:\xampp\htdocs\Blog\migrations\002_seed_admin.php

        You can generate a password hash using `password_hash('your_password', PASSWORD_DEFAULT)` in a PHP script.
*   **Manage Posts**: After logging in, go to `http://localhost/Blog/admin/posts.php` to view, edit, or delete posts.
*   **New Post**: From the "Manage Posts" page, click "New Post" to create a new blog post.
*   **Edit Post**: Click "Edit" next to a post on the "Manage Posts" page to modify an existing post.
*   **Delete Post**: Click "Delete" next to a post to remove it. You will be asked for confirmation.

## Technologies Used

*   PHP
*   MySQL
*   HTML
*   CSS (Bootstrap is likely used for styling based on class names, though not explicitly imported in the provided files)

## Contributing

Feel free to fork the repository, make improvements, and submit pull requests.

## License

[Specify your license here, e.g., MIT, Apache 2.0, etc.]



//add a admin in user copy this query

INSERT INTO users (name, email, password)
VALUES ('Admin', 'admin@example.com', 'admin123')
ON DUPLICATE KEY UPDATE password = VALUES(password);