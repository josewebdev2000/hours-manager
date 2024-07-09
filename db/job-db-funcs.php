<?php 
    require_once "conn.php";
    require_once __DIR__ . "/../helpers/index.php";

    /** PHP File that deals with DB interactions regarding the Job Entity/Table */

function insertNewJob($userId, $employerData, $jobData, $payRateData, $payRollData, $workShiftsData)
{
    global $conn;

    // Create final message assoc
    $finalMsgAssoc = [];

    // Need to insert employer, job, pay rate, pay roll, and schedule entries alltogether

    // Prepare SQL Code used to insert all entries into the DB
    $employer_sql = "INSERT INTO employers (user_id, name, email, phone_number) VALUES (?, ?, ?, ?)";
    $job_sql = "INSERT INTO jobs (user_id, employer_id, title, role, address, description) VALUES (?, ?, ?, ?, ?, ?)";
    $payrate_sql = "INSERT INTO payrates (user_id, job_id, rate_type, rate_amount, effective_date) VALUES (?, ?, ?, ?, ?)";
    $payroll_sql = "INSERT INTO payrolls (user_id, job_id, pay_period_start, pay_period_end, payment_day, total_hours, total_payment, tips) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Begin a DB Transaction
    $conn->begin_transaction();

    // Try catch block for transaction
    try
    {
        // Try to insert employer data first
        $employerName = $employerData["employerName"];
        $employerEmail = (strlen($employerData["employerEmail"]) > 0) ? $employerData["employerEmail"] : NULL;
        $employerPhoneNumber = (strlen($employerData["employerPhoneNumber"]) > 0) ? $employerData["employerPhoneNumber"] : NULL;

        // Create employer statement
        $employerStmt = $conn->prepare($employer_sql);

        if (!$employerStmt)
        {
            // JSON encode exception error messages
            $employerPreparationErrorAssoc = [
                'error' => 'Could not prepare to insert a new employer', 
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($employerPreparationErrorAssoc));
        }

        // Bind parameters for employer
        $employerStmt->bind_param("isss", $userId, $employerName, $employerEmail, $employerPhoneNumber);

        // If there is an error inserting the new employer, throw an error
        if (!$employerStmt->execute())
        {
            // JSON encode exception error messages
            $employerExcecutionErrorAssoc = [
                'error' => 'Could not try to insert a new employer',
                'error_code' => 'excecution_error'
            ];

            throw new Exception(json_encode($employerExcecutionErrorAssoc));
        }

        // Grab the id of the last employer inserted
        $employerId = $conn->insert_id;

        // Get data to insert new job
        $jobTitle = $jobData["jobTitle"];
        $jobRole = $jobData["jobRole"];
        $jobAddress = (strlen($jobData["jobAddress"]) > 0) ? $jobData["jobAddress"] : NULL;
        $jobDescription = (strlen($jobData["jobDescription"]) > 0) ? $jobData["jobDescription"] : NULL;

        // Create job statement
        $jobStmt = $conn->prepare($job_sql);

        if (!$jobStmt)
        {
            // JSON encode error messages
            $jobPreparationErrorAssoc = [
                'error' => 'Could not prepare to insert a new job',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($jobPreparationErrorAssoc));
        }

        // Bind parameters for job
        $jobStmt->bind_param("iissss", $userId, $employerId, $jobTitle, $jobRole, $jobAddress, $jobDescription);

        // If there is an error inserting the new job, throw it
        if (!$jobStmt->execute())
        {
            // JSON encode error messages
            $jobExcecutionErrorAssoc = [
                'error' => 'Could not try to insert a new job',
                'error_code' => 'excecution_error'
            ];

            throw new Exception(json_encode($jobExcecutionErrorAssoc));
        }

        // Grab the id of the last inserted job
        $jobId = $conn->insert_id;

        // Now insert a new pay rate
        $rateType = $payRateData["rateType"];
        $rateAmount = $payRateData["rateAmount"];
        $effectiveDate = $payRateData["effectiveDate"];

        // Create pay rate statement
        $payRateStmt = $conn->prepare($payrate_sql);

        if (!$payRateStmt)
        {
            $payRatePreparationErrorAssoc = [
                'error' => 'Could not prepare to insert a new pay rate',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($payRatePreparationErrorAssoc));
        }

        // Bind parameters for pay rate
        $payRateStmt->bind_param("iisss", $userId, $jobId, $rateType, $rateAmount, $effectiveDate);

        // If pay rate couldn't be inserted, throw an error
        if (!$payRateStmt->execute())
        {
            $payRateExcecutionErrorAssoc = [
                'error' => 'Could not try to insert a new pay rate',
                'error_code' => 'excecution_error'
            ];

            throw new Exception(json_encode($payRateExcecutionErrorAssoc));
        }

        // Grab data to insert new pay roll
        $startingDay = $payRollData["startingDay"];
        $endingDay = $payRollData["endingDay"];
        $paymentDay = $payRollData["paymentDay"];
        $totalHours = $payRollData["totalHours"];
        $totalPay = $payRollData["totalPay"];
        $tip = (is_numeric($payRollData["tip"])) ? $payRollData["tip"] : NULL;

        // Create pay roll statement
        $payRollStmt = $conn->prepare($payroll_sql);

        if (!$payRollStmt)
        {
            $payRollPreparationErrorAssoc = [
                'error' => 'Could not prepare to insert a new pay roll',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($payRollPreparationErrorAssoc));
        }

        // Bind parameters for pay roll
        $payRollStmt->bind_param("iisssiii", $userId, $jobId, $startingDay, $endingDay, $paymentDay, $totalHours, $totalPay, $tip);

        // If insert new pay roll failed, then throw a new exception
        if (!$payRollStmt->execute())
        {
            $payRollExcecutionErrorAssoc = [
                'error' => 'Could not try to insert a new pay roll',
                'error_code' => 'excecution_error'
            ];

            throw new Exception(json_encode($payRollExcecutionErrorAssoc));
        }

        // Close all statements by this point
        $employerStmt->close();
        $jobStmt->close();
        $payRateStmt->close();
        $payRollStmt->close();

        // Confirm all insertions into the DB
        $conn->commit();

        // Prepare success message
        $finalMsgAssoc["message"] = "New ($jobRole - $employerName) Job could be addedd successfully";
    }

    catch (Exception $e)
    {
        // If one insertion fail, remove all others so the DB returns to its previous state
        $conn->rollback();

        // Grab error message
        $error_msg = $e->getMessage();

        // Json Decode
        $decoded_message = json_decode($e->getMessage());

        // If it is null, then make the assoc yourself
        if ($decoded_message == NULL)
        {
            $finalMsgAssoc["error"]  = $error_msg;
        }

        else
        {
            $finalMsgAssoc["error"]  = $decoded_message;
        }
    }
    
    return $finalMsgAssoc;
}

function editJob($employerId, $jobId, $employerData, $jobData, $payRateData, $payRollData)
{
    /** Edit all data associated to a job at once in a transaction */
    global $conn;

    // Create final message assoc
    $finalMsgAssoc = [];

    // Need to update employer, job, pay rate, pay roll, and schedule entries alltogether
    // Prepare SQL Code used to update all entries
    $edit_employer_sql = "UPDATE employers SET name = ?, email = ?, phone_number = ? WHERE id = ?";
    $edit_job_sql = "UPDATE jobs SET title = ?, role = ?, address = ?, description = ? WHERE id = ?";
    $edit_payrate_sql = "UPDATE payrates SET rate_type = ?, rate_amount = ?, effective_date = ? WHERE job_id = ?";
    $edit_payroll_sql = "UPDATE payrolls SET pay_period_start = ?, pay_period_end = ?, total_hours = ?, total_payment = ?, tips = ?, payment_day = ? WHERE job_id = ?";

    // Begin a DB Transaction
    $conn->begin_transaction();

    // Try/catch block for transaction
    try
    {
        // Try to update employer data first
        $employerName = $employerData["employerName"];
        $employerEmail = (strlen($employerData["employerEmail"]) > 0) ? $employerData["employerEmail"] : NULL;
        $employerPhoneNumber = (strlen($employerData["employerPhoneNumber"]) > 0) ? $employerData["employerPhoneNumber"] : NULL;

        // Create employer statement
        $editEmployerStmt = $conn->prepare($edit_employer_sql);

        if (!$editEmployerStmt)
        {
            // JSON encode exception error message
            $employerPreparationErrorAssoc = [
                'error' => 'Could not prepare to edit employer', 
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($employerPreparationErrorAssoc));
        }

        // Bind parameters for employer
        $editEmployerStmt->bind_param("sssi", $employerName, $employerEmail, $employerPhoneNumber, $employerId);

        // If there is an error updating the employer, throw an exception
        if (!$editEmployerStmt->execute())
        {
            // JSON encode exception error messages
            $employerExcecutionErrorAssoc = [
                'error' => 'Could not try to update a new employer',
                'error_code' => 'excecution_error'
            ];

            throw new Exception(json_encode($employerExcecutionErrorAssoc));
        }

        // Get data to update job
        $jobTitle = $jobData["jobTitle"];
        $jobRole = $jobData["jobRole"];
        $jobAddress = (strlen($jobData["jobAddress"]) > 0) ? $jobData["jobAddress"] : NULL;
        $jobDescription = (strlen($jobData["jobDescription"]) > 0) ? $jobData["jobDescription"] : NULL;

        // Create job statement
        $editJobStmt = $conn->prepare($edit_job_sql);

        if (!$editJobStmt)
        {
            // JSON encode error messages
            $jobPreparationErrorAssoc = [
                'error' => 'Could not prepare to update job',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($jobPreparationErrorAssoc));
        }

        // Bind parameters for job
        $editJobStmt->bind_param("ssssi", $jobTitle, $jobRole, $jobAddress, $jobDescription, $jobId);

        // If there is an error updating job, throw it
        if (!$editJobStmt->execute())
        {
             // JSON encode error messages
             $jobExcecutionErrorAssoc = [
                'error' => 'Could not try to update job',
                'error_code' => 'excecution_error'
            ];

            throw new Exception(json_encode($jobExcecutionErrorAssoc));
        }

        // Get payrate data
        $rateType = $payRateData["rateType"];
        $rateAmount = $payRateData["rateAmount"];
        $effectiveDate = $payRateData["effectiveDate"];

        // Create edit pay rate statement
        $editPayRateStmt = $conn->prepare($edit_payrate_sql);

        if (!$editPayRateStmt)
        {
            $payRatePreparationErrorAssoc = [
                'error' => 'Could not prepare to update pay rate',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($payRatePreparationErrorAssoc));
        }

        // Bind parameters for pay rate
        $editPayRateStmt->bind_param("sisi", $rateType, $rateAmount, $effectiveDate, $jobId);

        // If pay rate couldn't be inserted, throw an error
        if (!$editPayRateStmt->execute())
        {
            $payRateExcecutionErrorAssoc = [
                'error' => 'Could not try to insert a new pay rate',
                'error_code' => 'excecution_error'
            ];

            throw new Exception(json_encode($payRateExcecutionErrorAssoc));
        }

        // Get data to update pay roll
        $startingDay = $payRollData["startingDay"];
        $endingDay = $payRollData["endingDay"];
        $paymentDay = $payRollData["paymentDay"];
        $totalHours = $payRollData["totalHours"];
        $totalPay = $payRollData["totalPay"];
        $tip = (is_numeric($payRollData["tip"])) ? $payRollData["tip"] : NULL;

        // Create pay roll statement
        $editPayRollStmt = $conn->prepare($edit_payroll_sql);

        if (!$editPayRollStmt)
        {
            $payRollPreparationErrorAssoc = [
                'error' => 'Could not prepare to insert a new pay roll',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($payRollPreparationErrorAssoc));
        }

        // Bind parameters for pay roll
        $editPayRollStmt->bind_param("ssiiisi", $startingDay, $endingDay, $totalHours, $totalPay, $tip, $paymentDay, $jobId);

        if (!$editPayRollStmt->execute())
        {
            $payRollExcecutionErrorAssoc = [
                'error' => 'Could not try to insert a new pay roll',
                'error_code' => 'excecution_error'
            ];

            throw new Exception(json_encode($payRollExcecutionErrorAssoc));
        }



        // Close statements
        $editEmployerStmt->close();
        $editJobStmt->close();
        $editPayRateStmt->close();
        $editPayRollStmt->close();

        // Confirm all updates to the DB
        $conn->commit();

        // Prepare success message
        $finalMsgAssoc["message"] = "($jobRole - $employerName) job could be successfully updated";
    }

    catch (Exception $e)
    {
        // If one update fail, remove all others
        $conn->rollback();

        // Grab error message
        $error_msg = $e->getMessage();

        // JSON Decode
        $decoded_msg = json_decode($e->getMessage());

        // If it is null, then make assoc yourself
        if ($decoded_message == NULL)
        {
            $finalMsgAssoc["error"] = $error_msg;
        }

        else
        {
            $finalMsgAssoc["error"] = $decoded_msg;
        }
    }

    return $finalMsgAssoc;
}

function deleteJob($jobId, $employerId)
{
    // Execute Operations in Bulk to Delete a Job
    global $conn;

    // Create final message assoc
    $finalMsgAssoc = [];

    // Prepare SQL queries to execute to delete all related job data
    $delete_payroll_sql = "DELETE FROM payrolls WHERE job_id = ?";
    $delete_payrate_sql = "DELETE FROM payrates WHERE job_id = ?";
    $delete_worksessions_sql = "DELETE FROM worksessions WHERE job_id = ?";
    $delete_job_sql = "DELETE FROM jobs WHERE id = ?";
    $delete_employer_sql = "DELETE FROM employers WHERE id = ?";

    // Start out a transaction
    $conn->begin_transaction();

    // Start out transaction try/catch block
    try
    {
        // Make a statement to delete the payroll
        $deletePayRollStmt = $conn->prepare($delete_payroll_sql);

        // If that failed, throw a preparation error
        if (!$deletePayRollStmt)
        {
            $payRollPreparationErrorAssoc = [
                'error' => 'Could not prepare to delete pay roll data',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($payRollPreparationErrorAssoc));
        }

        // Bind the job_id parameter to the pay roll delete statement
        $deletePayRollStmt->bind_param("i", $jobId);

        // If execution failed, throw excecution error
        if (!$deletePayRollStmt->execute())
        {
            $payRollExcecutionErrorAssoc = [
                'error' => 'Could not try to delete pay roll data',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($payRollExcecutionErrorAssoc));
        }

        // Now make a statement to delete pay rate data
        $deletePayRateStmt = $conn->prepare($delete_payrate_sql);

        // If preparing the statement failed, throw an error
        if (!$deletePayRateStmt)
        {
            $payRatePreparationErrorAssoc = [
                'error' => 'Could not prepare to delete pay rate data',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($payRatePreparationErrorAssoc));
        }

        // Bind Job ID parameter to Statement
        $deletePayRateStmt->bind_param("i", $jobId);

        // If there is an error in excecution, throw it
        if (!$deletePayRateStmt->execute())
        {
            $payRateExcecutionErrorAssoc = [
                'error' => 'Could not try to delete pay rate data',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($payRateExcecutionErrorAssoc));
        }

        // Make statement to delete work sessions
        $deleteWorkSessionsStmt = $conn->prepare($delete_worksessions_sql);

        if (!$deleteWorkSessionsStmt)
        {
            $workSessionsPreparationErrorAssoc = [
                'error' => 'Could not prepare to delete work sessions data',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($workSessionsPreparationErrorAssoc));
        }

        // Bind work session ID parameter
        $deleteWorkSessionsStmt->bind_param("i", $jobId);

        if (!$deleteWorkSessionsStmt->execute())
        {
            $workSessionsExcecutionErrorAssoc = [
                'error' => 'Could not try to delete pay rate data',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($workSessionsExcecutionErrorAssoc));
        }

        // Make Statement to delete job
        $deleteJobStmt = $conn->prepare($delete_job_sql);

        // If couldn't prepare throw an error
        if (!$deleteJobStmt)
        {
            $jobPreparationErrorAssoc = [
                'error' => 'Could not prepare to delete job data',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($jobPreparationErrorAssoc));
        }

        // Bind ID Parameter
        $deleteJobStmt->bind_param("i", $jobId);

        // If couldn't execute that statement, throw an error
        if (!$deleteJobStmt->execute())
        {
            $jobExcecutionErrorAssoc = [
                'error' => 'Could not try to delete job data',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($jobExcecutionErrorAssoc));
        }

        // Make statement to delete employer
        $deleteEmployerStmt = $conn->prepare($delete_employer_sql);

        // If couldn't prepare, throw an error
        if (!$deleteEmployerStmt)
        {
            $employerPreparationErrorAssoc = [
                'error' => 'Could not prepare to delete employer data',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($employerPreparationErrorAssoc));
        }

        // Bind employer ID parameter
        $deleteEmployerStmt->bind_param("i", $employerId);

        // If couldn't execute statement, throw an error
        if (!$deleteEmployerStmt->execute())
        {
            $employerExcecutionErrorAssoc = [
                'error' => 'Could not try to delete employer data',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($employerExcecutionErrorAssoc));
        }

        // Close statements
        $deletePayRollStmt->close();
        $deletePayRateStmt->close();
        $deleteWorkSessionsStmt->close();
        $deleteJobStmt->close();
        $deleteEmployerStmt->close();

        // Confirm all deletions
        $conn->commit();

        // Provide success message
        $finalMsgAssoc["message"] = "Job Could Be Successfully Deleted";
    }

    catch (Exception $e)
    {
        // If one update fail, remove all others
        $conn->rollback();

        // Grab error message
        $error_msg = $e->getMessage();

        // JSON Decode
        $decoded_msg = json_decode($e->getMessage());

        // If it is null, then make assoc yourself
        if ($decoded_message == NULL)
        {
            $finalMsgAssoc["error"] = $error_msg;
        }

        else
        {
            $finalMsgAssoc["error"] = $decoded_msg;
        }
    }

    return $finalMsgAssoc;
}

function getEmployerIdOfJobId($job_id)
{
    // Return the employer Id associated to a job
    global $conn;

    // Prepare SQL statement to grab employer id
    $sql = "SELECT employer_id FROM jobs WHERE id = ?";

    // Make a prepared SQL statement
    $stmt = $conn->prepare($sql);

    // If statement could not be prepared return an early error assoc
    if (!$stmt)
    {
        return [
            "error" => "Could not prepare to get employer ID",
            "error_code" => "preparation_error"
        ];
    }

    // Bind the user_id parameter as an integer
    $stmt->bind_param("i", $job_id);

    // Execute the statement
    // If there is an error, return early
    if (!$stmt->execute())
    {
        return [
            "error" => "Could not try to get employer ID",
            "error_code" => "excecution_error"
        ];
    }

    // Grab the result
    $result = $stmt->get_result();

    // If the result has no rows, then return jobs not found error
    if ($result->num_rows != 1)
    {
        return [
            "error" => "Could not find employer ID",
            "error_code" => "jobs_not_found_error"
        ];
    }

    $employer_id = $result->fetch_assoc()["employer_id"];

    return $employer_id;

}

function getAllJobsOfUserForJobsPage($user_id)
{
    /** Extract All Jobs From The DB */
    global $conn;

    // Prepare a SQL statement to grab all jobs

    $sql = "SELECT 
    j.title AS job_title,
    j.role AS job_role,
    j.id AS job_id, 
    e.name AS employer_name,
    e.id AS employer_id,
    p.rate_amount AS pay_rate_amount, 
    p.rate_type AS pay_rate_type,
    pr.payment_day AS payroll_day
    FROM 
    jobs j
    INNER JOIN 
    payrates p ON j.id = p.job_id AND j.user_id = p.user_id
    INNER JOIN 
    payrolls pr ON j.id = pr.job_id AND j.user_id = pr.user_id
    INNER JOIN
    employers e ON e.id = j.employer_id AND e.user_id = j.user_id
    WHERE 
    j.user_id = ?
    GROUP BY 
    j.id
    ORDER BY 
    j.title";

    // Make a prepared SQL statement
    $stmt = $conn->prepare($sql);

    // If statement could not be prepared return an early error assoc
    if (!$stmt)
    {
        return [
            "error" => "Could not prepare to get jobs data",
            "error_code" => "preparation_error"
        ];
    }

    // Bind the user_id parameter as an integer
    $stmt->bind_param("i", $user_id);

    // Execute the statement
    // If there is an error, return early
    if (!$stmt->execute())
    {
        return [
            "error" => "Could not try to get jobs",
            "error_code" => "excecution_error"
        ];
    }

    // Grab the result
    $result = $stmt->get_result();

    // If the result has no rows, then return jobs not found error
    if ($result->num_rows == 0)
    {
        return [
            "error" => "Could not find any jobs",
            "error_code" => "jobs_not_found_error"
        ];
    }

    // If there were jobs found, grab them
    $jobs = [];

    // Loop through all jobs and add them to the jobs array
    while ($job = $result->fetch_assoc())
    {
        $jobs[$job["job_id"]] = $job;
    }

    // Close the statement
    $stmt->close();

    // Return jobs array
    return $jobs;
}

function getAllJobsOfUserForWorkShiftsPage($user_id)
{
    /** Extract All Jobs from the DB for Work Shift Management */
    global $conn;

    $sql = "SELECT 
            j.id AS job_id,
            j.title AS job_title, 
            j.role AS job_role, 
            e.name AS employer_name,
            p.rate_type AS pay_rate_type,
            p.rate_amount AS pay_rate_amount,
            CASE
                WHEN ws.start_time IS NOT NULL AND ws.end_time IS NULL THEN 'clock-out'
                ELSE 'clock-in'
            END AS clock_state
        FROM 
            jobs j
            INNER JOIN employers e ON j.employer_id = e.id AND j.user_id = e.user_id
            INNER JOIN payrates p ON j.id = p.job_id AND j.user_id = p.user_id
            LEFT JOIN (
                SELECT 
                    job_id,
                    user_id,
                    start_time,
                    end_time
                FROM 
                    worksessions
                WHERE 
                    (user_id, job_id, id) IN (
                        SELECT 
                            user_id, 
                            job_id, 
                            MAX(id) 
                        FROM 
                            worksessions 
                        GROUP BY 
                            user_id, job_id
                    )
            ) ws ON j.id = ws.job_id AND j.user_id = ws.user_id
        WHERE 
            j.user_id = ?
        GROUP BY 
            j.id
        ORDER BY 
            j.title";

    // Make a prepared SQL statement
    $stmt = $conn->prepare($sql);

    // If it couldn't be prepared, return error
    if (!$stmt)
    {
        return [
            "error" => "Could not prepare to get jobs data",
            "error_code" => "preparation_error"
        ];
    }

    // Bind the user id parameter
    $stmt->bind_param("i", $user_id);

    // If statement could not be executed, return error
    if (!$stmt->execute())
    {
        return [
            "error" => "Could not try to get jobs",
            "error_code" => "excecution_error"
        ];
    }

    // Now grab the results
    $result = $stmt->get_result();

    // If the result has no rows, then return jobs not found error
    if ($result->num_rows == 0)
    {
        return [
            "error" => "Could not find any jobs",
            "error_code" => "jobs_not_found_error"
        ];
    }

    // If there were jobs found, grab them
    $jobs = [];

    // Loop through all jobs and add them to the jobs array
    while ($job = $result->fetch_assoc())
    {
        $jobs[$job["job_id"]] = $job;
    }

    // Close the statement
    $stmt->close();

    // Return jobs array
    return $jobs;
}

function getJobRecordsForDashboardPage($user_id)
{
    /** Grab Job Data to Show In Dashboard Page */
    global $conn;

    $sql = "SELECT
                j.title AS job_title,
                j.role AS job_role,
                e.name AS employer_name,
                ws.id AS worksession_id,
                ws.start_time AS start_time,
                ws.end_time AS end_time,
                ROUND(TIME_TO_SEC(ws.duration) / 3600, 3) AS hours_worked
            FROM jobs j
                INNER JOIN employers e ON j.user_id = e.user_id
                INNER JOIN worksessions ws ON j.user_id = ws.user_id
            WHERE
                j.user_id = ?
            AND
                YEAR(start_time) = YEAR(CURDATE()) 
            AND 
                WEEK(start_time) = WEEK(CURDATE())
            ORDER BY ws.start_time
    ";

    // Make a prepared SQL statement
    $stmt = $conn->prepare($sql);

    // If it couldn't be prepared, return error
    if (!$stmt)
    {
        return [
            "error" => "Could not prepare to get job data",
            "error_code" => "preparation_error"
        ];
    }

    // Bind the user id parameter
    $stmt->bind_param("i", $user_id);

    // If statement could not be executed, return error
    if (!$stmt->execute())
    {
        return [
            "error" => "Could not try to get job",
            "error_code" => "excecution_error"
        ];
    }

    // Now grab the results
    $result = $stmt->get_result();

    // If the result has no rows, then return jobs not found error
    if ($result->num_rows == 0)
    {
        return [
            "error" => "Could not find any job",
            "error_code" => "job_not_found_error"
        ];
    }

    // If there were jobs found, grab them
    $jobs = [];

    // Loop through all jobs and add them to the jobs array
    while ($job = $result->fetch_assoc())
    {
        $jobs[$job["worksession_id"]] = $job;
    }

    // Close the statement
    $stmt->close();

    // Return jobs array
    return $jobs;
}

function getJobRecordsForHistoryPage($user_id, $job_id)
{
    /** Grab a Job to keep track of its work logs */
    global $conn;

    $sql = "SELECT 
            j.id AS job_id,
            j.title AS job_title, 
            j.role AS job_role, 
            e.name AS employer_name,
            CASE
                WHEN ws.id IS NULL THEN 0
                ELSE ws.id
            END AS worksession_id,
            ws.start_time AS start_time,
            ws.end_time AS end_time,
            CASE
                WHEN ws.start_time IS NOT NULL AND ws.end_time IS NULL THEN 'clock-out'
                ELSE 'clock-in'
            END AS clock_state
        FROM 
            jobs j
            INNER JOIN employers e ON j.employer_id = e.id AND j.user_id = e.user_id
            LEFT JOIN worksessions ws ON j.id = ws.job_id AND j.user_id = ws.user_id
        WHERE 
            j.user_id = ? AND j.id = ?
        ORDER BY 
            j.title";

    // Make a prepared SQL statement
    $stmt = $conn->prepare($sql);

    // If it couldn't be prepared, return error
    if (!$stmt)
    {
        return [
            "error" => "Could not prepare to get job data",
            "error_code" => "preparation_error"
        ];
    }

    // Bind the user id parameter
    $stmt->bind_param("ii", $user_id, $job_id);

    // If statement could not be executed, return error
    if (!$stmt->execute())
    {
        return [
            "error" => "Could not try to get job",
            "error_code" => "excecution_error"
        ];
    }

    // Now grab the results
    $result = $stmt->get_result();

    // If the result has no rows, then return jobs not found error
    if ($result->num_rows == 0)
    {
        return [
            "error" => "Could not find any job",
            "error_code" => "job_not_found_error"
        ];
    }

    // If there were jobs found, grab them
    $jobs = [];

    // Loop through all jobs and add them to the jobs array
    while ($job = $result->fetch_assoc())
    {
        $jobs[$job["worksession_id"]] = $job;
    }

    // Close the statement
    $stmt->close();

    // Return jobs array
    return $jobs;
}

function getJobOfUserById($user_id, $job_id)
{
    /** Extract A Job For The DB */
    global $conn;

    // Prepare SQL statement to grab a job by its id
    $sql = "SELECT 
    j.title AS job_title,
    j.role AS job_role,
    j.id AS job_id, 
    j.address AS job_address,
    j.description AS job_description,
    e.id AS employer_id,
    e.name AS employer_name,
    e.email AS employer_email,
    e.phone_number AS employer_phone_number,
    p.rate_amount AS pay_rate_amount, 
    p.rate_type AS pay_rate_type,
    p.effective_date AS effective_date,
    pr.payment_day AS payroll_day,
    pr.pay_period_start AS starting_day,
    pr.pay_period_end AS ending_day,
    pr.total_hours AS total_hours,
    pr.total_payment AS total_pay,
    pr.tips AS tip
    FROM 
    jobs j
    INNER JOIN 
    payrates p ON j.id = p.job_id AND j.user_id = p.user_id
    INNER JOIN 
    payrolls pr ON j.id = pr.job_id AND j.user_id = pr.user_id
    INNER JOIN
    employers e ON e.id = j.employer_id AND e.user_id = j.user_id
    WHERE 
    j.user_id = ?
    AND
    j.id = ?
    GROUP BY 
    j.id
    ORDER BY 
    j.title";

    // Make a prepared SQL statement
    $stmt = $conn->prepare($sql);

    // If the statement could not be prepared, return an error
    if (!$stmt)
    {
        return [
            "error" => "Could not prepare to get job by its id",
            "error_code" => "preparation_error"
        ];
    }

    // Bind user_id and job_id parameters
    $stmt->bind_param("ii", $user_id, $job_id);

    // Execute the statement
    // If there was an error, return an error assoc
    if (!$stmt->execute())
    {
        return [
            "error" => "Could not try to get job by its id",
            "error_code" => "excecution_error"
        ];
    }

    // Grab the result
    $result = $stmt->get_result();

    // If the result does not have one row, return not found
    if ($result->num_rows != 1)
    {
        return [
            "error" => "Could not find job by its id",
            "error_code" => "job_not_found_error"
        ];
    }

    // If the job was found, return it as a PHP assoc
    $job = $result->fetch_assoc();

    // Close the statement
    $stmt->close();

    return $job;
}

function getNumRegisteredJobs($userId)
{
    /** Grab all info required for the summary cards */
    global $conn;

    // Form SQL String to grab all summary card data
    $num_registered_jobs_sql = "SELECT COUNT(*) AS num_jobs FROM jobs WHERE user_id = ?";

    // Make a statement for this
    $numRegisteredJobsStmt = $conn->prepare($num_registered_jobs_sql);

    // If couldn't prepare, throw error
    if (!$numRegisteredJobsStmt)
    {
        return [
            "error" => "Could not prepare to get number of jobs",
            "error_code" => "preparation_error"
        ];
    }

    // Bind user_id parameter
    $numRegisteredJobsStmt->bind_param("i", $userId);

    // If there is a failure executing the statement, return an error too
    if (!$numRegisteredJobsStmt->execute())
    {
        return [
            "error" => "Could not try to get number of jobs",
            "error_code" => "excecution_error"
        ];
    }

    // Grab the result
    $result = $numRegisteredJobsStmt->get_result();

    // If the result does not have one row, return not found
    if ($result->num_rows == 0)
    {
        return [
            "error" => "Could not find number of jobs",
            "error_code" => "num_of_jobs_not_found_error"
        ];
    }

    // Get the number as a PHP assoc
    $num_jobs_assoc = $result->fetch_assoc();

    // Close the statement
    $numRegisteredJobsStmt->close();

    return $num_jobs_assoc;
}

?>
