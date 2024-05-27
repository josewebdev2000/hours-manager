<?php require_once "templates/header.php"; ?>
<?php require_once "templates/main-header.php"; ?>

<main>
    <section class="banner">
        <img src="<?=$websiteUrl?>assets/img/purple_hourglass.jpg" alt="Hourglass">
    </section>
    <section class="content">
        <div class="privacy-content">
            <div class="image">
                <img src="<?=$websiteUrl?>assets/img/pocket_watch.jpg" alt="Clock Banner">
            </div>
            <div class="text">
                <h2 class="fsize-200-e dark-purple-color">About</h2>
                
                <p>Welcome to HoursManager!!</p>
                <p>HoursManager is your reliable partner in efficient time management.</p>
                <p>We understand that keeping track of your working hours can be challenging, whether you're managing a busy team or tracking your personal productivity.</p>
                <p>That's why we created HoursManager – to simplify and streamline the process for you.</p>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 text-center">
                            <h3>Our Mission</h3>
                            <p>At HoursManager, our mission is to provide an intuitive and secure platform that helps individuals and organizations manage their time effectively. We aim to enhance productivity and ensure accurate time tracking with ease.</p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 text-center">
                            <h3>Our Story</h3>
                            <p>HoursManager was founded by a group of professionals who experienced firsthand the challenges of tracking work hours and managing time efficiently. We realized the need for a simple, yet powerful tool that could help people stay organized and focused on their tasks without the hassle of complicated software.</p>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                            <h3>Our Values</h3>
                            <div class="row">
                                <div class="col-12">
                                    <h5>Simplicity</h5>
                                    <p>We believe in keeping things simple. Our user-friendly interface ensures that you can start managing your time without any steep learning curve.</p>
                                </div>
                                <div class="col-12">
                                    <h5>Security</h5>
                                    <p>Your data's security is our top priority. We use advanced encryption methods to protect your information and ensure it remains confidential.</p>
                                </div>
                                <div class="col-12">
                                    <h5>Efficiency</h5>
                                    <p>Time is valuable. HoursManager is designed to save you time by automating and simplifying time tracking, so you can focus on what matters most.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="w-100">
                                <h3 class="text-center">What We Offer</h3>
                                <ul class="p-3 row list-unstyled text-center">
                                    <li class="col-md-6 col-12 purple-color-hover pointy trans-color-03 media mb-3">
                                        <i class="fas fa-business-time fa-2x mr-3"></i>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1">Easy Time Tracking</h5>
                                            <p>Log your hours with just a few clicks. Whether you're tracking daily tasks, project hours, or team activities, HoursManager makes it effortless.</p>
                                        </div>
                                    </li>
                                    <li class="col-md-6 col-12 purple-color-hover pointy trans-color-03 media mb-3">
                                        <i class="fas fa-chart-bar fa-2x mr-3"></i>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1">Detailed Reports</h5>
                                            <p>Generate comprehensive reports to get insights into your productivity. Analyze your time usage to make informed decisions.</p>
                                        </div>
                                    </li>
                                    <li class="col-md-6 col-12 purple-color-hover pointy trans-color-03 media mb-3">
                                        <i class="fas fa-sitemap fa-2x mr-3"></i>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1">Flexible Integrations</h5>
                                            <p>HoursManager integrates seamlessly with your favorite tools and platforms, ensuring a smooth workflow.</p>
                                        </div>
                                    </li>
                                    <li class="col-md-6 col-12 purple-color-hover pointy trans-color-03 media mb-3">
                                        <i class="fas fa-arrows-alt fa-2x mr-3"></i>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1">Customization</h5>
                                            <p>Tailor HoursManager to fit your unique needs. Customize settings, reports, and notifications to suit your preferences.</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6">
                            <h3>Join Us</h3>
                            <p>Join the growing community of users who trust HoursManager to keep their time management on track.</p>
                            <p>Whether you're a freelancer, a small business owner, or part of a large organization, HoursManager is here to help you achieve your goals.</p>
                        </div>
                        <div class="col col-sm-12 col-md-6">
                            <h3>Get In Touch</h3>
                            <p>We love hearing from our users! If you have any questions, feedback, or suggestions, feel free to contact us. Your input helps us improve and serve you better.</p>
                            <p>Thank you for choosing HoursManager. Together, let's make every hour count!</p>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 w-100">
                            <h3>Frequently Asked Questions</h3>
                            <div class="accordion" id="faq-accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="calculations-faq-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#calculations-faq-content" aria-expanded="false" aria-controls="calculations-faq-content">
                                            How will HoursManager round numbers to calculate my income?
                                        </button>
                                    </h2>
                                    <div id="calculations-faq-content" class="accordion-collapse collapse" aria-labelledby="calculations-faq-header" data-bs-parent="#faq-accordion">
                                        <div class="accordion-body">
                                            <p>Since we know employers may use different rounding criteria to pay, we'll let you choose the same rounding criteria your employer has so your calculations accomodate to your needs</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="rates-faq-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rates-faq-content" aria-expanded="false" aria-controls="rates-faq-content">
                                            Does HoursManager consider a different sort of rating system other than hourly rates?
                                        </button>
                                    </h2>
                                    <div id="rates-faq-content" class="accordion-collapse collapse" aria-labelledby="rates-faq-header" data-bs-parent="#faq-accordion">
                                        <div class="accordion-body">
                                            <p>It doesn't matter if you get paid per hour, per day, or even on a fixed salary. HoursManager lets you choose your rating system to accomodate to your needs.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="tips-faq-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tips-faq-content" aria-expanded="false" aria-controls="tips-faq-content">
                                            If I get tips in my job, will HoursManager consider them in its calculations?
                                        </button>
                                    </h2>
                                    <div id="tips-faq-content" class="accordion-collapse collapse" aria-labelledby="tips-faq-header" data-bs-parent="#faq-accordion">
                                        <div class="accordion-body">
                                            <p>HoursManager lets you add the tips you earned in the calculations or to ignored them. You just need to specify if you earn tips in your job.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="paychecks-faq-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#paychecks-faq-content" aria-expanded="false" aria-controls="paychecks-faq-content">
                                            If I get paid every two weeks, will HoursManager still calculate my weekly income?
                                        </button>
                                    </h2>
                                    <div id="paychecks-faq-content" class="accordion-collapse collapse" aria-labelledby="paychecks-faq-header" data-bs-parent="#faq-accordion">
                                        <div class="accordion-body">
                                            <p>HoursManager will automatically calculate your income based on how often you get paid, however you could manually change this frequency if you want</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="roles-faq-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#roles-faq-content" aria-expanded="false" aria-controls="roles-faq-content">
                                            If I work two positions for the same employers with different earnings, will HoursManager consider them as the same?
                                        </button>
                                    </h2>
                                    <div id="roles-faq-content" class="accordion-collapse collapse" aria-labelledby="roles-faq-header" data-bs-parent="#faq-accordion">
                                        <div class="accordion-body">
                                            <p>No, HoursManager lets you add multiple jobs/roles for the same employers.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="taxes-faq-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#taxes-faq-content" aria-expanded="false" aria-controls="taxes-faq-content">
                                            Will HoursManager calculate my income before taxes or after taxes?
                                        </button>
                                    </h2>
                                    <div id="taxes-faq-content" class="accordion-collapse collapse" aria-labelledby="taxes-faq-header" data-bs-parent="#faq-accordion">
                                        <div class="accordion-body">
                                            <p>HoursManager will calculate your income before taxes since we acknowledge calculating taxes may be a complicated process dependent on factors outside our scope of concern.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once "templates/main-footer.php"; ?>
<?php require_once "templates/footer.php"; ?>