<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Hidayah Bootstrap Template - Index</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= base_url() ?>assets/img/favicon.png" rel="icon">
  <link href="<?= base_url() ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Hidayah - v2.3.1
  * Template URL: https://bootstrapmade.com/hidayah-free-simple-html-template-for-corporate/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container-fluid">

      <div class="row justify-content-center">
        <div class="col-xl-10 d-flex align-items-center justify-content-end">

          <h1 class="logo mr-auto"><a href="<?= base_url() ?>">Remaja Id</a></h1>
          <!-- Uncomment below if you prefer to use an image logo -->
          <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

          <nav class="nav-menu d-none d-lg-block">
            <ul>
              <li class="active"><a href="<?= base_url() ?>">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#services">Services</a></li>
              <li><a href="#portfolio">Portfolio</a></li>
              <li><a href="#team">Team</a></li>
              <li><a href="#contact">Contact</a></li>
              <li><a href="<?= base_url('login') ?>">Login</a></li>

            </ul>
          </nav><!-- .nav-menu -->

        </div>
      </div>
    </div>
  </header><!-- End Header -->

  <?php if($aplikasi->slide > 0) { ?>
  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel">

      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

      <div class="carousel-inner" role="listbox">

        <?php $no = 0;
        foreach($slide as $data1): ?>
        <!-- Slide 1 -->
        <div class="carousel-item <?= $no == 0 ? 'active' : '' ?>" style="background-image: url(<?= base_url() ?>assets/image/slide/<?= $data1->image ?>)">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animated fadeInDown"><?= $data1->header ?></span></h2>
              <p class="animated fadeInUp">Ut velit est quam dolor ad a aliquid qui aliquid. Sequi ea ut et est quaerat sequi nihil ut aliquam. Occaecati alias dolorem mollitia ut. Similique ea voluptatem. Esse doloremque accusamus repellendus deleniti vel. Minus et tempore modi architecto.</p>
              <a href="#about" class="btn-get-started animated fadeInUp scrollto">Read More</a>
            </div>
          </div>
        </div>
    <?php $no++;
  endforeach; ?>

      </div>

      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon icofont-simple-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon icofont-simple-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>

    </div>
  </section><!-- End Hero -->
  <?php } ?>

  <main id="main">
    <?php if($aplikasi->about > 0) { ?>
    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container-fluid">
      <?php $about = $this->db->query("SELECT * FROM about WHERE id_about = 1")->row(); ?>
        <div class="row justify-content-center">
          <div style="background: url(<?= base_url('assets/image/'.$about->thumbnail) ?>)" class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch">
          <?= $about->youtube != null ? '<a href="'.$about->youtube.'" class="venobox play-btn mb-4" data-vbtype="video" data-autoplay="true"></a>' : '' ?>
            
          </div>

          <div class="col-xl-5 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
            <h3><?= $about->header ?></h3>
            <p><?= $about->text ?></p>

            <?php $list_about = $this->db->query("SELECT * FROM list_about WHERE status_delete = 0")->result();
            foreach($list_about as $val): ?>
            <div class="icon-box">
              <div class="icon"><i class="<?= $val->icon ?>"></i></div>
              <h4 class="title"><a href=""><?= $val->nama ?></a></h4>
              <p class="description"><?= $val->keterangan ?></p>
            </div>
    <?php endforeach; ?>

          </div>
        </div>

      </div>
    </section><!-- End About Section -->
    <?php } ?>
    
      <?php if($aplikasi->service > 0) { ?>
    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container-fluid">

        <div class="section-title">
          <h2>Services</h2>
          <h3>Check our <span>Services</span></h3>
          <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-xl-10">
            <div class="row">
            <?php $service = $this->db->query("SELECT * FROM service WHERE status_delete = 0")->result();
            foreach($service as $svc) : ?>
              <div class="col-lg-4 col-md-6 icon-box">
                <div class="icon"><i class="<?= $svc->icon ?>"></i></div>
                <h4 class="title"><a href=""><?= $svc->nama ?></a></h4>
                <p class="description"><?= $svc->keterangan ?></p>
              </div>
            <?php endforeach; ?>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Services Section -->
      <?php } ?>

        <?php if($aplikasi->portfolio > 0) { ?>
    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
      <div class="container-fluid">

        <div class="section-title">
          <h2>Portfolio</h2>
          <h3>Check our <span>Portfolio</span></h3>
          <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>
        </div>

        <div class="row">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">All</li>
              <?php $jenis_kegiatan = $this->db->query("SELECT * FROM jenis_kegiatan WHERE status_delete = 0")->result(); foreach($jenis_kegiatan as $row) : ?>
                <li data-filter=".<?= $row->nama ?>"><?= $row->nama ?></li>
              <?php endforeach; ?>
              <!-- <li data-filter=".card">Card</li>
              <li data-filter=".web">Web</li> -->
            </ul>
          </div>
        </div>

        <div class="row portfolio-container justify-content-center">

          <div class="col-xl-10">
            <div class="row">
            
            <?php $kegiatan = $this->db->query("SELECT a.*, b.nama as jenis_kegiatan FROM kegiatan a LEFT JOIN jenis_kegiatan b ON b.id=a.id_jenis_kegiatan WHERE a.status_delete = 0")->result(); foreach($kegiatan as $row) : ?>

              <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item <?= $row->jenis_kegiatan ?>">
                <div class="portfolio-wrap">
                  <img src="<?= base_url() ?>assets/image/kegiatan/<?= $row->image ?>" class="img-fluid" alt="">
                  <div class="portfolio-info">
                    <h4><?= $row->nama ?></h4>
                    <p><?= $row->jenis_kegiatan ?></p>
                    <div class="portfolio-links">
                      <a href="<?= base_url() ?>assets/image/kegiatan/<?= $row->image ?>" data-gall="portfolioGallery" class="venobox" title="App 1"><i class="bx bx-plus"></i></a>
                      <a href="<?= base_url() ?>Welcome/detail/<?= $row->id ?>" title="More Details"><i class="bx bx-link"></i></a>
                    </div>
                  </div>
                </div>
              </div><!-- End portfolio item -->
            <?php endforeach; ?>

            </div>
          </div>

        </div>

      </div>
    </section><!-- End Portfolio Section -->
        <?php } ?>

          <?php if ($aplikasi->team > 0) { ?>
    <!-- ======= Team Section ======= -->
    <section id="team" class="team">
      <div class="container-fluid">

        <div class="section-title">
          <h2>Team</h2>
          <h3>Our Hard Working <span>Team</span></h3>
          <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-xl-10">
            <div class="row">

              <?php $team = $this->db->query("SELECT * FROM team WHERE status_delete = 0")->result();
              foreach($team as $tm): ?>

              <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="member">
                  <img src="<?= base_url() ?>assets/image/team/<?= $tm->image ?>" class="img-fluid" alt="">
                  <div class="member-info">
                    <div class="member-info-content">
                      <h4><?= $tm->nama ?></h4>
                      <span><?= $tm->jabatan ?></span>
                    </div>
                  </div>
                </div>
              </div> <!-- End Member Item -->
            <?php endforeach; ?>


            </div>
          </div>
        </div>

      </div>
    </section><!-- End Team Section -->
          <?php } ?>
          <?php if($aplikasi->contact_us > 0) { ?>
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact section-bg">
      <div class="container-fluid">

        <div class="section-title">
          <h2>Contact</h2>
          <h3>Get In Touch With <span>Us</span></h3>
          <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-xl-10">
            <div class="row">

              <div class="col-lg-6">

                <div class="row justify-content-center">
                <?php $contact = $this->db->query("SELECT * FROM contact")->row(); ?>

                  <div class="col-md-6 info d-flex flex-column align-items-stretch">
                    <i class="bx bx-map"></i>
                    <h4>Address</h4>
                    <p><?= $contact->alamat ?></p>
                  </div>
                  <div class="col-md-6 info d-flex flex-column align-items-stretch">
                    <i class="bx bx-phone"></i>
                    <h4>Call Us</h4>
                    <p><?= $contact->no_telp ?></p>
                  </div>
                  <div class="col-md-6 info d-flex flex-column align-items-stretch">
                    <i class="bx bx-envelope"></i>
                    <h4>Email Us</h4>
                    <p><?= $contact->email ?></p>
                  </div>

                </div>

              </div>

              <div class="col-lg-6">
                <form action="<?= base_url() ?>Welcome/message" method="post" role="form" class="php-email-form">
                  <div class="form-row">
                    <div class="col-md-6 form-group">
                      <label for="name">Your Name</label>
                      <input type="text" name="name" class="form-control" id="name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                      <div class="validate"></div>
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="email">Your Email</label>
                      <input type="email" class="form-control" name="email" id="email" data-rule="email" data-msg="Please enter a valid email" />
                      <div class="validate"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" class="form-control" name="subject" id="subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                    <div class="validate"></div>
                  </div>
                  <div class="form-group">
                    <label for="message">Message</label>
                    <textarea class="form-control" name="message" rows="8" data-rule="required" data-msg="Please write something for us"></textarea>
                    <div class="validate"></div>
                  </div>
                  <div class="mb-3">
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your message has been sent. Thank you!</div>
                  </div>
                  <div class="text-center"><button type="submit">Send Message</button></div>
                </form>
              </div>

            </div>
          </div>
        </div>

      </div>
    </section><!-- End Contact Section -->
          <?php } ?>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><a href="https://aa43000.github.io/">Ahmad Zaeni Mubarok</a></strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?= base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="<?= base_url() ?>assets/vendor/php-email-form/validate.js"></script>
  <script src="<?= base_url() ?>assets/vendor/venobox/venobox.min.js"></script>
  <script src="<?= base_url() ?>assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="<?= base_url() ?>assets/vendor/counterup/counterup.min.js"></script>
  <script src="<?= base_url() ?>assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?= base_url() ?>assets/vendor/owl.carousel/owl.carousel.min.js"></script>

  <!-- Template Main JS File -->
  <script src="<?= base_url() ?>assets/js/main.js"></script>

</body>

</html>
