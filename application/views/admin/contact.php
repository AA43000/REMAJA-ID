
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Contact</h1>

              <!-- DataTales Example -->
              <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Contact</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table2" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="40%"><a href="#" class="btn btn-success" data-toggle="modal" data-target="#modalContact" onclick="update(1)"><i class="fa fa-edit"></i></a> Alamat</th>
                      <th width="30%"><a href="#" class="btn btn-success" data-toggle="modal" data-target="#modalContact" onclick="update(2)"><i class="fa fa-edit"></i></a> No Telp</th>
                      <th width="30%"><a href="#" class="btn btn-success" data-toggle="modal" data-target="#modalContact"  onclick="update(3)"><i class="fa fa-edit"></i></a> Email</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                      <th width="40%">Alamat</th>
                      <th width="30%">No Telp</th>
                      <th width="30%">Email</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          
          
          </div>
    <!-- /.container-fluid -->

<div class="modal fade" id="modalContact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

          <div id="alm" class="d-none">
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <input type="text" class="form-control" id="alamat" name="alamat">
            </div>
          </div>

          <div id="telp" class="d-none">
            <div class="form-group">
              <label for="no_telp">No Telp</label>
              <input type="text" id="no_telp" name="no_telp" class="form-control">
            </div>
          </div>

          <div id="eml" class="d-none">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" class="form-control" id="email" name="email">
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="update_contact()">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        load_data_utama();
        load_contact();
    });

    function load_contact() {
      $.ajax({
        url: "<?= base_url('Contact/load_contact') ?>",
        dataType: 'json',
        type: 'get',
      }).done(function(data) {
        $("#alamat").val(data.alamat);
        $("#no_telp").val(data.no_telp);
        $("#email").val(data.email);
      });
    }

    function load_data_utama() {
        $("#table2").DataTable({
            destroy: true,
            "processing" : true,
            "serverSide" : true,
            ajax : {
                url: "<?= base_url('Contact/load_data_utama') ?>"
            },
            "columns" :[
                {"name" : "alamat"},
                {"name" : "no_telp"},
                {"name" : "email"},
            ],
            "order" : [
                [0, 'asc']
            ],
            "iDisplayLength" : 10
        });
    }

    function update(field) {
      if(field == 1) {
        $("#alm").removeClass('d-none');
        $("#telp").addClass('d-none');
        $("#eml").addClass('d-none');
      } else if (field == 2) {
        $("#alm").addClass('d-none');
        $("#telp").removeClass('d-none');
        $("#eml").addClass('d-none');
      } else if (field == 3) {
        $("#alm").addClass('d-none');
        $("#telp").addClass('d-none');
        $("#eml").removeClass('d-none');
      }
    }

    function update_contact() {
      var formData = new FormData($("#formedit")[0]);
      $.ajax({
        url: "<?= base_url('Contact/update') ?>",
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
            $("#modalContact").modal('hide');
            load_data_utama();
            load_contact();
          });
        } else if(data.status == 202) {
          swal("Warning", data.message, "warning");
        }
      }) 
    }
</script>