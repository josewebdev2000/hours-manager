<?php require_once "templates/header.php"; ?>
<?php require_once "templates/main-header.php"; ?>

<main>
    <div class="register-container">
        <div class="register-box">
            <h2 class="fsize-200-e dark-purple-color">Create account</h2>
            <form id="register-form" enctype="multipart/form-data" novalidate>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                    <div class="valid-tooltip email">Email Looks Good</div>
                    <div class="invalid-tooltip email">Please enter a valid email address</div>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username" required>
                    <div class="valid-tooltip username">Username Looks Good</div>
                    <div class="invalid-tooltip username">Please enter a valid username</div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                    <div class="valid-tooltip password">Password Looks Good</div>
                    <div class="invalid-tooltip password">Please enter your password</div>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm password</label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm your password" required>
                    <div class="valid-tooltip confirm_password">Password Confirmation Looks Good</div>
                    <div class="invalid-tooltip confirm_password">Passwords do not match</div>
                </div>
                <button id="create-account" class="btn btn-purple btn-block">Create account</button>
                <div class="text-center mt-3">
                    <a href="<?=$websiteUrl?>login.php">Already have an account?</a>
                </div>
            </form>
        </div>
    </div>
</main>


<?php require_once "templates/main-footer.php"; ?>
<?php require_once "templates/footer.php"; ?>