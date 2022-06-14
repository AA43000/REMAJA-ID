<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran extends CI_Controller {

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
            if($this->session->userdata("user_type") == 1 || $this->session->userdata("user_type") == 2) {

            } else {
                redirect(base_url('welcome/admin'));
            }
        } else {
            redirect(base_url('login'));
        }
	}
	public function index()
	{
        $data['judul'] = 'Pengeluaran';
        $data['konten'] = $this->load->view('admin/pengeluaran', $data, true);
		$this->load->view('template/index', $data);
	}
    
    public function load_data($jenis, $tanggal_awal, $tanggal_akhir) {
        $request = (object) [
            "like" => $this->input->get("search[value]", true),
            "order" => (object) [
                "column" => $this->input->get('columns['.$this->input->get('order[0][column]').'][name]'),
                "type" => $this->input->get('order[0][dir]')
            ],
            "limit" => (object) [
                "start" => $this->input->get("start", true),
                "length" => $this->input->get("length", true)
            ]
        ];
        $this->db->select("a.*, b.nama");
        $this->db->join("m_pengeluaran b", "b.id=a.idm_pengeluaran", "left");
        $this->db->order_by($request->order->column, $request->order->type);
        $this->db->where("a.status_delete", 0);
        if($jenis != 0) {
            $this->db->where("a.idm_pengeluaran", $jenis);
        }
        if($tanggal_awal != 0) {
            $this->db->where("a.tanggal >=", "$tanggal_awal");
        }
        if($tanggal_akhir != 0) {
            $this->db->where("a.tanggal <=", "$tanggal_akhir");
        }
        $this->db->where("a.status_delete", 0);
        $this->db->like("CONCAT_WS(' ', a.kode, b.nama)", $request->like, "both");
        if($request->limit->length>="0"){
            $this->db->limit($request->limit->length, $request->limit->start);
        }
        $query = $this->db->get("pengeluaran a");
        $response['data'] = array();
        if ($query<>false) {
            $no = $request->limit->start+1;
            foreach ($query->result() as $val) {
                if ($val->id>0) {
                    $edit = '<button class="btn btn-circle btn-sm btn-success" type="button" onclick="edit_data('.$val->id.')"><i class="fas fa-edit"></i></button>';
                    $delete = '<button class="btn btn-circle btn-sm btn-danger" type="button" onclick="delete_data('.$val->id.')"><i class="fas fa-trash"></i></button>';
                    
                    $response['data'][] = array(
                        $no,
                        $val->kode,
                        $val->nama,
                        $val->tanggal,
                        "Rp. ".number_format($val->jumlah, 0, ',', '.'),
                        $val->operator,
                        $val->keterangan,
                        $edit." ".$delete
                    );
                    $no++;	
                }
            }
        }
        $this->db->select("a.id");
        $this->db->join("m_pengeluaran b", "b.id=a.idm_pengeluaran", "left");
        $this->db->where("a.status_delete", 0);
        if($jenis != 0) {
            $this->db->where("a.idm_pengeluaran", $jenis);
        }
        if($tanggal_awal != 0) {
            $this->db->where("a.tanggal >=", "$tanggal_awal");
        }
        if($tanggal_akhir != 0) {
            $this->db->where("a.tanggal <=", "$tanggal_akhir");
        }
        $this->db->like("CONCAT_WS(' ', a.kode, b.nama)", $request->like, "both");
        $response["recordsFiltered"] = $this->db->get("pengeluaran a")->num_rows();

        $this->db->select("a.id");
        $this->db->join("m_pengeluaran b", "b.id=a.idm_pengeluaran", "left");
        $this->db->where("a.status_delete", 0);
        if($jenis != 0) {
            $this->db->where("a.idm_pengeluaran", $jenis);
        }
        if($tanggal_awal != 0) {
            $this->db->where("a.tanggal >=", "$tanggal_awal");
        }
        if($tanggal_akhir != 0) {
            $this->db->where("a.tanggal <=", "$tanggal_akhir");
        }
        $response["recordsTotal"] = $this->db->get("pengeluaran a")->num_rows();
        $response["start"] = $this->input->get("start", true);

        echo json_encode($response);
	}

    public function tambah() {
        if($this->input->post('id') > 0) {
            $data = $this->general_input_post();
            // $data['kode'] = $this->_get_code();
            $where = [
                'id' => $this->input->post('id')
            ];
            $update = $this->Modelku->update('pengeluaran', $data, $where);
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
            $insert = $this->db->insert('pengeluaran', $data);
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
            'idm_pengeluaran' => $this->input->post('idm_pengeluaran'),
            'tanggal' => $this->input->post('tanggal'),
            'jumlah' => $this->_convert($this->input->post('jumlah')),
            'operator' => $this->session->userdata("username"),
            'keterangan' => $this->input->post('keterangan'),
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
        $query =  $this->db->query("SELECT CAST(MID(kode, 10, 4) AS UNSIGNED) AS ids FROM pengeluaran WHERE kode LIKE CONCAT('PNG/', '$thn', '$bln', '/', '%') ORDER BY kode DESC LIMIT 1")->row();
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
        return "PNG/".$thn.$bln."/".$seq;
    }

	public function edit_data($id) {
		$query = $this->db->query("SELECT a.*, b.nama FROM pengeluaran a LEFT JOIN m_pengeluaran b ON b.id=a.idm_pengeluaran WHERE a.id = $id AND a.status_delete = 0")->row();
        $response['value'] = [
            'id' => $query->id,
            'idm_pengeluaran' => $query->idm_pengeluaran,
            'kode' => $query->kode,
			'tanggal' => $query->tanggal,
			'jumlah' => $query->jumlah,
			'operator' => $query->operator,
			'keterangan' => $query->keterangan,
			'nama' => $query->nama,
        ];

        echo json_encode($response);
	}

	public function delete_data($id) {
		$data['status_delete'] = 1;
		$where = [
			'id' => $id
		];
		$delete = $this->Modelku->update('pengeluaran', $data, $where);
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
    public function get_select_jenis($sts = 0)
    {
        $this->db->select("a.id, CONCAT(a.nama) as text");
        $this->db->where("a.status_delete", 0);
        if($sts == 0){
            $this->db->where("a.id != 1");
        }
        $this->db->like("CONCAT_WS(' ', a.nama)", $this->input->get('q'));
        $this->db->limit(50);
        $response["items"] = $this->db->get("m_pengeluaran a")->result();
        
        echo json_encode($response);
    }

    public function print($tanggal_awal, $tanggal_akhir, $jenis) {
        $this->db->select("a.*, b.nama");
        $this->db->join("m_pengeluaran b", "b.id=a.idm_pengeluaran", "left");
        $this->db->where("a.status_delete", 0);
        if($tanggal_awal != 0) {
            $this->db->where("a.tanggal >=", "$tanggal_awal");
        }
        if($tanggal_akhir != 0) {
            $this->db->where("a.tanggal <=", "$tanggal_akhir");
        }
        if($jenis != 0) {
            $this->db->where("a.idm_pengeluaran", "$jenis");
        }
        $this->db->where("a.status_delete", 0);
        $data['data'] = $this->db->get("pengeluaran a")->result();
        $data['tanggal_awal'] = $tanggal_awal == 0 ? '00-00-0000' : date("d M Y", strtotime($tanggal_awal));
        $data['tanggal_akhir'] = $tanggal_akhir == 0 ? '00-00-0000' : date("d M Y", strtotime($tanggal_akhir));
        $data['judul'] = 'Pengeluaran';
        $this->load->view('admin/print/pengeluaran', $data);
    }

}
