<?php require_once "../templates/session-starter.php"; ?>
<?php require_once "templates/dashboard-header.php"; ?>
<?php require_once "../templates/header.php"; ?>

<?php 

require_once "../db/job-db-funcs.php"; 
require_once "../db/pay-rate-db-funcs.php";
require_once "../db/worksession-db-funcs.php";

$num_jobs_assoc = getNumRegisteredJobs($user["id"]);
$total_earnings = getTotalMoneyEarned($user["id"]);
$total_hours = getAllHoursEverWorkedByUser($user["id"]);
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
                                <p class="card-text">$<?php echo (!array_key_exists("error", $total_earnings)) ? $total_earnings["total_earnings"]: 0?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 mb-3">
                    <a href="#" class="card-link">
                        <div class="card text-white h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <h2 class="card-title">Hours worked</h2>
                                <p class="card-text"><?php echo (!array_key_exists("error", $total_hours)) ? $total_hours["total_hours"] : 0?> Hr</p>
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
                                <th>Pay Rate</th>
                                <th>Total Hours Worked</th>
                                <th>Wages</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!array_key_exists("error", $jobs)): ?>
                                <?php foreach ($jobs as $job): ?>
                                <tr>
                                    <td><?php echo $job["job_title"]; ?></td>
                                    <td><?php echo $job["job_role"]; ?></td>
                                    <td><?php echo $job["employer_name"]; ?></td>
                                    <td><?php echo formatRateAmountByType($job["rate_amount"], $job["rate_type"]); ?></td>
                                    <td><?php echo $job["hours_worked"]; ?></td>
                                    <td><?php echo "$" . $job["wages"]; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else:?>
                                <tr>
                                    <td colspan="6">
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
            </div>
            <?php if(!array_key_exists("error", $jobs)):?>
                <div class="row text-center">
                    <div class="col-sm-6">
                        <p class="badge rounded-pill text-bg-dark text-white p-3 fs-6">Total Wages Earned: $<?php echo array_sum(array_column($jobs, 'wages')); ?></p>
                    </div>
                    <div class="col-sm-6">
                        <p class="badge rounded-pill text-bg-dark text-white p-3 fs-6">Total Hours Worked: <?php echo array_sum(array_column($jobs, 'hours_worked')); ?> Hr</p>
                    </div>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>

<?php require_once "../templates/footer.php"; ?>
