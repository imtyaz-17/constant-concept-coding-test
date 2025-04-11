# PHP Language Switcher and AJAX Form

A simple PHP web application with language switching functionality and AJAX form processing.

## Features

- Language switching between English and Polish using URL parameters (?lang=en or ?lang=pl)
- Dynamic language toggle without page reload using jQuery
- AJAX form submission without page refresh
- Object-oriented PHP for handling responses
- Responsive layout with header image

## Setup

1. Place the project files in your web server directory (e.g., Apache, Nginx)
2. Add a header image named `header.jpg` to the project directory (maximum width 600px recommended)
3. Access the application via your web server (e.g., http://localhost/your-project-folder/)

## Usage

- Access with language parameter: 
  - English: `index.php?lang=en` or just `index.php` (default)
  - Polish: `index.php?lang=pl`
- Use the language toggle button to switch languages without reloading the page
- Enter text in the form and submit to see the response displayed below

## Files

- `index.php` - Main application file with HTML, CSS, and JavaScript
- `process.php` - Backend processor using OOP to handle form submissions
- `header.jpg` - Header image (you need to add this)
- `README.md` - This documentation file

## Requirements

- PHP 7.0+
- Web server (Apache, Nginx, etc.)
- Modern web browser with JavaScript enabled 