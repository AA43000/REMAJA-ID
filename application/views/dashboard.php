

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <span onclick="show_pengaduan()" style="cursor: pointer" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-bullhorn fa-sm text-white-50"></i> Pengaduan</span>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Anggaran</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= $anggaran ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Kegiatan(1 tahun)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_kegiatan ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calender-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Unit</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $jumlah_unit ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Anggota</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_anggota ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->

          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Pengumuman</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body row w-100" id="pengumuman">
                  
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Riwayat Kas</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                <small>hanya 5 data terakhir yang tampil</small>
                  <table class="table table-striped">
                    <thead class="thead-light">
                      <tr>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                      </tr>
                    </thead>
                    <tbody id="riwayat_kas">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->
          
          </div>
    <!-- /.container-fluid -->
     <!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pengumuman</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-right">ٱلسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ ٱللَّٰهِ وَبَرَكَاتُهُ</p>
        <p>Melalui pesan ini kami sampaikan kepada seluruh anggota karang taruna <b>kampala</b> untuk dapat berkenan hadir <span id="nama"></span> yang akan dilaksanakan pada:</p>
        <span>Tanggal: <span id="tanggal"></span></span><br>
        <span>Pukul: <span id="waktu"></span> WIB - selesai</span><br>
        <span>Tempat: <span id="tempat"></span></span><br>
        <span>Keterangan: <span id="keterangan"></span></span>
        <p></p>
        <p>Demikian pesan ini saya sampaikan, atas perhatiannya saya ucapkan terimakasih.</p>
        <p class="text-right">وَالسَّلاَمُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُهُ</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalPengaduan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pengaduan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="formAll">
          <div class="form-group">
            <label for="header">Text</label>
            <textarea name="text" id="text" class="form-control"></textarea>
          </div>

          <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="kirim_pengaduan()">Kirim</button>
      </div>
    </div>
  </div>
</div>

  <script type="text/javascript">
    $(document).ready(function() {
        load_data();
        load_kas();
        $("#image").filestyle({
          btnClass : 'btn-outline-primary',
          text: 'Pilih Image'
        });
        $('#formModal').on('hidden.bs.modal', function (e) {
            load_data();
        });
        $('#modalPengaduan').on('hidden.bs.modal', function (e) {
            reset_pengaduan();
        });
    });
    function load_data() {
        $.ajax({
            url: "<?= base_url() ?>Welcome/load_data",
            dataType: "json",
            type: "post",
            success: function(data) {
                var result = '';
                for(var i = 0;i<data.data.length;i++) {
                    var notif = '';
                    if(data.data[i].notif == 1) {
                        notif = 'background-color: #e5eaf7';
                    }
                    result+= '<div class="col-lg-4 py-1">';
                    result+= '    <div class="card" style="width: 100%; cursor: pointer; '+notif+'" onclick="show_modal('+data.data[i].id+')">';
                    result+= '        <div class="card-body">';
                    result+= '            <h5 class="card-title">'+data.data[i].nama+'</h5>';
                    result+= '            <h6 class="card-subtitle mb-2 text-muted">'+data.data[i].tanggal+'</h6>';
                    result+= '            <p class="card-text">'+data.data[i].keterangan+'</p>';
                    result+= '        </div>  ';
                    result+= '    </div>';
                    result+= '</div>';
                }
                $("#pengumuman").html(result);
            }
        })
    }
    function show_modal(id) {
        $.ajax({
            url: "<?= base_url() ?>Welcome/load_data/"+id,
            dataType: "json",
            success: function(data) {
              $("#nama").html(data.data.nama);
              $("#tanggal").html(data.data.tanggal);
              $("#keterangan").html(data.data.keterangan);
              $("#tempat").html(data.data.tempat);
              $("#waktu").html(data.data.waktu);
              $("#formModal").modal("show");
            }
        })
    }
    function load_kas() {
      $.ajax({
        url: "<?= base_url() ?>Welcome/load_kas",
        dataType: "json",
        success: function(data) {
          var result = '';
          if(data.data.length > 0) {
            for(var i = 0; i<data.data.length;i++) {
              result += '<tr>';
              result += '<td>'+data.data[i].tanggal+'</td>';
              result += '<td>Rp. '+data.data[i].jumlah+'</td>';
              result += '</tr>';
            }
          } else {
            result = '<td colspan="2">Data tidak ditemukan</td>';
          }
          $("#riwayat_kas").html(result);
        }
      })
    }
    function show_pengaduan() {
      $("#modalPengaduan").modal("show");
    }
    function reset_pengaduan() {
      $("#text").val("");
      $("#image").filestyle('clear');
    }
    function kirim_pengaduan() {
      var formData = new FormData($("#formAll")[0]);
      $.ajax({
        url: "<?= base_url('Welcome/kirim_pengaduan') ?>",
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
            $("#modalPengaduan").modal('hide');
          });
        } else if(data.status == 202) {
          swal("Warning", data.message, "warning");
        }
      }) 
    }
</script>
