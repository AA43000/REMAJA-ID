
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Data Pinjaman</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Data Pinjaman</h6>
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
                      <th width="10%">Nama Peminjam</th>
                      <th width="10%">Unit</th>
                      <th width="10%">No HP</th>
                      <th width="10%">Jumlah</th>
                      <th width="10%">Tanggal</th>
                      <th width="20%">Keterangan</th>
                      <th width="10%">Status</th>
                      <th width="10%">Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tr>
                        <th width="10%">No</th>
                      <th width="10%">Nama Peminjam</th>
                      <th width="10%">Unit</th>
                      <th width="10%">No HP</th>
                      <th width="10%">Jumlah</th>
                      <th width="10%">Tanggal</th>
                      <th width="20%">Keterangan</th>
                      <th width="10%">Status</th>
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
            <label for="id_unit">Unit</label>
            <select name="id_unit" id="id_unit" class="form-control" style="width: 100%"></select>
          </div>

          <div class="form-group">
            <label for="nama">Nama Peminjam</label>
            <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam">
          </div>

          <div class="form-group">
            <label for="no_hp">No Hp</label>
            <input type="text" name="no_hp" id="no_hp" class="form-control">
          </div>

          <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control">
          </div>

          <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="text" name="jumlah" id="jumlah" class="form-control">
          </div>

          <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
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
        load_select_unit();
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
                url: "<?= base_url('Pinjaman/load_data') ?>"
            },
            "columns" :[
                {"name" : "id"},
                {"name" : "nama_peminjam"},
                {"name" : "nama"},
                {"name" : "no_hp"},
                {"name" : "jumlah"},
                {"name" : "tanggal"},
                {"name" : "keterangan"},
                {"name" : "status"},
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
        url: "<?= base_url('Pinjaman/tambah') ?>",
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
      $("#nama_peminjam").val("");
      $("#tanggal").val("");
      $("#no_hp").val("");
      $("#jumlah").val("");
      $("#keterangan").val("");
      $("#id_unit option").remove();
    }

    function edit_data(id) {
        $.ajax({
            url: "<?= base_url('Pinjaman/edit_data/') ?>"+id,
            dataType: 'json',
            type: 'post'
        }).done(function(data) {
            $("#formModal").modal('show');
            $("#nama_peminjam").val(data.value.nama_peminjam);
            $("#id").val(data.value.id);
            $("#keterangan").val(data.value.keterangan);
            $("#jumlah").val(data.value.jumlah);
            $("#tanggal").val(data.value.tanggal);
            $("#no_hp").val(data.value.no_hp);
            if(Number(data.value.id_unit) > 0) {
              $("#id_unit").append("<option value='"+data.value.id_unit+"'>"+data.value.nama+"</option>");
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
            url: "<?= base_url('Pinjaman/delete_data/') ?>"+id,
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
    function load_select_unit(){
        $('#id_unit').select2({
            placeholder: 'Pilih unit',
            multiple: false,
            allowClear: true,
            ajax: {
                url: '<?php echo site_url("Pinjaman/get_select_unit"); ?>',
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
    function update_sts(id) {
      $.ajax({
        url: "<?= base_url() ?>Pinjaman/update_sts/"+id,
        dataType: "json",
        success: function(data) {
          load_data();
        }
      })
    }
</script>