<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index()
	{
		$this->load->view('nav');
		$this->load->view('konten/home');
	}
	public function login()
	{
		$this->load->view('nav');
		$this->load->view('konten/login/login');
	}
	public function cek_login()
	{

		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$level = $this->input->post('level');
		$query = "SELECT * from user where username='$username' and password='$password' and level='$level'";
		$ketemu = $this->db->query($query)->num_rows();
		$data = $this->db->query($query)->row_array();

		if ($ketemu>0) {
			$this->session->set_userdata('login', true);
			$this->session->set_userdata('level', $data['level']);
			$this->session->set_userdata('nama', $data['nama']);
			if($data['level']=="CS"){
				redirect('user/cs');
			}
			elseif($data['level']=="BO"){
				redirect('user/bo');
			}else{
				redirect('user/teller');
			}
			
		}else{
			$this->session->set_flashdata('pesan','Data anda tidak ditemukan <br>Silahkan coba lagi dengan username dan pasword yag benar');
			redirect('home/login');
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('home');
	}
}
