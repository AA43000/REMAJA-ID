
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Team</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Team</h6>
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
                      <th width="10%">No</th>
                      <th width="20%">Nama</th>
                      <th width="10%">Jabatan</th>
                      <!-- <th width="20%">Sosmed</th> -->
                      <th width="30%">Foto</th>
                      <th width="10%">Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tr>
                    <th width="10%">No</th>
                      <th width="20%">Nama</th>
                      <th width="10%">Jabatan</th>
                      <!-- <th width="20%">Sosmed</th> -->
                      <th width="30%">Foto</th>
                      <th width="10%">Action</th>
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
            <label for="header">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama">
          </div>

          <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan Jabatan">
          </div>

          <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image">
          </div>

          <div id="image-view" class="d-none">
            <span>ubah image</span>
            <div id="src">
            
            </div>
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
        $("#image").filestyle({
          btnClass : 'btn-outline-primary',
          text: 'Pilih Image'
        });
        $('#formModal').on('hidden.bs.modal', function (e) {
            reset_form();
        });
    });
    
    function load_data() {
        $("#table1").DataTable({
            destroy: true,
            "processing" : true,
            "serverSide" : true,
            ajax :{
                url: "<?= base_url('Team/load_data') ?>"
            },
            "columns" :[
                {"name" : "id_team"},
                {"name" : "nama"},
                {"name" : "jabatan"},
                {"name" : "image"},
                {"name" : "action", "orderable": false, "searchlable": false, "className": "text-center"}
            ],
            "order" : [
                [0, 'asc']
            ],
            "iDisplayLength" : 10
        });
    }

    function save() {
      var formData = new FormData($("#formAll")[0]);
      $.ajax({
        url: "<?= base_url('Team/tambah') ?>",
        data: formData,
        contentType: false,
        processData: false,
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
        }
      }) 
    }

    function reset_form() {
      $("#id").val(0);
      $("#nama").val("");
      $("#jabatan").val("");
      $("#image").filestyle('clear');
      $("#image-view").addClass("d-none");
    }

    function edit_data(id) {
        $.ajax({
            url: "<?= base_url('Team/edit_data/') ?>"+id,
            dataType: 'json',
            type: 'post'
        }).done(function(data) {
            $("#formModal").modal('show');
            $("#nama").val(data.value.nama);
            $("#id").val(data.value.id);
            $("#jabatan").val(data.value.jabatan);
            $("#image-view").removeClass("d-none");
            $("#src").html(data.value.image);
        });
    }

    function delete_data(id){
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
            url: "<?= base_url('Team/delete_data/') ?>"+id,
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