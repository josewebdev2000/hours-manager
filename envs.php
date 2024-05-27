<?php 
/** PHP File Responsible for loading environment variables when they are needed */
require_once 'vendor/autoload.php';

function loadEnvVarsWhenRequired()
{
    global $envVarsLoaded;

    if (!$envVarsLoaded)
    {
         // Load environment variables from .env file or another source
         $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
         $dotenv->load();
 
         // Mark environment variables as loaded
         $envVarsLoaded = true;
    }
}

?>