# Repository Overview: Blog

- **Language/Stack**: PHP (procedural), MySQL, Bootstrap-style HTML, XAMPP environment
- **Target base URL**: `/Blog` (configured in `config/config.php`)
- **Auth**: Simple session-based auth (`require_login`, `is_logged_in`)
- **Helpers**: `db()` for PDO, `e()` for escaping, `redirect()`, flash helpers, `slugify()`

## Structure
- **index.php, post.php**: Public pages
- **admin/**: Admin interface (login, CRUD for posts)
- **config/**: Global configuration and helpers
- **includes/**: Header/footer includes
- **assets/**: CSS and uploads
- **migrations/**: SQL files for database schema

## Notable Conventions
- **Redirects** use `redirect('/path')` which prefixes with `$BASE_URL`
- **Escaping**: Always use `e()` in templates for user-visible data
- **Database**: PDO with ERRMODE_EXCEPTION and FETCH_ASSOC
- **Slug**: Generated with `slugify()` and enforced unique via DB checks

## Admin Posts
- `admin/posts.php`: List
- `admin/post_new.php`: Create
- `admin/post_edit.php`: Update (supports optional image upload)
- `admin/post_delete.php`: Delete

## Environment Notes
- Assumed **MySQL** running locally with credentials in `config/config.php`
- Default timezone set to UTC

## Testing & Running
- Place repo under `c:/xampp/htdocs/Blog`
- Access via `http://localhost/Blog`

This file helps assistants understand repository layout and conventions to provide accurate, minimal-change fixes without altering output behavior.