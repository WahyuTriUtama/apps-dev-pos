<!-- modal -->
<div class="modal fade in" id="modal_open_kasir" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Open Kasir</h4>
      </div>
      <form action="#" class="form" id="form_open_modal">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Jumlah Uang Modal</label>
            <input type="number" value="" class="form-control" id="open_amount" placeholder="" required="">
          </div>
        </div>
        <div class="modal-footer">
          <a href="<?= base_url();?>/site" class="btn btn-flat pull-left"><i class="fa fa-home"></i> Dahsboard</a>
          <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /modal -->
<input type="hidden" name="id_drawer" value="0" id="id_drawer"/>

<script>
  $(function() {
    $.ajax({
      url: '<?= base_url($cls_path);?>/cash_drawer/check_cash',
      type: 'POST',
      dataType: 'json'
    })
    .done(function(st) {
      if (st.msg[0]) {
        $('#modal_open_kasir').modal('show');
      } else {
        $('#id_drawer').val(st.msg[1].id);
        $('#open_modal').val(st.msg[1].amount);
      }
    })
    .fail(function() {
      eror("error");
      window.location.reload();
    });
    

    $('#form_open_modal').submit(function(e) {
      var total = $('#open_amount').val();
      total = parseFloat(total);
      if (total <= 0) {
        alert('Harus lebih besar 0');
      } else {
        $.ajax({
          url: '<?= base_url($cls_path);?>/cash_drawer/open_kasir',
          type: 'POST',
          dataType: 'json',
          data: {amount: total},
        })
        .done(function(data) {
          if (data.msg[0]) {
            $('#modal_open_kasir').modal('hide');
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