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
        $default_job = $jobs[0];
    }
}
?>

<div class="wrapper">
    <?php require_once "templates/dashboard-main-header.php"; ?>
    <?php require_once "templates/dashboard-sidebar.php"; ?>
    <?php require_once "templates/dashboard-preloader.php"; ?>

    <div class="content-wrapper">
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
                    <div class="table-responsive" style="margin-bottom: 73vh">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Job Title</th>
                                    <th>Job Role</th>
                                    <th>Employer Name</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php foreach ($jobs as $job): ?>
                                        <?php $workSessionId = $job["worksession_id"]; ?>
                                            <?php if (isset($default_job["start_time"])): ?>
                                                <td><?=$job["job_title"]; ?></td>
                                                <td><?=$job["job_role"];  ?></td>
                                                <td><?=$job["employer_name"];  ?></td>
                                                <td><?=$job["start_time"];  ?></td>
                                                <td><?=$job["end_time"]; ?></td>
                                            <?php endif; ?>
                                    <?php endforeach;?>
                                </tr>
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
