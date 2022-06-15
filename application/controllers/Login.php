<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		//$this->load->model("Master_model");
	}
	public function index()
	{
		if($this->session->userdata("id_user")) { 
			redirect(base_url('Welcome/admin'));
		} else {
			$this->load->view('login/login.php');
		}
	}

	public function register()
	{
		$this->load->view('login/register.php');
	}

	public function forgot()
	{
		$this->load->view('login/forgot.php');
	}

	public function daftar() {
		$username = $this->input->post('username', true);
		$nomor_wa = $this->input->post('nomor_wa', true);
		$query = $this->db->query("SELECT id_user FROM user WHERE username = '$username' AND status_delete = 0")->row();
		if(!$query) {
			$query2 = $this->db->query("SELECT id_user FROM user WHERE nomor_wa = '$nomor_wa' AND status_delete = 0")->row();
			if (!$query2) {
				$dataAkun = array(
					'nama' => $this->input->post('nama'),
					'username' => $this->input->post('username'),
					'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
					'nomor_wa' => $this->input->post('nomor_wa'),
					'user_type' => $this->input->post('user_type'),
					'image' => 'no-image.svg',
					'status_approve' => 0
				);
				$this->db->insert('user', $dataAkun);
				$response['status'] = '200';
			} else {
				$response['status'] = '202';
			}
		} else {
			$response['status'] = '201';
		}

		echo json_encode($response);
	}

	public function masuk() {
		$username = $this->input->post("username", TRUE);
		$password = $this->input->post("password", TRUE);
        $this->db->select('*');
        $this->db->where('username', $username);
        $this->db->where('status_delete', 0);
        $users = $this->db->get('user')->row();
		// $users = $this->db->query("SELECT * FROM user WHERE username = '$username' AND status_delete = 0")->row();
		
		if ($users) {
			if(password_verify($password, $users->password)) {
			// if ($password == $users->password) {
				if($users->status_approve == 1) {
					$userdata = [
						"id_user" => $users->id_user,
						"nama" => $users->nama,
						"username" => $users->username,
						"user_type" => $users->user_type
					];
					// set session data
					$this->session->set_userdata($userdata);
					$response['user_type'] = $users->user_type;
					$response["status"] = "200";
					$response["message"] = "Login Berhasil";
				} else {
					$response["status"] = "201";
					$response["message"] = "Akun anda belum di setujui! Silahkan tunggu persetujuan";	
				}
			}else{
				$response["status"] = "202";
				$response["message"] = "Password yang anda masukkan salah!";
			}
		}else{
			$response["status"] = "401";
			$response["message"] = "Username tidak ditemukan!";
		}
		echo json_encode($response);
	}

	public function logout() {
		$userdata = ["id_user", "nama"];
		$logout = $this->session->unset_userdata($userdata);
		redirect(base_url('login'));
	}

	public function lupa_password() {
		$no_wa = $this->input->post("no_wa");
		$this->db->select("id_user");
		$this->db->where("nomor_wa", $no_wa);
		$this->db->where("status_delete", 0);
		$user = $this->db->get("user")->row();
		if($user) {
			$this->db->insert("lupa_password", [
				"id_user" => $user->id_user,
				"tanggal" => date("Y-m-d"),
				"no_wa" => $no_wa
			]);

			$response['status'] = 200;
		} else {
			$response['status'] = 202;
			$response['message'] = "nomor tidak ditemukan, pastikan dengan benar";
		}


		echo json_encode($response);
	}
}
