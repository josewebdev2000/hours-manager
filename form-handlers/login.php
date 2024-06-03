<?php 

// Set error reporting level
error_reporting(E_ALL);

// Enable displaying errors
ini_set("display_errors", 1);

require_once __DIR__ . "/../helpers/index.php";
require_once __DIR__ . "/../db/user-db-funcs.php";
require_once __DIR__ . "/../utils/constants.php";

// Handle Post Request for Login Page
if (is_post_request())
{
    // Grab the login data of the user
    $login_data = get_json_request();

    // Grab email
    $email = isset($login_data["email"]) ? $login_data["email"] : "";

    // Grab password
    $password = isset($login_data["password"]) ? $login_data["password"] : "";

    // Validate login data to make sure it works well
    $login_data_validation = validate_login_data($email, $password);

    // If validation returns error, send early JSON error response
    if (array_key_exists("error", $login_data_validation))
    {
        return send_json_error_response($login_data_validation, 400);
    }

    // Try to login the user
    $logged_user_data = loginUser(
        $login_data_validation["email"],
        $login_data_validation["password"]
    );

    // If an error results, return Error JSON response
    if (array_key_exists("error", $logged_user_data))
    {
        // Depending on error code, return 400 Client Error or 500 Internal Server Error
        $error_code = NULL;

        if ($logged_user_data["error_code"] == "preparation_error" || $logged_user_data["error_code"] == "excecution_error")
        {
            $error_code = 500;
        }

        else
        {
            $error_code = 400;
        }

        return send_json_error_response(["error" => $logged_user_data["error"]], $error_code);
    }

    // By this point the login attempt was successful and you can send user data to the front-end
    return send_json_response($logged_user_data);

}

function validate_login_data($email, $password)
{
    // Validate data pieces given to register
    // Return error in case email is empty
    if (strlen($email) == 0)
    {
        return ["error" => "Email cannot be empty"];
    }

    // Return error in case email does not follow proper regex
    if (!preg_match(EMAIL_REGEX, $email))
    {
        return ["error" => "Email must be valid"];
    }

    // Return error in case the password is empty
    if (strlen($password) == 0)
    {
        return ["error" => "Password cannot be empty"];
    }

    // Return error in case the password doesn't match the regex
    if (!preg_match(PASSWORD_REGEX, $password))
    {
        return ["error" => "Password needs at least one uppercase, one lowecase, one digit, and eight characters"];
    }

    // In case all checks were successfully passed, skip HTML injection, XSS, and PHP Code Injection
    return [
        "email" => strip_tags($email),
        "password" => strip_tags($password)
    ];
}

?>