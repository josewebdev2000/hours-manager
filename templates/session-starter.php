<?php 
require_once __DIR__ . "/../helpers/index.php"; 
require_once __DIR__ . "/../db/user-db-funcs.php"; 

// Use session data
session_start();

// Grab the website URL
$websiteUrl = getWebsiteUrl();

// Grab actual page name with capital letter
$capitalLettersPageName = (ucfirst(explode(".", getActualPageName())[0]) != "Index") ? ucfirst(explode(".", getActualPageName())[0]) : "Home";

// If session id is set, then grab the user by its id
if (isset($_SESSION["id"]))
{
    $user = getUserById($_SESSION["id"]);
}
?>