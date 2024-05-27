<?php require_once "templates/header.php"; ?>
<?php require_once "templates/main-header.php"; ?>

<main>
    <section class="banner">
        <img src="<?=$websiteUrl?>assets/img/pocket_watch.jpg" alt="Clock Banner">
    </section>
    <section class="content mb-5">
        <div class="privacy-content">
            <div class="image">
                <img src="<?=$websiteUrl?>assets/img/purple_hourglass.jpg" alt="Hourglass">
            </div>
            <div class="text">
                <h2 class="fsize-200-e dark-purple-color">Privacy</h2>
                
                <p>HoursManager does not share with any third-party any details of the users' account without their express consent.</p>
                <p>HoursManager advises customers not to share their account tokens with anybody.</p>
                <p>HoursManager advises customers not to share screenshots of their dashboard panels to avoid security violations.</p>
                <p>HoursManager is hereby responsible for not sharing customers' data without their consent.</p>
                <p>HoursManager is hereby NOT responsible for how customers choose to share the data they chose to store in HoursManager.</p>

                <h3 class="fsize-150">User Controls And Options</h3>

                <p>HoursManager lets their users change the username, password, and account tokens of their HoursManager account.</p>
                <p>HoursManager even allows users to choose an extra encryption step where users will be able to provide their own keys to decrypt their private data.</p>
            </div>
        </div>
    </section>
</main>

<?php require_once "templates/main-footer.php"; ?>
<?php require_once "templates/footer.php"; ?>
