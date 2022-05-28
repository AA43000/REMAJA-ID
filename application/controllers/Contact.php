<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

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
		if ($this->session->userdata("id_user")) {
            if($this->session->userdata("user_type") == 1) {

            } else {
                redirect(base_url('welcome/admin'));
            }
        } else {
            redirect(base_url('login'));
        }
	}
	public function index()
	{
        $data['judul'] = 'Contact Us';
        $data['konten'] = $this->load->view('admin/contact', $data, true);
		$this->load->view('template/index', $data);
	}
	
	public function load_data_utama() {
		$val = $this->db->query("SELECT * FROM contact WHERE id_contact = 1")->row();
		
		$response['data'][] = array(
			$val->alamat,
			$val->no_telp,
			$val->email,
		);
	
		$response['recordsTotal'] = 1;
		$response['recordsFiltered'] = 1;
	
		echo json_encode($response);
	}

	public function load_contact() {
		$val = $this->db->query("SELECT * FROM contact WHERE id_contact = 1")->row();

		$data = array(
			'alamat' => $val->alamat,
			'no_telp' => $val->no_telp,
			'email' => $val->email
		);

		echo json_encode($data);
	}

	public function update() {
		$data = array(
			'alamat' => $this->input->post('alamat'),
			'no_telp' => $this->input->post('no_telp'),
			'email' => $this->input->post('email'),
		);

		$where = [
			'id_contact' => 1
		];
		$update = $this->Modelku->update('contact', $data, $where);

		if($update<>false) {
			$response['status'] = '200';
			$response['message'] = 'data berhasil diupdate';
		} else {
			$response['status'] = '202';
			$response['message'] = 'data gagal di update';
		}

		echo json_encode($response);

	}

}
