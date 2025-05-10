<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Society Management System</title>
    <?php include ('header.php'); ?>
</head>
<style>
/* About Us Section */
.about-us {
    background-color: #f8f9fa;
    padding: 50px 0;
}

.about-us .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.about-us h2 {
    font-size: 2rem;
    font-weight: bold;
    color: #c53030;
    margin-bottom: 20px;
}

.about-us .lead {
    font-size: 1.2rem;
    color: #555;
    margin-bottom: 30px;
}

/* Feature Box Styling */
.single-feature {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
    margin-bottom: 20px;
}

.single-feature:hover {
    transform: translateY(-5px);
}

.single-feature .icon {
    margin-bottom: 15px;
}

.single-feature h4 {
    font-size: 1.5rem;
    color: #c53030;
    margin-bottom: 10px;
}

.single-feature p {
    font-size: 1rem;
    color: #333;
}

/* Testimonials Section */
.testimonial {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
    margin-bottom: 20px;
}

.testimonial:hover {
    transform: translateY(-5px);
}

.testimonial .desc {
    margin-bottom: 15px;
}

.testimonial h3 {
    font-size: 1.3rem;
    color: #c53030;
}

.testimonial .lead {
    font-size: 1rem;
    color: #555;
}

.testi-meta {
    display: flex;
    align-items: center;
    margin-top: 15px;
}

.testi-meta img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
}

.testi-meta h4 {
    font-size: 1rem;
    color: #333;
}

/* Responsive Design */
@media (max-width: 768px) {
    .about-us .col-md-4, .about-us .col-md-12 {
        text-align: center;
    }
}

</style>

<body>
    <div class="about-us">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>About Our Society Management System</h2>
                    <p class="lead">Our system is designed to streamline society management, ensuring smooth operations, better communication, and effective management of resources.</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="single-feature">
                        <div class="icon"><img src="images/icon-01.png" class="img-responsive" alt=""></div>
                        <h4>Efficient Management</h4>
                        <p>Our system automates essential tasks like maintenance tracking, billing, and member communication.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="single-feature">
                        <div class="icon"><img src="images/icon-02.png" class="img-responsive" alt=""></div>
                        <h4>Enhanced Security</h4>
                        <p>Ensure resident safety with digital visitor logs, access control, and emergency alerts.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="single-feature">
                        <div class="icon"><img src="images/icon-03.png" class="img-responsive" alt=""></div>
                        <h4>Community Engagement</h4>
                        <p>Improve interactions among residents with discussion forums, event management, and announcements.</p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="section-title row text-center">
                <div class="col-md-8 col-md-offset-2">
                    <h3>What Our Residents Say</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="testi-carousel owl-carousel owl-theme">
                        <div class="testimonial clearfix">
                            <div class="desc">
                                <h3>Reliable & Secure</h3>
                                <p class="lead">This system has transformed the way we manage our society. Maintenance requests and payments are seamless.</p>
                            </div>
                            <div class="testi-meta">
                                <img src="images/testi_02.png" alt="" class="img-responsive alignleft">
                                <h4>Rahul Sharma <small>- Resident</small></h4>
                            </div>
                        </div>
                        <div class="testimonial clearfix">
                            <div class="desc">
                                <h3>Great Communication</h3>
                                <p class="lead">I love how easy it is to stay updated with society notices and events. A must-have for any residential community.</p>
                            </div>
                            <div class="testi-meta">
                                <img src="images/testi_03.png" alt="" class="img-responsive alignleft">
                                <h4>Priya Mehta <small>- Society Secretary</small></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/all.js"></script>
    <script src="js/custom.js"></script>

    <?php include ('footer.php'); ?>
</body>

</html>
