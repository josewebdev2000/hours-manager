<?php 
    require_once "conn.php";
    require_once __DIR__ . "/../helpers/index.php";

    /** PHP File that deals with DB interactions regarding the Job Entity/Table */

function insertNewJob($user_id, $employer_id, $job_title, $job_role, $job_address, $job_description)
{
    global $conn;

    /** Insert a new employer into the DB */
    $sql = "INSERT INTO jobs (user_id, employer_id, title, role, address, description) VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Check if statement could run well
    if (!$stmt)
    {
        // If error, return message
        [
            "error" => "Could not prepare to insert new job",
            "error_code" => "preparation_error"
        ];
    }

    // Bind parameters
    $stmt->bind_param("iissss", $user_id, $employer_id, $job_title, $job_role, $job_address, $job_description);

    // Execute the query
    if (!$stmt->query())
    {
        // If error, return message
        return [
            "error" => "Could not try to insert new job",
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
        "employer_id" => $employer_id,
        "title" => $job_title,
        "role" => $job_role,
        "address" => $job_address,
        "description" => $job_description
    ];
}

?>
