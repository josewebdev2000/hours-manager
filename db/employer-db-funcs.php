<?php 
    require_once "conn.php";
    require_once __DIR__ . "/../helpers/index.php";

    /** PHP File that deals with DB interactions regarding the Employer Entity/Table */

function insertNewEmployer($user_id, $employer_name, $employer_email, $employer_phone_number)
{
    global $conn;

    /** Insert a new employer into the DB */
    $sql = "INSERT INTO employers (user_id, name, email, phone_number) VALUES (?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Check if statement could run well
    if (!$stmt)
    {
        // If error, return message
        [
            "error" => "Could not prepare to insert new employer",
            "error_code" => "preparation_error"
        ];
    }

    // Bind parameters
    $stmt->bind_param("isss", $user_id, $employer_name, $employer_email, $employer_phone_number);

    // Execute the query
    if (!$stmt->query())
    {
        // If error, return message
        return [
            "error" => "Could not try to insert new employer",
            "error_code" => "excecution_error"
        ];
    }

    // Grab employer id
    $id = $conn->insert_id;

    // Close the stmt
    $stmt->close();

    return [
        "id" => $id,
        "user_id" => $user_id,
        "name" => $employer_name,
        "email" => $employer_email,
        "phone_number" => $employer_phone_number
    ];
}

?>
