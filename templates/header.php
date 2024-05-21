<?php require_once __DIR__ . "/../helpers/index.php"; 
// Start session to deal with user authentication
// session_start();

// Grab the website URL
$websiteUrl = getWebsiteUrl();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoursManager</title>

    <!--Favicon-->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <!--Plugin StyleSheets-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?=$websiteUrl?>assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?=$websiteUrl?>assets/plugins/bootstrap-5/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$websiteUrl?>assets/dist/css/adminlte.min.css?v=3.2.0">
    <link rel="stylesheet" href="<?=$websiteURL?>/assets/plugins/cookiealert/cookiealert.css">

    <!--Custom StyleSheets-->
    <link rel="stylesheet" href="<?=$websiteUrl?>assets/css/style.css">


    <!--Plugin Scripts-->
    <script src="<?=$websiteUrl?>assets/plugins/bootstrap-5/js/bootstrap.bundle.min.js"></script>
    <script src="<?=$websiteUrl?>assets/plugins/jquery/jquery.min.js"></script>

</head>
<body>