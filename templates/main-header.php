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

         <!--In my case this translates to http://localhost/projects/hours-manager/login.php-->
        <a href="<?=$websiteUrl?>login.php">LOGIN</a>
    </nav>
</header>