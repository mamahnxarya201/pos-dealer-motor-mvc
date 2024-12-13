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
    <form id="form-login" method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button id="submit_data" type="submit">Login</button>
        <button type="button" onclick="window.location.href='/register'">Register</button>
    </form>
</div>

<script>
    document.getElementById('form-login').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(document.getElementById('form-login'));

        fetch('/api/auth/login', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (response.ok) {
                    window.location.href = '/motor';
                    return response.text(); // Assuming the response is text
                } else {
                    alert('User & Password is wrong');
                    throw new Error('Failed to submit form');
                }
            })
            .then(data => {
                console.log('Success:', data);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to submit form');
            });
    });
</script>
</body>
</html>
