<?php 
    require_once "conn.php";
    require_once __DIR__ . "/../helpers/index.php";

    /** PHP File that deals with DB interactions regarding the Pay Rate Entity/Table */

function insertNewPayRate($user_id, $job_id, $rate_type, $rate_amount, $effective_date)
{
    global $conn;

    /** Insert a new employer into the DB */
    $sql = "INSERT INTO payrates (user_id, job_id, rate_type, rate_amount, effective_date) VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Check if statement could run well
    if (!$stmt)
    {
        // If error, return message
        [
            "error" => "Could not prepare to insert new pay rate",
            "error_code" => "preparation_error"
        ];
    }

    // Bind parameters
    $stmt->bind_param("iisds", $user_id, $job_id, $rate_type, $rate_amount, $effective_date);

    // Execute the query
    if (!$stmt->query())
    {
        // If error, return message
        return [
            "error" => "Could not try to insert new pay rate",
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
        "job_id" => $job_id,
        "rate_type" => $rate_type,
        "rate_amount" => $rate_amount,
        "effective_date" => $effective_date,
    ];
}

?>
