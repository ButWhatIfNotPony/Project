<?php

    // Initialize the session
    session_start();

    // Check if the user is logged in, otherwise redirect to login page
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }

    try {
    
        // Include db_conn file
        require_once "../admin/db_conn.php"; 
        // require_once "../forms/customer-details.php";

        // try {
        //     $forename = $surname = $email = $phonenumber = "";
    
        //     $sql = "SELECT forename, surname, email, phonenumber FROM users WHERE id=$_SESSION[id]";
    
        //     if ($stmt = $pdo->prepare($sql)) {
        //         while ($rows = $sql->fetch()) {
        //             $forname = $rows['forename'];
        //             $surname = $rows['surname'];
        //             $email = $rows['email'];
        //             $phonenumber = $rows['phonenumber'];
        //         }
    
        //         // Close statement
        //         unset($stmt);
        //     }
    
        //     unset($pdo);
        // } catch (PDOException $e) {
        //     echo "Error: " . $e->getMessage();
        // }

        // Define variables and initialize with empty values
        $forename = $surname = $email = $phonenumber = $date = $service = "";
        $forename_err = $surname_err = $email_err = $phonenumber_err = $date_err = $service_err = "";

        // Processing from data when form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Validate date
            if (empty(trim($_POST["date"]))) {
                $date_err = "Please select a date.";
            } elseif (strtotime(trim($_POST["date"])) < time()) {
                $date_err = "You can't book in the past.";
            } else {
                // Prepare a select statement
                $sql = "SELECT id FROM appointments WHERE date = :date";

                if ($stmt = $pdo->prepare($sql)) {
                    // Bind variables to prepared statement as parameters
                    $stmt->bindParam(":date", param_date, PDO::PARAM_STR);

                    // Set parameters
                    $param_date = trim($_POST["date"]);

                    // Attempt to execute prepared statement
                    if ($stmt->execute()) {
                        if ($stmt->rowCount() == 1) {
                            $date_err = "Sorry, that day is already fully booked, please select another.";
                        } else {
                            $date = trim($_POST["date"]);
                        }
                    } else {
                        echo "Oops! something went wrong!";
                    }

                    // Close statement
                    unset($stmt);

                }
            }

            // Validate service
            if (empty(trim($_POST["service"]))) {
                $service_err = "Please select a service.";
            } else {
                $service = trim($_POST["service"]);
            }

            // Validate forname
            if (empty(trim($_POST["forname"]))) {
                $forename_err = "Please enter your forename";
            } else {
                $forename = trim($_POST["forename"]);
            }

            // Validate surname
            if (empty(trim($_POST["surname"]))) {
                $surname_err = "Please enter your surname";
            } else {
                $surname = trim($_POST["surname"]);
            }

            // Validate email
            if (empty(trim($_POST["email"]))) {
                $email_err = "Please enter your email address";
            } else {
                $email = trim($_POST["email"]);
            }

            // Validate phone number
            if (empty(trim($_POST["phonenumber"]))) {
                $phonenumber_err = "Please enter your phone number";
            } else {
                $phonenumber = trim($_POST["phonenumber"]);
            }

            // Check input errors before inserting into database
            if (empty($date_err) && empty($service_err)) {
                // Prepare an insert statement
                $sql = "INSERT INTO appointments (forename, surname, email, phonenumber, app_date, app_details) VALUES (:forname, :surname, :email, :phonenumber, :app_date, :app_details)";

                if ($stmt = $pdo->prepare($sql)) {
                    // Bind parameters 
                    $stmt->bindParam(":forename", $param_forename, PDO::PARAM_STR);
                    $stmt->bindParam(":surname", $param_surname, PDO::PARAM_STR);
                    $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                    $stmt->bindParam(":phonenumber", $param_phonenumber, PDO::PARAM_STR);
                    $stmt->bindParam(":app_date", $param_date, PDO::PARAM_STR);
                    $stmt->bindParam(":app_details", $param_service, PDO::PARAM_STR);

                    // Set parameters
                    $param_forename = $forname;
                    $param_surname = $surname;
                    $param_email = $email;
                    $param_phonenumber = $phonenumber;
                    $param_date = $date;
                    $param_service = $service;

                    // Attempt to execute the prepared statement
                    if ($stmt->execute()) {
                        // Redirect to login page
                        header("location: index.php");
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
        echo "Error: " . $e->getMessage();
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="" name="description">
        <meta content="" name="keywords">

        <title>Customer Sign Up | Movement Optimised</title>

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
            <!-- Login Form Section -->
            <section class="signup">
                <div class="container">

                    <div class="section-title">
                        <h2>New Appointment</h2>
                        <p>Please fill in form below to make a new appointment.</p>
                    </div>
                    <div class="row">
                        <!-- Form Column -->
                        <div class="col-md-12 col-lg-6 align-items-stretch">
                            
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
                                    <div class="form-group">
                                    <label>Date of Appointment</label>
                                    <input type="date" name="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
                                    <span class="invalid-feedback"><?php echo $date_err; ?></span>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label>Choose a service</label>
                                    <?php

                                        echo $service;

                                        class TableRows extends RecursiveIteratorIterator {
                                            function __construct($it) {
                                                parent::__construct($it, self::LEAVES_ONLY);
                                            }

                                            function current() {
                                                return "<input type='radio' id='" . parent::current() . "' name='service' value='" . parent::current() . "'><label for='" . parent::current() . "'> ". parent::current() . "</label>";
                                            }

                                            function beginChildren() {
                                                echo "<br>";
                                            }

                                            function endChildren() {
                                                echo "<br>";
                                            }
                                        }

                                        $HOST = "localhost";
                                        $USER = "";
                                        $PASS = "";
                                        $DBNAME = "Project";

                                        try {
                                            $conn = new PDO("mysql:host=$HOST;dbname=$DBNAME", $USER, $PASS);
                                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            $stmt = $conn->prepare("SELECT s_name FROM services");
                                            $stmt->execute();

                                            // Set the resulting array to associative
                                            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                            foreach (new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                                                echo $v;
                                            }
                                        } catch (PDOException $e) {
                                            echo "Error: " . $e->getMessage();
                                        }

                                        unset($stmt);

                                        $conn = null;

                                    ?>
                                    <span class="invalid-feedback"><?php echo $service_err; ?></span>
                                </div>
                                <br>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                    <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                                </div>
                                </div>    
                            </form>
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

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi, bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        <script src="../assets/vendor/purecounter/purecounter.js"></script>
        <script src="../assets/vendor/aos/aos.js"></script>
        <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="../assets/vendor/waypoints/noframework.waypoints.js"></script>
        <script src="../assets/vendor/php-email-form/validate.js"></script>

        <!-- Template Main JS File -->
        <script src="../assets/js/main.js"></script>
    </body>
</html>
