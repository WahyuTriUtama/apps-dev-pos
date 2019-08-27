<?php
	$category = array('' => '-- Kategori --');
  $catModel = $this->Item_category_model->all();
  foreach ($catModel->result() as $row) {
    $category[$row->id] = $row->name;
  }

  $uom = array('' => '-- Satuan --');
  $uomModel = $this->Uom_model->all();
  foreach ($uomModel->result() as $row) {
    $uom[$row->id] = $row->code.' - '.$row->description;
  }
?>

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
          <label for="code" class="col-sm-2 control-label">Kode</label>
          <div class="col-sm-6">
            <input type="text" name="code" value="<?= set_value('code', isset($model->code) && $model->code ? $model->code : '');?>" class="form-control" id="code" placeholder="">
            <?= form_error('code');?>
          </div>
        </div>

        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">Nama</label>
          <div class="col-sm-6">
            <input type="text" name="name" value="<?= set_value('name', isset($model->name) && $model->name ? $model->name : '');?>" class="form-control" id="name" placeholder="">
            <?= form_error('name');?>
          </div>
        </div>

        <div class="form-group">
          <label for="group" class="col-sm-2 control-label">Kategori</label>
          <div class="col-sm-6">
          	<?= form_dropdown('category_id', $category, isset($model->category_id) && $model->category_id ? $model->category_id: '', ['class' => 'form-control select2']); ?>
            <?= form_error('category_id');?>
          </div>
        </div>

        <div class="form-group">
          <label for="group" class="col-sm-2 control-label">Satuan</label>
          <div class="col-sm-6">
            <?= form_dropdown('uom_id', $uom, isset($model->uom_id) && $model->uom_id ? $model->uom_id: '', ['class' => 'form-control select2']); ?>
            <?= form_error('uom_id');?>
          </div>
        </div>

        <div class="form-group">
          <label for="code" class="col-sm-2 control-label">Harga</label>
          <div class="col-sm-6">
            <input type="text" name="price" value="<?= set_value('price', isset($model->price) && $model->price ? $model->price : '');?>" class="form-control" id="price" placeholder="">
            <?= form_error('price');?>
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