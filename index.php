<?php
include 'signup.php';
include 'login.php';
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        form {
            background: white;
            padding: 20px;
            margin: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        input, button {
            display: block;
            margin: 10px 0;
            padding: 10px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h2>Register</h2>
    <form id="registerForm">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
    
    <h2>Login</h2>
    <form id="loginForm">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    
    <button id="logoutButton">Logout</button>

    <script>
        document.getElementById('registerForm').onsubmit = function(event) {
            event.preventDefault();
            fetch('signup.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams(new FormData(this)).toString()
            })
            .then(response => response.json())
            .then(data => alert(data.message));
        };

        document.getElementById('loginForm').onsubmit = function(event) {
            event.preventDefault();
            fetch('login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams(new FormData(this)).toString()
            })
            .then(response => response.json())
            .then(data => alert(data.message));
        };

        document.getElementById('logoutButton').onclick = function() {
            fetch('logout.php')
            .then(response => response.json())
            .then(data => alert(data.message));
        };
    </script>
</body>
</html>
