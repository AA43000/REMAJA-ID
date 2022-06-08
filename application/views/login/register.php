<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Register</title>

  <!-- Custom fonts for this template-->
  <link href="<?= base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block">
          <img src="<?= base_url('assets/image/login/bg-register.jpg') ?>" width="100%">
          </div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Buat Akun!</h1>
              </div>
              <form class="user" method="post" id="formDaftar">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="nama" name="nama" placeholder="Nama" required="" >
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="nomor_wa" name="nomor_wa" placeholder="Nomor Whatsapp" required="">
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" required="">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required="">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id="repeat_password" name="repeat_password" onkeyup="repeat(this.value)" placeholder="Ulangi Password" required="">
                    <div class="d-none" id="nb">
                        <small class="text-danger text-sm">*Password belum sama</small>
                    </div>
                    <input type="hidden" name="sts_repeat" id="sts_repeat" value="0">
                    <input type="hidden" name="user_type" value="4">
                  </div>
                </div>
                <!-- <span class="btn btn-primary btn-user btn-block" onclick="show()"> Daftar Akun</span> -->
                <button type="button" class="btn btn-primary btn-user btn-block" onclick="simpan()" id="btn" disabled=""> Daftar Akun</button>
                <!-- <hr>
                <a href="index.html" class="btn btn-google btn-user btn-block">
                  <i class="fab fa-google fa-fw"></i> Register with Google
                </a>
                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                  <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                </a> -->
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="<?= base_url('login/forgot') ?>">Forgot Password?</a>
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

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>
  <script src="<?= base_url('assets/') ?>js/sweetalert.min.js"></script>
  <script>
    function repeat(repeat) {
        var pass = $("#password").val();
        if (pass == repeat) {
            $("#password").removeClass('border-danger');
            $("#repeat_password").removeClass('border-danger');
            $("#password").addClass('border-success');
            $("#repeat_password").addClass('border-success');
            $("#sts_repeat").val('1');
            $("#nb").addClass('d-none');
            $("#btn").prop("disabled", false);
        } else {
            $("#password").addClass('border-danger');
            $("#repeat_password").addClass('border-danger');
            $("#sts_repeat").val('0');
            $("#nb").removeClass('d-none');
            $("#btn").prop("disabled", true);
        }
    }

    function simpan() {
      var nomor_wa = $("#nomor_wa").val();
      var username = $("#username").val();
      $.ajax({
        url: "<?= base_url('login/daftar') ?>",
        data: $("#formDaftar").serialize(),
        dataType: 'json',
        type: 'post'
      }).done(function(data) {
        if(data.status == 200) {
          swal({
            title: "Berhasil!",
            text: "Anda telah berhasil mendaftar! silahkan tunggu konfirmasi dari admin",
            icon: "success",
            button: "oke",
          }).then((status)=>{
            window.location.href= "<?= base_url('login') ?>";
          });
        } else if(data.status == 202) {
          swal("Warning", "Nomor "+nomor_wa+" telah digunakan, silahkan masukkan nomor lain", "warning");
        } else if(data.status == 201) {
          swal("Warning", "Username "+username+" telah digunakan, silahkan masukkan username lain", "warning");
        }
      }) 
    }
  </script>

</body>

</html>
