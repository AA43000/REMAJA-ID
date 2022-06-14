<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kas extends CI_Controller {

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
        $this->session->unset_userdata("session_kas");
        $data['judul'] = 'Kas';
        $data['konten'] = $this->load->view('admin/kas', $data, true);
		$this->load->view('template/index', $data);
    }
    public function detail($id = 0)
	{
        if($id != 0) {
            $query = $this->db->query("SELECT * FROM kas_detail WHERE id_kas = $id AND status_delete = 0")->result();
            $array = [];
            foreach($query as $row) {
                $array[$row->id_user] = [
                    "jumlah" => $row->jumlah,
                ];
            }
            $this->session->set_userdata("session_kas", $array);
        }
        $data['id'] = $id;
        $data['username'] = $this->session->userdata("username");
        $data['judul'] = 'Kas';
        $data['konten'] = $this->load->view('admin/detail/kas', $data, true);
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
            'column' => 'a.tanggal, a.operator',
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

        $where['data'][]=array(
            'column'	=>'a.status_delete',
            'param'		=>0
            );		

        $query_total = $this->Modelku->select($select,'kas a',NULL,NULL,NULL,NULL,$where);
        $query_filter = $this->Modelku->select($select,'kas a',NULL,$where_like,$order,NULL,$where);
        $query = $this->Modelku->select($select,'kas a',$limit,$where_like,$order,NULL,$where);
        $response['data'] = array();
        if ($query<>false) {
            $no = $limit['start']+1;
            foreach ($query->result() as $val) {
                if ($val->id>0) {
                    $edit = '<a href="'.base_url().'Kas/detail/'.$val->id.'"><button class="btn btn-circle btn-sm btn-success" type="button"><i class="fas fa-edit"></i></button></a>';
                    $delete = '<button class="btn btn-circle btn-sm btn-danger" type="button" onclick="delete_data('.$val->id.')"><i class="fas fa-trash"></i></button>';
                    
                    $response['data'][] = array(
                        $no,
                        '<a title="tekan kode untuk melihat detail" href="#" data-toggle="modal" data-target="#formModal" onclick="show_data('.$val->id.')">'.$val->kode.'</a>',
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
    
    public function load_detail($id) {
        $select = "a.*, b.nama";
        //LIMIT
        $limit = array(
            'start'  => $this->input->get('start'),
            'finish' => $this->input->get('length')
        );
        //WHERE LIKE
        $where_like['data'][] = array(
            'column' => 'b.nama',
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

        $where['data'][]=array(
            'column'	=>'a.status_delete',
            'param'		=>0
        );
        $where['data'][]=array(
            'column'	=>'a.id_kas',
            'param'		=>$id
        );

        $query_total = $this->Modelku->select($select,'kas_detail a',NULL,NULL,NULL,$join,$where);
        $query_filter = $this->Modelku->select($select,'kas_detail a',NULL,$where_like,$order,$join,$where);
        $query = $this->Modelku->select($select,'kas_detail a',$limit,$where_like,$order,$join,$where);
        $response['data'] = array();
        if ($query<>false) {
            $no = $limit['start']+1;
            foreach ($query->result() as $val) {
                if ($val->id>0) {
                    
                    $response['data'][] = array(
                        $no,
                        $val->nama,
                        $val->jumlah,
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
        if($this->cek_tanggal($this->input->post("id"), $this->input->post("tanggal")) == false) {
            if($this->input->post('id') > 0) {
                $data = $this->general_input_post();
                $where = [
                    'id' => $this->input->post('id')
                ];
                $update = $this->Modelku->update('kas', $data, $where);
                $id = $this->input->post('id');
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
                $insert = $this->db->insert('kas', $data);
                $id = $this->db->insert_id();
                if($insert<>false) {
                    $response['status'] = '200';
                    $response['message'] = 'Berhasil menambahkan data';
                } else {
                    $response['status'] = '202';
                    $response['message'] = 'gagal tambah data';
                }
            }
            $this->insert_detail($id, $this->input->post("tanggal"));
        } else {
            $response['status'] = '202';
            $response['message'] = 'gagal tambah data, kas ditanggal tersebut sudah tersedia';
        }
        

        echo json_encode($response);
    }
    public function cek_tanggal($id, $tanggal) {
        if($id > 0) {
            $cek = $this->db->query("SELECT id FROM kas WHERE tanggal = '$tanggal' AND id != $id AND status_delete = 0")->row();
        } else {
            $cek = $this->db->query("SELECT id FROM kas WHERE tanggal = '$tanggal' AND status_delete = 0")->row();
        }
        return $cek;
    }
    public function insert_detail($id, $tanggal) {
        $session = $this->session->userdata("session_kas");
        foreach($session as $key => $val) {
            $cek = $this->db->query("SELECT id FROM kas_detail WHERE id_kas = $id AND id_user = $key")->row();
            if($cek) {
                $this->db->update("kas_detail", [
                    "id_kas" => $id,
                    "id_user" => $key,
                    "jumlah" => $val['jumlah']
                ], [
                    "id" => $cek->id
                ]);    
            } else {
                $this->db->insert("kas_detail", [
                    "id_kas" => $id,
                    "id_user" => $key,
                    "jumlah" => $val['jumlah']
                ]);
            }
        }

        $cek = $this->db->query("SELECT id FROM pemasukan WHERE idm_pemasukan = 1 AND tanggal = '$tanggal'")->row();
        if($cek) {
            $this->db->update("pemasukan", [
                'idm_pemasukan' => 1,
                'tanggal' => $tanggal,
                'jumlah' => $this->_convert($this->input->post('jumlah')),
                'operator' => $this->session->userdata("username"),
            ], [
                'id' => $cek->id
            ]);
        } else {
            $this->db->insert("pemasukan", [
                'kode' => $this->_get_code2(),
                'idm_pemasukan' => 1,
                'tanggal' => $tanggal,
                'jumlah' => $this->_convert($this->input->post('jumlah')),
                'operator' => $this->session->userdata("username"),
            ]);
        }

        return true;
    }

    public function _get_code2()
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

    function general_input_post() {
        $data = [
            'tanggal' => $this->input->post('tanggal'),
            'jumlah' => $this->_convert($this->input->post('jumlah')),
            'operator' => $this->input->post('operator'),
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
        $query =  $this->db->query("SELECT CAST(MID(kode, 10, 4) AS UNSIGNED) AS ids FROM kas WHERE kode LIKE CONCAT('KAS/', '$thn', '$bln', '/', '%') ORDER BY kode DESC LIMIT 1")->row();
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
        return "KAS/".$thn.$bln."/".$seq;
    }

	public function edit_data($id) {
		$query = $this->db->query("SELECT * FROM kas WHERE id = $id AND status_delete = 0")->row();
        $response['value'] = [
            'id' => $query->id,
            'kode' => $query->kode,
			'tanggal' => $query->tanggal,
			'jumlah' => $query->jumlah,
			'operator' => $query->operator,
			
        ];

        echo json_encode($response);
	}

	public function delete_data($id) {
		$data['status_delete'] = 1;
		$where = [
			'id' => $id
        ];
        $where2 = [
			'id_kas' => $id
		];
        $this->Modelku->update('kas_detail', $data, $where2);
        $delete = $this->Modelku->update('kas', $data, $where);
        $this->db->select("b.id");
        $this->db->join("pemasukan b", "b.tanggal=a.tanggal", "left");
        $this->db->where("a.id", $id);
        $this->db->where("b.idm_pemasukan", 1);
        $cek = $this->db->get("kas a")->row();
        if($cek) {
            $this->db->update("pemasukan", $data, ["id" => $cek->id]);
        }
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

    public function load_anggota() {
        $select = "a.*";
        //LIMIT
        $limit = array(
            'start'  => $this->input->get('start'),
            'finish' => $this->input->get('length')
        );
        //WHERE LIKE
        $where_like['data'][] = array(
            'column' => 'a.nama, a.username',
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

        $where['data'][]=array(
            'column'	=>'a.status_delete',
            'param'		=>0
            );		

        $query_total = $this->Modelku->select($select,'user a',NULL,NULL,NULL,NULL,$where);
        $query_filter = $this->Modelku->select($select,'user a',NULL,$where_like,$order,NULL,$where);
        $query = $this->Modelku->select($select,'user a',$limit,$where_like,$order,NULL,$where);
        $response['data'] = array();
        if ($query<>false) {
            $no = $limit['start']+1;
            foreach ($query->result() as $val) {
                if ($val->id_user>0) {
                    $add = '<button class="btn btn-success" type="button" onclick="add_proses('.$val->id_user.')"><i class="fas fa-plus"></i></button>';
                    $jumlah = '<input type="text" name="jumlah_'.$val->id_user.'" id="jumlah_'.$val->id_user.'" value="" class="form-control">';
                    
                    $response['data'][] = array(
                        $no,
                        $val->nama,
                        $jumlah,
                        $add
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

    public function add_proses() {
        $id = $this->input->post('id');
        $data = $this->input->post('jumlah');
        $session = $this->session->userdata('session_kas');
        
        if($session != null) {
            $array = $session;
            if(in_array($id, $array)) {
                $edit = [$id=>[
                    "jumlah" => $data,
                ]];
    
                $array = array_replace($session, $edit);
                $message = "update";
            } else {
                if($data != null) {
                    $array[$id] = [
                        "jumlah" => $data,
                    ];
                    $message = "insert";
                }
                $message = "nothing";
            }
        } else {
            $array = [];
            if($data != null) {
                $array[$id] = [
                    "jumlah" => $data,
                ];
                $message = "insert";
            }
        }
        
        $this->session->set_userdata('session_kas', $array);

        echo json_encode(['status' => '200', 'message' => $message]);
    }
    public function cek_session() {
        // $array = $this->session->userdata("session_kas");
        // if(in_array(7 , $array)) {
        //     echo "ada";
        // } else {
        //     echo "tidak ada";
        // }
        // echo "<pre>";
        // print_r($array);
        // echo "</pre>";
        // $this->session->unset_userdata("session_kas");
    }
    public function load_proses()
    {
        $session = $this->session->userdata('session_kas');
        $data["data"] = [];
        $no = 1;
        if($session<>false) {
			foreach ($session as $key => $val) {
                $this->db->select("a.nama");
                $this->db->where("a.id_user", $key);
                $query = $this->db->get("user a")->row();

                $jumlah = '<input type="text" value="'.$val['jumlah'].'" id="jumlah_'.$key.'" name="jumlah_'.$key.'" onchange="update_proses(this.value, '.$key.')">';
                $data['data'][] = array(
                    $no,
                    $query->nama,
                    $jumlah
                );
                $no++;	
			}
        }
        echo json_encode($data);
    }
    public function jumlah() {
        $session = $this->session->userdata("session_kas");
        $jumlah = 0;
        if($session) {
            foreach($session as $key => $val) {
                $jumlah += $val['jumlah'];
            }
        }

        echo json_encode(strval($jumlah));
    }

}
