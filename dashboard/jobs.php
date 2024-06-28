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
    <div class="content-wrapper" id="jobs-page-content-wrapper">
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
                            <div class="card-body">
                                <div class="table-responsive">
                                <input type="hidden" id="user-id" value="<?=$user["id"]?>">
                                    <div>
                                        <a class="btn btn-block btn-purple btn-lg text-white" href="<?=$websiteUrl?>dashboard/job.php?action=add">Add New Job</a>
                                    </div>
                                    <table class="table table-bordered table-hover align-middle">
                                        <thead>
                                            <tr>
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
                                                    <?php $employer_id =  $job["employer_id"];?>
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
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-modal-<?=$job_id?>"><i class="fas fa-trash"></i> Delete</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>                                                                                                                      <!-- Delete Job Modal -->
                                                            <div class="modal fade" id="delete-modal-<?=$job_id?>" tabindex="-1" role="dialog" aria-labelledby="deleteJobModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="deleteJobModalLabel">Delete (<?=$job["job_role"]?> - <?=$job["employer_name"]?>) Job</h5>
                                                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure you want to delete this job?
                                                                        </div>
                                                                        <div class="modal-footer" id="delete-modal-footer-<?=$job_id?>">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="button" class="btn btn-danger delete-job-btn" id="btn-modal-delete-job-<?=$employer_id?>-<?=$job_id?>">Delete</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                <?php endforeach;?>
                                            <?php else:?>
                                                <tr>
                                                    <td colspan="7">
                                                        <div class="text-center">
                                                            <h4 class="display-5">No Jobs</h4>
                                                            <p class="h5">You have not added any jobs yet</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php require_once "../templates/footer.php"; ?>
