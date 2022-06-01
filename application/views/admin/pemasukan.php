
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Master Pemasukan</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Master Pemasukan</h6>
              <a href="#" class="btn btn-primary btn-icon-split btn-sm ml-3" data-toggle="modal" data-target="#formModal">
                <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                <span class="text">Tambah data</span>
              </a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <div class="row">
                  <div class="col-6">
                      <div class="form-group">
                          <label for="tanggal">Tanggal</label>
                          <div class="row">
                              <input type="date" class="form-control col-5" id="tanggal_awal" name="tanggal_awal" onchange="$('#tanggal_akhir').prop('min', this.value), load_data()">
                              <span class="col-1 text-center">to</span>
                              <input type="date" class="form-control col-5" id="tanggal_akhir" name="tanggal_akhir" onchange="$('#tanggal_awal').prop('max', this.value), load_data()">
                          </div>
                      </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="i_jenis">Jenis</label>
                      <select name="i_jenis" id="i_jenis" class="form-control" style="width: 100%" onchange="load_data()"></select>  
                    </div>
                  </div>
                  <div class="col-2">
                    <button class="btn btn-secondary mt-4" type="button" onclick="print()">Print</button>
                  </div>
                </div>
              <table class="table table-bordered" id="table1" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="10%">No</th>
                      <th width="10%">Kode</th>
                      <th width="10%">Jenis</th>
                      <th width="20%">tanggal</th>
                      <th width="20%">jumlah</th>
                      <th width="10%">Operator</th>
                      <th width="10%">Keterangan</th>
                      <th width="10%">Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tr>
                    <th width="10%">No</th>
                      <th width="10%">Kode</th>
                      <th width="10%">Jenis</th>
                      <th width="20%">tanggal</th>
                      <th width="20%">jumlah</th>
                      <th width="10%">Operator</th>
                      <th width="10%">Keterangan</th>
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
            <label for="idm_pemasukan">Jenis</label><br>
            <select name="idm_pemasukan" id="idm_pemasukan" class="form-control" style="width: 100%"></select>
          </div>
          <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="text" class="form-control" id="jumlah" name="jumlah">
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

    function print() {
      var tanggal_awal = $("#tanggal_awal").val();
      var tanggal_akhir = $("#tanggal_akhir").val();
      var i_jenis = $("#i_jenis").val();
      if(tanggal_awal == "") {
        tanggal_awal = 0;
      }
      if(tanggal_akhir == "") {
        tanggal_akhir = 0;
      }
      if(i_jenis == "") {
        i_jenis = 0;
      }
      window.open("<?= base_url() ?>Pemasukan/print/"+tanggal_awal+"/"+tanggal_akhir+"/"+i_jenis);
    }
    
    function load_data() {
      var tanggal_awal = $("#tanggal_awal").val();
      var tanggal_akhir = $("#tanggal_akhir").val();
      var i_jenis = $("#i_jenis").val();
      if(tanggal_awal == "") {
        tanggal_awal = 0;
      }
      if(tanggal_akhir == "") {
        tanggal_akhir = 0;
      }
      if(i_jenis == "") {
        i_jenis = 0;
      }
        $("#table1").DataTable({
            destroy: true,
            "processing" : true,
            "serverSide" : true,
            ajax :{
                url: "<?= base_url('Pemasukan/load_data/') ?>"+i_jenis+"/"+tanggal_awal+"/"+tanggal_akhir
            },
            "columns" :[
                {"name" : "id"},
                {"name" : "kode"},
                {"name" : "jenis"},
                {"name" : "tanggal"},
                {"name" : "jumlah"},
                {"name" : "operator"},
                {"name" : "keterangan"},
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
        url: "<?= base_url('Pemasukan/tambah') ?>",
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
      $("#idm_pemasukan option").remove();
      $("#jumlah").val(0);
      $("#keterangan").val("");
      $("#tanggal").val("<?= date("Y-m-d") ?>");
    }

    function edit_data(id) {
        $.ajax({
            url: "<?= base_url('Pemasukan/edit_data/') ?>"+id,
            dataType: 'json',
            type: 'post'
        }).done(function(data) {
            $("#formModal").modal('show');
            $("#tanggal").val(data.value.tanggal);
            $("#keterangan").val(data.value.keterangan);
            $("#jumlah").val(formatrupiah(data.value.jumlah));
            if(Number(data.value.idm_pemasukan) > 0) {
              $("#idm_pemasukan").append("<option value='"+data.value.idm_pemasukan+"'>"+data.value.nama+"</option>");
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
            url: "<?= base_url('Pemasukan/delete_data/') ?>"+id,
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
        $('#idm_pemasukan').select2({
            placeholder: 'Pilih Jenis Pemasukan',
            multiple: false,
            allowClear: true,
            ajax: {
                url: '<?php echo site_url("Pemasukan/get_select_jenis"); ?>',
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
        $('#i_jenis').select2({
            placeholder: 'Pilih Jenis Pemasukan',
            multiple: false,
            allowClear: true,
            ajax: {
                url: '<?php echo site_url("Pemasukan/get_select_jenis/"); ?>'+1,
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