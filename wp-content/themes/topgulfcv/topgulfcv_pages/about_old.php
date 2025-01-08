<?php
$file_path = site_url() . '/wp-content/uploads/2023/10/';
get_header();
?>

<main id="primary" class="site-main">
    <!-- banner section start -->
    <!-- <section class="about-sec about-secinner">
        <div class="container c-container">
            <div class="banner-inner">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-12">
                        <div class="banner-left-sec" data-aos="fade-right">
                            <h2 class="section-title">
                                Find Your Job And <span>Make Sure Goal</span>
                            </h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus,luctus
                                nec ullamcorper mattis, pulvinar dapibus leo.Lorem ipsum dolor sit amet,
                                consectetur adipiscing elit. Ut elit tellus,luctus nec ullamcorper mattis,
                                pulvinar dapibus leo.</span> </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="banner-right-sec" data-aos="fade-left">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/about-img-1.png" alt="about-img" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- banner section end -->
    <section class="content-section">
        <div class="container c-container">
            <div class="row align-items-center flex-row-reverse">

                <div class="col-lg-6 col-md-6 col-12">
                    <div class="content-section-text about-content">
                        <h3 class="section-title">
                            Company
                            <span class="d-inline-block">Overview</span>
                            <p class="mt-2 mt-md-4">
                                TopGulfCV was founded in 2023. Its founding family has been intimately involved in the
                                GCC region since the 1960s, primarily in the UAE, Qatar, Kuwait, and the Kingdom of
                                Saudi Arabia. Our mission is to facilitate the job searching and career development, of
                                professionals, particularly university students and graduates in the early stages of
                                their careers.
                            </p>

                            <p class="mt-2 ">
                                We specialize in offering career development services to young professionals from across
                                the globe, who wish to be a part of the GCC expatriate workers community. We provide
                                professional consultations in our <a href="/paid-services/">Paid Services</a>, but also
                                offer <a href="/free-services/">Free Services</a>, so everyone who visits us leaves with
                                some guidance and benefit.
                            </p>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <!-- <div class="content-img">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/about-img-2.png" alt="about-img-2" class="img-fluid">
                    </div> -->
                    <div class="about_banner">
                        <div class="ratio ratio-16x9">
                            <video
                                src="/wp-content/uploads/2024/02/pexels-mikhail-nilov-8396975-1440p-COMPANY-OVERVIEW.mp4"
                                muted autoplay loop loading="lazy">
                                Your browser does not support the video tag
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="interJob">
        <div class="container c-container">
            <h3 class="section-title text-center">Why Choose <span class="d-inline-block">Us ?</span></h3>
            <div class="row">
                <div class="col-md-6 col-sm-12 col-12 mb-4 col-lg-3">
                    <div class="interinner">
                        <div class="daimond-bg"><i class="fas fa-pie-chart" aria-hidden="true"></i></div>
                        <h4 class="text-red">Specialization</h4>
                        <p>We specialize in the GCC job market with decades of experience in the region working with top
                            human capital, talent acquisition and recruitment professionals</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-12 mb-4 col-lg-3">
                    <div class="interinner">
                        <div class="daimond-bg"><i class="fas fa-building" aria-hidden="true"></i></div>
                        <h4 class="text-red">Market Experience</h4>
                        <p>In-depth experience with the HR, talent acquisition, recruitment, training and development
                            departments of over 10,000+ companies and organizations in the public and private sectors

                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-12 mb-4 col-lg-3">
                    <div class="interinner">
                        <div class="daimond-bg">
                            <i class="fa-sharp fa-solid fa-money-bill-1"></i>
                        </div>
                        <h4 class="text-red">Free Services</h4>
                        <p>We know more than anyone the financial burdens on job seekers, especially in these times, so
                            we offer a selection of free services that will help accelerate your job search or, for
                            those starting from scratch, help you launch it in the right direction!</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-12 mb-4 col-lg-3">
                    <div class="interinner">
                        <div class="daimond-bg"><i class="fas fa-user" aria-hidden="true"></i></div>
                        <h4 class="text-red">Paid Services</h4>
                        <p>A selection of consultation and professional services that are custom-tailored for our valued
                            clients to help them get an edge in the ever-competitive job market in the region</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- #main -->

<?php
get_footer();
?>