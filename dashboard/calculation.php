<?php require_once "../templates/session-starter.php"; ?>
<?php require_once "templates/dashboard-header.php"; ?>
<?php require_once "../templates/header.php"; ?>
<?php require_once "../db/job-db-funcs.php"; ?>

<?php
$history = [
    ["Job Title" => "Job1", "Job Role" => "Web Designer", "Employer Name" => "Company A", "Pay Rate" => 25, "Hours Worked" => 4.81],
    ["Job Title" => "Job2", "Job Role" => "UX Designer", "Employer Name" => "Company B", "Pay Rate" => 30, "Hours Worked" => 2.76],
    ["Job Title" => "Job3", "Job Role" => "Graphic Artist", "Employer Name" => "Company C", "Pay Rate" => 28, "Hours Worked" => 3.67],
    ["Job Title" => "Job4", "Job Role" => "Coffee Lover", "Employer Name" => "Company D", "Pay Rate" => 15, "Hours Worked" => 5.32],
    ["Job Title" => "Job5", "Job Role" => "Marketing Specialist", "Employer Name" => "Company E", "Pay Rate" => 35, "Hours Worked" => 3.96],
    ["Job Title" => "Job6", "Job Role" => "Software Engineer", "Employer Name" => "Company F", "Pay Rate" => 40, "Hours Worked" => 4.51],
    ["Job Title" => "Job7", "Job Role" => "Data Analyst", "Employer Name" => "Company G", "Pay Rate" => 33, "Hours Worked" => 4.54]
];
?>

<div class="wrapper">
    <!--IMPORT MAIN HEADER CODE-->
    <?php require_once "templates/dashboard-main-header.php"; ?>

    <!--IMPORT SIDEBAR CODE HERE-->
    <?php require_once "templates/dashboard-sidebar.php"; ?>

    <!--IMPORT PRELOADER HERE-->
    <?php require_once "templates/dashboard-preloader.php"; ?>

    <!--INCLUDE CODE FOR THE CALCULATION PAGE INSIDE THE content-wrapper -->

    <!--I ADDED THIS PHP INCASE WE WILL USE THE PROFILE.PHP FOR SOMETHING ELSE, ALSO UPDATED SIDEBAR-->
    <div class="content-wrapper">
        <div class="container">
            <h1 class="my-4">Weekly Calculations</h1>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Job Title</th>
                            <th>Job Role</th>
                            <th>Employer Name</th>
                            <th>Pay Rate ($/hr)</th>
                            <th>Hours Worked</th>
                            <th>Weekly Wages ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($history as $entry) { 
                            $weekly_wages = $entry["Hours Worked"] * $entry["Pay Rate"];
                        ?>
                        <tr>
                            <td><?php echo $entry["Job Title"]; ?></td>
                            <td><?php echo $entry["Job Role"]; ?></td>
                            <td><?php echo $entry["Employer Name"]; ?></td>
                            <td><?php echo "$" . number_format($entry["Pay Rate"], 2); ?></td>
                            <td><?php echo $entry["Hours Worked"]; ?></td>
                            <td><?php echo "$" . number_format($weekly_wages, 2); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require_once "../templates/footer.php"; ?>
