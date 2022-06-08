<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Remaja Id - Welcome</title>
        <link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="<?= base_url() ?>assets/css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="#page-top">Remaja Id</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#about">About</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#events">Events</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#contact">Contact</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="<?= base_url() ?>Login">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container d-flex h-100 align-items-center">
                <div class="mx-auto text-center">
                    <h1 class="mx-auto my-0 text-uppercase">REMAJA ID</h1>
                    <h2 class="text-white-50 mx-auto mt-2 mb-5">Adhitya Karya Mahatva Yodha, Yang Muda Yang Berkarya</h2>
                    <a class="btn btn-primary js-scroll-trigger" href="#about">Get Started</a>
                </div>
            </div>
        </header>
        <!-- About-->
        <section class="about-section text-center" id="about">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <h2 class="text-white mb-4">Adhitya Karya Mahatva Yodha</h2>
                        <p class="text-white-50">
                        Adhitya berarti cerdas dan penuh pengetahuan. Karya berarti pekerjaan, keterampilan atau karya. Mahatva berarti terhormat, berbudi luhur dan berkepribadian. Sementara Yodha berarti pejuang atau patriot. 
                        </p>
                    </div>
                </div>
                <img class="img-fluid" src="<?= base_url() ?>assets/img/ipad.png" alt="" />
            </div>
        </section>
        <!-- Projects-->
        <section class="projects-section bg-light" id="events">
            <?php $kegiatan = $this->db->query("SELECT * FROM kegiatan WHERE status_delete = 0 ORDER BY tanggal desc LIMIT 3")->result_array(); ?>
            <div class="container">
                <!-- Featured Project Row-->
                <div class="row align-items-center no-gutters mb-4 mb-lg-5">
                    <div class="col-xl-8 col-lg-7"><img class="img-fluid mb-3 mb-lg-0" src="<?= base_url() ?>assets/image/kegiatan/<?= $kegiatan[0]['image'] ?>" alt="" /></div>
                    <div class="col-xl-4 col-lg-5">
                        <div class="featured-text text-center text-lg-left">
                            <h4><?= $kegiatan[0]['nama'] ?></h4>
                            <p class="text-black-50 mb-0"><?= $kegiatan[0]['deskripsi'] ?></p>
                        </div>
                    </div>
                </div>
                <!-- Project One Row-->
                <div class="row justify-content-center no-gutters mb-5 mb-lg-0">
                    <div class="col-lg-6"><img class="img-fluid" src="<?= base_url() ?>assets/image/kegiatan/<?= $kegiatan[1]['image'] ?>" alt="" /></div>
                    <div class="col-lg-6">
                        <div class="bg-black text-center h-100 project">
                            <div class="d-flex h-100">
                                <div class="project-text w-100 my-auto text-center text-lg-left">
                                    <h4 class="text-white"><?= $kegiatan[1]['nama'] ?></h4>
                                    <p class="mb-0 text-white-50"><?= $kegiatan[1]['deskripsi'] ?></p>
                                    <hr class="d-none d-lg-block mb-0 ml-0" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Project Two Row-->
                <div class="row justify-content-center no-gutters">
                    <div class="col-lg-6"><img class="img-fluid" src="<?= base_url() ?>assets/image/kegiatan/<?= $kegiatan[2]['image'] ?>" alt="" /></div>
                    <div class="col-lg-6 order-lg-first">
                        <div class="bg-black text-center h-100 project">
                            <div class="d-flex h-100">
                                <div class="project-text w-100 my-auto text-center text-lg-right">
                                    <h4 class="text-white"><?= $kegiatan[2]['nama'] ?></h4>
                                    <p class="mb-0 text-white-50"><?= $kegiatan[2]['deskripsi'] ?></p>
                                    <hr class="d-none d-lg-block mb-0 mr-0" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container d-flex h-100 align-items-center" style="padding-top: 10rem">
                    <div class="mx-auto text-center">
                        <a class="btn btn-primary js-scroll-trigger" href="<?= base_url() ?>welcome/view_all/">View more</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="contact-section bg-black" id="contact">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card py-4 h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-map-marked-alt text-primary mb-2"></i>
                                <h4 class="text-uppercase m-0">Address</h4>
                                <hr class="my-4" />
                                <div class="small text-black-50"><span style="cursor: pointer" onclick="open_map()">Dukuh Plantungan Rt 27/08, Desa KrandonLor, Kecamatan Suruh</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card py-4 h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-envelope text-primary mb-2"></i>
                                <h4 class="text-uppercase m-0">Email</h4>
                                <hr class="my-4" />
                                <div class="small text-black-50"><span style="cursor: pointer" onclick="send_email()">ahmadzaenimubarok121@gmail.com</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card py-4 h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-mobile-alt text-primary mb-2"></i>
                                <h4 class="text-uppercase m-0">Phone</h4>
                                <hr class="my-4" />
                                <div class="small text-black-50"><span style="cursor: pointer" onclick="send_wa()">+62 813-2833-1831</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social d-flex justify-content-center">
                    <a class="mx-2" href="https://wa.me/+6281328331831"><i class="fab fa-whatsapp"></i></a>
                    <a class="mx-2" href="https://facebook.com/aa43000"><i class="fab fa-facebook-f"></i></a>
                    <a class="mx-2" href="https://github.com/aa43000"><i class="fab fa-github"></i></a>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="footer bg-black small text-center text-white-50"><div class="container">Copyright © <a href="https://aa43000.github.io">Ahmad Zaeni Mubarok</a> 2022</div></footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Core theme JS-->
        <script src="<?= base_url() ?>assets/js/scripts.js"></script>
    </body>
</html>
<script>
    function send_email() {
        window.open("https://mail.google.com/mail/?view=cm&fs=1&to=ahmadzaenimubarok121@gmail.com");
    }
    function send_email() {
        window.open("https://wa.me/+6281328331831");
    }
    function open_map() {
        window.open("https://goo.gl/maps/jj9Hqh7smzf1E4u16");
    }
</script>