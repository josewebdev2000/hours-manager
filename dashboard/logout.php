<?php require_once "../templates/header.php"; ?>
<?php require_once "templates/dashboard-header.php"; ?>
<?php require_once "../helpers/index.php";

// Grab website URL
$websiteURL = getWebsiteUrl();

// Destroy the current session when user wants to logout
if (isset($_SERVER["HTTP_REFERER"]) && isset($_SESSION["id"]))
{
    // Destroy the current session
    session_destroy();
}

header("Location: $websiteURL");
?>