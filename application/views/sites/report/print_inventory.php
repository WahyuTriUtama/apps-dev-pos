<html><!-- #BeginTemplate "/Templates/Template #2.dwt" --><!-- DW6 -->
<head>
<!-- #BeginEditable "doctitle" --> 
<title><?= APPS; ?> | Inventory</title>
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
      <div align="right">Tanggal : <?= date('Y-m-d')?></div>
    </td>
  </tr>
  <tr> 
    <td width="530"><h4>WONOGIRI</h4></td>
    <td width="530"> 
      <div align="right"></div>
    </td>
  </tr>
</table>
<p class="title1Print">Laporan Inventory <br> <span style="font-size: 10pt"><?= $end; ?></span></p>
<br>
<table border="0" cellspacing="0" cellpadding="2" align="center" width="1060">
  <tr> 
    <td colspan="15" height="2">
    =========================================================================================================================
    </td>
  </tr>
  <tr class="head1Print"> 
    <td width="4%" height="2">No.</td>
    <td width="12%" height="2"> 
      <div align="center"><b>Kode</b></div>
    </td>
    <td width="20%" height="2"> 
      <div align="center"><b>Nama</b></div>
    </td>
    <td width="15%" height="2">Kategori</td>
    <td width="10%" height="2">Satuan</td>
    <td width="20%" height="2">Stok</td>
  </tr>
  <tr> 
    <td colspan="15" height="2">
      --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    </td>
  </tr>
  <?php 
      $no=0; 
      foreach ($model->result() as $row) { 
    ?>
      <tr class="line-bottom"> 
        <td width="4%" valign="top"> 
          <div align="center"><?= ++$no; ?></div>
        </td>
        <td width="12%" valign="top"> 
          <div align="left"><?= $row->code; ?></div>
        </td>
        <td width="20%" valign="top"><?= $row->name; ?></td>
        <td width="15%" valign="top"> 
          <div align="center"><?= $row->category; ?></div>
        </td>
        <td width="10%" valign="top"> 
          <div align="center"><?= $row->uom_code; ?></div>
        </td>
        <td width="20%" valign="top"> 
          <div align="right"><?= $row->stock;?></div>
        </td>
      </tr>
    <?php } ?>
    

  <tr class="row2Print"> 
    <td colspan="15">
    =========================================================================================================================
    </td>
  </tr>
</table>
<p></p>
<table width="1060" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td height="27" colspan="2" align="right">Wonogiri, .........................  
     <!-- <font face="arial" size="3"></font>  -->
    </td>
  </tr>
  <tr> 
    <td height="27" colspan="2" align="right" style="padding-right: 20px">  
     <font face="arial" size="2">Mengetahui,</font> 
    </td>
  </tr>
  <tr> 
    <td height="27" colspan="2" align="right" style="padding-top: 50px">.........................  
    </td>
  </tr>
</table>
<!-- #EndEditable -->
<p align="center">&nbsp; </p>
</body>
<!-- #EndTemplate -->
</html>
