
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Kas</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Kas</h6>
              <a href="<?= base_url() ?>Kas/detail" class="btn btn-primary btn-icon-split btn-sm ml-3">
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
                      <th width="20%">Kode</th>
                      <th width="20%">tanggal</th>
                      <th width="20%">jumlah</th>
                      <th width="20%">Operator</th>
                      <th width="10%">Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tr>
                    <th width="10%">No</th>
                      <th width="20%">Kode</th>
                      <th width="20%">tanggal</th>
                      <th width="20%">jumlah</th>
                      <th width="20%">Operator</th>
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
        <div class="table-responsive">
          <table class="table table-bordered" id="table2" width="100%" cellspacing="0">
            <thead>
                <tr>
                <th width="20%">No</th>
                <th width="40%">Anggota</th>
                <th width="40%">Jumlah</th>
                </tr>
            </thead>
            <tfoot>
            <tr>
                <th width="20%">No</th>
                <th width="40%">Anggota</th>
                <th width="40%">Jumlah</th>
                </tr>
            </tfoot>
            <tbody>
                
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        load_data();
    });
    function show_data(id) {
      $("#table2").DataTable({
            destroy: true,
            "processing" : true,
            "serverSide" : true,
            ajax :{
                url: "<?= base_url('Kas/load_detail/') ?>"+id
            },
            "columns" :[
                {"name" : "id"},
                {"name" : "nama"},
                {"name" : "jumlah"},
            ],
            "order" : [
                [0, 'asc']
            ],
            "iDisplayLength" : 10
        });
    }
    
    function load_data() {
        $("#table1").DataTable({
            destroy: true,
            "processing" : true,
            "serverSide" : true,
            ajax :{
                url: "<?= base_url('Kas/load_data') ?>"
            },
            "columns" :[
                {"name" : "id"},
                {"name" : "kode"},
                {"name" : "tanggal"},
                {"name" : "jumlah"},
                {"name" : "operator"},
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
        url: "<?= base_url('Kas/tambah') ?>",
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
      $("#keterangan").val("");
      $("#icon").val("");
    }

    function edit_data(id) {
        $.ajax({
            url: "<?= base_url('Kas/edit_data/') ?>"+id,
            dataType: 'json',
            type: 'post'
        }).done(function(data) {
            $("#formModal").modal('show');
            $("#nama").val(data.value.nama);
            $("#id").val(data.value.id);
            $("#keterangan").val(data.value.keterangan);
            $("#icon").val(data.value.icon);
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
            url: "<?= base_url('Kas/delete_data/') ?>"+id,
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