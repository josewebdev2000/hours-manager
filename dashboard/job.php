<?php require_once "../templates/session-starter.php"; ?>
<?php require_once "templates/dashboard-header.php"; ?>
<?php require_once "../templates/header.php"; ?>

<?php
/*  Job Page Infrastructure
    
    This file will need to use GET parameter to conditionally render what is required-->

    GET Params
    action = ["view", "add", "update", "delete"]
    id = Id of Job in DB for ["view", "update", "delete"]
    If GET Param action is not set, show error page
    If GET param id is not set for ["view", "update", and "delete", show error page]
*/
?>

<?php $allowed_actions = ["add", "view", "update", "delete"]; // Actions Job Page May Do ?>
<?php $id_required_actions = ["view", "update", "delete"]; // DB Id of Job Entry ?>
<!--HTML CODE GOES HERE-->
    <div class="wrapper">
        <!--IMPORT MAIN HEADER CODE-->
        <?php require_once "templates/dashboard-main-header.php"; ?>

        <!--IMPORT SIDEBAR CODE HERE-->
        <?php require_once "templates/dashboard-sidebar.php"; ?>

        <!--IMPORT PRELOADER HERE-->
        <?php require_once "templates/dashboard-preloader.php"; ?>

        <!--INCLUDE CODE TO SHOW/EDIT EACH JOB PROFILE PAGE INSIDE THE content-wrapper -->
        <div class="content-wrapper">
            <?php // If action is not set as get param, show action error ?>
            <?php if (!isset($_GET["action"]) || !in_array(strtolower($_GET["action"]), $allowed_actions)): ?>
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="text-danger">Job Action Error</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="<?=$websiteUrl?>dashboard/">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Job</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="content">
                    <div class="error-page">
                        <div class="headline text-danger">400</div>
                        <div class="error-content">
                            <h3 class="mb-4">
                                <i class="fas fa-exclamation-triangle text-danger"></i>
                                Bad Request
                            </h3>
                            <h4>Invalid Action Parameter</h4>
                            <p>The <b>action</b> parameter was either not specified or invalid.</p>
                        </div>
                    </div>
                </section>
            <?php // If Job Id Is Not Set for actions that need it, show id param error?>
            <?php elseif (in_array(strtolower($_GET["action"]), $id_required_actions) && !isset($_GET["id"])): ?>
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="text-danger">Job Id Error</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="<?=$websiteUrl?>dashboard/">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Job</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="content">
                    <div class="error-page">
                        <div class="headline text-danger">400</div>
                        <div class="error-content">
                            <h3 class="mb-4">
                                <i class="fas fa-exclamation-triangle text-danger"></i>
                                Bad Request
                            </h3>
                            <h4>Invalid Id Parameter</h4>
                            <p>The <b>id</b> parameter was either not specified or invalid.</p>
                        </div>
                    </div>
                </section>
            <?php // Show Add New Page When Action is set to "add" ?>
            <?php elseif ($_GET["action"] == "add"):?>
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Add New Job</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="<?=$websiteUrl?>dashboard/">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Job</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h2 class="card-title fsize-150">
                                            <i class="fas fa-user-tie mr-sm-3"></i>
                                            <span>Employer</span>
                                        </h2>
                                        <div class="card-tools">
                                            <button class="btn btn-tool" type="button" data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="employer-name">Employer Name</label>
                                            <input type="text" class="form-control" name="employer-name" id="employer-name">
                                        </div>
                                        <div class="form-group">
                                            <label for="employer-email">Employer Email</label>
                                            <input type="email" class="form-control" name="employer-email" id="employer-email">
                                        </div>
                                        <div class="form-group">
                                            <label for="employer-phone-number">Employer Phone Number</label>
                                            <input type="tel" class="form-control" name="employer-phone-number" id="employer-phone-number" value="+1 (___) ___ - ____" mask="+1 (___) ___ - ____" placeholder="+1 (___) ___ - ____">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-pink">
                                    <div class="card-header">
                                        <h2 class="card-title fsize-150">
                                            <i class="fas fa-suitcase mr-sm-3"></i>
                                            <span>Job</span>
                                        </h2>
                                        <div class="card-tools">
                                            <button class="btn btn-tool" type="button" data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="job-title">Job Title</label>
                                            <input type="text" class="form-control" name="job-title" id="job-title">
                                        </div>
                                        <div class="form-group">
                                            <label for="job-role">Job Role</label>
                                            <input type="text" class="form-control" name="job-role" id="job-role">
                                        </div>
                                        <div class="form-group">
                                            <label for="job-address">Job Address</label>
                                            <input type="text" class="form-control" name="job-address" id="job-address">
                                        </div>
                                        <div class="form-group">
                                            <label for="job-description">Job Description</label>
                                            <textarea class="form-control" name="job-description" id="job-description" rows="4"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="job-start-date">Job Start Date</label>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </div>
<?php require_once "../templates/footer.php";?>