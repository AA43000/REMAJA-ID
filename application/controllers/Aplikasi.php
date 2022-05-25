<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aplikasi extends CI_Controller {

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
        $data['judul'] = 'Aplikasi';
        $data['konten'] = $this->load->view('admin/aplikasi', $data, true);
		$this->load->view('template/index', $data);
	}
    
    public function load_data() {
	$select = "a.*";
	//LIMIT
	$limit = array(
		'start'  => $this->input->get('start'),
		'finish' => $this->input->get('length')
	);
	//WHERE LIKE
	$where_like['data'][] = array(
		'column' => 'a.nama_aplikasi',
		'param'	 => $this->input->get('search[value]')
	);
	//ORDER
	$index_order = $this->input->get('order[0][column]');
	$order['data'][] = array(
		'column' => $this->input->get('columns['.$index_order.'][name]'),
		'type'	 => $this->input->get('order[0][dir]')
	);

	// $join['data'][] = array(
	// 	'table' => 'user_type b',
	// 	'join'	=> 'b.id_user_type=a.user_type',
	// 	'type'	=> 'left'
	// );

	// $where['data'][]=array(
	// 	'column'	=>'a.status_delete',
	// 	'param'		=>0
	// 	);		

	$query_total = $this->Modelku->select($select,'aplikasi a',NULL,NULL,NULL,NULL,NULL);
	$query_filter = $this->Modelku->select($select,'aplikasi a',NULL,$where_like,$order,NULL,NULL);
	$query = $this->Modelku->select($select,'aplikasi a',$limit,$where_like,$order,NULL,NULL);
	$response['data'] = array();
	if ($query<>false) {
		$no = $limit['start']+1;
		foreach ($query->result() as $val) {
			if ($val->id_aplikasi>0) {
				if($val->slide == 0) {
					$slide = '<span class="btn btn-danger" onclick="approve('.$val->id_aplikasi.', 0, 1)">tampil</span>';
				} else {
					$slide = '<span class="btn btn-success" onclick="approve('.$val->id_aplikasi.', 1, 1)">tampil</span>';
                }
                if($val->about == 0) {
					$about = '<span class="btn btn-danger" onclick="approve('.$val->id_aplikasi.', 0, 2)">tampil</span>';
				} else {
					$about = '<span class="btn btn-success" onclick="approve('.$val->id_aplikasi.', 1, 2)">tampil</span>';
                }
                if($val->service == 0) {
					$service = '<span class="btn btn-danger" onclick="approve('.$val->id_aplikasi.', 0, 3)">tampil</span>';
				} else {
					$service = '<span class="btn btn-success" onclick="approve('.$val->id_aplikasi.', 1, 3)">tampil</span>';
                }
                if($val->portfolio == 0) {
					$portfolio = '<span class="btn btn-danger" onclick="approve('.$val->id_aplikasi.', 0, 4)">tampil</span>';
				} else {
					$portfolio = '<span class="btn btn-success" onclick="approve('.$val->id_aplikasi.', 1, 4)">tampil</span>';
                }
                if($val->team == 0) {
					$team = '<span class="btn btn-danger" onclick="approve('.$val->id_aplikasi.', 0, 5)">tampil</span>';
				} else {
					$team = '<span class="btn btn-success" onclick="approve('.$val->id_aplikasi.', 1, 5)">tampil</span>';
                }
                if($val->contact_us == 0) {
					$contact_us = '<span class="btn btn-danger" onclick="approve('.$val->id_aplikasi.', 0, 6)">tampil</span>';
				} else {
					$contact_us = '<span class="btn btn-success" onclick="approve('.$val->id_aplikasi.', 1, 6)">tampil</span>';
				}
				$response['data'][] = array(
                    $no,
                    $val->nama_aplikasi,
                    $slide,
                    $about,
                    $service,
                    $portfolio,
                    $team,
                    $contact_us
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
		$id_aplikasi = $this->input->post('id_aplikasi');
        $sts = $this->input->post('sts');
        $column = $this->input->post('column');
        if($column == 1) {
            $kolom = 'slide';
        } else if($column == 2) {
            $kolom = 'about';
        } else if($column == 3) {
            $kolom = 'service';
        } else if($column == 4) {
            $kolom = 'portfolio';
        } else if($column == 5) {
            $kolom = 'team';
        } else if($column == 6) {
            $kolom = 'contact_us';
        }

		if ($sts == 0) {
			$data[$kolom]  = 1;
			$where = [
				'id_aplikasi' => $id_aplikasi
			];

			$update = $this->Modelku->update('aplikasi', $data, $where);
			if ($update<>false) {
				$response['title'] = 'Berhasil';
				$response['status'] = '200';
				$response['message'] = $kolom.' telah ditampilkan';
			} else {
				$response['status'] = '201';
				$response['message'] = 'Akun gagal Di tampilkan';
			}
		} else {
			$data[$kolom]  = 0;
			$where = [
				'id_aplikasi' => $id_aplikasi
			];

			$update = $this->Modelku->update('aplikasi', $data, $where);
			if ($update<>false) {
				$response['title'] = 'Berhasil';
				$response['status'] = '200';
				$response['message'] = $kolom.' telah sembunyikan';
			} else {
				$response['status'] = '201';
				$response['message'] = 'Akun gagal Di sembunyikan';
			}
		}
		echo json_encode($response);
	}
}
