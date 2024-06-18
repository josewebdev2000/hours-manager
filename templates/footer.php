<?php require_once __DIR__ . "/../helpers/index.php";

$websiteUrl = getWebsiteUrl();

?> 
    <!--Dependency DOM Scripts-->
    <script src="<?=$websiteUrl?>assets/dist/js/adminlte.js"></script>
    <script src="<?=$websiteUrl?>assets/plugins/cookiealert/cookiealert.js"></script>

    <!--Custom Scripts-->
    
    <!--JS Constants-->
    <script src="<?=$websiteUrl?>assets/js/constants.js"></script>

    <!--JS Helpers-->
    <script src="<?=$websiteUrl?>assets/js/helpers.js"></script>

    <!--JS HTML Snippets-->
    <script src="<?=$websiteUrl?>assets/js/snippets/spinners/loading.js"></script>
    <script src="<?=$websiteUrl?>assets/js/snippets/alerts/error.js"></script>
    <script src="<?=$websiteUrl?>assets/js/snippets/alerts/success.js"></script>

    <!--JS OOP Classes-->
    <script src="<?=$websiteUrl?>assets/js/oop/ResponsiveElement.js"></script>

    <!--Page Scripts-->
    <script src="<?=$websiteUrl?>assets/js/index.js"></script>

    <!--Conditionally Load Scripts Depending on the Page We Are-->
    <?php require_once __DIR__ . "/../helpers/index.php";

        // Grab the name of the current page
        $currentPage = getActualPageName();

        // Grab the whole URI of the current page as well
        $wholePageURI = getActualPageWithFolderName();

        // If dashboard is in the whole URI, add it to the currentPage name
        if (str_contains($wholePageURI, "dashboard"))
        {
            $currentPage = "dashboard/" . $currentPage; 
        }

        // Dynamically Load Content For Each Page
        switch($currentPage)
        {
            case "about.php":
            {
                echo "<script src='$websiteUrl/assets/js/about.js'></script>\n";
                break;
            }

            case "contact.php":
            {
                echo "<script src='$websiteUrl/assets/js/contact.js'></script>\n";
                break;
            }

            case "privacy.php":
            {
                echo "<script src='$websiteUrl/assets/js/privacy.js'></script>\n";
                break;
            }

            case "register.php":
            {
                echo "<script src='$websiteUrl/assets/js/register.js'></script>";
                break;
            }

            case "login.php":
            {
                echo "<script src='$websiteUrl/assets/js/login.js'></script>";
                break;
            }

            case "dashboard/jobs.php":
            {
                echo "<script src='$websiteUrl/assets/js/jobs.js'></script>";
                break;
            }
        }

        // Grab the $_GET parameter action if set
        if (isset($_GET["action"]))
        {
            // If the parameter is add, associate it to dashboard/job.php
            if ($_GET["action"] == "add" && $currentPage == "dashboard/job.php")
            {
                echo "<script src='$websiteUrl/assets/js/job/job-add.js'></script>";
            }

            if ($_GET["action"] == "view" && $currentPage == "dashboard/job.php")
            {
                echo "<script src='$websiteUrl/assets/js/job/job-view.js'></script>";
            }
        }
    ?>
</body>
</html>