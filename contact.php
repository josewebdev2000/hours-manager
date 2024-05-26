<?php require_once "templates/header.php"; ?>
<?php require_once "templates/main-header.php"; ?>

<main>
    <section class="banner">
        <img src="<?=$websiteUrl?>assets/img/contact_computer.jpg" alt="Contact Computer Banner">
    </section>
    <section class="d-flex container-fluid justify-content-center align-items-center w-100 p-5">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-1">
            </div>
            <div class="col-12 col-sm-12 col-md-11">
                <div class="mb-5">
                    <h2 class="fsize-200-e dark-purple-color">Contact</h2>
                    <p>We are here to assist you with any questions or concerns you may have about HoursManager.</p>
                    <p>Whether you need help with your account, have a question about our services, or want to provide feedback, we're just a message away.</p>
                </div>
                <form id="contact-form" enctype="multipart/form-data" novalidate>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10 input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10 input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="subject" class="col-sm-2 col-form-label">Subject</label>
                        <div class="col-sm-10 input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-marker"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter subject of your message">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="message" class="col-sm-2 col-form-label">Message</label>
                        <div class="col-sm-10 input-group">
                            <textarea class="summernote form-control" name="message" id="message" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col" id="form-alerts-container"></div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <button class="btn btn-purple btn-block btn-lg text-white">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php require_once "templates/main-footer.php"; ?>
<?php require_once "templates/footer.php"; ?>