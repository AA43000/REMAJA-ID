
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Kas</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
              <h6 class="m-0 font-weight-bold text-primary">Header</h6>
            </div>
            <div class="card-body">
            <form id="formData">
            <input type="hidden" name="id" id="id" value="<?= $id ?>">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="kode">Kode</label>
                            <input type="text" class="form-control" id="kode" name="kode" placeholder="Auto" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date("Y-m-d") ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="text" class="form-control" id="jumlah" name="jumlah" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="operator">Operator</label>
                            <input type="text" class="form-control" id="operator" name="operator" value="<?= $username ?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button class="btn btn-primary" type="button" onclick="save()">Simpan</button>
                        <a href="<?= base_url() ?>Kas/" class="btn btn-warning">Kembali</a>
                    </div>
                </div>
            </form>
            </div>
          </div>

          <div class="card shadow mb-4">
            <a href="#collapseCardExample2" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample2">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Anggota</h6>
            </a>
            <div class="collapse show" id="collapseCardExample2">
                <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="table1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        <th width="10%">No</th>
                        <th width="40%">Anggota</th>
                        <th width="40%">Jumlah</th>
                        <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th width="10%">No</th>
                        <th width="40%">Anggota</th>
                        <th width="40%">Jumlah</th>
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

          <div class="card shadow mb-4">
            <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Proses</h6>
            </a>
            <div class="collapse show" id="collapseCardExample">
                <div class="card-body">
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
            </div>
          </div>
          
          </div>
    <!-- /.container-fluid -->
<script type="text/javascript">
    $(document).ready(function() {
        load_anggota();
        load_proses();
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
    
    function load_anggota() {
        $("#table1").DataTable({
            destroy: true,
            "processing" : true,
            "serverSide" : true,
            ajax :{
                url: "<?= base_url('Kas/load_anggota') ?>"
            },
            "columns" :[
                {"name" : "id_user"},
                {"name" : "nama"},
                {"name" : "jumlah"},
                {"name" : "action", "orderable": false, "searchlable": false, "className": "text-center"}
            ],
            "order" : [
                [0, 'asc']
            ],
            "iDisplayLength" : 10
        });
    }
    function add_proses(id) {
        var jumlah = $("#jumlah_"+id).val();
        $.ajax({
            url: "<?= base_url() ?>Kas/add_proses/",
            data: {
                id: id,
                jumlah: jumlah
            },
            dataType: "json",
            type: "post" ,
            success: function(data) {
                load_proses();
            }
        })
    }
    function load_proses() {
      $.ajax({
        url: "<?= base_url() ?>Kas/jumlah",
        dataType: "json",
        success: function(data) {
          $("#jumlah").val(formatrupiah(data));
        }
      });
      $("#table2").DataTable({
          destroy: true,
          "processing" : true,
          "serverSide" : false,
          ajax :{
              url: "<?= base_url('Kas/load_proses') ?>"
          },
          "columns" :[
              {"name" : "id_user"},
              {"name" : "nama"},
              {"name" : "jumlah", "orderable": false, "searchlable": false},
          ],
          "order" : [
              [0, 'asc']
          ],
          "iDisplayLength" : 10
      });
    }
    function update_proses(jumlah, id) {
        var key = null;
        $.ajax({
            url: "<?= base_url() ?>Kas/add_proses",
            data: {
                jumlah: jumlah,
                id: id,
                key: key
            },
            dataType: "json",
            type: "post",
            success: function(data) {
                load_proses();
            }
        })
    }

    function save() {
      var formData = new FormData($("#formData")[0]);
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
            window.location.href = "<?= base_url() ?>Kas/"
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
                load_anggota();
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