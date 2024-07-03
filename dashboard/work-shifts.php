<?php require_once "../templates/session-starter.php"; ?>
<?php require_once "templates/dashboard-header.php"; ?>
<?php require_once "../templates/header.php"; ?>

<?php require_once "../db/job-db-funcs.php";
// Grab Jobs Data
$jobs = getAllJobsOfUserForWorkShiftsPage($user["id"]);
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
                        <h1>Work Shifts</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <?php if (!array_key_exists("error", $jobs)):?>
                        <?php foreach ($jobs as $job): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title text-center m-3"><?=$job["job_title"]; ?> Job</h5>
                                    <p class="card-text mb-1">Role: <?=$job["job_role"]; ?></p>
                                    <p class="card-text mb-1">Employer: <?=$job["employer_name"]; ?></p>
                                    <p class="card-text mb-1">Rate: <?=formatRateAmountByType($job["pay_rate_amount"], $job["pay_rate_type"]);?></p>
                                </div>
                                <div class="card-footer">
                                    <a href="<?=$websiteUrl?>dashboard/job-history.php?id=<?=$job["job_id"]?>" class="btn btn-block <?php echo ($job["clock_state"] == "clock-in") ? "btn-primary" : "btn-danger"; ?>">
                                        <?php echo ($job["clock_state"] == "clock-in") ? "Clock-In" : "Clock-Out"; ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else:?>
                        <div class="text-center">
                            <h4 class="display-5">No Jobs</h4>
                            <p class="h5">You have not added any jobs yet</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>
</div>

<?php require_once "../templates/footer.php"; ?>
