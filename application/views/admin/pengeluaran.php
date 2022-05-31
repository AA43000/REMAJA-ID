
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Master Pengeluaran</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Master Pengeluaran</h6>
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
                      <th width="10%">Kode</th>
                      <th width="20%">Jenis</th>
                      <th width="20%">tanggal</th>
                      <th width="20%">jumlah</th>
                      <th width="10%">Operator</th>
                      <th width="10%">Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tr>
                    <th width="10%">No</th>
                      <th width="10%">Kode</th>
                      <th width="20%">Jenis</th>
                      <th width="20%">tanggal</th>
                      <th width="20%">jumlah</th>
                      <th width="10%">Operator</th>
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
            <label for="tanggal">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date("Y-m-d") ?>">
          </div>
          <div class="form-group">
            <label for="idm_pengeluaran">Jenis</label><br>
            <select name="idm_pengeluaran" id="idm_pengeluaran" class="form-control" style="width: 100%"></select>
          </div>
          <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="text" class="form-control" id="jumlah" name="jumlah">
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
        $('#formModal').on('hidden.bs.modal', function (e) {
            reset_form();
        });
        /* Tanpa Rupiah */
        var jumlah = document.getElementById('jumlah');
        jumlah.addEventListener('keyup', function(e)
        {
            jumlah.value = formatrupiah(this.value);
        });
    });
    /* Fungsi */
    function formatrupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
    
    function load_data() {
        $("#table1").DataTable({
            destroy: true,
            "processing" : true,
            "serverSide" : true,
            ajax :{
                url: "<?= base_url('Pengeluaran/load_data') ?>"
            },
            "columns" :[
                {"name" : "id"},
                {"name" : "kode"},
                {"name" : "jenis"},
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
        url: "<?= base_url('Pengeluaran/tambah') ?>",
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
      $("#idm_pengeluaran option").remove();
      $("#jumlah").val(0);
      $("#tanggal").val("<?= date("Y-m-d") ?>");
    }

    function edit_data(id) {
        $.ajax({
            url: "<?= base_url('Pengeluaran/edit_data/') ?>"+id,
            dataType: 'json',
            type: 'post'
        }).done(function(data) {
            $("#formModal").modal('show');
            $("#tanggal").val(data.value.tanggal);
            $("#jumlah").val(formatrupiah(data.value.jumlah));
            if(Number(data.value.idm_pengeluaran) > 0) {
              $("#idm_pengeluaran").append("<option value='"+data.value.idm_pengeluaran+"'>"+data.value.nama+"</option>");
            }
            $("#id").val(data.value.id);
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
            url: "<?= base_url('Pengeluaran/delete_data/') ?>"+id,
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
        $('#idm_pengeluaran').select2({
            placeholder: 'Pilih Jenis Pengeluaran',
            multiple: false,
            allowClear: true,
            ajax: {
                url: '<?php echo site_url("Pengeluaran/get_select_jenis"); ?>',
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