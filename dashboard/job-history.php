<?php require_once "../templates/session-starter.php"; ?>
<?php require_once "templates/dashboard-header.php"; ?>
<?php require_once "../templates/header.php"; ?>

<?php require_once "../db/job-db-funcs.php";
// Grab Job Data
if (isset($_GET["id"]))
{
    $jobs = getJobRecordsForHistoryPage($user["id"], $_GET["id"]);
    if (!array_key_exists("error", $jobs))
    {
        // Grab job keys
        $job_keys = array_keys($jobs);

        // Grab first key
        $first_workession_id = reset($job_keys);

        $default_job = $jobs[$first_workession_id];
    }
}
?>

<div class="wrapper">
    <?php require_once "templates/dashboard-main-header.php"; ?>
    <?php require_once "templates/dashboard-sidebar.php"; ?>
    <?php require_once "templates/dashboard-preloader.php"; ?>

    <?php // Place user-id and job-id in hidden inputs ?>
    <div class="content-wrapper" id="job-history-content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <?php if(is_valid_id_param($_GET["id"]) && isset($default_job["job_role"])): ?>
                            <h1>Job <?=$default_job["job_id"]; ?> History</h1>
                        <?php elseif (is_valid_id_param($_GET["id"]) && $jobs["error_code"] == "job_not_found_error"): ?>
                            <h1 class="text-warning">Job Not Found</h1>
                        <?php else:?>
                            <h1 class="text-danger">Bad Request</h1>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <?php if (is_valid_id_param($_GET["id"]) && isset($default_job["job_role"])): ?>
                    <input type="hidden" id="user_id" value="<?=$user["id"]; ?>">
                    <input type="hidden" id="job_id" value="<?=$_GET["id"]; ?>">
                    <div class="table-responsive" style="margin-bottom: 670px">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Job Title</th>
                                    <th>Job Role</th>
                                    <th>Employer Name</th>
                                    <th>Start Date</th>
                                    <th>Start Time</th>
                                    <th>End Date</th>
                                    <th>End Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jobs as $job): ?>
                                    <?php $workSessionId = $job["worksession_id"]; ?>
                                        <input type="hidden" class="work-session-id-holder" id="<?=$workSessionId?>" value="<?=$workSessionId?>">
                                        <?php if (isset($default_job["start_time"])): ?>
                                            <tr>
                                                <td><?=$job["job_title"]; ?></td>
                                                <td><?=$job["job_role"];  ?></td>
                                                <td><?=$job["employer_name"];  ?></td>
                                                <td><?=getDateOutOfDateTimeStr($job["start_time"]); ?></td>
                                                <td><?=getTimeOutOfDateTimeStr($job["start_time"]); ?></td>
                                                <td><?php echo (isset($job["end_time"])) ? getDateOutOfDateTimeStr($job["end_time"]) : "No End Date Specified"; ?></td>
                                                <td><?php echo (isset($job["end_time"])) ? getTimeOutOfDateTimeStr($job["end_time"]) : "No End Time Specified"; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col col-md-9">
                            <button id="clock-state-btn" class="btn <?php echo ($jobs[$workSessionId]["clock_state"] == "clock-in") ? "btn-primary" : "btn-danger"; ?> btn-block btn-lg">
                                <?php echo ($jobs[$workSessionId]["clock_state"] == "clock-in") ? "Clock-In" : "Clock-Out"; ?>
                            </button>
                        </div>
                        <div class="col col-md-3">
                            <a href="<?=$websiteUrl?>dashboard/work-shifts.php" class="btn btn-info btn-block btn-lg">Go Back</a>
                        </div>
                    </div>
                <?php elseif (is_valid_id_param($_GET["id"]) && $jobs["error_code"] == "job_not_found_error"):?>
                    <div class="error-page">
                        <div class="headline text-warning">404</div>
                        <div class="error-content">
                            <h3 class="mb-4">
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                Not Found
                            </h3>
                            <h4>Job Not Found</h4>
                            <p>No Job Was Found For The Given Id Parameter</p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="error-page">
                        <div class="headline text-danger">400</div>
                        <div class="error-content">
                            <h3 class="mb-4">
                                <i class="fas fa-exclamation-triangle text-danger"></i>
                                Bad Request
                            </h3>
                            <h4>Invalid Id Parameter</h4>
                            <p>The <b>id</b> parameter was either not specified or invalid.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

<?php require_once "../templates/footer.php"; ?>
