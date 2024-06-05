<?php require_once "templates/header.php"; ?>
<?php
    // Redirect user to the dashboard in case the user is set
    if (isset($_SESSION["id"]))
    {
        header("Location: $websiteUrl" . "dashboard/");
    }
?>
<?php require_once "templates/main-header.php"; ?>
<main id="index-main">
    <div id="index-hero-container" class="content d-flex flex-column justify-content-center align-items-center">
        <div class="hero grayish-hero d-flex flex-column justify-content-center align-items-center text-center p-5 m-5">

            <img class="d-block mx-auto mb-4 img-fluid" id="logo-pic" src="<?=$websiteUrl?>/assets/img/chronometer-128px.png" alt="HoursManger Logo">

            <h1 class="display-5 purple-color">HOURSMANAGER</h1>

            <p class="fsize-120">Do you have more than one job and struggle to keep track of your working hours? </p>

            <p class="fsize-120">Don't you think it'd be great to easily manage and keep track of all your hours in one place?</p>

            <p class="fsize-120">That place is HoursManager.</p>

            <p class="fsize-120">What are you waiting for?</p>
            
            <!--Using PHP defined variables to build up HTML link atrributes-->
            <a href="<?=$websiteUrl?>register.php" class="start-here-button btn-purple silent-link">Start Here</a>
            
        </div>
    </div>
</main>

<?php require_once "templates/main-footer.php"; ?>
<?php require_once "templates/footer.php"; ?>
