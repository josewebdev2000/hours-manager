<?php 
    require_once "conn.php";
    require_once __DIR__ . "/../helpers/index.php";

    /** PHP File that deals with DB interactions regarding the Pay Rate Entity/Table */
/**
 * 
 * KEEP WORKING HERE IN ORDER TO ADD THE WORKING DAY MAN
 */
function insertNewPayRoll($user_id, $job_id, $starting_day, $ending_day, $payment_day, $total_hours, $total_pay, $tip)
{
    global $conn;

    /** Insert a new employer into the DB */
    $sql = "INSERT INTO payrolls (user_id, job_id, pay_period_start, pay_period_end, payment_day, total_hours, total_payment, tip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Check if statement could run well
    if (!$stmt)
    {
        // If error, return message
        [
            "error" => "Could not prepare to insert new pay roll",
            "error_code" => "preparation_error"
        ];
    }

    // Bind parameters
    $stmt->bind_param("iisssddd", $user_id, $job_id, $starting_day, $ending_day, $payment_day, $total_hours, $total_payment, $tip);

    // Execute the query
    if (!$stmt->query())
    {
        // If error, return message
        return [
            "error" => "Could not try to insert new pay roll",
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
        "starting_day" => $starting_day,
        "ending_day" => $ending_day,
        "payment_day" => $payment_day,
        "total_hours" => $total_hours,
        "total_pay" => $total_pay,
        "tip" => $tip
    ];
}

?>
