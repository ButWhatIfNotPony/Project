<?php
    // Initialize the session
    session_start();

    // Check if the user is logged in, otherwise redirect to login page
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: ../login/login.php");
        exit;
    }

    try {
    
        // Include db_conn file
        require_once "../admin/db_conn.php";

        // Define variables and initialize with empty values
        $forename = $surname = $email = $phonenumber = $username = "";
        $forename_err = $surname_err = $email_err = $phonenumber_err = $username_err = "";

        // Processing from data when form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Validate forename
            if (empty(trim($_POST["forename"]))) {
                $forename_err = "Please enter your Forename.";
            } else {
                $forename = trim($_POST["forename"]);
            }

            // Validate surname
            if (empty(trim($_POST["surname"]))) {
                $surname_err = "Please enter your Surname.";
            } else {
                $surname = trim($_POST["surname"]);
            }

            // Validate email address
            if (empty(trim($_POST["email"]))) {
                $email_err = "Please enter your email address.";
            } /*elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', trim($_POST["email"]))) {
                $email_err = "Please enter a valid email address.";
            }*/ else {
                $email = trim($_POST["email"]);
            }

            // Validate phone number
            if (empty(trim($_POST["phonenumber"]))) {
                $phonenumber_err = "Please enter your phone number.";
            } elseif (strlen(trim($_POST["phonenumber"])) < 11 || strlen(trim($_POST["phonenumber"])) > 11) {
                $phonenumber_err = "Please enter a valid phone number.";
            } else {
                $phonenumber = trim($_POST["phonenumber"]);
            }

            // Validate username
            if (empty(trim($_POST["username"]))) {
                $username_err = "Please enter a username.";
            } elseif (!preg_match('/^[A-Za-z]\S*$/', trim($_POST["username"]))) {
                $username_err = "Username can only contain letters, numbers, and underscrores.";
            } elseif (strlen(trim($_POST["username"])) < 6 || strlen(trim($_POST["username"])) > 16) {
                $username_err = "Username must be between 6 and 16 characters long.";
            } else {
                // Prepare a select statement
                $sql = "SELECT id FROM users WHERE username = :username";

                if ($stmt = $pdo->prepare($sql)) {
                    // Bind variables to prepared statement as parameters
                    $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

                    // Set parameters
                    $param_username = trim($_POST["username"]);

                    // Attempt to execute the prepared statement
                    if ($stmt->execute()) {
                        if ($stmt->rowCount() == 1) {
                            $username_err = "This username is already taken.";
                        } else {
                            $username = trim($_POST["username"]);
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement
                    unset($stmt);
                }
            }

            // Check input errors before inserting into database
            if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($forename_err) && empty($surname_err) && empty($email_err) && empty($phonenumber_err)) {
                // Prepare an insert statement
                $idd = $_SESSION["id"];
                $sql = "UPDATE users SET forename=:forename, surname=:surname, email=:email, phonenumber=:phonenumber, username=:username WHERE id=$idd";

                if ($stmt = $pdo->prepare($sql)) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":forename", $param_forename, PDO::PARAM_STR);
                    $stmt->bindParam(":surname", $param_surname, PDO::PARAM_STR);
                    $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                    $stmt->bindParam(":phonenumber", $param_phonenumber, PDO::PARAM_STR);
                    $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

                    // Set parameters
                    $param_forename = $forename;
                    $param_surname = $surname;
                    $param_email = $email;
                    $param_phonenumber = $phonenumber;
                    $param_username = $username;

                    // Attempt to execute the prepared statement
                    if ($stmt->execute()) {
                        // Redirect to login page
                        header("location: ../login/logout.php");
                    } else {
                        echo "Oops! Something went wrong. Please try again.";
                    }

                    // Close statement
                    unset($stmt);
                }
            }

            // Close connection
            unset($pdo);
        }
    } catch (PDOException $e) {
        die("ERROR: Could not connect. " . $e->getMessage());
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="" name="description">
        <meta content="" name="keywords">

        <title>Customer Dashboard | Movement Optimised</title>

        <!-- Favicon -->
        <link href="../assets/img/favicon.png" rel="icon">

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
        <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
        <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
        <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="../assets/css/main.css" rel="stylesheet">
    </head>
    <body>
        <!-- === Header === -->
        <header id="header" class="fixed-top d-flex align-items-center">
            <div class="container d-flex justify-content-between align-items-center">

                <div class="logo">
                    <h1 class="text-light"><a href="../index.html"><span>Movement Optimised</span></a></h1>
                    <!-- Uncomment below if you prefer to use an image logo -->
                    <!-- <a href="../index.html"><img src="../assets/img/logo.png" alt="" class="img-fluid"></a> -->
                </div>

                <nav id="navbar" class="navbar">
                    <ul>
                        <li><a href="../index.html">Home</a></li>
                        <li><a href="../about.html">About</a></li>
                        <li class="dropdown"><a href="#"><span>Services</span> <i class="bi bi-chevron-down"></i></a>
                            <ul>
                                <li><a href="#">Sports Massages</a></li>
                                <li><a href="#">Cupping</a></li>
                                <li><a href="#">K Tape</a></li>
                                <li><a href="#">Movement Mapping</a></li>
                            </ul>
                        </li>
                        <li><a href="../blog.html">Blog</a></li>
                        <li><a href="../contact.html">Contact Us</a></li>
                        <li><a href="../login/login.php">Login</a></li>
                        <li><a href="../login/signup.php">Sign Up</a></li>
                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav>
            </div>
        </header>

        <main id="main">
            <!-- Customer Details -->
            <section class="about" data-aos="fade-up">
                <div class="container">

                    <div class="section-title">
                        <h2>Update Your Details</h2>
                        <p><a class="btn btn-danger" href="../login/logout.php">Logout</a></p>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-3 align-items-stretch">
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                <div class="form-group">
                                    <label>Forename</label>
                                    <input type="text" name="forename" class="form-control <?php echo (!empty($forename_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $forename; ?>">
                                    <span class="invalid-feedback"><?php echo $forename_err; ?></span>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label>Surname</label>
                                    <input type="text" name="surname" class="form-control <?php echo (!empty($surname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $surname; ?>">
                                    <span class="invalid-feedback"><?php echo $surname_err; ?></span>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" name="phonenumber" class="form-control <?php echo (!empty($phonenumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phonenumber; ?>">
                                    <span class="invalid-feedback"><?php echo $phonenumber_err; ?></span>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                                </div>
                                <br>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                    <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                                </div>
                            </form>
                        </div>
                        <!-- Credential Rules Column -->
                        <div class="col-md-12 col-lg-6 align-items-stretch">
                            <h6>Username:</h6>
                            <ul style="list-style: none;">
                                <li><i class="bi bi-check2-circle"></i> Must contain only letters, numbers, and underscrores.</li>
                                <li><i class="bi bi-check2-circle"></i> Must be between 6 and 16 characters long.</li>
                            </ul>
                            <h6>Password:</h6>
                            <ul style="list-style: none;">
                                <li><i class="bi bi-check2-circle"></i> Must be at least 6 characters long.</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </section>
        </main>

        <!-- === Footer === -->
        <footer id="footer" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
            <div class="footer-newsletter">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4>Our Newsletter</h4>
                            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sint, molestias nemo quo eveniet saepe ea excepturi perferendis iusto facere, iste voluptatibus libero animi esse sapiente deleniti voluptatum accusamus nisi eligendi.</p>
                        </div>
                        <div class="col-lg-6">
                            <form action="" method="post">
                                <input type="email" name="email"><input type="submit" value="Subscribe">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-top">
                <div class="container">
                    <div class="row">
                    
                        <div class="col-lg-3 col-md-6 footer-links">
                            <h4>Useful Links</h4>
                            <ul>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-6 footer-links">
                            <h4>Our Services</h4>
                            <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-6 footer-contact">
                            <h4>Contact Us</h4>
                            <p>
                                74 Asfordby Rd <br>
                                ALCONBURY WESTON, PE17 0SA<br>
                                United Kingdom <br><br>
                                <strong>Phone:</strong> 070 0173 9665<br>
                                <strong>Email:</strong> p1g2twjv25@temporary-mail.net<br>
                            </p>
                        </div>

                        <div class="col-lg-3 col-md-6 footer-info">
                            <h3>About Movement Optimised</h3>
                            <p>Cras fermentum odio eu feugiat lide par naso tierra. Justo eget nada terra videa magna derita valies darta donna mare fermentum iaculis eu non diam phasellus.</p>
                            <div class="social-links mt-3">
                                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </footer>

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        <script src="../assets/vendor/purecounter/purecounter.js"></script>
        <script src="../assets/vendor/aos/aos.js"></script>
        <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="../assets/vendor/isotope-layout/isotope-pkgd.min.js"></script>
        <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="../assets/vendor/waypoints/noframework.waypoints.js"></script>
        <script src="../assets/vendor/php-email-form/validate.js"></script>

        <!-- Main JS File(s) -->
        <script src="../assets/js/main.js"></script>
    </body>
</html>