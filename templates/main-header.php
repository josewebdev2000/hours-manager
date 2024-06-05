<header>
    <!--Using PHP defined variables to build up HTML link atrributes-->
    <!--This is needed to ensure resources lead to where they are inteded in our web server -->
    <!--In my case this translates to http://localhost/projects/hours-manager/-->
    <h1><a class="silent-link purple-color purple-color-hover" href="<?=$websiteUrl?>">HOURSMANAGER</a></h1>
    <nav>
        <a href="<?=$websiteUrl?>">HOME</a>
        
        <a href="<?=$websiteUrl?>about.php">ABOUT</a>

        <!--In my case this translates to http://localhost/projects/hours-manager/contact.php-->
        <a href="<?=$websiteUrl?>contact.php">CONTACT</a>

         <!--In my case this translates to http://localhost/projects/hours-manager/privacy.php-->
        <a href="<?=$websiteUrl?>privacy.php">PRIVACY</a>
        <?php if(isset($_SESSION["id"])): ?>
            <div class="d-flex flex-lg-row flex-column align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo get_profile_pic_html_code($user, "img-circle img-fluid", 32, "$websiteUrl/assets/img/avatars/user.png"); ?>
                        </button>
                        <ul class="dropdown-menu bg-light" aria-labelledby="dropdownMenuButton">
                            <li><h6 class="dropdown-header fsize-150 text-black"><?=$user["name"];?></h6></li>
                            <li><a class="dropdown-item user fsize-120" href="<?=$websiteUrl?>/dashboard/">Dashboard</a></li>
                            <li><a class="dropdown-item user fsize-120" href="<?=$websiteUrl?>/dashboard/jobs.php">Jobs</a></li>
                            <li><a class="dropdown-item user fsize-120" href="<?=$websiteUrl?>/dashboard/profile.php">Profile</a></li>
                            <li><a class="dropdown-item user fsize-120" href="<?=$websiteUrl?>/dashboard/settings.php">Settings</a></li>
                            <li><hr class="dropdown-divider"></hr></li>
                            <li><a class="dropdown-item logout fsize-120" href="<?=$websiteUrl?>/dashboard/logout.php">Log out</a></li>
                        </ul>
                    </div>
            </div>
        <?php else: ?>
            <a href="<?=$websiteUrl?>login.php"><i class="fas fa-user"></i></a>
        <?php endif; ?>
    </nav>
</header>