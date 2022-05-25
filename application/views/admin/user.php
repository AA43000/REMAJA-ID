<link href="<?= base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">User</h1>
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
              <h6 class="m-0 font-weight-bold text-primary">Tabel User</h6>
              <a href="#" class="btn btn-primary btn-icon-split btn-sm ml-3" data-toggle="modal" data-target="#formModal">
                <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                <span class="text">Tambah data</span>
              </a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table1" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Username</th>
                      <th>Nomor Wa</th>
                      <th>User Type</th>
                      <th>Status Approve</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Username</th>
                      <th>Nomor Wa</th>
                      <th>User Type</th>
                      <th>Status Approve</th>
                      <th>Aksi</th>
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
        <form id="formDaftar" mthod="post">
          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama">
          </div>

          <div class="form-group">
            <label for="nomor_wa">Nomor Wa</label>
            <input type="text" class="form-control" id="nomor_wa" name="nomor_wa">
          </div>
          
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username">
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>

          <div class="form-group">
            <label for="user_type">Usert type</label><br>
            <select name="user_type" id="user_type" class="form-group"></select>
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
        load_user_type();
    });

    function load_user_type() {
      $('#user_type').select2({
	      placeholder: 'Pilih User Type',
	      multiple: false,
	      allowClear: true,
        width: '100%',
	      ajax: {
	        url: "<?php echo base_url('User/load_user_type') ?>",
	        dataType: 'json',
	        delay: 600,
	        cache: true,
	        data: function (params) {
	          return {
	            q: params.term, // search term
	            page: params.page
	          };
	        },
	        processResults: function (data, params) {
	          params.page = params.page || 1;

	          return {
	            results: data.user_type,
	            pagination: {
	              more: (params.page * 30) < data.count_filtered
	            }
	          };
	        }
	      }
	    });
    }

    function load_data() {
        $("#table1").DataTable({
            destroy: true,
            "processing" : true,
            "serverSide" : true,
            ajax :{
                url: "<?= base_url('User/load_data') ?>"
            },
            "columns" :[
                {"name" : "id_user"},
                {"name" : "nama"},
                {"name" : "username"},
                {"name" : "nomor_wa"},
                {"name" : "user_type"},
                {"name" : "status_approve"},
                {"name" : "action", "orderable": false, "searchlable": false, "className": "text-center"}
            ],
            "order" : [
                [5, 'asc']
            ],
            "iDisplayLength" : 10
        });
    }

    function save() {
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
            $("#formModal").modal('hide');
            reset_form();
            load_data();
          });
        } else if(data.status == 202) {
          swal("Warning", "Nomor "+nomor_wa+" telah digunakan, silahkan masukkan nomor lain", "warning");
        } else if(data.status == 201) {
          swal("Warning", "Username "+username+" telah digunakan, silahkan masukkan username lain", "warning");
        }
      }) 
    }

    function reset_form() {
      $("#nama").val("");
      $("#nomor_wa").val("");
      $("#username").val("");
      $("#password").val("");
      $("#user_type").val(0).trigger("change");
    }

    function approve(id_user,sts) {
      $.ajax({
        url: "<?= base_url('User/approve') ?>",
        data: {
          id_user: id_user,
          sts: sts
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

    function delete_data(id_user){
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
            url: "<?= base_url('User/delete_data/') ?>"+id_user,
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