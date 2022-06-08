<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Remaja Id - Events</title>
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
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="<?= base_url() ?>">Remaja Id</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
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
                </div>
            </div>
        </header>
        <!-- Projects-->
        <section class="projects-section bg-light" id="events">
            <?php $kegiatan = $this->db->query("SELECT * FROM kegiatan WHERE status_delete = 0 ORDER BY tanggal desc")->result(); ?>
            <div class="container">
                <h1 class="text-center">Events</h1>
                <div class="row">
                    <?php foreach($kegiatan as $row): ?>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-dark text-white">
                            <img class="card-img" src="<?= base_url() ?>assets/image/kegiatan/<?= $row->image ?>" alt="Card image">
                            <div class="card-img-overlay" style="padding: 0">
                                <div class="bg-black text-center h-100 project" style="opacity: 0.6">
                                    <div class="d-flex h-100">
                                        <div class="project-text w-100 my-auto text-center text-lg-left">
                                            <h4 class="text-white"><?= $row->nama ?></h4>
                                            <p class="mb-0 text-white-50"><?= $row->deskripsi ?></p>
                                            <hr class="d-none d-lg-block mb-0 ml-0" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

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