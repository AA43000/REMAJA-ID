<link href="<?= base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Lupa Password</h1>
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Lupa Password</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table1" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Nomor Wa</th>
                      <th>Tanggal</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Nomor Wa</th>
                      <th>Tanggal</th>
                      <th>Status</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          
          </div>
    <!-- /.container-fluid -->
    
<script type="text/javascript">
    $(document).ready(function() {
        load_data();
    });

    function load_data() {
        $("#table1").DataTable({
            destroy: true,
            "processing" : true,
            "serverSide" : true,
            ajax :{
                url: "<?= base_url('Lupa_password/load_data') ?>"
            },
            "columns" :[
                {"name" : "id"},
                {"name" : "nama"},
                {"name" : "no_wa"},
                {"name" : "tanggal"},
                {"name" : "status_kirim"}
            ],
            "order" : [
                [4, 'asc']
            ],
            "iDisplayLength" : 10
        });
    }
    function kirim(id,sts) {
      $.ajax({
        url: "<?= base_url('Lupa_password/kirim') ?>",
        data: {
          id: id,
          sts: sts
        },
        dataType: 'json',
        type: 'post'
      }).done(function(data) {
        if(data.status == 200) {
            if(data.no_wa[0] == 0) {
                data.no_wa = "62"+data.no_wa.substring(1);
            }
            var txt = encodeURI("Password baru untuk akun Remaja id anda adalah: *"+data.password+"* Segera ganti password anda setelah login");
            window.open("https://wa.me/"+data.no_wa+"?text="+txt);
        } else {
          swal('Error', data.message, 'error');
        }
      });
    }
</script>