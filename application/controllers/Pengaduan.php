<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaduan extends CI_Controller {

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
        $data['judul'] = 'Pengaduan';
        $data['konten'] = $this->load->view('admin/pengaduan', $data, true);
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
		'column' => 'b.nama, a.text',
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

	$query_total = $this->Modelku->select($select,'pengaduan a',NULL,NULL,NULL,$join,NULL);
	$query_filter = $this->Modelku->select($select,'pengaduan a',NULL,$where_like,$order,$join,NULL);
	$query = $this->Modelku->select($select,'pengaduan a',$limit,$where_like,$order,$join,NULL);
	$response['data'] = array();
	if ($query<>false) {
		$no = $limit['start']+1;
		foreach ($query->result() as $val) {
			if ($val->id>0) {
                $image = '';
				if($val->image != '') {
                    $image = '<a class="venobox" data-gall="slideGallery" title="slide '.$no.'" href="'.base_url('assets/image/pengaduan/').$val->image.'"><img src="'.base_url('assets/image/pengaduan/').$val->image.'" alt="image alt" width="100%"></a>';
                }
                
				$response['data'][] = array(
                    $no,
                    $val->nama,
                    $val->tanggal,
                    $val->text,
                    $image,
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
}
