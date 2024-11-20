<?php
// login.php
// Connect to MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017/");
$database = $mongoClient->myDatabase;
$collection = $database->users;

// Sanitize user input
$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
$password = $_POST['password'];

// Find user in the database
$user = $collection->findOne(['username' => $username]);

// Verify password (replace with secure password hashing)
if ($user && $password === $user['password']) {
    // Successful login, redirect or set session
    header('Location: dashboard.php');
} else {
    // Failed login, display error message
    echo "Invalid username or password.";
}