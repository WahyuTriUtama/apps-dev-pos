<?php defined('BASEPATH') OR exit('No direct script access allowed');

function format_currency($angka, $desimal=2, $satuan='Rp. ')
{
	return $satuan.number_format($angka, $desimal, ',', '.');
}