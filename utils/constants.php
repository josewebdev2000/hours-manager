<?php
// Useful Constants to use throughout the application
define("NAME_REGEX", "/^[A-Za-z\s.,:;]+$/");
define("EMAIL_REGEX", "/^[\w.-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,}$/");
define("PASSWORD_REGEX", "/^(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{8,}$/");
define("PHONE_NUMBER_REGEX", "/^\+1\s*\(\s*\d{3}\s*\)\s*\d{3}\s*-\s*\d{4}$/");
define("NUMBER_REGEX", "/^\d*\.?\d+$/");
define("DAYS", ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"]);
define("RATES", ["hourly", "daily", "weekly", "biweekly", "monthly"]);
?>