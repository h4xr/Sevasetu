<div class="container-fluid" id="admin-index">
    <div class="container-fluid" id="admin-logo">
        Arrow
    </div>
    <?php
        if($mode=="login")
        {
            echo<<<_END
<div id="admin-login" class="container-fluid">
        <form id="admin-login-form" method="POST" action="/admins/login">
            <div id="login-form-title" class="container-fluid">
                Admin Login
            </div>
            <input type="text" class="arrow-input" id="username" name="username" placeholder="Username">
            <input type="password" class="arrow-input" id="password" name="password" placeholder="Password">
            <input type="submit" class="arrow-button" id="submit" name="submit" value="Login">
        </form>
    </div>
_END;
        }
        else
        {
            echo<<<_END
<div id="admin-register" class="container-fluid">
        <form id="admin-register-form" method="POST" action="/admins/register">
            <div id="register-form-title" class="container-fluid">
                Admin Registration
            </div>
            <input type="text" class="arrow-input" id="admin-name" name="name" placeholder="Name">
            <input type="text" class="arrow-input" id="admin-username" name="username" placeholder="Username">
            <input type="text" class="arrow-input" id="admin-email" name="email" placeholder="Email ID">
            <input type="password" class="arrow-input" id="admin-password" name="password" placeholder="Password">
            <input type="password" class="arrow-input" id="admin-password2" name="password2" placeholder="Confirm Password">
            <input type="submit" class="arrow-button" id="submit" name="submit" value="Register">
        </form>
    </div>
_END;
        }
    ?>

</div>