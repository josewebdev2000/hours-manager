<?php require_once __DIR__ . "/../helpers/index.php";

$websiteUrl = getWebsiteUrl();

?> 
    <!--Dependency DOM Scripts-->
    <script src="<?=$websiteUrl?>assets/dist/js/adminlte.js"></script>
    <script src="<?=$websiteUrl?>assets/plugins/cookiealert/cookiealert.js"></script>

    <!--Custom Scripts-->
    
    <!--JS Constants-->
    <script src="<?=$websiteUrl?>/assets/js/constants.js"></script>

    <!--JS Helpers-->
    <script src="<?=$websiteUrl?>/assets/js/helpers.js"></script>

    <!--JS HTML Snippets-->

    <!--JS OOP Classes-->
    <script src="<?=$websiteUrl?>/assets/js/oop/ResponsiveElement.js"></script>

    <!--Page Scripts-->
    <script src="<?=$websiteUrl?>/assets/js/index.js"></script>

    <?php require_once __DIR__ . "/../helpers/index.php";

        // Grab the name of the current page
        $currentPage = getActualPageName();

        // Dynamically Load Content For Each Page
        switch($currentPage)
        {
            case "contact.php":
            {
                echo "<script src='$websiteUrl/assets/js/contact.js'></script>";
                break;
            }

            case "privacy.php":
            {
                echo "<script src='$websiteUrl/assets/js/privacy.js'></script>";
                break;
            }
        }
    ?>
</body>
</html>