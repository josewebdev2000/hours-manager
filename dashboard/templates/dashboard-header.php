<?php
    require_once __DIR__ . "/../../helpers/index.php";
    require_once __DIR__ . "/../../db/user-db-funcs.php"; 
    
    // Check the session id is set and it is valid
    $id = $_SESSION["id"];

    // Redirect to main page if user id session isn't set well
    if (!isset($id))
    {
        $websiteURL = getWebsiteUrl();
        header("Location: $websiteURL");
    }

?>