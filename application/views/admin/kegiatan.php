
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Kegiatan</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Kegiatan</h6>
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
                      <th width="10%">Jenis Kegiatan</th>
                      <th width="30%">Deskripsi</th>
                      <th width="20%">Foto</th>
                      <th width="10%">Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tr>
                    <th width="10%">No</th>
                      <th width="20%">Nama</th>
                      <th width="10%">Jenis Kegiatan</th>
                      <th width="30%">Deskripsi</th>
                      <th width="20%">Foto</th>
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
            <label for="id_jenis_kegiatan">Jenis Kegiatan</label>
            <select name="id_jenis_kegiatan" id="id_jenis_kegiatan" class="form-control" style="width: 100%"></select>
          </div>
          <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
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
        load_select_jenis();
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
                url: "<?= base_url('Kegiatan/load_data') ?>"
            },
            "columns" :[
                {"name" : "id"},
                {"name" : "nama"},
                {"name" : "jenis_kegiatan"},
                {"name" : "deskripsi"},
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
        url: "<?= base_url('Kegiatan/tambah') ?>",
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
      $("#deskripsi").val("");
      $("#id_jenis_kegiatan option").remove();
      $("#image").filestyle('clear');
      $("#image-view").addClass("d-none");
    }

    function edit_data(id) {
        $.ajax({
            url: "<?= base_url('Kegiatan/edit_data/') ?>"+id,
            dataType: 'json',
            type: 'post'
        }).done(function(data) {
            $("#formModal").modal('show');
            $("#nama").val(data.value.nama);
            $("#id").val(data.value.id);
            $("#deskripsi").val(data.value.deskripsi);
            $("#image-view").removeClass("d-none");
            $("#src").html(data.value.image);
            if(Number(data.value.id_jenis_kegiatan) > 0) {
                $("#id_jenis_kegiatan").append("<option value='"+data.value.id_jenis_kegiatan+"'>"+data.value.jenis_kegiatan+"</option>")
            }
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
            url: "<?= base_url('Kegiatan/delete_data/') ?>"+id,
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
    function load_select_jenis(){
        $('#id_jenis_kegiatan').select2({
            placeholder: 'Pilih Jenis Kegiatan',
            multiple: false,
            allowClear: true,
            ajax: {
                url: '<?php echo site_url("Kegiatan/get_select_jenis"); ?>',
                dataType: 'json',
                delay: 100,
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
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                }
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 0,
            templateResult: FormatResult,
            templateSelection: FormatSelection,
        });
    }
</script>