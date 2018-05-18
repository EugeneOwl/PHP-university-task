<form method="POST" id="logupForm">
    <h3>Registration</h3>
    <span class="invalid">{logup_username_error}</span><br>
    <span class="invalid">{logup_password_error}</span><br>
    <div>
        <input type="text" placeholder="username" name="logup_username">
    </div>
    <div>
        <input type="password" placeholder="password" name="logup_password">
    </div>
    <div>
        <input type="password" placeholder="repeat password" name="logup_password_second">
    </div>
    <div class="button">
        <input id="regSubmitButton" type="submit" value="submit" name="logup_submit">
    </div>

    <div class="button">
        <input id="goToLoginButton" type="button" value="go to login">
    </div>
</form>

