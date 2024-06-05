<?php require_once "templates/session-starter.php"; ?>
<?php require_once "helpers/index.php";
    
    // Grab URL of this website
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
            header("Location: $websiteUrl" . "dashboard");
        }
    }
?>
<?php require_once "templates/header.php"; ?>
<?php require_once "templates/main-header.php"; ?>
<main>
    <div class="login-container">
        <div class="login-box">
            <h2 class="fsize-200-e dark-purple-color">Log in</h2>
            <form id="login-form" enctype="multipart/form-data" novalidate>
                <div class="form-group position-relative">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                    <div class="valid-tooltip email">Email Looks Good</div>
                    <div class="invalid-tooltip email"></div>
                </div>
                <div class="form-group position-relative">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                    <div class="valid-tooltip password">Password Looks Good</div>
                    <div class="invalid-tooltip password"></div>
                </div>
                <button id="login" class="btn btn-purple btn-block">Log in</button>
                <div class="text-center mt-3">
                    <a href="<?=$websiteUrl?>register.php">Need an account?</a><br>
                    <!--a href="forgot-password.php">Forgot password?</a-->
                </div>
            </form>
            <div class="form-group p-3 m-2">
                <div id="form-alerts-container"></div>
            </div>
        </div>
        <div class="d-none" id="hidden-login-form">
        <form action="<?=$websiteUrl?>login.php" method="POST">
            <input type="text" name="id" id="hidden-id">
            <input type="submit" name="submit" id="hidden-submit">
        </form>
    </div>
    </div>
</main>

<?php require_once "templates/main-footer.php"; ?>
<?php require_once "templates/footer.php"; ?>