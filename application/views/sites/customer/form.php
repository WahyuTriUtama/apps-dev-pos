<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Form 
    	<?= $method_name == 'create' ? "Add" : "Edit"; ?>
    </h3>
    <div class="box-tools pull-right">
		<a href="<?= base_url($controller_id);?>" class="btn btn-danger btn-xs btn-flat" title="Back"><i class="fa fa-long-arrow-left"></i> Kembali</a>
	</div>
  </div>
  <div class="box-body">
  	<?= form_open(current_url(), array('id'=>'form', 'class'=>'form-horizontal'));?>
      <div class="box-body">
        <div class="form-group">
          <label for="code" class="col-sm-2 control-label">Nama</label>
          <div class="col-sm-6">
            <input type="text" name="name" value="<?= set_value('name', isset($model->name) && $model->name ? $model->name : '');?>" class="form-control" id="name" placeholder="">
            <?= form_error('name');?>
          </div>
        </div>

        <div class="form-group">
          <label for="description" class="col-sm-2 control-label">Kontak</label>
          <div class="col-sm-6">
            <input type="text" name="contact" value="<?= set_value('contact', isset($model->contact) && $model->contact ? $model->contact : '');?>" class="form-control" id="contact" placeholder="">
            <?= form_error('contact');?>
          </div>
        </div>

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <button type="submit" class="btn btn-success pull-right btn-flat"><i class="fa fa-save"></i> Simpan</button>
      </div>
      <!-- /.box-footer -->
    <?= form_close();?>
  </div>
</div>