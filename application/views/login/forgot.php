<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Forgot Password</title>

  <!-- Custom fonts for this template-->
  <link href="<?= base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block">
              <img src="<?= base_url('assets/image/login/bg-forgot.jpg') ?>" width="100%">
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                    <p class="mb-4">Kami akan mengirimkan pasword baru untukmu lewat wa!</p>
                  </div>
                  <form class="user">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="no_wa" placeholder="Masukkan No wa">
                    </div>
                    <span class="btn btn-primary btn-user btn-block" onclick="action()">Reset Password</span>
                    <!-- <button type="button" class="btn btn-primary btn-user btn-block" onclick="action()">Reset Password</button> -->
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="<?= base_url('login/register') ?>">Create an Account!</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="<?= base_url('login') ?>">Already have an account? Login!</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="<?= base_url() ?>">Back</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>
  <script src="<?= base_url('assets/') ?>js/sweetalert.min.js"></script>

  <script>
    function action() {
      var no_wa = $("#no_wa").val();
      $.ajax({
        url: "<?= base_url() ?>Login/lupa_password",
        data: {no_wa, no_wa},
        dataType: "json",
        type: "post",
        success: function(data) {
          if(data.status == 200) {
            swal({
              title: "Berhasil!",
              text: "Password baru akan dikirim ke wa anda,segera ganti password anda!!",
              icon: "success",
              button: "oke",
            }).then((status)=>{
              window.location.href = "<?= base_url() ?>";
            });
          } else {
            swal("Warning", data.message, "warning");
          }
        }
      })
    }
  </script>

</body>

</html>
