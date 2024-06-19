<?php require_once "../templates/session-starter.php"; ?>
<?php require_once "templates/dashboard-header.php"; ?>
<?php require_once "../templates/header.php"; ?>

<!--HTML CODE GOES HERE-->
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
                    <a href="jobs.php" class="card-link">
                        <div class="card text-white h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <h2 class="card-title">Closest Pay Date</h2>
                                <p class="card-text">19 Jun, 2028</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 mb-3">
                    <a href="jobs.php" class="card-link">
                        <div class="card text-white h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <h2 class="card-title">Jobs registered</h2>
                                <p class="card-text">2</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 mb-3">
                    <a href="jobs.php" class="card-link">
                        <div class="card text-white h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <h2 class="card-title">Earnings</h2>
                                <p class="card-text">$384</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 mb-3">
                    <a href="jobs.php" class="card-link">
                        <div class="card text-white h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <h2 class="card-title">Hours worked</h2>
                                <p class="card-text">16</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 mb-3">
                    <a href="http://localhost/projects/hours-manager/dashboard/job.php?action=add" class="card-link">
                        <div class="card text-white h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <h2 class="card-title">Add New Job</h2>
                                <p class="card-text">Click here to add a new job</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="chart">
                <canvas id="hoursChart"></canvas>
            </div>
            <div class="calendar">
                <h2>Calendar</h2>
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
<?php require_once "../templates/footer.php";?>

<!-- FullCalendar and jQuery scripts -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
<script src="<?=$websiteUrl?>/assets/js/script.js"></script>
