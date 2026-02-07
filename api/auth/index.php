<?php
// api/auth/index.php

// Include necessary files
require_once 'config.php';
require_once 'db.php';

// Start session
session_start();

// Function to handle registration
function register($username, $password) {
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('INSERT INTO users (username, password) VALUES (?, ?);');
    return $stmt->execute([$username, $hashedPassword]);
}

// Function to handle login
function login($username, $password) {
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?;');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        return true;
    }
    return false;
}

// Function to handle logout
function logout() {
    session_destroy();
    header('Location: /');
}

// Function to get user profile
function getUserProfile($userId) {
    global $conn;
    $stmt = $conn->prepare('SELECT id, username FROM users WHERE id = ?;');
    $stmt->execute([$userId]);
    return $stmt->fetch();
}

// Handle requests
action();
function action() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['register'])) {
            register($_POST['username'], $_POST['password']);
            echo 'Registration successful';
        } elseif (isset($_POST['login'])) {
            if (login($_POST['username'], $_POST['password'])) {
                echo 'Login successful';
            } else {
                echo 'Invalid username or password';
            }
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['profile'])) {
        if (isset($_SESSION['user_id'])) {
            echo json_encode(getUserProfile($_SESSION['user_id']));
        } else {
            echo 'User not logged in';
        }
    }
}