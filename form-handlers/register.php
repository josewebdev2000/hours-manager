<?php
// Set error reporting level
error_reporting(E_ALL);

// Enable displaying errors
ini_set('display_errors', 1);

require_once __DIR__ . "/../helpers/index.php";
require_once __DIR__ . "/../db/user-db-funcs.php";
require_once __DIR__ . "/../utils/constants.php";

// Handle Post Request for Register Page
if (is_post_request())
{
        // Grab the register data of the user
        $register_data = get_json_request();

        // Grab name data
        $name = isset($register_data["name"]) ? $register_data["name"] : "";

        // Grab email data
        $email = isset($register_data["email"]) ? $register_data["email"]: "";

        // Grab password data
        $password = isset($register_data["password"]) ? $register_data["password"]: ":";

        // Validate register data to make sure it works well
        $register_data_validation = validate_register_data($name, $email, $password);

        // If validation returns error, send early JSON error response
        if (array_key_exists("error", $register_data_validation))
        {
                return send_json_error_response($register_data_validation, 400);
        }

        // Try to register the user to the db
        $registered_user_data = registerNewUser(
                $register_data_validation["name"],
                $register_data_validation["email"],
                $register_data_validation["password"]
        );

        // If an error results, return Error JSON response
        if (array_key_exists("error", $registered_user_data))
        {
                // Depending on error code, return 400 or 500
                $error_code = NULL;

                if ($registered_user_data["error_code"] == "preparation_error" || $registered_user_data["error_code"] == "excecution_error")
                {
                        $error_code = 500;
                }

                else
                {
                        $error_code = 400;
                }

                return send_json_error_response(["error" => $registered_user_data["error"]],$error_code);
        }

        // By this point registration was successful and you can send user data to front-end
        return send_json_response($registered_user_data);
}

function validate_register_data($name, $email, $password)
{
        // Validate data pieces given to register
        // Return error in case name is empty
        if (strlen($name) == 0)
        {
                return ["error" => "Name cannot be empty"];
        }

        // Return error in case name does not follow proper regex
        if (!preg_match(NAME_REGEX, $name))
        {
                return ["error" => "Name cannot contain numbers or special symbols"];
        }


        if (strlen($email) == 0)
        {
                return ["error" => "Email cannot be empty"];
        }

        if (!preg_match(EMAIL_REGEX, $email))
        {
                return ["error" => "Email must be valid"];
        }

        if (strlen($password) == 0)
        {
                return ["error" => "Password cannot be empty"];
        }
        
        if (!preg_match(PASSWORD_REGEX, $password))
        {
                return ["error" => "Password needs at least one uppercase, one lowecase, one digit, and eight characters"];
        }

        // In case all checks were successful, skip HTML injection, XSS, and PHP Code Injection
        return [
                "name" => strip_tags($name),
                "email" => strip_tags($email),
                "password" => strip_tags($password)
        ];
}
?>