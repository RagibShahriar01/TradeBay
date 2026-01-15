<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Register</title>
    <link rel="stylesheet" href="../Css/register.css">
</head>
<body>
    <div class="logo-container">
        <a href="">
            <span style="color: blue;">T</span><span style="color: green;">r</span><span style="color: red;">a</span><span style="color: blue;">d</span><span style="color: red;">e</span><span style="color: green;">B</span><span style="color: blue;">a</span><span style="color: orange;">y</span>
        </a>
    </div>

    <div class="form-container">
        <div class="login-card">
            <h3>Create Account</h3>

           
            <form method="post" action="../php/registers.php">

                <label><b>Your name</b></label>
                <input type="text" placeholder="your name" name="name" required>

                <label><b>E-mail Address</b></label>
                <input type="email" placeholder="your email" name="email" required>

                <label><b>Phone Number</b></label>
                <input type="tel" placeholder="01XXXXXXXXX" name="phone" required>

                <label><b>Gender</b></label>
                <div class="gender-row">
                    <label class="radio-label">
                        <input type="radio" name="gender" value="male" required> Male
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="gender" value="female"> Female
                    </label>
                </div>

                <label><b>Password</b></label>
                <input type="password" placeholder="your password" name="password" required>

                <label><b>Confirm Password</b></label>
                <input type="password" placeholder="confirm password" name="confirm_password" required>

                
                <button type="submit" name="submit">REGISTER</button>

            </form>
           

            <div class="links register-links">
                <span>Already have an account?</span>
                <a href="login.php">Login</a>
            </div>

        </div>
    </div>
</body>
</html>
