<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cs extends CI_Controller {
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

		$data['nasabah'] = $this->db->get('nasabah')->result_array();
		$data['jnasabah'] = $this->db->get('nasabah')->num_rows();
		$this->load->view('nav',  $data);
		$this->load->view('konten/nasabah/data_nasabah', $data);
	}
	public function tambahnasabah()
	{
		$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;

	
		$this->load->view('nav',  $data);
		$this->load->view('konten/nasabah/tambah_nasabah');
	}
	public function editnasabah($id)
	{
		$data['login'] = $this->login;
		$data['nama'] = $this->nama;
		$data['level'] = $this->level;

		$data['nasabah'] = $this->db->get_where('nasabah', array('id_nasabah'=>$id))->row_array();
		$this->load->view('nav',  $data);
		$this->load->view('konten/nasabah/edit_nasabah', $data);
	}
	public function hapusnasabah($id){
		$this->db->delete('nasabah', array('id_nasabah'=>$id));
		redirect('user/cs');
	}

	public function simpan_nasabah()
	{

		$nama = $this->input->post('nama');
		$alamat = $this->input->post('alamat');
		$nohp = $this->input->post('nohp');

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
			'nohp'=>$nohp,
			'no_rekening'=>$no,
			'status'=>"Calon Nasabah"

		];

		$this->db->insert('nasabah', $data);
		redirect('user/cs');
	
	}
	public function simpanedit_nasabah()
	{

		$nama = $this->input->post('nama');
		$alamat = $this->input->post('alamat');
		$nohp = $this->input->post('nohp');
		$id = $this->input->post('id');

		$q = $this->db->query("SELECT max(id_nasabah) as last from nasabah")->row_array();
		$last = $q['last'];

		if ($last==0) {
			$no = '002-'.'001-'.date('ymd').'-'.date('his');
		}
		elseif ($last>=0 and $last <10) {
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

		$this->db->update('nasabah', $data, array('id_nasabah'=>$id));
		redirect('user/cs');
	
	}
	
	
}
