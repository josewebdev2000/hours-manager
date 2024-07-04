<?php require_once "../templates/session-starter.php"; ?>
<?php require_once "templates/dashboard-header.php"; ?>
<?php require_once "../templates/header.php"; ?>
<?php require_once "../db/job-db-funcs.php"; 

$num_jobs_assoc = getNumRegisteredJobs($_SESSION["id"]);
$num_jobs = NULL;

if (!array_key_exists("error", $num_jobs_assoc))
{
    $num_jobs = $num_jobs_assoc["num_jobs"];
}

$history = [
    ["Job Title" => "Job1", "Job Role" => "Web Designer", "Employer Name" => "Company A", "Start Time" => "8:55 AM", "End Time" => "1:44 PM", "Hours" => 4.81, "Hourly Wage" => 25],
    ["Job Title" => "Job2", "Job Role" => "UX Designer", "Employer Name" => "Company B", "Start Time" => "5:24 PM", "End Time" => "8:10 PM", "Hours" => 2.76, "Hourly Wage" => 30],
    ["Job Title" => "Job3", "Job Role" => "Graphic Artist", "Employer Name" => "Company C", "Start Time" => "4:56 PM", "End Time" => "8:36 PM", "Hours" => 3.67, "Hourly Wage" => 28],
    ["Job Title" => "Job4", "Job Role" => "Coffee Lover", "Employer Name" => "Company D", "Start Time" => "8:56 AM", "End Time" => "2:15 PM", "Hours" => 5.32, "Hourly Wage" => 15],
    ["Job Title" => "Job5", "Job Role" => "Marketing Specialist", "Employer Name" => "Company E", "Start Time" => "8:59 AM", "End Time" => "12:57 PM", "Hours" => 3.96, "Hourly Wage" => 35],
    ["Job Title" => "Job6", "Job Role" => "Software Engineer", "Employer Name" => "Company F", "Start Time" => "4:57 PM", "End Time" => "9:27 PM", "Hours" => 4.51, "Hourly Wage" => 40],
    ["Job Title" => "Job7", "Job Role" => "Data Analyst", "Employer Name" => "Company G", "Start Time" => "8:57 AM", "End Time" => "1:29 PM", "Hours" => 4.54, "Hourly Wage" => 33]
];

// Calculate total hours worked and total wages earned
$total_hours_worked = array_sum(array_column($history, 'Hours'));
$total_wages_earned = 0;
foreach ($history as $entry) {
    $total_wages_earned += $entry["Hours"] * $entry["Hourly Wage"];
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
            <div class="chart">
                <canvas id="hoursChart"></canvas>
            </div>
            <div class="history mt-4">
                <h2>This Week's Clock-In/Clock-Out History</h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Job Title</th>
                                <th>Job Role</th>
                                <th>Employer Name</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Estimated Hours Worked</th>
                                <th>Weekly Wages</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($history as $entry) { 
                                $weekly_wages = $entry["Hours"] * $entry["Hourly Wage"];
                            ?>
                            <tr>
                                <td><?php echo $entry["Job Title"]; ?></td>
                                <td><?php echo $entry["Job Role"]; ?></td>
                                <td><?php echo $entry["Employer Name"]; ?></td>
                                <td><?php echo $entry["Start Time"]; ?></td>
                                <td><?php echo $entry["End Time"]; ?></td>
                                <td><?php echo $entry["Hours"]; ?></td>
                                <td><?php echo "$" . number_format($weekly_wages, 2); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <p class="text-right font-weight-bold">Total Hours Worked: <?php echo $total_hours_worked; ?></p>
                <p class="text-right font-weight-bold">Total Wages Earned: <?php echo "$" . number_format($total_wages_earned, 2); ?></p>
                <div class="text-left mt-3">
                    <a href="<?=$websiteUrl?>dashboard/calculation.php" class="btn btn-primary">Go to Calculation Page</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../templates/footer.php"; ?>

<!-- Chart.js script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script src="<?=$websiteUrl?>/assets/js/script.js"></script>
