<?php 
/** Functions related to Web Pages in PHP */
function getActualPageName()
{
    return basename($_SERVER["PHP_SELF"]);
}

function getActualPageWithFolderName()
{
    return $_SERVER["PHP_SELF"];
}

function getWebsiteUrl()
{
    /**
     * Change the value of this string according to
     * what's the URL of your server for the index.php of
     * HoursManager
     */
    return "http://localhost/projects/hours-manager/";
}
?>