<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bo extends CI_Controller {
	 public function __construct()
        {
                parent::__construct();
                $this->level = $this->session->userdata('level');
                $this->login = $this->session->userdata('login');
                $this->nama = $this->session->userdata('nama');



        }
	public function index()
	{
		$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;

		$data['nasabah'] = $this->db->get_where('nasabah', array('status'=>'Nasabah'))->result_array();
		$data['jnasabah'] = $this->db->get_where('nasabah', array('status'=>'Nasabah'))->num_rows();
		$this->load->view('nav',  $data);
		$this->load->view('konten/laporan_transaksi/data_nasabah', $data);
	}
	public function calon_nasabah()
	{
		$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;

		$data['nasabah'] = $this->db->get_where('nasabah', array('status'=>"Calon Nasabah"))->result_array();
		$data['jnasabah'] = $this->db->get_where('nasabah', array('status'=>"Calon Nasabah"))->num_rows();
		$this->load->view('nav',  $data);
		$this->load->view('konten/transaksi/calon_nasabah', $data);
	}
	public function setor($id)
	{
		$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;

		$data['idnas'] = $id;
		$this->load->view('nav',  $data);
		$data['nasabah']= $this->db->get_where('nasabah',array('id_nasabah'=>$id))->row_array();
		$this->load->view('konten/transaksi/tambah_setor', $data);
	}
	public function tarik($id)
	{
		$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;

		$data['idnas'] = $id;
		$this->load->view('nav',  $data);
		$data['nasabah']= $this->db->get_where('nasabah',array('id_nasabah'=>$id))->row_array();
		$setor = $this->db->query("SELECT sum(jumlah) as setoran from transaksi where id_nasabah='$id' and jenis='Setoran'")->row_array();
		$danasetor =  $setor['setoran'];
		$tarik = $this->db->query("SELECT sum(jumlah) as penarikan from transaksi where id_nasabah='$id' and jenis='Penarikan'")->row_array();
		$danatarik =  $tarik['penarikan'];
		$sisasaldo = $danasetor - $danatarik;
		$data['saldo'] = $sisasaldo;
		$this->load->view('konten/transaksi/tambah_tarik', $data);
	}
	public function transfer($id)
	{
		$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;

		$data['idnas'] = $id;
		$this->load->view('nav',  $data);
		$data['nasabah']= $this->db->get_where('nasabah',array('id_nasabah'=>$id))->row_array();
		$setor = $this->db->query("SELECT sum(jumlah) as setoran from transaksi where id_nasabah='$id' and jenis in ('Setoran','Terima Transfer')")->row_array();
		$danasetor =  $setor['setoran'];
		$tarik = $this->db->query("SELECT sum(jumlah) as penarikan from transaksi where id_nasabah='$id' and jenis in ('Penarikan','Transfer')")->row_array();
		$danatarik =  $tarik['penarikan'];
		$sisasaldo = $danasetor - $danatarik;
		$data['saldo'] = $sisasaldo;
		$this->load->view('konten/transaksi/tambah_transfer', $data);
	}
	public function cek_rek_tujuan($id)
	{
		$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;
			$this->load->view('nav',  $data);
		$rektujuan = $this->input->post('norek');
		$data['jcektujuan'] = $this->db->get_where('nasabah', array('no_rekening'=>$rektujuan))->num_rows();
		$data['cektujuan'] = $this->db->get_where('nasabah', array('no_rekening'=>$rektujuan))->row_array();
		$me = $this->db->get_where('nasabah', array('id_nasabah'=>$id))->row_array();
		$rekeningsaya = $me['no_rekening'];
		
		if ($data['jcektujuan']>0) {
			if ($rekeningsaya==$rektujuan) {
			$this->session->set_flashdata('pesan', "Maaf, Anda tidak bisa transfer ke rekening anda sendiri");
				redirect('user/teller/transfer/'.$id);
			}else{

				$data['idnas'] = $id;
				$data['nasabah']= $this->db->get_where('nasabah',array('id_nasabah'=>$id))->row_array();
				$setor = $this->db->query("SELECT sum(jumlah) as setoran from transaksi where id_nasabah='$id' and jenis in ('Setoran','Terima Transfer')")->row_array();
				$danasetor =  $setor['setoran'];
				$tarik = $this->db->query("SELECT sum(jumlah) as penarikan from transaksi where id_nasabah='$id' and jenis in ('Penarikan','Transfer')")->row_array();
				$danatarik =  $tarik['penarikan'];
				
				$sisasaldo = $danasetor - $danatarik;
				$data['saldo'] = $sisasaldo;
				$this->load->view('konten/transaksi/input_transfer', $data);
			}


		}else{
			$this->session->set_flashdata('pesan', "Maaf, Data nasabah tidak ditemukan");
			redirect('user/teller/transfer/'.$id);
		}
		
	}
	public function data_transaksi($id)
	{
		$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;
		$data['transaksi'] = $this->db->query("SELECT * from transaksi  as a left join nasabah as b on a.id_nasabah = b.id_nasabah where a.id_nasabah='$id'")->result_array();



		$data['jtransaksi'] = $this->db->query("SELECT * from transaksi  as a left join nasabah as b on a.id_nasabah = b.id_nasabah where a.id_nasabah='$id'")->num_rows();
		$data['idnas'] = $id;


		
		$setor = $this->db->query("SELECT sum(jumlah) as setoran from transaksi where id_nasabah='$id' and jenis in ('Setoran','Terima Transfer')")->row_array();
		$danasetor =  $setor['setoran'];
		$tarik = $this->db->query("SELECT sum(jumlah) as penarikan from transaksi where id_nasabah='$id' and jenis in ('Penarikan','Transfer')")->row_array();
		$danatarik =  $tarik['penarikan'];
		$sisasaldo = $danasetor - $danatarik;
		$data['saldo'] = $sisasaldo;



		$this->load->view('nav',  $data);
		$data['nasabah']= $this->db->get_where('nasabah',array('id_nasabah'=>$id))->row_array();
		$this->load->view('konten/laporan_transaksi/transaksi_nasabah', $data);
	}
	public function lap_transaksi()
	{
		$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;
		$data['transaksi'] = $this->db->query("SELECT * from transaksi  as a left join nasabah as b on a.id_nasabah = b.id_nasabah ")->result_array();



		$data['jtransaksi'] = $this->db->query("SELECT * from transaksi  as a left join nasabah as b on a.id_nasabah = b.id_nasabah")->num_rows();
		

		$this->load->view('nav',  $data);
		$this->load->view('konten/laporan_transaksi/lap_transaksi_nasabah', $data);
	}
	public function lap_transaksi_print()
	{
		$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;
		$data['transaksi'] = $this->db->query("SELECT * from transaksi  as a left join nasabah as b on a.id_nasabah = b.id_nasabah ")->result_array();



		$data['jtransaksi'] = $this->db->query("SELECT * from transaksi  as a left join nasabah as b on a.id_nasabah = b.id_nasabah")->num_rows();
		

		
		$this->load->view('konten/laporan_transaksi/lap_transaksi_nasabah_print', $data);
	}

	public function lap_nasabah()
	{
		$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;

		$data['nasabah'] = $this->db->get('nasabah')->result_array();
		$data['jnasabah'] = $this->db->get('nasabah')->num_rows();
		$this->load->view('nav',  $data);
		$this->load->view('konten/laporan_nasabah/data_nasabah', $data);
	}

	public function print_lap_nasabah()
	{
		$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;

		$data['nasabah'] = $this->db->get('nasabah')->result_array();
		$data['jnasabah'] = $this->db->get('nasabah')->num_rows();
		$this->load->view('nav',  $data);
		$this->load->view('konten/laporan_nasabah/data_nasabah', $data);
	}


	public function cari_laporan_transaksi()
	{
		$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;

	
		$this->load->view('nav',  $data);
		$this->load->view('konten/laporan_transaksi/form_cari');
	}
	public function hasil_cari()
	{
			$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;
		$tglawal = $this->input->post('tglawal');
		$tglakhir = $this->input->post('tglakhir');
$data['tglawaldb']= $tglawal;
		$data['tglakhirdb']= $tglakhir;
		$ptaw = explode('-', $tglawal);
		$ptak = explode('-', $tglakhir);

		$data['tglawal'] = $ptaw[2].'-'.$ptaw[1].'-'.$ptaw[0];
		$data['tglakhir'] = $ptak[2].'-'.$ptak[1].'-'.$ptak[0];

		$ctaa = strtotime($tglawal)	;
		$ctak = strtotime($tglakhir);
		if ($ctaa>$ctak) {
			$this->session->set_flashdata('pesan','Tanggal awal tidak boleh lebih besar dari tanggal akhir');
			redirect('user/bo/cari_laporan_transaksi');
		}else{


		$data['transaksi'] = $this->db->query("SELECT * from transaksi where tgl_transaksi between '$tglawal' and '$tglakhir'")->result_array();
		$data['jtransaksi'] = $this->db->query("SELECT * from transaksi where tgl_transaksi between '$tglawal' and '$tglakhir'")->num_rows();
		$this->load->view('nav',  $data);
		$this->load->view('konten/laporan_transaksi/hasilcari', $data);
		}

	
	}
	public function print_hasil_cari($tglawal, $tglakhir)
	{
			$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;
		
		
		$ptaw = explode('-', $tglawal);
		$ptak = explode('-', $tglakhir);

		$data['tglawal'] = $ptaw[2].'-'.$ptaw[1].'-'.$ptaw[0];
		$data['tglakhir'] = $ptak[2].'-'.$ptak[1].'-'.$ptak[0];

		$ctaa = strtotime($tglawal)	;
		$ctak = strtotime($tglakhir);
		if ($ctaa>$ctak) {
			$this->session->set_flashdata('pesan','Tanggal awal tidak boleh lebih besar dari tanggal akhir');
			redirect('user/bo/cari_laporan_transaksi');
		}else{


		$data['transaksi'] = $this->db->query("SELECT * from transaksi where tgl_transaksi between '$tglawal' and '$tglakhir'")->result_array();
		$data['jtransaksi'] = $this->db->query("SELECT * from transaksi where tgl_transaksi between '$tglawal' and '$tglakhir'")->num_rows();
		
		$this->load->view('konten/laporan_transaksi/hasilcari_print', $data);
		}

	
	}
	
	
	
}
