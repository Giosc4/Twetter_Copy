# Readme Project.

# Tweeter_copy

This project is a simple PHP and MySQL based social network that allows users to share short text messages and interact with other users.

## **Requirements**

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server with PHP support (XAMPP).

## **Installation**

1. Download and unzip the project to the web server folder.
2. Create a MySQL database and import the **`database.sql`** file.
3. Edit the **`db.php`** file with the database details (host, username, password and database name).
4. Start the web server and visit the application URL.

## **Functionality**

- User registration and authentication
- Creating, viewing and deleting messages (tweets)
- Adding and removing "likes" to tweets
- Editing user profile data
- User administration (for administrators only)

## **File structure**

- **`index.php`** - Main page
- **`login.php`** - Login page
- **`register.php`** - Registration page
- **`profile.php`** - User profile page
- **`tweet.php`** - Page for viewing and managing tweets
- **`admin.php`** - Administration page (for administrators only)
- **`config.php`** - Database configuration file
- **`functions.php`** - File containing the main functions of the application
- **`style.css`** - CSS style file.

## **Functions of the social network**.

The social network allows users to register and log in to the system. Once authenticated, users can:

- Create short text messages, called "tweets," that will be displayed in their own timeline and in the timelines of users who follow them.
- Follow other users to see their tweets in their own timeline.
- Like tweets to express appreciation or interest.
- View and edit one's profile, which contains personal information and a list of followed users and followers.

Administrators also have access to additional features:

- Manage user accounts, with the ability to suspend or remove users.
- Monitor activity on the platform, such as tweet creation and user interaction.
