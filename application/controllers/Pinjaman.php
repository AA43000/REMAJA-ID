<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pinjaman extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata("id_user")) {
            if($this->session->userdata("user_type") == 1 || $this->session->userdata("user_type") == 3) {

            } else {
                redirect(base_url('welcome/admin'));
            }
        } else {
            redirect(base_url('login'));
        }
	}
	public function index()
	{
        $data['judul'] = 'Data Pinjaman';
        $data['konten'] = $this->load->view('admin/pinjaman', $data, true);
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
		'column' => 'a.nama_peminjam, b.nama',
		'param'	 => $this->input->get('search[value]')
	);
	//ORDER
	$index_order = $this->input->get('order[0][column]');
	$order['data'][] = array(
		'column' => $this->input->get('columns['.$index_order.'][name]'),
		'type'	 => $this->input->get('order[0][dir]')
	);

	$join['data'][] = array(
		'table' => 'unit b',
		'join'	=> 'b.id=a.id_unit',
		'type'	=> 'left'
	);

	$where['data'][]=array(
		'column'	=>'a.status_delete',
		'param'		=>0
		);		

	$query_total = $this->Modelku->select($select,'pinjaman a',NULL,NULL,NULL,$join,$where);
	$query_filter = $this->Modelku->select($select,'pinjaman a',NULL,$where_like,$order,$join,$where);
	$query = $this->Modelku->select($select,'pinjaman a',$limit,$where_like,$order,$join,$where);
	$response['data'] = array();
	if ($query<>false) {
		$no = $limit['start']+1;
		foreach ($query->result() as $val) {
			if ($val->id>0) {
				$edit = '<button class="btn btn-circle btn-sm btn-success" type="button" onclick="edit_data('.$val->id.')"><i class="fas fa-edit"></i></button>';
				$delete = '<button class="btn btn-circle btn-sm btn-danger" type="button" onclick="delete_data('.$val->id.')"><i class="fas fa-trash"></i></button>';
				$color = 'btn-success';
				$text = 'sudah';
				if($val->status != 1) {
					$text = 'belum';
					$color = 'btn-danger';
				}
				$sts = '<button class="btn '.$color.'" type="button" onclick="update_sts('.$val->id.')">'.$text.' dikembalikan</button>';
				
				$response['data'][] = array(
                    $no,
                    $val->nama_peminjam,
                    $val->nama,
                    $val->no_hp,
                    $val->jumlah,
                    $val->tanggal,
                    $val->keterangan,
                    $sts,
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
	public function cek_stok($id_unit, $jumlah, $id=0) {
		$this->db->select("stok, dipinjam");
		$this->db->where("id", $id_unit);
		$query = $this->db->get("unit")->row();

		$pinjam = 0;
		if($id > 0) {
			$this->db->select("jumlah");
			$this->db->where("id", $id);
			$query2 = $this->db->get("pinjaman")->row();
			if($query) {
				$pinjam = $query2->jumlah;
			}
		}

		$result = false;
		if($query) {
			if(($query->stok - ($query->dipinjam - $pinjam)) >= $jumlah) {
				$this->db->update("unit", [
					"dipinjam" => ($query->dipinjam - $pinjam) + $jumlah
				], [
					"id" => $id_unit
				]);
				$result = true;
			}
		}

		return $result;
	}

    public function tambah() {
		if($this->cek_stok($this->input->post("id_unit"), $this->input->post("jumlah"), $this->input->post('id'))) {
			if($this->input->post('id') > 0) {
				$data = $this->general_input_post();
				$where = [
					'id' => $this->input->post('id')
				];
				$update = $this->Modelku->update('pinjaman', $data, $where);
				if($update<>false) {
					$response['status'] = '200';
					$response['message'] = 'Data berhasil di update';
				} else {
					$response['status'] = '202';
					$response['message'] = 'gagal update data';
				}
			} else {
				$data = $this->general_input_post();
				$insert = $this->db->insert('pinjaman', $data);
				if($insert<>false) {
					$response['status'] = '200';
					$response['message'] = 'Berhasil menambahkan data';
				} else {
					$response['status'] = '202';
					$response['message'] = 'gagal tambah data';
				}
			}
		} else {
			$response['status'] = '202';
			$response['message'] = 'Stok tidak mencukupi';
		}
        

        echo json_encode($response);
    }

    function general_input_post() {
        $data = [
            'nama_peminjam' => $this->input->post('nama_peminjam'),
            'id_unit' => $this->input->post('id_unit'),
            'jumlah' => $this->input->post('jumlah'),
            'tanggal' => $this->input->post('tanggal'),
            'no_hp' => $this->input->post('no_hp'),
            'keterangan' => $this->input->post('keterangan'),
        ];

        return $data;
    }

	public function edit_data($id) {
		$query = $this->db->query("SELECT a.*, b.nama FROM pinjaman a LEFT JOIN unit b ON b.id=a.id_unit WHERE a.id = $id")->row();
        $response['value'] = [
            'id' => $query->id,
            'nama_peminjam' => $query->nama_peminjam,
			'id_unit' => $query->id_unit,
			'nama' => $query->nama,
			'jumlah' => $query->jumlah,
			'tanggal' => $query->tanggal,
			'no_hp' => $query->no_hp,
			'keterangan' => $query->keterangan			
        ];

        echo json_encode($response);
	}

	public function delete_data($id) {
		$data['status_delete'] = 1;
		$where = [
			'id' => $id
		];
		$delete = $this->Modelku->update('pinjaman', $data, $where);
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
	
	public function get_select_unit()
    {
        $this->db->select("a.id, CONCAT(a.nama) as text");
        $this->db->where("a.status_delete", 0);
        $this->db->like("CONCAT_WS(' ', a.nama)", $this->input->get('q'));
        $this->db->limit(50);
        $response["items"] = $this->db->get("unit a")->result();
        
        echo json_encode($response);
	}
	public function update_sts($id) {
		$this->db->select("a.jumlah, b.dipinjam, a.id_unit, a.status");
		$this->db->join("unit b", "b.id=a.id_unit", "left");
		$this->db->where("a.id", $id);
		$query = $this->db->get("pinjaman a")->row();
		
		$status = 1;
		$dipinjam = $query->dipinjam - $query->jumlah;
		if($query->status == 1) {
			$status = 0;
			$dipinjam = $query->dipinjam + $query->jumlah;
		}
		$this->db->update("pinjaman", ["status" => $status], ["id" => $id]);
		
		$this->db->update("unit", ["dipinjam" => $dipinjam], ["id" => $query->id_unit]);

		echo json_encode(["status" => 200]);
	}

}
