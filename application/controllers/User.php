<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
        $data['judul'] = 'User';
        $data['konten'] = $this->load->view('admin/user', $data, true);
		$this->load->view('template/index', $data);
	}
	
	public function load_user_type() {
		$query = $this->db->query("SELECT * FROM user_type WHERE status_delete = 0")->result();
		$response = [];
		$search = $this->input->get("q", true);
		foreach($query as $value) {
			if (strlen($search)>0) {
				if(strpos(strtolower($value->nama),strtolower($search)) !== false){
					$response["user_type"][] = [
						"id" => $value->id_user_type,
						"text" => $value->nama
					];
				}
			}else{
				$response["user_type"][] = [
					"id" => $value->id_user_type,
					"text" => $value->nama
				];
			}
		}
		$response['pagination'] = ["more" => true];
		echo json_encode($response);
	}
    
    public function load_data() {
	$select = "a.*, b.nama as type";
	//LIMIT
	$limit = array(
		'start'  => $this->input->get('start'),
		'finish' => $this->input->get('length')
	);
	//WHERE LIKE
	$where_like['data'][] = array(
		'column' => 'a.nama',
		'param'	 => $this->input->get('search[value]')
	);
	//ORDER
	$index_order = $this->input->get('order[0][column]');
	$order['data'][] = array(
		'column' => $this->input->get('columns['.$index_order.'][name]'),
		'type'	 => $this->input->get('order[0][dir]')
	);

	$join['data'][] = array(
		'table' => 'user_type b',
		'join'	=> 'b.id_user_type=a.user_type',
		'type'	=> 'left'
	);

	$where['data'][]=array(
		'column'	=>'a.status_delete',
		'param'		=>0
		);		

	$query_total = $this->Modelku->select($select,'user a',NULL,NULL,NULL,$join,$where);
	$query_filter = $this->Modelku->select($select,'user a',NULL,$where_like,$order,$join,$where);
	$query = $this->Modelku->select($select,'user a',$limit,$where_like,$order,$join,$where);
	$response['data'] = array();
	if ($query<>false) {
		$no = $limit['start']+1;
		foreach ($query->result() as $val) {
			if ($val->id_user>0) {
				$edit = '<button class="btn btn-circle btn-sm btn-success" type="button" onclick="edit_data('.$val->id_user.')"><i class="fas fa-edit"></i></button>';
				$delete = '<button class="btn btn-circle btn-sm btn-danger" type="button" onclick="delete_data('.$val->id_user.')"><i class="fas fa-trash"></i></button>';
				if($val->status_approve == 0) {
					$status_approve = '<span class="btn btn-danger" onclick="approve('.$val->id_user.', 0)">Approve</span>';
				} else {
					$status_approve = '<span class="btn btn-success" onclick="approve('.$val->id_user.', 1)">Approve</span>';
				}
				$response['data'][] = array(
					$no,
					$val->nama,
					$val->username,
					$val->nomor_wa,
					$val->type,
					$status_approve,
					$delete
				);
				$no++;	
			}
		}
	}

	$response['recordsTotal'] = 0;
	if ($query_total<>false) {
		$response['recordsTotal'] = $query_total->num_rows();
	}
	$response['recordsFiltered'] = 0;
	if ($query_filter<>false) {
		$response['recordsFiltered'] = $query_filter->num_rows();
	}

	echo json_encode($response);
	}
	
	public function approve() {
		$id_user = $this->input->post('id_user');
		$sts = $this->input->post('sts');

		if ($sts == 0) {
			$data['status_approve']  = 1;
			$where = [
				'id_user' => $id_user
			];

			$update = $this->Modelku->update('user', $data, $where);
			if ($update<>false) {
				$response['title'] = 'Berhasil Disetujui';
				$response['status'] = '200';
				$response['message'] = 'Akun telah Di setujui';
			} else {
				$response['status'] = '201';
				$response['message'] = 'Akun gagal Di setujui';
			}
		} else {
			$response['title'] = 'Akun Sudah Disetujui';
			$response['status'] = '200';
			$response['message'] = 'Akun telah Di setujui';
		}
		echo json_encode($response);
	}

	public function delete_data($id_user) {
		$data['status_delete'] = 1;
		$where = [
			'id_user' => $id_user
		];
		$delete = $this->Modelku->update('user', $data, $where);
		if($delete<>false) {
			$response['status'] = '200';
			$response['title'] = 'Data telah berhasil dihapus';
			$response['message'] = 'Data ini tidak akan dapat dipulihkan';
		} else {
			$response['status'] = '201';
			$response['message'] = 'Data gagal dihapus';
		}

		echo json_encode($response);
	}
}
