
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Slide</h1>
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Slide</h6>
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
                      <th width="20%">Header</th>
                      <th width="30%">Text</th>
                      <th width="20%">Image</th>
                      <th width="10%">Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tr>
                        <th>No</th>
                      <th>Header</th>
                      <th>Text</th>
                      <th>Image</th>
                      <th>Action</th>
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
        <h5 class="modal-title" id="labelModal">Form tambah data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formAll">
            <input type="hidden" name="id" id="id" value="">

          <div class="form-group">
            <label for="header">Header</label>
            <input type="text" class="form-control" id="header" name="header">
          </div>

          <div class="form-group">
            <label for="text">Text</label>
            <textarea name="text" id="text" class="form-control" cols="30" rows="5"></textarea>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="reset_form()">Close</button>
        <button type="button" class="btn btn-primary" onclick="save()">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        load_data();
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
                url: "<?= base_url('slide/load_data') ?>"
            },
            "columns" :[
                {"name" : "id_slide"},
                {"name" : "header"},
                {"name" : "text"},
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
        url: "<?= base_url('Slide/tambah') ?>",
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
      $("#text").val("");
      $("#header").val("");
      $("#image").filestyle('clear');
      $("#image-view").addClass("d-none");
      $("#labelModal").html("Form tambah data");
    }

    function edit_data(id_slide) {
        $.ajax({
            url: "<?= base_url('Slide/edit_data/') ?>"+id_slide,
            dataType: 'json',
            type: 'post'
        }).done(function(data) {
            $("#formModal").modal('show');
            $("#header").val(data.value.header);
            $("#text").val(data.value.text);
            $("#image-view").removeClass("d-none");
            $("#src").html(data.value.image);
            $("#id").val(data.value.id);
            $("#labelModal").html("Form edit data");
        });
    }

    function delete_data(id_slide){
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
            url: "<?= base_url('Slide/delete_data/') ?>"+id_slide,
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