<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Bank BRI</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>
		Identitas Nasabah
	</h1>

	<div id="body">
		<form action="<?php echo base_url() ?>user/teller/simpan_setoran" method="post">
			
		<table>
			<tr>
				<td>No Rekening</td>
				<td>:</td>
				<td><?php echo $nasabah['no_rekening'] ?></td>
				
			</tr>
			<tr>
				<td>Nama</td>
				<td>:</td>		
				<td><?php echo $nasabah['nama'] ?></td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td><?php echo $nasabah['alamat'] ?></td>
			</tr>
			<tr>
				<td>No HP</td>
				<td>:</td>		
				<td><?php echo $nasabah['nohp'] ?></td>
			</tr>
			<tr>
				<td>Saldo Anda</td>
				<td>:</td>		
				<td><?php echo number_format($saldo) ?></td>
			</tr>
			
		</table>
		<br>
		<a href="<?php echo base_url() ?>user/teller/tarik/<?php echo $nasabah['id_nasabah'] ?>" style="margin:10px">Tarik</a>
		<a href="<?php echo base_url() ?>user/teller/setor/<?php echo $nasabah['id_nasabah'] ?>" style="margin:10px">Setor</a>
		<a href="<?php echo base_url() ?>user/teller/transfer/<?php echo $nasabah['id_nasabah'] ?>" style="margin:10px">Transfer</a>
		<a href="<?php echo base_url() ?>user/teller/" style="margin:10px">Kembali</a>

		</form>
	</div>

	
</div>


<div id="container">
	<h1>
		Data Transaksi
	</h1>

	<div id="body">
	
		<?php if ($jtransaksi>0) { ?>
			
		<table style="width: 100%; border-collapse: collapse;" border=1>
			<tr>
				<td>No</td>
				<td>Tanggal Transaksi</td>
				<td>Jenis Transaksi</td>
				<td>Jumlah Transaksi</td>
			<tr>
				<?php
				$no=1;
				 foreach ($transaksi as $d) { 
				 	$idnas = $d['id_nasabah2'];
				 	$dnas = $this->db->get_where('nasabah', array('id_nasabah'=>$idnas))->row_array();

				 	?>
					
			<tr>
				<td><?php echo $no++ ?></td>
				<td><?php echo $d['tgl_transaksi'].' '.$d['jam_transaksi'] ?></td>
				<td><?php 
				 if ($d['jenis']=='Transfer') {
				  	$jenis = $d['jenis'].' ke '.$dnas['nama'];
				  	# code...
				  } 
				 else if ($d['jenis']=='Terima Transfer') {
				  	$jenis = $d['jenis'].' dari '.$dnas['nama'];
				  } else{
				  	$jenis = $d['jenis'];
				  }
				  echo $jenis;
				 ?></td>
				<td><?php echo number_format($d['jumlah']) ?></td>
				<?php } ?>
			<tr>
		
			
		</table>
		<?php }else{
			echo "Belum ada data transaksi";
		} ?>
	

		
	</div>
<p class="footer">By Hamid Septian</p>
	
</div>

</body>
</html>