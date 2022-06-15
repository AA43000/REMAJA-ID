
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Pengaduan</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Pengaduan</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table1" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="10%">No</th>
                      <th width="20%">Nama</th>
                      <th width="10%">Tanggal</th>
                      <th width="30%">Text</th>
                      <th width="30%">Image</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tr>
                    <th width="10%">No</th>
                      <th width="20%">Nama</th>
                      <th width="10%">Tanggal</th>
                      <th width="30%">Text</th>
                      <th width="30%">Image</th>
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
    
<script type="text/javascript">
    $(document).ready(function() {
        load_data();
    });
    
    function load_data() {
        $("#table1").DataTable({
            destroy: true,
            "processing" : true,
            "serverSide" : true,
            ajax :{
                url: "<?= base_url('Pengaduan/load_data') ?>"
            },
            "columns" :[
                {"name" : "id"},
                {"name" : "nama"},
                {"name" : "tanggal"},
                {"name" : "text"},
                {"name" : "image"},
            ],
            "order" : [
                [0, 'asc']
            ],
            "iDisplayLength" : 10
        });
    }
</script>