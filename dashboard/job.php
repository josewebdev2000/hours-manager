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

<?php $allowed_actions = ["add", "view", "edit"]; // Actions Job Page May Do ?>
<?php $id_required_actions = ["view", "edit"]; // DB Id of Job Entry ?>
<!--HTML CODE GOES HERE-->
    <div class="wrapper">
        <!--IMPORT MAIN HEADER CODE-->
        <?php require_once "templates/dashboard-main-header.php"; ?>

        <!--IMPORT SIDEBAR CODE HERE-->
        <?php require_once "templates/dashboard-sidebar.php"; ?>

        <!--IMPORT PRELOADER HERE-->
        <?php require_once "templates/dashboard-preloader.php"; ?>

        <!--INCLUDE CODE TO SHOW/EDIT EACH JOB PROFILE PAGE INSIDE THE content-wrapper -->
        <div class="content-wrapper" id="job-page-content-wrapper">
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
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h2 class="card-title fsize-150">
                                            <i class="fas fa-dollar-sign mr-sm-3"></i>
                                            <span>Pay Rate</span>
                                        </h2>
                                        <div class="card-tools">
                                            <button class="btn btn-tool" type="button" data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="rate-type">Rate Type</label>
                                            <select name="rate-type" id="rate-type" class="form-select">
                                                <option value="hourly">Hourly</option>
                                                <option value="daily">Daily</option>
                                                <option value="weekly">Weekly</option>
                                                <option value="biweekly">Biweekly</option>
                                                <option value="monthly">Monthly</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="rate-amount">Rate Amount</label>
                                            <input type="number" class="form-control" name="rate-amount" id="rate-amount" min="1">
                                        </div>
                                        <div class="form-group">
                                            <label for="effective-rate">Effective Date</label>
                                            <input type="date" class="form-control" name="effective-date" id="effective-date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-purple">
                                    <div class="card-header">
                                        <h2 class="card-title fsize-150">
                                            <i class="fas fa-money-bill mr-sm-3"></i>
                                            <span>Pay Roll</span>
                                        </h2>
                                        <div class="card-tools">
                                            <button class="btn btn-tool" type="button" data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="pay-period-start">Starting Day</label>
                                            <select class="form-select" name="pay-period-start" id="pay-period-start">
                                                <option value="monday">Monday</option>
                                                <option value="tuesday">Tueday</option>
                                                <option value="wednesday">Wednesday</option>
                                                <option value="thursday">Thursday</option>
                                                <option value="friday">Friday</option>
                                                <option value="saturday">Saturday</option>
                                                <option value="sunday">Sunday</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="pay-period-end">Ending Day</label>
                                            <select class="form-select" name="pay-period-end" id="pay-period-end">
                                                <option value="monday">Monday</option>
                                                <option value="tuesday">Tueday</option>
                                                <option value="wednesday">Wednesday</option>
                                                <option value="thursday">Thursday</option>
                                                <option value="friday">Friday</option>
                                                <option value="saturday">Saturday</option>
                                                <option value="sunday">Sunday</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="payment-day">Payment Day</label>
                                            <select class="form-select" name="payment-day" id="payment-day">
                                                <option value="monday">Monday</option>
                                                <option value="tuesday">Tueday</option>
                                                <option value="wednesday">Wednesday</option>
                                                <option value="thursday">Thursday</option>
                                                <option value="friday">Friday</option>
                                                <option value="saturday">Saturday</option>
                                                <option value="sunday">Sunday</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="total-hours">Predicted Total Hours</label>
                                            <input type="number" class="form-control" name="total-hours" id="total-hours">
                                        </div>
                                        <div class="form-group">
                                            <label for="total-pay">Predicted Total Payment</label>
                                            <input type="number" class="form-control" name="total-pay" id="total-pay">
                                        </div>
                                        <div class="form-group">
                                            <label for="tip-amount">Tips</label>
                                            <input type="number" class="form-control" name="tip-amount" id="tip-amount" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6">
                                <div class="card card-indigo">
                                    <div class="card-header">
                                        <h2 class="card-title fsize-150">
                                            <i class="fas fa-calendar-alt mr-sm-3"></i>
                                            <span>Schedule</span>
                                        </h2>
                                        <div class="card-tools">
                                            <button class="btn btn-tool" type="button" data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="working-days">Working Days</label>
                                            <div id="schedule-calendar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input id="user_id" type="hidden" value="<?=$_SESSION["id"]?>">
                        <div class="row">
                            <div class="col">
                                <div class="btn-group w-100" role="group">
                                    <button id="add-job-cancel-btn" class="btn btn-danger btn-lg">Cancel</button>
                                    <button id="add-job-new-btn" class="btn btn-success btn-lg">Add New Job</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <>
            <?php // Show Edit Page for a Job?>
            <?php elseif ($_GET["action"] == "edit"): ?>
                <section class="content-header">
                    <h1>Edit Job Page</h1>
                    <p>Ronny, Code Edit Job Page Here</p>
                </section>
                <section class="content">

                </section>
            
            <?php // Show View Page for a Job?>
            <?php elseif ($_GET["action"] == "view"):?>
                <section class="content-header">
                    <h1>View Job Page</h1>
                    <p>Ronny, Code View Job Page Here</p>
                </section>
                <section class="content">

                </section>
            <?php endif; ?>
        </div>
    </div>
<?php require_once "../templates/footer.php";?>