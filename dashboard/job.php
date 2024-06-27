<?php require_once "../templates/session-starter.php"; ?>
<?php require_once "templates/dashboard-header.php"; ?>
<?php require_once "../templates/header.php"; ?>

<?php require_once "../db/job-db-funcs.php";
require_once "../db/working-day-db-funcs.php";
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
            <input id="user_id" type="hidden" value="<?=$_SESSION["id"]?>">
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
                                        <div class="form-group position-relative">
                                            <label for="employer-name">Employer Name</label>
                                            <input type="text" class="form-control" name="employer-name" id="employer-name">
                                            <div class="valid-tooltip employer-name">Employer Name Looks Good</div>
                                            <div class="invalid-tooltip employer-name">An Employer Name Is Required</div>
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
                                        <div class="form-group position-relative">
                                            <label for="rate-type">Rate Type</label>
                                            <select name="rate-type" id="rate-type" class="form-select">
                                                <option value="hourly">Hourly</option>
                                                <option value="daily">Daily</option>
                                                <option value="weekly">Weekly</option>
                                                <option value="biweekly">Biweekly</option>
                                                <option value="monthly">Monthly</option>
                                            </select>
                                            <div class="valid-tooltip rate-type">Rate Type Looks Good</div>
                                            <div class="invalid-tooltip rate-type">A Rate Type Must Be Chosen</div>
                                        </div>
                                        <div class="form-group position-relative">
                                            <label for="rate-amount">Rate Amount</label>
                                            <input type="number" class="form-control" name="rate-amount" id="rate-amount" min="1">
                                            <div class="valid-tooltip rate-amount">Rate Amount Looks Good</div>
                                            <div class="invalid-tooltip rate-amount">A Rate Amount Must Be Given</div>
                                        </div>
                                        <div class="form-group position-relative">
                                            <label for="effective-date">Effective Date</label>
                                            <input type="date" class="form-control" name="effective-date" id="effective-date">
                                            <div class="valid-tooltip effective-date">Effective Date Looks Good</div>
                                            <div class="invalid-tooltip effective-date">A Valid Date Must Be Chosen</div>
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
                                            <div class="form-group position-relative">
                                                <label for="job-title">Job Title</label>
                                                <input type="text" class="form-control" name="job-title" id="job-title">
                                                <div class="valid-tooltip job-title">Job Title Looks Good</div>
                                                <div class="invalid-tooltip job-title">Job Title Is A Required Field</div>
                                            </div>
                                            <div class="form-group position-relative">
                                                <label for="job-role">Job Role</label>
                                                <input type="text" class="form-control" name="job-role" id="job-role">
                                                <div class="valid-tooltip job-role">Job Role Looks Good</div>
                                                <div class="invalid-tooltip job-role">Job Role Is A Required Field</div>
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
                                        <div class="form-group position-relative">
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
                                            <div class="valid-tooltip pay-period-start">Starting Day Looks Good</div>
                                            <div class="invalid-tooltip pay-period-start">Please Choose A Valid Day</div>
                                        </div>
                                        <div class="form-group position-relative">
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
                                            <div class="valid-tooltip pay-period-end">Ending Day Looks Good</div>
                                            <div class="invalid-tooltip pay-period-end">Please Choose A Valid Day</div>
                                        </div>
                                        <div class="form-group position-relative">
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
                                            <div class="valid-tooltip payment-day">Payment Day Looks Good</div>
                                            <div class="invalid-tooltip payment-day">Please Choose A Valid Day</div>
                                        </div>
                                        <div class="form-group position-relative">
                                            <label for="total-hours">Predicted Total Hours</label>
                                            <input type="number" class="form-control" name="total-hours" id="total-hours" min="1">
                                            <div class="valid-tooltip total-hours">Predicted Total Hours Look Good</div>
                                            <div class="invalid-tooltip total-hours">Predicted Total Hours Is A Valid Field</div>
                                        </div>
                                        <div class="form-group position-relative">
                                            <label for="total-pay">Predicted Total Payment</label>
                                            <input type="number" class="form-control" name="total-pay" id="total-pay" min="1">
                                            <div class="valid-tooltip total-pay">Predicted Total Payment Looks Good</div>
                                            <div class="invalid-tooltip total-hours">Predicted Total Payment Is A Valid Field</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tip-amount">Tips</label>
                                            <input type="number" class="form-control" name="tip-amount" id="tip-amount" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            <?php // Show Edit Page for a Job?>
            <?php elseif ($_GET["action"] == "edit"): ?>
                <input type="hidden" id="edit_job_id" value="<?=$_GET["id"];?>">
                <?php // Try to grab data about the job?>
                <?php $job = getJobOfUserById($_SESSION["id"], $_GET["id"]); ?>
                <?php if(array_key_exists("error", $job)): ?>
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1 class="text-warning">Job Not Found Error</h1>
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
                            <div class="headline text-warning">404</div>
                            <div class="error-content">
                                <h3 class="mb-4">
                                    <i class="fas fa-exclamation-triangle text-warning"></i>
                                    Not Found
                                </h3>
                                <h4>Job Not Found</h4>
                                <p>The requested job could not be found</p>
                            </div>
                        </div>
                    </section>
                <?php else:?>
                    <section class="content-header">
                        <input type="hidden" id="edit_employer_id" value="<?=getEmployerIdOfJobId($_GET["id"]); ?>">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>Edit Job Details</h1>
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
                                                <label for="edit-employer-name">Employer Name</label>
                                                <input type="text" id="edit-employer-name" class="form-control" value="<?=$job["employer_name"];?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-employer-email">Employer Email</label>
                                                <input type="email" class="form-control" id="edit-employer-email" value="<?php echo (isset($job["employer_email"])) ? $job["employer_email"] : "" ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-employer-phone-number">Employer Phone Number</label>
                                                <input type="tel" id="edit-employer-phone-number" class="form-control" value="<?php echo (isset($job["employer_phone_number"])) ? $job["employer_phone_number"] : "" ?>" mask="+1 (___) ___ - ____" placeholder="+1 (___) ___ - ____">
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
                                                <label for="edit-rate-type">Rate Type</label>
                                                <select class="form-select" id="edit-rate-type">
                                                    <option value="hourly" <?php echo ($job["pay_rate_type"] == "hourly") ? "selected" : "" ?>>Hourly</option>
                                                    <option value="daily" <?php echo ($job["pay_rate_type"] == "daily") ? "selected" : "" ?>>Daily</option>
                                                    <option value="weekly" <?php echo ($job["pay_rate_type"] == "weekly") ? "selected" : "" ?>>Weekly</option>
                                                    <option value="monthly" <?php echo ($job["pay_rate_type"] == "monthly") ? "selected" : "" ?>>Monthly</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-rate-amount">Rate Amount</label>
                                                <input type="number" id="edit-rate-amount" class="form-control" value="<?=$job["pay_rate_amount"]?>" min="1">
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-effective-rate">Effective Date</label>
                                                <input type="date" id="edit-effective-date" class="form-control" value="<?=$job["effective_date"]?>">
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
                                                    <label for="edit-job-title">Job Title</label>
                                                    <input type="text" id="edit-job-title" class="form-control" value="<?=$job["job_title"];?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-job-role">Job Role</label>
                                                    <input type="text" id="edit-job-role" class="form-control" value="<?=$job["job_role"];?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-job-address">Job Address</label>
                                                    <input type="text" id="edit-job-address" class="form-control" value="<?php echo (isset($job["job_address"])) ? $job["job_address"] : "" ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-job-description">Job Description</label>
                                                    <textarea class="form-control" id="edit-job-description" rows="4">
                                                        <?php echo (isset($job["job_description"])) ? $job["job_description"] : "" ?>
                                                    </textarea>
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
                                                <label for="edit-starting-day">Starting Day</label>
                                                <select class="form-select" id="edit-starting-day">
                                                    <option value="monday" <?php echo (ucfirst($job["starting_day"]) == "Monday") ? "selected" : "" ?>>Monday</option>
                                                    <option value="tuesday" <?php echo (ucfirst($job["starting_day"]) == "Tuesday") ? "selected" : "" ?>>Tuesday</option>
                                                    <option value="wednesday" <?php echo (ucfirst($job["starting_day"]) == "Wednesday") ? "selected" : "" ?>>Wednesday</option>
                                                    <option value="thursday" <?php echo (ucfirst($job["starting_day"]) == "Thursday") ? "selected" : "" ?>>Thursday</option>
                                                    <option value="friday" <?php echo (ucfirst($job["starting_day"]) == "Friday") ? "selected" : "" ?>>Friday</option>
                                                    <option value="saturday" <?php echo (ucfirst($job["starting_day"]) == "Saturday") ? "selected" : "" ?>>Saturday</option>
                                                    <option value="sunday" <?php echo (ucfirst($job["starting_day"]) == "Sunday") ? "selected" : "" ?>>Sunday</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-ending-day">Ending Day</label>
                                                <select class="form-select" id="edit-ending-day">
                                                    <option value="monday" <?php echo (ucfirst($job["ending_day"]) == "Monday") ? "selected" : "" ?>>Monday</option>
                                                    <option value="tuesday" <?php echo (ucfirst($job["ending_day"]) == "Tuesday") ? "selected" : "" ?>>Tuesday</option>
                                                    <option value="wednesday" <?php echo (ucfirst($job["ending_day"]) == "Wednesday") ? "selected" : "" ?>>Wednesday</option>
                                                    <option value="thursday" <?php echo (ucfirst($job["ending_day"]) == "Thursday") ? "selected" : "" ?>>Thursday</option>
                                                    <option value="friday" <?php echo (ucfirst($job["ending_day"]) == "Friday") ? "selected" : "" ?>>Friday</option>
                                                    <option value="saturday" <?php echo (ucfirst($job["ending_day"]) == "Saturday") ? "selected" : "" ?>>Saturday</option>
                                                    <option value="sunday" <?php echo (ucfirst($job["ending_day"]) == "Sunday") ? "selected" : "" ?>>Sunday</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-payment-day">Payment Day</label>
                                                <select class="form-select" id="edit-payment-day">
                                                    <option value="monday" <?php echo (ucfirst($job["payroll_day"]) == "Monday") ? "selected" : "" ?>>Monday</option>
                                                    <option value="tuesday" <?php echo (ucfirst($job["payroll_day"]) == "Tuesday") ? "selected" : "" ?>>Tuesday</option>
                                                    <option value="wednesday" <?php echo (ucfirst($job["payroll_day"]) == "Wednesday") ? "selected" : "" ?>>Wednesday</option>
                                                    <option value="thursday" <?php echo (ucfirst($job["payroll_day"]) == "Thursday") ? "selected" : "" ?>>Thursday</option>
                                                    <option value="friday" <?php echo (ucfirst($job["payroll_day"]) == "Friday") ? "selected" : "" ?>>Friday</option>
                                                    <option value="saturday" <?php echo (ucfirst($job["payroll_day"]) == "Saturday") ? "selected" : "" ?>>Saturday</option>
                                                    <option value="sunday" <?php echo (ucfirst($job["payroll_day"]) == "Sunday") ? "selected" : "" ?>>Sunday</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-total-hours">Predicted Total Hours</label>
                                                <input type="number" id="edit-total-hours" class="form-control" value="<?=$job["total_hours"];?>" min="1">
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-total-pay">Predicted Total Payment</label>
                                                <input type="number" id="edit-total-pay" class="form-control" value="<?=$job["total_pay"]?>" min="1">
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-tips">Tips</label>
                                                <input type="number" id="edit-tips" class="form-control" value="<?=$job["tip"];?>" min="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-6">
                                    <div class="card card-indigo d-none">
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
                                                <div id="view-schedule-calendar" class="text-center">
                                                    <div id="working-days-not-found" class="d-none text-center">
                                                        <h4>No Working Schedule</h4>
                                                        <p>No working schedule was specified for this job</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                        <div class="btn-group w-100" role="group">
                                            <button id="edit-job-cancel-btn" class="btn btn-danger btn-lg">Cancel</button>
                                            <button id="edit-job-btn" class="btn btn-info btn-lg text-white">Edit Job</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </section>
                <?php endif; ?>
            <?php // Show View Page for a Job?>
            <?php elseif ($_GET["action"] == "view"):?>
                <input type="hidden" id="view_job_id" value="<?=$_GET["id"];?>">
                <?php // Try to grab data about the job?>
                <?php $job = getJobOfUserById($_SESSION["id"], $_GET["id"]); ?>
                <?php if(array_key_exists("error", $job)): ?>
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1 class="text-warning">Job Not Found Error</h1>
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
                            <div class="headline text-warning">404</div>
                            <div class="error-content">
                                <h3 class="mb-4">
                                    <i class="fas fa-exclamation-triangle text-warning"></i>
                                    Not Found
                                </h3>
                                <h4>Job Not Found</h4>
                                <p>The requested job could not be found</p>
                            </div>
                        </div>
                    </section>
                <?php else:?>
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>View Job Details</h1>
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
                                                <label>Employer Name</label>
                                                <input type="text" id="view-employer-name" class="form-control" value="<?=$job["employer_name"];?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Employer Email</label>
                                                <input type="email" class="form-control" value="<?php echo (isset($job["employer_email"])) ? $job["employer_email"] : "Employer Email Not Specified" ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Employer Phone Number</label>
                                                <input type="tel" class="form-control" value="<?php echo (isset($job["employer_phone_number"])) ? $job["employer_phone_number"] : "Employer Phone Number Not Specified" ?>" readonly>
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
                                                <input type="text" class="form-control" value="<?=ucfirst($job["pay_rate_type"]);?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Rate Amount</label>
                                                <input type="text" class="form-control" value="$<?=$job["pay_rate_amount"]?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="effective-rate">Effective Date</label>
                                                <input type="date" class="form-control" value="<?=$job["effective_date"]?>" readonly>
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
                                                    <label>Job Title</label>
                                                    <input type="text" class="form-control" value="<?=$job["job_title"];?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Job Role</label>
                                                    <input type="text" id="view-job-role" class="form-control" value="<?=$job["job_role"];?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Job Address</label>
                                                    <input type="text" class="form-control" value="<?php echo (isset($job["job_address"])) ? $job["job_address"] : "Job Address Not Specified" ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Job Description</label>
                                                    <textarea class="form-control" value="<?php echo (isset($job["job_description"])) ? $job["job_description"] : "Job Description Not Specified" ?>" rows="4" readonly>
                                                        <?php echo (isset($job["job_description"])) ? $job["job_description"] : "Job Description Not Specified" ?>
                                                    </textarea>
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
                                                <label>Starting Day</label>
                                                <input type="text" class="form-control" value="<?=$job["starting_day"];?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Ending Day</label>
                                                <input type="text" class="form-control" value="<?=$job["ending_day"];?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Payment Day</label>
                                                <input type="text" class="form-control"  value="<?=$job["payroll_day"];?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Predicted Total Hours</label>
                                                <input type="text" class="form-control" value="<?=$job["total_hours"];?> hours" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Predicted Total Payment</label>
                                                <input type="text" class="form-control" value="$<?=$job["total_pay"]?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Tips</label>
                                                <input type="text" class="form-control" value="$<?=$job["tip"];?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-6">
                                    <div class="card card-indigo d-none">
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
                                                <div id="view-schedule-calendar" class="text-center">
                                                    <div id="working-days-not-found" class="d-none text-center">
                                                        <h4>No Working Schedule</h4>
                                                        <p>No working schedule was specified for this job</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<?php require_once "../templates/footer.php";?>