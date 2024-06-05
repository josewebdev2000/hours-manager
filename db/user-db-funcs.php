<?php 
    require_once "conn.php";
    require_once __DIR__ . "/../helpers/index.php";

/** PHP File that deals with DB interactions regarding the User Entity/Table */

function getUserById($id)
{
    /** Grab data from a user by the user's id */

    global $conn;

    // Prepare a SQL statement to grab the user
    $sql = "SELECT * FROM users WHERE id = ?";

    // Make a prepared SQL statement
    $stmt = $conn->prepare($sql);

    // If statement could not be prepared return an early error assoc
    if (!$stmt)
    {
        return [
            "error" => "Could not prepare to get user of id: \"$id\"",
            "error_code" => "preparation_error"
        ];
    }

    // Bind the id parameter as an integer
    $stmt->bind_param("i", $id);

    // Execute the statement
    // If there was an error return an error assoc
    if (!$stmt->execute())
    {
        return [
            "error" => "Could not try to get user of id: \"$id\"",
            "error_code" => "excecution_error"
        ];
    }

    // Grab the result
    $result = $stmt->get_result();

    // If the result does not have one row, the user could not be found
    if ($result->num_rows != 1)
    {
        return [
            "error" => "Could not find user of id: \"$id\"",
            "error_code" => "user_not_found_error"
        ];
    }

    // If the user was found, return it as a PHP assoc
    $user = $result->fetch_assoc();

    // Close the statement
    $stmt->close();

    return [
        "id" => $user["id"],
        "name" => $user["name"],
        "email" => $user["email"]
    ];

}

function getUserByName($name)
{
    /** Grab a user from the database that has a specific name */
    global $conn;

    // Prepare a SQL statement to grab the user
    $sql = "SELECT * FROM users WHERE name = ?";

    // Make a prepared SQL statement
    $stmt = $conn->prepare($sql);

    // If statement could not be prepared return an early error assoc
    if (!$stmt)
    {
        return [
            "error" => "Could not prepare to get user of name: \"$name\"",
            "error_code" => "preparation_error"
        ];
    }

    // Bind the id parameter as an integer
    $stmt->bind_param("s", $name);

    // Execute the statement
    // If there was an error return an error assoc
    if (!$stmt->execute())
    {
        return [
            "error" => "Could not try to get user of id: \"$name\"",
            "error_code" => "excecution_error"
        ];
    }

    // Grab the result
    $result = $stmt->get_result();

    // If the result does not have one row, the user could not be found
    if ($result->num_rows != 1)
    {
        return [
            "error" => "Could not find user of id: \"$name\"",
            "error_code" => "user_not_found_error"
        ];
    }

    // If the user was found, return it as a PHP assoc
    $user = $result->fetch_assoc();

    // Close the statement
    $stmt->close();
    
    return [
        "id" => $user["id"],
        "name" => $user["name"],
        "email" => $user["email"]
    ];
}

function getUserByEmail($email)
{
       /** Grab a user from the database that has a specific email */
       global $conn;

       // Prepare a SQL statement to grab the user
       $sql = "SELECT * FROM users WHERE email = ?";
   
       // Make a prepared SQL statement
       $stmt = $conn->prepare($sql);
   
       // If statement could not be prepared return an early error assoc
       if (!$stmt)
       {
           return [
            "error" => "Could not prepare to get user of email: \"$email\"",
            "error_code" => "preparation_error"
        ];
       }
   
       // Bind the id parameter as an integer
       $stmt->bind_param("s", $email);
   
       // Execute the statement
       // If there was an error return an error assoc
       if (!$stmt->execute())
       {
           return [
            "error" => "Could not try to get user of id: \"$email\"",
            "error_code" => "excecution_error"
        ];
       }
   
       // Grab the result
       $result = $stmt->get_result();
   
       // If the result does not have one row, the user could not be found
       if ($result->num_rows != 1)
       {
           return [
            "error" => "Could not find user of id: \"$email\"",
            "error_code" => "user_not_found_error"
        ];
       }
   
       // If the user was found, return it as a PHP assoc
       $user = $result->fetch_assoc();
   
       // Close the statement
       $stmt->close();
       
       return [
            "id" => $user["id"],
            "name" => $user["name"],
            "email" => $user["email"]
        ];
}

function registerNewUser($name, $email, $password)
{
    /** Register a New User In The Database */
    // First determine the user is not in the db
    // Start out a transaction with a boolean to determine it
    global $conn; 

    $conn->begin_transaction();

    $trans_success = true;

    // Message of failure in case user could not register
    $error = "";

    // Error code to append to the message
    $error_code = "";

    // Have new user as empty assoc
    $new_user = [];

    // Now try to find a user with the same name
    $same_name_user_response = getUserByName($name);

    // If the user exists, the transaction will fail
    if (!array_key_exists("error", $same_name_user_response))
    {
        $trans_success = false;
        $error = "User of name \"$name\" already exists";
        $error_code = "user_already_exists_error";
    }

    // If an error was thrown to find a user other than user not found, return error
    // Always check the transaction is still successful to avoid uncessesary code execution
    else if ($trans_success && array_key_exists("error", $same_name_user_response) && $same_name_user_response["error_code"] != "user_not_found_error")
    {
        $trans_success = false;
        $error = $same_name_user_response["error"];
        $error_code = $same_name_user_response["error_code"];
    }

    // First check if a user of the same email exists
    $same_email_user_response = getUserByEmail($email);

    // If the user exists, the transaction will fail
    // Always check the transaction is still successful to avoid uncessesary code execution
    if ($trans_success && !array_key_exists("error", $same_email_user_response))
    {
        $trans_success = false;
        $error = "User of email \"$email\" already exists";
        $error_code = "user_already_exists_error";
    }

    // If an error was thrown to find a user other than user not found, return error
    // Always check the transaction is still successful to avoid uncessesary code execution
    else if ($trans_success && array_key_exists("error", $same_email_user_response) && $same_email_user_response["error_code"] != "user_not_found_error")
    {
        $trans_success = false;
        $error = $same_email_user_response["error"];
        $error_code = $same_email_user_response["error_code"];
    }

    // Try to insert user by this point only error and error_code are still empty
    if ($trans_success)
    {
        // Build SQL query to insert a new user to the DB
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // If statement could not be prepared, cancel transaction and return it all
        if (!$stmt)
        {
            $trans_success = false;
            $error = "Could not prepare to register new user";
            $error_code = "preparation_error";
        }

        // If the transaction is still successful, try to insert the new user
        if ($trans_success)
        {
            // Hash the password to store it safely
            $hash_password = hash_password($password);

            // Bind parameters
            $stmt->bind_param("sss", $name, $email, $hash_password);

            // Execute the statement
            if (!$stmt->execute())
            {
                $trans_success = false;
                $error = "Could not try to register new user";
                $error_code = "excecution_error";
            }

            // Close the statement
            $stmt->close();

            // If the transaction is still successful, then prepare data of new user
            if ($trans_success)
            {
                $id = $conn->insert_id;
                $new_user = [
                    "id" => $id,
                    "name" => $name,
                    "email" => $email
                ];
            }
        }
    }

    // If at the end, none of the DB operations were successful, rollback the DB to a previous state
    // And return an error
    if (!$trans_success)
    {
        $conn->rollback();

        return [
            "error" => $error,
            "error_code" => $error_code
        ];
    }

    // If transactions were successful, commit all changes to db and return the new user
    $conn->commit();

    return $new_user;
}

function loginUser($email, $password)
{
    /** Function to login an existing user */
    global $conn; 

    // Make SQL query to grab all the user's data by the email
    $sql = "SELECT id, name, email, password FROM users WHERE email = ?";

    // Make prepared SQL statement
    $stmt = $conn->prepare($sql);

    // If statement could not be prepared return an early error assoc
    if (!$stmt)
    {
        return [
        "error" => "Could not prepare to get user of email: \"$email\"",
        "error_code" => "preparation_error"
    ];
    }

    // Bind the id parameter as an integer
    $stmt->bind_param("s", $email);

    // Execute the statement
    // If there was an error return an error assoc
    if (!$stmt->execute())
    {
        return [
        "error" => "Could not try to get user of id: \"$email\"",
        "error_code" => "excecution_error"
        ];
    }

    // Grab the result
    $result = $stmt->get_result();

    // If the result does not have one row, the user could not be found
    if ($result->num_rows != 1)
    {
        return [
        "error" => "Incorrect Credentials",
        "error_code" => "user_not_found_error"
        ];
    }
       
    // If the user was found, grab its password
    $user = $result->fetch_assoc();
    $user_password = $user["password"];

    // Compare the hash and verify the given password is the user_password
    // If the password is incorrect, return error
    if (!password_verify($password, $user_password))
    {
        return [
            "error"      => "Incorrect Credentials",
            "error_code" => "incorrect_password"
        ];
    }

    // Return user data in case password was correct
    return [
        "id" => $user["id"],
        "name" => $user["name"],
        "email" => $user["email"]
    ];

}

?>