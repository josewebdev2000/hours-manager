<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
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
<?php require_once "templates/header.php"; ?>
<?php require_once "templates/main-header.php"; ?>

<main id="index-main">
    <div class="content">
        <div class="center-box">
            <p>Are you the kind of person that always forgets to track your working hours?<br>
            Don't you think it'd be great to easily manage and keep track of all your hours in one place?<br>
            That place is HoursManager.<br>
            What are you waiting for?</p>
            <a href="#" class="start-here-button">Start Here</a>
        </div>
    </div>
</main>

<?php require_once "templates/main-footer.php"; ?>
<?php require_once "templates/footer.php"; ?>

</body>
</html>
