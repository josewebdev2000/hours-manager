<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$capitalLettersPageName?> | HoursManager</title>

    <!--Favicon-->
    <link rel="shortcut icon" href="<?=$websiteUrl?>favicon.ico" type="image/x-icon">

    <!--Plugin StyleSheets-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?=$websiteUrl?>assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?=$websiteUrl?>assets/plugins/bootstrap-5/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$websiteUrl?>assets/dist/css/adminlte.css">
    <link rel="stylesheet" href="<?=$websiteUrl?>assets/plugins/cookiealert/cookiealert.css">

    <!--Custom StyleSheets-->
    <link rel="stylesheet" href="<?=$websiteUrl?>assets/css/style.css">

    <!--Conditionally Load Stylesheets Depending on the page we are-->
    <?php require_once __DIR__ . "/../helpers/index.php";

        // Grab the name of the current page
        $currentPage = getActualPageName();

        // Dynamically Load Content For Each Page
        switch($currentPage)
        {
            case "login.php":
            {
                echo "<link rel='stylesheet' href='$websiteUrl/assets/css/login.css'>\n";
                break;
            }

            case "register.php":
            {
                echo "<link rel='stylesheet' href='$websiteUrl/assets/css/register.css'>\n";
                break;
            }

            case "contact.php":
            {
                echo "<link rel='stylesheet' href='$websiteUrl/assets/plugins/summernote/summernote-bs5.min.css'>\n";
                break;
            }
        }
    ?>


    <!--Plugin Scripts-->
    <script src="<?=$websiteUrl?>assets/plugins/bootstrap-5/js/bootstrap.bundle.min.js"></script>
    <script src="<?=$websiteUrl?>assets/plugins/jquery/jquery.min.js"></script>

    <!--Conditionally Load JS Scripts depending on the page we are-->
    <?php
        // Dynamically Load Scripts for each page
        switch($currentPage)
        {
            case "contact.php":
            {
                echo '<script src="' . $websiteUrl .'assets/plugins/summernote/summernote-bs5.min.js"></script>';
                break;
            }

            case "job.php":
            {
                echo '<script src="' . $websiteUrl . 'assets/plugins/phonemask/src/phonemask.min.js"></script>';
            }
        }
    ?>

</head>
<body>