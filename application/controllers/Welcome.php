<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	public function index()
	{	
		$data['slide'] = $this->db->query("SELECT * FROM slide WHERE status_delete = 0")->result();
		$data['aplikasi'] = $this->db->query("SELECT * FROM aplikasi WHERE id_aplikasi = 1")->row();
		$this->load->view('welcome_message', $data);
	}

	public function admin() {
		if($this->session->userdata("id_user")) { 
			$data['judul'] = 'Dashboard';
			$data['konten'] = $this->load->view('dashboard', $data, true);
			$this->load->view('template/index', $data);
		} else {
			redirect(base_url('login'));
		}
	}

	public function message() {
		$query = $this->db->query("SELECT email FROM contact")->row();
		$to = $query->email; // this is your Email address
		$from = $_POST['email']; // this is the sender's Email address
		$subject = $_POST['subject'];;
		$message = $_POST['message'];;

		$headers = "From:" . $from;
		mail($to,$subject,$message,$headers);
		echo "success";	
	}
}
