<<<<<<< HEAD
<!--Using PHP to use the code from another files once-->
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page at index</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('assets/img/clocks.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
            padding: 1em;
        }
    </style>
</head>
<body>
>>>>>>> 0e724d116980876312ce95901bb4b49e5e43d473
<?php require_once "templates/header.php"; ?>
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
            <a href="<?=$websiteUrl?>/register.php" class="start-here-button">Start Here</a>
            
        </div>
    </div>
</main>

<?php require_once "templates/main-footer.php"; ?>
<?php require_once "templates/footer.php"; ?>

</body>
</html>
