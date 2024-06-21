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

    <!--INCLUDE CODE FOR THE JOBS PROFILE PAGE INSIDE THE content-wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Jobs Profile Page</h1>
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
                                <h3 class="card-title">Jobs</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Job Name</th>
                                                <th>Rate</th>
                                                <th>Working Days</th>
                                                <th>Pay Roll Day</th>
                                                <th style="width: 140px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#</td>
                                                <td>USER EXAMPLE</td>
                                                <td>$16.50/hr</td>
                                                <td>Friday, Saturday, Sunday, Monday</td>
                                                <td>Friday</td>
                                                <td>
                                                    <a href="job.php?action=view&id=2" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                                    <a href="job.php?action=edit&id=2" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#</td>
                                                <td>USER EXAMPLE</td>
                                                <td>$20.00/hr</td>
                                                <td>Tuesday, Wednesday, Thursday</td>
                                                <td>Friday</td>
                                                <td>
                                                    <a href="job.php?action=view&id=2" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                                    <a href="job.php?action=edit&id=2" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#</td>
                                                <td>USER EXAMPLE</td>
                                                <td>$18.75/hr</td>
                                                <td>Monday, Tuesday, Wednesday</td>
                                                <td>Friday</td>
                                                <td>
                                                    <a href="job.php?action=view&id=2" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                                    <a href="job.php?action=edit&id=2" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#</td>
                                                <td>USER EXAMPLE</td>
                                                <td>$19.00/hr</td>
                                                <td>Thursday, Friday, Saturday</td>
                                                <td>Friday</td>
                                                <td>
                                                    <a href="job.php?action=view&id=2" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                                    <a href="job.php?action=edit&id=2" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>USER EXAMPLE</td>
                                                <td>$15.00/hr</td>
                                                <td>Monday, Wednesday, Friday</td>
                                                <td>Friday</td>
                                                <td>
                                                    <a href="job.php?action=view&id=2" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                                    <a href="job.php?action=edit&id=2" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>USER EXAMPLE</td>
                                                <td>$21.50/hr</td>
                                                <td>Tuesday, Thursday, Saturday</td>
                                                <td>Friday</td>
                                                <td>
                                                    <a href="job.php?action=view&id=2" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                                    <a href="job.php?action=edit&id=2" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td>USER EXAMPLE</td>
                                                <td>$22.00/hr</td>
                                                <td>Friday, Saturday, Sunday, Monday</td>
                                                <td>Friday</td>
                                                <td>
                                                    <a href="job.php?action=view&id=2" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                                    <a href="job.php?action=edit&id=2" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>8</td>
                                                <td>USER EXAMPLE</td>
                                                <td>$18.00/hr</td>
                                                <td>Wednesday, Thursday, Friday</td>
                                                <td>Friday</td>
                                                <td>
                                                    <a href="job.php?action=view&id=2" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                                    <a href="job.php?action=edit&id=2" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>9</td>
                                                <td>USER EXAMPLE</td>
                                                <td>$20.00/hr</td>
                                                <td>Monday, Wednesday, Friday</td>
                                                <td>Friday</td>
                                                <td>
                                                    <a href="job.php?action=view&id=2" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                                    <a href="job.php?action=edit&id=2" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="job.php?action=add" class="btn btn-success"><i class="fas fa-plus"></i> Add New Job</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php require_once "../templates/footer.php"; ?>
