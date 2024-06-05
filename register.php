<?php require_once "templates/session-starter.php"; ?>
<?php require_once "helpers/index.php";
    
    // Grab URL of the website
    $websiteUrl = getWebsiteUrl();

    // Redirect user to the dashboard in case the user is set
    if (isset($_SESSION["id"]))
    {
        header("Location: $websiteUrl" . "dashboard/");
    }

    // Start user session in case register was successful
    // Detect POST request
    if (is_post_request())
    {
        // Place the user id as a new session and redirect the user to the dashboard
        $id = isset($_POST["id"]) ? $_POST["id"] : 0;

        if ($id != 0)
        {
            $_SESSION["id"] = $id;
            header("Location: $websiteUrl/dashboard");
        }

    }

?>
<?php require_once "templates/header.php"; ?>
<?php require_once "templates/main-header.php"; ?>
<main>
    <div class="register-container">
        <div class="register-box">
            <h2 class="fsize-200-e dark-purple-color">Create account</h2>
            <form id="register-form" novalidate>
                <div class="form-group position-relative">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" required>
                    <div class="valid-tooltip name">Name Looks Good</div>
                    <div class="invalid-tooltip name"></div>
                </div>
                <div class="form-group position-relative">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                    <div class="valid-tooltip email">Email Looks Good</div>
                    <div class="invalid-tooltip email">Please enter a valid email address</div>
                </div>
                <div class="form-group position-relative">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                    <div class="valid-tooltip password">Password Looks Good</div>
                    <div class="invalid-tooltip password"></div>
                </div>
                <div class="form-group position-relative">
                    <label for="confirm_password">Confirm password</label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm your password" required>
                    <div class="valid-tooltip confirm_password">Password Confirmation Looks Good</div>
                    <div class="invalid-tooltip confirm_password"></div>
                </div>
                <button id="create-account" class="btn btn-purple btn-block">Create account</button>
                <div class="text-center mt-3">
                    <a href="<?=$websiteUrl?>login.php">Already have an account?</a>
                </div>
            </form>
            <div class="form-group p-3 m-2">
                <div id="form-alerts-container"></div>
            </div>
        </div>
    </div>
    <div class="d-none" id="hidden-login-form">
        <form action="<?=$websiteUrl?>register.php" method="POST">
            <input type="number" name="id" id="hidden-id">
            <input type="submit" name="submit" id="hidden-submit">
        </form>
    </div>
</main>
<?php require_once "templates/main-footer.php"; ?>
<?php require_once "templates/footer.php"; ?>