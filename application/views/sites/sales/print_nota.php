<html><!-- #BeginTemplate "/Templates/Template #2.dwt" --><!-- DW6 -->
<head>
<!-- #BeginEditable "doctitle" --> 
<title><?= APPS; ?> | Nota</title>
<!-- #EndEditable --> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="<?= base_url();?>assets/report/css-def.css">
</head>
<body bgcolor="#FFFFFF">
<!-- #BeginEditable "Content" -->
  <table width="1060" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr> 
    <td width="530"><h2><?= APPS; ?></h2></td>
    <td width="530"> 
      <div align="right">Tanggal : <?= $model->document_date; ?></div>
    </td>
  </tr>
  <tr> 
    <td width="530"><h4>WONOGIRI</h4></td>
    <td width="530"> 
      <div align="right"></div>
    </td>
  </tr>
</table>
<p class="title1Print">Nota Penjualan</p>
<table border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#000000" width="1060">
  <tr> 
    <td height="43"> 
      <table width="1060" border="0" bgcolor="#F9F9F9" cellpadding="1" cellspacing="2">
        <tr> 
          <td width="68"> 
            <div align="left">Nota </div>
          </td>
          <td width="300"> : <?= $model->code; ?></td>
          <td width="400"> 
            <div align="right">Kasir : </div>
          </td>
          <td width="292"><?= $this->User_model->find_where(['id' => $model->user_id])->row()->name;?></td>
        </tr>
        <tr> 
          <td width="68"> 
            <div align="left">Pelanggan </div>
          </td>
          <td width="300"> : <?= $model->customer_name; ?></td>
          <td width="400"> 
            <div align="right"></div>
          </td>
          <td width="292"></td>
        </tr>
        <tr> 
          <td width="68"> 
            <div align="left"></div>
          </td>
          <td width="300"></td>
          <td width="400"> 
            <div align="right"></div>
          </td>
          <td width="292"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<table border="0" cellspacing="0" cellpadding="2" align="center" width="1060">
  <tr> 
    <td colspan="15" height="2">
    =========================================================================================================================
    </td>
  </tr>
  <tr class="head1Print"> 
    <td width="4%" height="2">No.</td>
    <td width="10%" height="2">Kode</td>
    <td width="10%" height="2">Nama</td>
    <td width="10%" height="2">Satuan</td>
    <td width="8%" height="2">Qty</td>
    <td width="10%" height="2">Harga</td>
    <td width="10%" height="2">Total</td>
  </tr>
  <tr> 
    <td colspan="15" height="2">
      --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    </td>
  </tr>
  <?php 
      $no=0; 
      foreach ($detailModel->result() as $row) { 
    ?>
      <tr class="line-bottom"> 
        <td width="4%" valign="top"> 
          <div align="left"><?= ++$no; ?></div>
        </td>
        <td width="10%" valign="top"> 
          <div align="left"><?= $row->item_code; ?></div>
        </td>
        <td width="10%" valign="top"> 
          <div align="left"><?= $row->item_name; ?></div>
        </td>
        <td width="10%" valign="top"> 
          <div align="left"><?= $row->uom; ?></div>
        </td>
        <td width="8%" valign="top"> 
          <div align="right"><?= $row->qty; ?></div>
        </td>
        <td width="10%" valign="top"> 
          <div align="right"><?= format_currency($row->price); ?></div>
        </td>
        <td width="10%" valign="top"> 
          <div align="right"><?= format_currency($row->total_price); ?></div>
        </td>
      </tr>
  <?php } ?>
  <tr class="row2Print"> 
    <td colspan="15">
    --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    </td>
  </tr>

  <tr class="row2Print"> 
    <td colspan="6"> 
      <div align="right">Total Qty :</div>
    </td>
    <td> 
      <div align="right"><?= $qty; ?></div>
    </td> 
  </tr>

  <tr class="row2Print"> 
    <td colspan="6"> 
      <div align="right">Total :</div>
    </td>
    <td> 
      <div align="right"><?= format_currency($model->total_amount); ?></div>
    </td> 
  </tr>

  <tr class="row2Print"> 
    <td colspan="15">
    =========================================================================================================================
    </td>
  </tr>
</table>
<p></p>
<!-- #EndEditable -->
<p align="center">--- TERIMA KASIH TELAH BERBELANJA ---</p>
</body>
<!-- #EndTemplate -->
</html>
