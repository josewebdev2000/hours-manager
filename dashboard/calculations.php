<?php require_once "../templates/session-starter.php"; ?>
<?php require_once "templates/dashboard-header.php"; ?>
<?php require_once "../templates/header.php"; ?>
<?php require_once "../db/job-db-funcs.php";

// Get Jobs Records For Calculation Page for the current user
$jobs = getJobRecordsForCalculationPage($user["id"]);

?>
<!--HTML CODE GOES HERE-->
<div class="wrapper">
    <!--IMPORT MAIN HEADER CODE-->
    <?php require_once "templates/dashboard-main-header.php"; ?>

    <!--IMPORT SIDEBAR CODE HERE-->
    <?php require_once "templates/dashboard-sidebar.php"; ?>

    <!--IMPORT PRELOADER HERE-->
    <?php require_once "templates/dashboard-preloader.php"; ?>

    <!--INCLUDE CODE FOR THE PROFILE PAGE INSIDE THE content-wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Income Calculations</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Job Title</th>
                                <th>Job Role</th>
                                <th>Employer Name</th>
                                <th>Pay Rate</th>
                                <th>Start Date</th>
                                <th>Start Time</th>
                                <th>End Date</th>
                                <th>End Time</th>
                                <th>Hours Worked</th>
                                <th>Wages</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!array_key_exists("error", $jobs)):?>
                                <?php foreach ($jobs as $job): ?>
                                    <tr>
                                        <td><?php echo  $job["job_title"]; ?></td>
                                        <td><?php echo  $job["job_role"]; ?></td>
                                        <td><?php echo  $job["employer_name"]; ?></td>
                                        <td><?php echo  formatRateAmountByType($job["rate_amount"], $job["rate_type"]); ?></td>
                                        <td><?php echo  getDateOutOfDateTimeStr($job["start_time"]); ?></td>
                                        <td><?php echo  getTimeOutOfDateTimeStr($job["start_time"]); ?></td>
                                        <td><?php echo  getDateOutOfDateTimeStr($job["end_time"]); ?></td>
                                        <td><?php echo  getTimeOutOfDateTimeStr($job["end_time"]); ?></td>
                                        <td><?php echo  $job["total_hours"]; ?></td>
                                        <td><?php echo  "$" . $job["wages"]; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else:?>
                                <tr>
                                    <td colspan="10">
                                        <div class="text-center">
                                            <h4 class="display-5">No Jobs</h4>
                                            <p class="h5">You have not added any records to calculate income yet</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<?php require_once "../templates/footer.php";?>