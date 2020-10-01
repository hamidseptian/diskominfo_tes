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

<div style="float:left">
	<img src="<?php echo base_url() ?>gambar/bri.png" width="150px">	
	
</div>
<div style="float:left; margin-left: 50px">
	<h3>Bank BRI Cabang Sawahan</h3>
	Sawahan Tim., Kec. Padang Tim., Kota Padang, Sumatera Barat 25171
	
</div>
<div style="clear:both"></div>
<hr>	
	<h1>
		Laporan Data Transaksi <br>	Tanggal <?php echo $tglawal ?> sampai tanggal <?php echo $tglakhir ?>
	</h1>
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
				 	$idnas1 = $d['id_nasabah'];
				 	$dnas1 = $this->db->get_where('nasabah', array('id_nasabah'=>$idnas1))->row_array();

				 	?>
					
			<tr>
				<td><?php echo $no++ ?></td>
				<td><?php echo $d['tgl_transaksi'].' '.$d['jam_transaksi'] ?></td>
				<td><?php 
				 if ($d['jenis']=='Transfer') {
				  	$jenis = $d['jenis'].' dari '.$dnas1['nama'].' ke '.$dnas['nama'];
				  	# code...
				  } 
				 else if ($d['jenis']=='Terima Transfer') {
				  	$jenis = $d['jenis'].' dari '.$dnas['nama'].' ke '.$dnas1['nama'];
				  } else{
				  	$jenis = $d['jenis'].' '.$dnas1['nama'];
				  }
				  echo $jenis;
				 ?></td>
				<td><?php echo number_format($d['jumlah']) ?></td>
				<?php } ?>
			<tr>
		
			
		</table>
		
		<?php }else{
			echo "Tidak ada data transaksi";
		} ?>


</body>
</html>


<script>
	window.print()
</script>