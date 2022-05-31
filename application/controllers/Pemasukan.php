<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemasukan extends CI_Controller {

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
        $data['judul'] = 'Pemasukan';
        $data['konten'] = $this->load->view('admin/pemasukan', $data, true);
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
		'column' => 'a.kode, b.nama',
		'param'	 => $this->input->get('search[value]')
	);
	//ORDER
	$index_order = $this->input->get('order[0][column]');
	$order['data'][] = array(
		'column' => $this->input->get('columns['.$index_order.'][name]'),
		'type'	 => $this->input->get('order[0][dir]')
	);

	$join['data'][] = array(
		'table' => 'm_pemasukan b',
		'join'	=> 'b.id=a.idm_pemasukan',
		'type'	=> 'left'
	);

	$where['data'][]=array(
		'column'	=>'a.status_delete',
		'param'		=>0
	);

	$query_total = $this->Modelku->select($select,'pemasukan a',NULL,NULL,NULL,$join,$where);
	$query_filter = $this->Modelku->select($select,'pemasukan a',NULL,$where_like,$order,$join,$where);
	$query = $this->Modelku->select($select,'pemasukan a',$limit,$where_like,$order,$join,$where);
	$response['data'] = array();
	if ($query<>false) {
		$no = $limit['start']+1;
		foreach ($query->result() as $val) {
			if ($val->id>0) {
                $edit = '';
                $delete = '';
                if($val->idm_pemasukan !=1) {
                    $edit = '<button class="btn btn-circle btn-sm btn-success" type="button" onclick="edit_data('.$val->id.')"><i class="fas fa-edit"></i></button>';
                    $delete = '<button class="btn btn-circle btn-sm btn-danger" type="button" onclick="delete_data('.$val->id.')"><i class="fas fa-trash"></i></button>';
                }
				
				$response['data'][] = array(
                    $no,
                    $val->kode,
                    $val->nama,
                    $val->tanggal,
                    "Rp. ".number_format($val->jumlah, 0, ',', '.'),
                    $val->operator,
                    $edit." ".$delete
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

    public function tambah() {
        if($this->input->post('id') > 0) {
            $data = $this->general_input_post();
            // $data['kode'] = $this->_get_code();
            $where = [
                'id' => $this->input->post('id')
            ];
            $update = $this->Modelku->update('pemasukan', $data, $where);
            if($update<>false) {
                $response['status'] = '200';
                $response['message'] = 'Data berhasil di update';
            } else {
                $response['status'] = '202';
                $response['message'] = 'gagal update data';
            }
        } else {
            $data = $this->general_input_post();
            $data['kode'] = $this->_get_code();
            $insert = $this->db->insert('pemasukan', $data);
            if($insert<>false) {
                $response['status'] = '200';
                $response['message'] = 'Berhasil menambahkan data';
            } else {
                $response['status'] = '202';
                $response['message'] = 'gagal tambah data';
            }
        }
        

        echo json_encode($response);
    }

    function general_input_post() {
        $data = [
            'idm_pemasukan' => $this->input->post('idm_pemasukan'),
            'tanggal' => $this->input->post('tanggal'),
            'jumlah' => $this->_convert($this->input->post('jumlah')),
            'operator' => $this->session->userdata("username"),
        ];

        return $data;
    }
    public function _convert($angka) {
        $angka_str = preg_replace("/[^0-9]/", "", $angka);
        return (int) $angka_str;
    }
    public function _get_code()
    {
        $bln = date('m');
        $thn = date('y');
        $query =  $this->db->query("SELECT CAST(MID(kode, 10, 4) AS UNSIGNED) AS ids FROM pemasukan WHERE kode LIKE CONCAT('PMS/', '$thn', '$bln', '/', '%') ORDER BY kode DESC LIMIT 1")->row();
        if ($query) {
            if ($query->ids<9) {
                $nomor = $query->ids+1;
                $seq = '000'.$nomor;
            } elseif ($query->ids<99) {
                $nomor = $query->ids+1;
                $seq = '00'.$nomor;
            } elseif ($query->ids<999) {
                $nomor = $query->ids+1;
                $seq = '0'.$nomor;
            } else {
                $nomor = $query->ids+1;
                $seq = $nomor;
            }
        } else {
            $seq = '0001';
        }
        return "PMS/".$thn.$bln."/".$seq;
    }

	public function edit_data($id) {
		$query = $this->db->query("SELECT a.*, b.nama FROM pemasukan a LEFT JOIN m_pemasukan b ON b.id=a.idm_pemasukan WHERE a.id = $id AND a.status_delete = 0")->row();
        $response['value'] = [
            'id' => $query->id,
            'idm_pemasukan' => $query->idm_pemasukan,
            'kode' => $query->kode,
			'tanggal' => $query->tanggal,
			'jumlah' => $query->jumlah,
			'operator' => $query->operator,
			'nama' => $query->nama,
        ];

        echo json_encode($response);
	}

	public function delete_data($id) {
		$data['status_delete'] = 1;
		$where = [
			'id' => $id
		];
		$delete = $this->Modelku->update('pemasukan', $data, $where);
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
    public function get_select_jenis()
    {
        $this->db->select("a.id, CONCAT(a.nama) as text");
        $this->db->where("a.status_delete", 0);
        $this->db->where("a.id != 1");
        $this->db->like("CONCAT_WS(' ', a.nama)", $this->input->get('q'));
        $this->db->limit(50);
        $response["items"] = $this->db->get("m_pemasukan a")->result();
        
        echo json_encode($response);
    }

}
