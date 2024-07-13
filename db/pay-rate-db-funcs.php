<?php 
require_once "conn.php";
require_once __DIR__ . "/../helpers/index.php";

/** PHP File that deals with DB interactions regarding the Pay Rate Entity/Table */
function getTotalMoneyEarned($user_id)
{
    /** Get all the money the user earned and round it by 3 decimal places */
    global $conn;

    $sql = "SELECT
                ROUND(SUM((TIME_TO_SEC(ws.duration) / 3600) * pr.rate_amount), 3) AS total_earnings
            FROM 
                payrates pr
            INNER JOIN worksessions ws ON ws.user_id = pr.user_id
            WHERE
                pr.user_id = ?
            AND
                ws.duration IS NOT NULL
    ";

    $stmt = $conn->prepare($sql);

    // If it couldn't be prepared, return error
    if (!$stmt)
    {
        return [
            "error" => "Could not prepare to get total earnings",
            "error_code" => "preparation_error"
        ];
    }

    // Bind the user id parameter
    $stmt->bind_param("i", $user_id);

    // If statement could not be executed, return error
    if (!$stmt->execute())
    {
        return [
            "error" => "Could not try to get total earnings",
            "error_code" => "excecution_error"
        ];
    }

    // Now grab the results
    $result = $stmt->get_result();

    // If the result has no rows, then return jobs not found error
    if ($result->num_rows != 1)
    {
        return [
            "error" => "Could not find total earnings",
            "error_code" => "job_not_found_error"
        ];
    }

    $earnings = $result->fetch_assoc();

    $stmt->close();

    return $earnings;
}
?>
