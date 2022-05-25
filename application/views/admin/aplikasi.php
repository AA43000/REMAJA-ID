<link href="<?= base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">User</h1>
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Aplikasi</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table1" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Aplikasi</th>
                      <th>Slide</th>
                      <th>About</th>
                      <th>Service</th>
                      <th>Portfolio</th>
                      <th>Team</th>
                      <th>Contact</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tr>
                    <th>No</th>
                      <th>Nama Aplikasi</th>
                      <th>Slide</th>
                      <th>About</th>
                      <th>Service</th>
                      <th>Portfolio</th>
                      <th>Team</th>
                      <th>Contact</th>
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
    
    <!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form tambah data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formAll">
            <input type="hidden" name="id" id="id" value="">

          <div class="form-group">
            <label for="nama">Nama Type</label>
            <input type="text" class="form-control" id="nama" name="nama" onkeydown="if(event.keyCode == 13 ) { save() }">
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="save()">Save changes</button>
      </div>
    </div>
  </div>
</div>

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
                url: "<?= base_url('aplikasi/load_data') ?>"
            },
            "columns" :[
                {"name" : "id_aplikasi"},
                {"name" : "nama_aplikasi"},
                {"name" : "slide"},
                {"name" : "about"},
                {"name" : "service"},
                {"name" : "portfolio"},
                {"name" : "team"},
                {"name" : "contact"},
            ],
            "order" : [
                [0, 'asc']
            ],
            "iDisplayLength" : 10
        });
    }

    function approve(id_aplikasi,sts,column) {
      $.ajax({
        url: "<?= base_url('Aplikasi/approve') ?>",
        data: {
          id_aplikasi: id_aplikasi,
          sts: sts,
          column:column
        },
        dataType: 'json',
        type: 'post'
      }).done(function(data) {
        if(data.status == 200) {
          swal({
            title: data.title,
            text: data.message,
            icon: "success",
            button: "oke"
          }).then((a)=>{
            load_data();
          });
        } else {
          swal('Error', data.message, 'error');
        }
      });
    }

    function save() {
      var nama = $("#nama").val();
      $.ajax({
        url: "<?= base_url('User_type/tambah') ?>",
        data: $("#formAll").serialize(),
        dataType: 'json',
        type: 'post'
      }).done(function(data) {
        if(data.status == 200) {
          swal({
            title: "Berhasil!",
            text: data.message,
            icon: "success",
            button: "oke",
          }).then((status)=>{
            $("#formModal").modal('hide');
            reset_form();
            load_data();
          });
        } else if(data.status == 202) {
          swal("Warning", data.message, "warning");
          $("#nama").val("");
        }
      }) 
    }

    function reset_form() {
    $("#id").val(0);
      $("#nama").val("");
    }

    function edit_data(id_user_type) {
        $.ajax({
            url: "<?= base_url('User_type/edit_data/') ?>"+id_user_type,
            dataType: 'json',
            type: 'post'
        }).done(function(data) {
            $("#formModal").modal('show');
            $("#nama").val(data.value.nama);
            $("#id").val(data.value.id);
        });
    }

    function delete_data(id_user_type){
      swal({
        title: "Anda yakin?",
        text: "Data yang telah dihapus tidak dapat dipulihkan!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?= base_url('User_type/delete_data/') ?>"+id_user_type,
            dataType: 'json',
            type: 'post'
          }).done(function(data) {
            if(data.status == 200) {
              swal({
                title: data.title,
                text: data.message,
                icon: 'success',
                button: 'oke'
              }).then((a)=>{
                load_data();
              });
            } else {
              swal('Error', data.message, 'error');
            }
          });
        } else {
          swal("Data Tidak jadi dihapus!");
        }
      });
    }
</script>