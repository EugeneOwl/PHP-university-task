<form method="POST" id="loginForm">
    <h3>Login</h3>
    <span class="invalid">{login_username_error}</span><br>
    <span class="invalid">{login_password_error}</span>
    <div>
        <input type="text" placeholder="username" name="login_username">
    </div>
    <div>
        <input type="password" placeholder="password" name="login_password">
    </div>
    <div class="button">
        <input type="submit" value="submit" name="login_submit">
    </div>

    <div class="button">
        <input id="goToRegButton" type="button" value="go to registration">
    </div>
</form>

