<div class="container" id="registration-container">
    <form action="/users/register" method="post" enctype="multipart/form-data">
        <div class="container-fluid text-center" id="reg-form-title">
            <h3>New User Registration</h3>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <label for="email">E-Mail ID</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Your Email address" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
            <label for="password2">Confirm Password</label>
            <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirm Password" required>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="datetime" class="form-control" id="dob" name="dob" placeholder="Date of birth">
        </div>
        <div class="form-group">
            <label for="profile_picture">Upload your profile picture</label>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
        </div>
        <button type="submit" class="btn btn-default" id="submit">Register</button>
    </form>
</div>