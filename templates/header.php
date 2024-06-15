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

        // Grab the whole URI of the current page as well
        $wholePageURI = getActualPageWithFolderName();

        // If dashboard is in the whole URI, add it to the currentPage name
        if (str_contains($wholePageURI, "dashboard"))
        {
            // Add dashboard/ before all dashboard pages
            $currentPage = "dashboard/" . $currentPage; 
        }

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

            case "dashboard/index.php":
            case "dashboard/job.php":
            {
                echo "<link rel='stylesheet' href='$websiteUrl/assets/css/dashboard.css'>\n";
                echo "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/jqwidgets/12.0.0/jqwidgets/styles/jqx.base.css'>";
                break;
            }
        }
    ?>

    <!--Plugin Scripts-->
    <script src="<?=$websiteUrl?>assets/plugins/bootstrap-5/js/bootstrap.bundle.min.js"></script>
    <script src="<?=$websiteUrl?>assets/plugins/jquery/jquery.min.js"></script>

    
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


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

            case "dashboard/index.php":
            case "dashboard/job.php":
            {
               echo "<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>\n"; 
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxcore.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxbuttons.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxscrollbar.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxdata.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxdate.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxscheduler.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxscheduler.api.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxdatetimeinput.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxmenu.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxcalendar.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxtooltip.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxwindow.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxcheckbox.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxlistbox.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxdropdownlist.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxnumberinput.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxradiobutton.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/jqxinput.js'></script>\n";
               echo "<script src='$websiteUrl/assets/plugins/jqwidgets/globalization/globalize.js'></script>\n";
               echo "<script async src='https://www.googletagmanager.com/gtag/js?id=G-2FX5PV9DNT'></script>\n";
               echo '<script src="' . $websiteUrl . 'assets/plugins/phonemask/src/phonemask.min.js"></script>' . "\n";
               echo '<script src="' . $websiteUrl .'assets/plugins/moment/moment.js"></script>' . "\n";
               echo "<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>\n";
               echo "<script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-2FX5PV9DNT');</script>\n";
               break;
            }
        }
    ?>
</head>
<body>
