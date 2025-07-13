# 1 - Introduction
This web application is designed to manage recipes, allowing users to create, edit, and delete recipes, as well as generate shopping lists based on selected recipes. It includes a role-based access control system to secure the application and its inputs.

# 2 - Installation
- Clone the repository.
- Install dependencies using Composer.
- Configure the database connection in `Database.php`.
- Import the SQL schema from `recipeapp.sql` into your database (mySQL).
- Start the web server(e.g., using PHP's built-in server or Apache).

# 3 - Features
- User authentication with roles and permissions.
- Recipe management (create, read).

# 4 - Security
- Input validation and sanitization to prevent SQL injection and XSS attacks.
- Role-based access control to restrict actions based on user roles.
- Secure session management to protect user sessions.

# 5 - Future Improvements
- Recipe card editing and deletion buttons.
- Enhanced security measures for user authentication.
- Recipe card refactoring with steps and images.
- Recipe publication system.
- Recipe generation system.
- Shopping list generation system.
- Implement a more robust user authentication system (e.g., OAuth).
- Enhance the UI with a modern front-end framework.
- Add unit tests for critical components.