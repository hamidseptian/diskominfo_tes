<style>
	li{
		display: 	inline-block;	
		margin: 	10px;
		color: white;

	}

	.nav{
		width:100%;
		background: blue;
	}
	.putih{
		color:white;
	}
</style>
<div style="float:left">
	<img src="<?php echo base_url() ?>gambar/bri.png" width="250px">	
	
</div>
<div style="float:left; margin-left: 50px">
	<h3>Bank BRI Cabang Sawahan</h3>
	Sawahan Tim., Kec. Padang Tim., Kota Padang, Sumatera Barat 25171
	
</div>
<div style="clear:both"></div>
<div class="nav">
	
	<ul>
		<?php if (isset($login)) { 
			$namalevel = array('BO'=>"Back Office",'Teller'=>'Teller', 'CS'=>"Customer Service");
			if ($level =="CS") { ?>
			<li><a href="<?php echo 	base_url() ?>user/cs" class="putih">Data Nasabah</a></li>
				
			<?php }
			else if ($level =="BO") { ?>
			<li><a href="<?php echo 	base_url() ?>user/bo" class="putih">Transaksi Nasabah</a></li>
			<li><a href="<?php echo 	base_url() ?>user/bo/lap_nasabah" class="putih">Laporan Data Nasabah</a></li>
			<li><a href="<?php echo 	base_url() ?>user/bo/lap_transaksi" class="putih">Laporan Transaksi</a></li>
			<li><a href="<?php echo 	base_url() ?>user/bo/cari_laporan_transaksi" class="putih">Cari Laporan Transaksi</a></li>
			<!-- <li><a href="<?php echo 	base_url() ?>user/bo/data_user" class="putih">Data User</a></li> -->
				
			<?php }
			else  { ?>
			<li><a href="<?php echo 	base_url() ?>user/teller" class="putih">Data Transksi</a></li>
			<li><a href="<?php echo 	base_url() ?>user/teller/calon_nasabah" class="putih">Calon Nasabah</a></li>
				
			<?php }?>
			
			<li style="float:right"><a href="<?php echo 	base_url() ?>home/logout" class="putih">Logout</a></li>
			<li style="float:right"><a href="#" class="putih"><?php echo $nama.' - '.$namalevel[$level] ?></a></li>
		<?php }else{ ?>
		<li><a href="<?php echo 	base_url() ?>" class="putih">Home</a></li>
		<li><a href="<?php echo 	base_url() ?>home/login" class="putih">Login</a></li>
		<?php } ?>
	</ul>
</div>

<?php echo $this->session->flashdata('pesan') ?>