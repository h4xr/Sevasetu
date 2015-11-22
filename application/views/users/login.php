<div class="container" id="login-container">
    <form action="/users/loginauth" method="POST">
        <div class="container-fluid text-center" id="login-form-title">
            <h3>User Login</h3>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-default">Login</button>
    </form>
</div>