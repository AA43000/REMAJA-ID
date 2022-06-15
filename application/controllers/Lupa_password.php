<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lupa_password extends CI_Controller {

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
        $data['judul'] = 'Lupa Password';
        $data['konten'] = $this->load->view('admin/lupa_password', $data, true);
		$this->load->view('template/index', $data);
	}
    public function load_data() {
	$select = "a.*, b.nama";
	//LIMIT
	$limit = array(
		'start'  => $this->input->get('start'),
		'finish' => $this->input->get('length')
	);
	//WHERE LIKE
	$where_like['data'][] = array(
		'column' => 'b.nama, a.no_wa',
		'param'	 => $this->input->get('search[value]')
	);
	//ORDER
	$index_order = $this->input->get('order[0][column]');
	$order['data'][] = array(
		'column' => $this->input->get('columns['.$index_order.'][name]'),
		'type'	 => $this->input->get('order[0][dir]')
	);

	$join['data'][] = array(
		'table' => 'user b',
		'join'	=> 'b.id_user=a.id_user',
		'type'	=> 'left'
	);

	// $where['data'][]=array(
	// 	'column'	=>'a.status_delete',
	// 	'param'		=>0
	// 	);		

	$query_total = $this->Modelku->select($select,'lupa_password a',NULL,NULL,NULL,$join,NULL);
	$query_filter = $this->Modelku->select($select,'lupa_password a',NULL,$where_like,$order,$join,NULL);
	$query = $this->Modelku->select($select,'lupa_password a',$limit,$where_like,$order,$join,NULL);
	$response['data'] = array();
	if ($query<>false) {
		$no = $limit['start']+1;
		foreach ($query->result() as $val) {
			if ($val->id>0) {
				if($val->status_kirim == 1) {
					$status_kirim = '<span class="btn btn-warning" onclick="kirim('.$val->id.', 0)">Kirim Ulang</span>';
				} else {
					$status_kirim = '<span class="btn btn-success" onclick="kirim('.$val->id.', 1)">Kirim</span>';
				}
				$response['data'][] = array(
					$no,
					$val->nama,
                    $val->no_wa,
                    $val->tanggal,
					$status_kirim
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
	
	public function kirim() {
        $id = $this->input->post('id');
        $sts = $this->input->post('sts');
        
        $this->db->select("id_user, password_baru, no_wa");
        $this->db->where("id", $id);
        $query = $this->db->get("lupa_password")->row();
        if($sts == 1) {
    
            $this->db->select("id_user");
            $this->db->where("id_user", $query->id_user);
            $this->db->where("status_delete", 0);
            $user = $this->db->get("user")->row();
    
            if ($user) {
                $password_baru = time();
                $this->db->update("lupa_password", [
                    "status_kirim" => 1,
                    "password_baru" => $password_baru
                ], [
                    "id" => $id
                ]);
                $this->db->update("user", [
                    "password" => password_hash($password_baru, PASSWORD_BCRYPT)
                ], [
                    "id_user" => $query->id_user
                ]);
    
                $response['password'] = $password_baru;
                $response['no_wa'] = $query->no_wa;
                $response['status'] = '200';
            } else {
                $response['status'] = '201';
                $response['message'] = 'Akun Telah tidak aktif';
            }
        } else {
            $response['status'] = '200';
            $response['password'] = $query->password_baru;
            $response['no_wa'] = $query->no_wa;
        }
		echo json_encode($response);
	}
}
