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

    <!--INCLUDE CODE FOR THE PROFILE PAGE INSIDE THE content-wrapper -->


<!--NOTE MODEL FOR DELETING JOBS -->
<div class="content-wrapper">
    <!-- Button to trigger modal -->
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteJobModal">
            Delete Job
        </button>
    </div>
</div>

<!-- Delete Job Modal -->
<div class="modal fade" id="deleteJobModal" tabindex="-1" role="dialog" aria-labelledby="deleteJobModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteJobModalLabel">Delete Job</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete job?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<?php require_once "../templates/footer.php";?>



    <!-- Bootstrap CSS
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>