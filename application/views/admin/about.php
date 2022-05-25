
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">About</h1>

              <!-- DataTales Example -->
              <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
              <h6 class="m-0 font-weight-bold text-primary">Tabel konten</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table2" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="20%"><a href="#" class="btn btn-success" data-toggle="modal" data-target="#modalAbout" onclick="update(1)"><i class="fa fa-edit"></i></a> Header</th>
                      <th width="30%"><a href="#" class="btn btn-success" data-toggle="modal" data-target="#modalAbout" onclick="update(2)"><i class="fa fa-edit"></i></a> Text</th>
                      <th width="20%"><a href="#" class="btn btn-success" data-toggle="modal" data-target="#modalAbout"  onclick="update(3)"><i class="fa fa-edit"></i></a> Thumbnil</th>
                      <th width="5%"><a href="#" class="btn btn-success" data-toggle="modal" data-target="#modalAbout" onclick="update(4)"><i class="fa fa-edit"></i></a> Youtube</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                      <th width="20%">Header</th>
                      <th width="30%">Text</th>
                      <th width="20%">Thumbnil</th>
                      <th width="5%">Youtube</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
              <h6 class="m-0 font-weight-bold text-primary">Tabel list</h6>
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
                      <th width="30%">Keterangan</th>
                      <th width="20%">Icon</th>
                      <th width="10%">Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tr>
                      <th width="10%">No</th>
                      <th width="20%">Nama</th>
                      <th width="30%">Keterangan</th>
                      <th width="20%">Icon</th>
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
            <input type="text" class="form-control" id="nama" name="nama">
          </div>

          <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="5"></textarea>
          </div>

          <div class="form-group">
            <label for="icon">Icon</label>
            <input type="text" name="icon" id="icon" class="form-control"><br>
            <small>*anda bisa mengunjungi <a href="https://boxicons.com/cheatsheet/">https://boxicons.com/cheatsheet/</a> untuk mendapatkan lebih banyak icon</small>
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

<div class="modal fade" id="modalAbout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Edit data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formedit">

          <div id="hdr" class="d-none">
            <div class="form-group">
              <label for="header">Header</label>
              <input type="text" class="form-control" id="header" name="header">
            </div>
          </div>

          <div id="txt" class="d-none">
            <div class="form-group">
              <label for="text">Text</label>
              <textarea name="text" id="text" class="form-control" cols="30" rows="5"></textarea>
            </div>
          </div>

          <div id="yt" class="d-none">
            <div class="form-group">
              <label for="youtube">Youtube</label>
              <input type="text" class="form-control" id="youtube" name="youtube">
            </div>
          </div>

          <div id="img" class="d-none">
            <div class="form-group">
              <label for="image">Thumbnail</label>
              <input type="file" name="image" id="image">
            </div>

            <div id="image-view">
              <span>ubah image</span>
              <div id="src">
              
              </div>
            </div>
          </div>


        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="update_about()">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        load_data();
        load_data_utama();
        load_about();
        $("#image").filestyle({
          btnClass : 'btn-outline-primary',
          text: 'Pilih Image'
        });
    });
    
    function load_data() {
        $("#table1").DataTable({
            destroy: true,
            "processing" : true,
            "serverSide" : true,
            ajax :{
                url: "<?= base_url('About/load_data') ?>"
            },
            "columns" :[
                {"name" : "id_list_about"},
                {"name" : "nama"},
                {"name" : "keterangan"},
                {"name" : "icon"},
                {"name" : "action", "orderable": false, "searchlable": false, "className": "text-center"}
            ],
            "order" : [
                [0, 'asc']
            ],
            "iDisplayLength" : 10
        });
    }

    function load_about() {
      $.ajax({
        url: "<?= base_url('About/load_about') ?>",
        dataType: 'json',
        type: 'get',
      }).done(function(data) {
        $("#header").val(data.header);
        $("#text").val(data.text);
        $("#youtube").val(data.youtube);
        $("#src").html(data.thumbnail);
      });
    }

    function load_data_utama() {
        $("#table2").DataTable({
            destroy: true,
            "processing" : true,
            "serverSide" : true,
            ajax : {
                url: "<?= base_url('About/load_data_utama') ?>"
            },
            "columns" :[
                {"name" : "header"},
                {"name" : "text"},
                {"name" : "thumbnail"},
                {"name" : "link_youtube"},
            ],
            "order" : [
                [0, 'asc']
            ],
            "iDisplayLength" : 10
        });
    }

    function update(field) {
      if(field == 1) {
        $("#hdr").removeClass('d-none');
        $("#txt").addClass('d-none');
        $("#img").addClass('d-none');
        $("#yt").addClass('d-none');
      } else if (field == 2) {
        $("#hdr").addClass('d-none');
        $("#txt").removeClass('d-none');
        $("#img").addClass('d-none');
        $("#yt").addClass('d-none');
      } else if (field == 3) {
        $("#hdr").addClass('d-none');
        $("#txt").addClass('d-none');
        $("#img").removeClass('d-none');
        $("#yt").addClass('d-none');
      } else if (field == 4) {
        $("#hdr").addClass('d-none');
        $("#txt").addClass('d-none');
        $("#img").addClass('d-none');
        $("#yt").removeClass('d-none');
      }
    }

    function update_about() {
      var formData = new FormData($("#formedit")[0]);
      $.ajax({
        url: "<?= base_url('About/update') ?>",
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
            $("#modalAbout").modal('hide');
            load_data_utama();
            load_about();
          });
        } else if(data.status == 202) {
          swal("Warning", data.message, "warning");
        }
      }) 
    }

    function save() {
      var formData = new FormData($("#formAll")[0]);
      $.ajax({
        url: "<?= base_url('About/tambah') ?>",
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

    function edit_data(id_list_about) {
        $.ajax({
            url: "<?= base_url('About/edit_data/') ?>"+id_list_about,
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

    function delete_data(id_list_about){
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
            url: "<?= base_url('About/delete_data/') ?>"+id_list_about,
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