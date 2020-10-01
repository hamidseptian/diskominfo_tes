<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teller extends CI_Controller {
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
		$this->load->view('konten/transaksi/data_nasabah', $data);
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
		$this->load->view('konten/transaksi/transaksi_nasabah', $data);
	}
	public function tambahnasabah()
	{
		$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;

	
		$this->load->view('nav',  $data);
		$this->load->view('konten/nasabah/tambah_nasabah');
	}


	public function simpan_setoran()
	{

		$idnas = $this->input->post('idnas');
		$setor = $this->input->post('setor');

		$tgl = date('Y-m-d');
		$jam = date('h:i:s');
	

		$data = [
			'id_nasabah'=>$idnas,
			'jumlah'=>$setor,
			'jenis'=>"Setoran",
			'tgl_transaksi'=>$tgl,
			'jam_transaksi'=>$jam
		];

		$cekstatus = $this->db->get_where('nasabah', array('id_nasabah'=>$idnas))->row_array();
		$status = $cekstatus['status'];
		if ($status=="Calon Nasabah") {
		$this->db->update('nasabah', ['status'=>'Nasabah'], ['id_nasabah'=>$idnas]);
		$this->db->insert('transaksi', $data);
		}else{

		$this->db->insert('transaksi', $data);
		}
		redirect('user/teller/data_transaksi/'.$idnas);
	
	}
	public function simpan_tarikan()
	{

		$idnas = $this->input->post('idnas');
		$tarik = $this->input->post('tarik');
		$saldo = $this->input->post('saldo');
		if ($tarik>$saldo) {
			$this->session->set_flashdata('pesan','Maaf<br>Saldo Anda tidak cukup<br>Maksimal anda biea melakukan penarikan adalah '.$saldo);
		redirect('user/teller/tarik/'.$idnas);
		}else{


		$tgl = date('Y-m-d');
		$jam = date('h:i:s');
	

		$data = [
			'id_nasabah'=>$idnas,
			'jumlah'=>$tarik,
			'jenis'=>"Penarikan",
			'tgl_transaksi'=>$tgl,
			'jam_transaksi'=>$jam
		];
		$this->db->insert('transaksi', $data);

		}
		redirect('user/teller/data_transaksi/'.$idnas);
	
	}
	public function simpan_transfer($id)
	{

		$idnas = $this->input->post('idnas');
		$transfer = $this->input->post('transfer');
		$saldo = $this->input->post('saldo');
		if ($transfer>$saldo) {
			$this->session->set_flashdata('pesan','Maaf<br>Saldo Anda tidak cukup<br>Maksimal anda biea melakukan penarikan adalah '.$saldo);
		redirect('user/teller/transfer/'.$id);
		}else{


		$tgl = date('Y-m-d');
		$jam = date('h:i:s');
	

		$data = [
			'id_nasabah'=>$id,
			'id_nasabah2'=>$idnas,
			'jumlah'=>$transfer,
			'jenis'=>"Transfer",
			'tgl_transaksi'=>$tgl,
			'jam_transaksi'=>$jam
		];
		$this->db->insert('transaksi', $data);
		$data2 = [
			'id_nasabah'=>$idnas,
			'id_nasabah2'=>$id,
			'jumlah'=>$transfer,
			'jenis'=>"Terima Transfer",
			'tgl_transaksi'=>$tgl,
			'jam_transaksi'=>$jam
		];
		$this->db->insert('transaksi', $data2);

		}
		redirect('user/teller/data_transaksi/'.$id);
	
	}
	public function simpanedit_nasabah()
	{

		$nama = $this->input->post('nama');
		$alamat = $this->input->post('alamat');
		$nohp = $this->input->post('nohp');
		$id = $this->input->post('id');

		$q = $this->db->query("SELECT max(id_nasabah) as last from nasabah")->row_array();
		$last = $q['last'];
		if ($last>=0 and $last <10) {
			$no = '002-'.'00'.$last.'-'.date('ymd').'-'.date('his');
		}
		else if ($last>=10 and $last <100) {
			$no = '002-'.'0'.$last.'-'.date('ymd').'-'.date('his');
		}else{
			$no = '002-'.$last.'-'.date('ymd').'-'.date('his');
		}

		$data = [
			'nama'=>$nama,
			'alamat'=>$alamat,
			'nohp'=>$nohp
			// 'no_rekening'=>$no
		];

		$this->db->update('nasabah', $data, array('id_nasabah'=>$idnasabah));
		redirect('user/cs');
	
	}
	
	
}
