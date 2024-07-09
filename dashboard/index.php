<?php require_once "../templates/session-starter.php"; ?>
<?php require_once "templates/dashboard-header.php"; ?>
<?php require_once "../templates/header.php"; ?>

<?php require_once "../db/job-db-funcs.php"; 

$num_jobs_assoc = getNumRegisteredJobs($user["id"]);
$num_jobs = NULL;

$jobs = getJobRecordsForDashboardPage($user["id"]);

if (!array_key_exists("error", $num_jobs_assoc))
{
    $num_jobs = $num_jobs_assoc["num_jobs"];
}
?>

<div class="wrapper">
    <!--IMPORT MAIN HEADER CODE-->
    <?php require_once "templates/dashboard-main-header.php"; ?>

    <!--IMPORT SIDEBAR CODE HERE-->
    <?php require_once "templates/dashboard-sidebar.php"; ?>

    <!--IMPORT PRELOADER HERE-->
    <?php require_once "templates/dashboard-preloader.php"; ?>

    <!--INCLUDE CODE FOR THE DASHBOARD PAGE INSIDE THE content-wrapper -->
    <div class="content-wrapper">
        <div class="container">
            <div class="header d-flex justify-content-between align-items-center">
                <h1>Dashboard</h1>
                <div class="logo">
                    <img src="<?=$websiteUrl.'/assets/img/chronometer-128px.png'?>" alt="MasterKey Key Logo" class="brand-image">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <a href="#" class="card-link">
                        <div class="card text-white h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <h2 class="card-title">Closest Pay Date</h2>
                                <p class="card-text">19 Jun, 2028</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 mb-3">
                    <a href="#" class="card-link">
                        <div class="card text-white h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <h2 class="card-title">Jobs registered</h2>
                                <p class="card-text"><?php echo (isset($num_jobs)) ? $num_jobs : 0?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 mb-3">
                    <a href="#" class="card-link">
                        <div class="card text-white h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <h2 class="card-title">Earnings</h2>
                                <p class="card-text">$384</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 mb-3">
                    <a href="#" class="card-link">
                        <div class="card text-white h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <h2 class="card-title">Hours worked</h2>
                                <p class="card-text">16</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col mb-3">
                <a href="<?=$websiteUrl?>dashboard/job.php?action=add" class="card-link">
                    <div class="card text-white h-100">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <h2 class="card-title">Add New Job</h2>
                            <p class="card-text">Click here to add a new job</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="history mt-4">
                <h2><?=getFirstDayOfTheCurrentWeek();?>/<?=getLastDayOfTheCurrentWeek(); ?> Weekly Job Records</h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Job Title</th>
                                <th>Job Role</th>
                                <th>Employer Name</th>
                                <th>Start Date</th>
                                <th>Start Time</th>
                                <th>End Date</th>
                                <th>End Time</th>
                                <th>Estimated Hours Worked</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!array_key_exists("error", $jobs)): ?>
                                <?php foreach ($jobs as $job): ?>
                                <tr>
                                    <td><?php echo $job["job_title"]; ?></td>
                                    <td><?php echo $job["job_role"]; ?></td>
                                    <td><?php echo $job["employer_name"]; ?></td>
                                    <td><?php echo getDateOutOfDateTimeStr($job["start_time"]); ?></td>
                                    <td><?php echo getTimeOutOfDateTimeStr($job["start_time"]); ?></td>
                                    <td><?php echo getDateOutOfDateTimeStr($job["end_time"]); ?></td>
                                    <td><?php echo getTimeOutOfDateTimeStr($job["end_time"]); ?></td>
                                    <td><?php echo $job["hours_worked"]; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else:?>
                                <tr>
                                    <td colspan="8">
                                        <div class="text-center">
                                            <h4 class="display-5">No Jobs Records</h4>
                                            <p class="h5">No records exist that track any hours worked yet</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
                <p class="text-right font-weight-bold">Total Hours Worked: <?php echo array_sum(array_column($jobs, 'hours_worked')); ?></p>
            </div>
        </div>
    </div>
</div>

<?php require_once "../templates/footer.php"; ?>
