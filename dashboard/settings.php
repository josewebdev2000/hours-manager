<?php require_once "../templates/session-starter.php"; ?>
<?php require_once "templates/dashboard-header.php"; ?>
<?php require_once "../templates/header.php"; ?>

<?php
$jobRoles = [
    "Web Designer",
    "UX Designer",
    "Graphic Artist",
    "Coffee Lover",
    "Marketing Specialist",
    "Software Engineer",
    "Data Analyst",
    "Product Manager"
];

$employers = [
    "Company A",
    "Company B",
    "Company C",
    "Company D",
    "Company E",
    "Company F",
    "Company G",
    "Company H"
];
?>

<style>
.card {
    height: 100%;
}
.card-body {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 200px;
}
</style>

<div class="wrapper">
    <?php require_once "templates/dashboard-main-header.php"; ?>
    <?php require_once "templates/dashboard-sidebar.php"; ?>
    <?php require_once "templates/dashboard-preloader.php"; ?>

    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <?php for ($i = 0; $i < 8; $i++) { ?>
                <div class="col-md-3 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title text-center">Job <?php echo $i + 1; ?></h5>
                            <p class="card-text">Job Role: <?php echo $jobRoles[$i]; ?></p>
                            <p class="card-text">Employer: <?php echo $employers[$i]; ?></p>
                        </div>
                        <div class="card-footer">
                            <a href="job-history.php?jobId=<?php echo $i + 1; ?>" class="btn <?php echo $i < 4 ? 'btn-primary' : 'btn-danger'; ?> w-100">
                                <?php echo $i < 4 ? 'Clock In' : 'Clock Out'; ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php require_once "../templates/footer.php"; ?>
