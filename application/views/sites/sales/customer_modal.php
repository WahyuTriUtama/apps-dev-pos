<!-- modal -->
<div class="modal fade in" id="modal_cust">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Pelanggan</h4>
      </div>
      <form action="#" class="form" id="form_cust">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Nama</label>
            <input type="text" value="" class="form-control" id="cust_name" placeholder="" required="">
          </div>

          <div class="form-group">
            <label for="">Kontak</label>
            <input type="text" value="" class="form-control" id="cust_contact" placeholder="" required="">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tutup</button>
          <button type="submit" id="save_customer" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /modal -->


<script>
  $(function() {
    $('#cust_btn').click(function(e) {
      $('#modal_cust').modal('show');
    })

    $('#form_cust').submit(function(e) {
      var name = $('#cust_name').val();
      var contact = $('#cust_contact').val();
      if (name == "" || contact == "") {
        alert('Nama / kontak tidak boleh kosong');
      } else {
        $.ajax({
          url: '<?= base_url($controller_id);?>/add_customer',
          type: 'POST',
          dataType: 'json',
          data: {name: name, contact: contact},
        })
        .done(function(data) {
          if (data.msg[0]) {
            $('#modal_cust').modal('hide');
            window.location.reload();
          } else {
            alert(data.msg[1]);
          }
        })
        .fail(function() {
          alert("error");
        });
      }
    });
    //
  });
</script>