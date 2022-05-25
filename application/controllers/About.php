<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

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
        $data['judul'] = 'About';
        $data['konten'] = $this->load->view('admin/about', $data, true);
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
		'column' => 'a.nama',
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

	$query_total = $this->Modelku->select($select,'list_about a',NULL,NULL,NULL,NULL,$where);
	$query_filter = $this->Modelku->select($select,'list_about a',NULL,$where_like,$order,NULL,$where);
	$query = $this->Modelku->select($select,'list_about a',$limit,$where_like,$order,NULL,$where);
	$response['data'] = array();
	if ($query<>false) {
		$no = $limit['start']+1;
		foreach ($query->result() as $val) {
			if ($val->id_list_about>0) {
				$edit = '<button class="btn btn-circle btn-sm btn-success" type="button" onclick="edit_data('.$val->id_list_about.')"><i class="fas fa-edit"></i></button>';
				$delete = '<button class="btn btn-circle btn-sm btn-danger" type="button" onclick="delete_data('.$val->id_list_about.')"><i class="fas fa-trash"></i></button>';
				$icon = '<div class="icon"><i style="font-size: 3rem" class="'.$val->icon.'"></i></div><br><span>('.$val->icon.')</span>';
				
				$response['data'][] = array(
                    $no,
                    $val->nama,
                    $val->keterangan,
                    $icon,
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
	
	public function load_data_utama() {
		$val = $this->db->query("SELECT * FROM about WHERE id_about = 1")->row();
		$image = '<a href="'.base_url('assets/image/').$val->thumbnail.'"><img src="'.base_url('assets/image/').$val->thumbnail.'" width="100%"  alt=""></a>';
		$youtube = $val->youtube != null ? '<a href="'.$val->youtube.'" class="venobox play-btn mb-4" data-vbtype="video" data-autoplay="true">'.$val->youtube.'</a>' : '(belum menambahkan link youtube)';
		
		$response['data'][] = array(
			$val->header,
			$val->text,
			$image,
			$youtube
		);
	
		$response['recordsTotal'] = 1;
		$response['recordsFiltered'] = 1;
	
		echo json_encode($response);
	}

	public function load_about() {
		$query = $this->db->query("SELECT * FROM about WHERE id_about = 1")->row();

		$data = array(
			'header' => $query->header,
			'text' => $query->text,
			'youtube' => $query->youtube,
			'thumbnail' => '<img src="'.base_url('assets/image/').$query->thumbnail.'" width="100%"  alt="">'
		);

		echo json_encode($data);
	}

	public function update() {
		$data = array(
			'header' => $this->input->post('header'),
			'text' => $this->input->post('text'),
			'youtube' => $this->input->post('youtube'),
		);
		if(!empty($_FILES['image']['name'])){
			$data['thumbnail'] = $this->do_upload();
			$this->hapus_image();
		}

		$where = [
			'id_about' => 1
		];
		$update = $this->Modelku->update('about', $data, $where);

		if($update<>false) {
			$response['status'] = '200';
			$response['message'] = 'data berhasil diupdate';
		} else {
			$response['status'] = '202';
			$response['message'] = 'data gagal di update';
		}

		echo json_encode($response);

	}

    public function tambah() {
        if($this->input->post('id') > 0) {
            $data = $this->general_input_post();
            $where = [
                'id_list_about' => $this->input->post('id')
            ];
            $update = $this->Modelku->update('list_about', $data, $where);
            if($update<>false) {
                $response['status'] = '200';
                $response['message'] = 'Data berhasil di update';
            } else {
                $response['status'] = '202';
                $response['message'] = 'gagal update data';
            }
        } else {
            $data = $this->general_input_post();
            $insert = $this->db->insert('list_about', $data);
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
            'nama' => $this->input->post('nama'),
            'keterangan' => $this->input->post('keterangan'),
            'icon' => $this->input->post('icon'),
        ];

        return $data;
    }

    function do_upload() {
        $config['upload_path'] = 'assets/image/'; // folder menyimpan gambar
        $config['allowed_types'] = 'gif|jpg|png';
		// $config['max_size'] = '1000'; //dalam kilobyte(kb)
		// $config['max_width']            = 1000; // batas lebar gambar
		// $config['max_height']           = 1000; // batas tinggi gambar
		$config['width'] = 500;
        $config['file_name'] = round(microtime(true) * 1000); //nama file

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('image')) { // jika upload gagal
            $data['inputerror'][] =  'image';
            $data['error_string'][] = "Upload error: ".$this->upload->display_errors('', ''); //menampilkan error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
		}

		return $this->upload->data('file_name'); // mengembalikan nama file
	}

	function hapus_image() {
		$query = $this->db->query("SELECT * FROM about WHERE id_about = 1")->row();
		if(file_exists('assets/image/'.$query->thumbnail) && $query->thumbnail){
			unlink('assets/image/'.$query->thumbnail);
		}
	}

	public function edit_data($id_list_about) {
		$query = $this->db->query("SELECT * FROM list_about WHERE id_list_about = $id_list_about AND status_delete = 0")->row();
        $response['value'] = [
            'id' => $query->id_list_about,
            'nama' => $query->nama,
			'keterangan' => $query->keterangan,
			'icon' => $query->icon,
			
        ];

        echo json_encode($response);
	}

	public function delete_data($id_list_about) {
		$data['status_delete'] = 1;
		$where = [
			'id_list_about' => $id_list_about
		];
		$delete = $this->Modelku->update('list_about', $data, $where);
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
