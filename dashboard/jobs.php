<?php require_once "../templates/session-starter.php"; ?>
<?php require_once "templates/dashboard-header.php"; ?>
<?php require_once "../templates/header.php"; ?>
<?php require_once "../db/job-db-funcs.php";
// Grab all the jobs of this user
$jobs = getAllJobsOfUserForJobsPage($user["id"]);
?>
<!--HTML CODE GOES HERE-->
<div class="wrapper">
    <!--IMPORT MAIN HEADER CODE-->
    <?php require_once "templates/dashboard-main-header.php"; ?>

    <!--IMPORT SIDEBAR CODE HERE-->
    <?php require_once "templates/dashboard-sidebar.php"; ?>

    <!--IMPORT PRELOADER HERE-->
    <?php require_once "templates/dashboard-preloader.php"; ?>

    <!--INCLUDE CODE FOR THE JOBS PROFILE PAGE INSIDE THE content-wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Jobs</h1>
                    </div>
                </div>
            </div>
        </section>
<!--NOTE: For the column I wasnt sure what to do so I placed both # and numbers for now -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><b><?=$user["name"]?></b> Jobs</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <input type="hidden" id="user-id" value="<?=$user["id"]?>">
                                            <th>Job Title</th>
                                            <th>Job Role</th>
                                            <th>Employer Name</th>
                                            <th>Pay Rate</th>
                                            <th>Working Days</th>
                                            <th>Pay Roll Day</th>
                                            <th style="width: 140px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php // Loop through each job in the DB?>
                                        <?php if (!array_key_exists("error", $jobs)):?>
                                            <?php foreach($jobs as $job): ?>
                                                <?php $job_id = $job["job_id"]; ?>
                                                <tr>
                                                    <td><?=$job["job_title"];?></td>
                                                    <td><?=$job["job_role"];?></td>
                                                    <td><?=$job["employer_name"];?></td>
                                                    <td><?=formatRateAmountByType($job["pay_rate_amount"], $job["pay_rate_type"]);?></td>
                                                    <td><?php echo (isset($job["working_days"])) ? $job["working_days"] : "No Schedule Specified"?></td>
                                                    <td><?=$job["payroll_day"];?></td>
                                                    <td class="job-actions" role="group">
                                                        <a href="<?=$websiteUrl;?>dashboard/job.php?action=view&id=<?=$job_id;?>" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                                        <a href="<?=$websiteUrl;?>dashboard/job.php?action=edit&id=<?=$job_id;?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                        <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach;?>
                                        <?php else:?>
                                            <tr>
                                                <div class="text-center">
                                                    <h4 class="display-5">No Jobs</h4>
                                                    <p class="h5">You have not added any jobs yet</p>
                                                </div>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php require_once "../templates/footer.php"; ?>
