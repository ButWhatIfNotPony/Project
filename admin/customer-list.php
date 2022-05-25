<?php
    // Initialize the session
    session_start();

    // Check if user logged in as admin
    if ($_SESSION["id"] !== "1") {
        header("location: ../admin/index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="" name="description">
        <meta content="" name="keywords">

        <title>Admin Dashboard | Movement Optimised</title>

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
                        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
                        <p><a class="btn btn-danger" href="../login/logout.php">Logout</a></p>
                    </div>
                    <div class="row">
                        <?php
                            echo "<table class='table table-hover'>";
                            echo "<thead><tr><th scope='col'>ID</th><th scope='col'>Forename</th><th scope='col'>Surname</th><th scope='col'>Email Address</th><th scope='col'>Phone Number</th></tr></thead>";
                            echo "<tbody>";

                            class TableRows extends RecursiveIteratorIterator {
                                function __construct($it) {
                                    parent::__construct($it, self::LEAVES_ONLY);
                                }

                                function current() {
                                    return "<td scope='row'>" . parent::current() . "</td>";
                                }

                                function beginChildren() {
                                    echo "<tr>";
                                }

                                function endChildren() {
                                    echo "</tr>";
                                }
                            }

                            $HOST = "localhost";
                            $USER = "";
                            $PASS = "";
                            $DBNAME = "Project";

                            try {
                                $conn = new PDO("mysql:host=$HOST;dbname=$DBNAME", $USER, $PASS);
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stmt = $conn->prepare("SELECT id, forename, surname, email, phonenumber FROM users");
                                $stmt->execute();

                                // Set the resulting array to associative
                                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                foreach (new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                                    echo $v;
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }

                            $conn = null;
                            echo "</tbody>";
                            echo "</table>";
                        ?>
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
