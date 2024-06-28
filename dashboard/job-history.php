<?php require_once "../templates/session-starter.php"; ?>
<?php require_once "templates/dashboard-header.php"; ?>
<?php require_once "../templates/header.php"; ?>

<?php
// Simulated data for demonstration. Replace this with actual database queries.
$jobId = $_GET['jobId'];
$jobRoles = [
    1 => "Web Designer",
    2 => "UX Designer",
    3 => "Graphic Artist",
    4 => "Coffee Lover",
    5 => "Marketing Specialist",
    6 => "Software Engineer",
    7 => "Data Analyst",
    8 => "Product Manager"
];

$employers = [
    1 => "Company A",
    2 => "Company B",
    3 => "Company C",
    4 => "Company D",
    5 => "Company E",
    6 => "Company F",
    7 => "Company G",
    8 => "Company H"
];

// Example clock-in/clock-out history data
$history = [
    ["Start Time" => "2024-06-01 09:00", "End Time" => "2024-06-01 17:00"],
    ["Start Time" => "2024-06-02 09:00", "End Time" => "2024-06-02 17:00"],
    // Add more history data as needed
];
?>

<div class="wrapper">
    <?php require_once "templates/dashboard-main-header.php"; ?>
    <?php require_once "templates/dashboard-sidebar.php"; ?>
    <?php require_once "templates/dashboard-preloader.php"; ?>

    <div class="content-wrapper">
        <div class="container">
            <h1>Job <?php echo $jobId; ?> History</h1>
            <p>Job Role: <?php echo $jobRoles[$jobId]; ?></p>
            <p>Employer: <?php echo $employers[$jobId]; ?></p>

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
                    <?php foreach ($history as $entry) { ?>
                    <tr>
                        <td>Job <?php echo $jobId; ?></td>
                        <td><?php echo $jobRoles[$jobId]; ?></td>
                        <td><?php echo $employers[$jobId]; ?></td>
                        <td><?php echo $entry['Start Time']; ?></td>
                        <td><?php echo $entry['End Time']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once "../templates/footer.php"; ?>
