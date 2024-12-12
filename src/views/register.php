<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Contact Person</title>
    <link rel="stylesheet" href="/src/views/resources/css/login.css">
</head>
<body>
<div class="login-container">
    <h1>Login</h1>
    <form id="register-form">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Register</button>
    </form>
</div>
</body>
</html>
<script>
    document.getElementById('register-form').addEventListener('submit', function (event) {
        event.preventDefault();
        let formData = new FormData(document.getElementById('register-form'))
        fetch('/api/auth/register', {
            method: 'POST',
            body: formData
        }).then(response => {
            if (response.ok) {
                console.log('success');
                window.location.href = '/home';
            } else {
                const errorData = response.text();
                console.error('Error:', errorData);
            }
        }).catch(error => {
                console.error('Error:', error);
                alert('Failed to submit form');
        })
    });
</script>

