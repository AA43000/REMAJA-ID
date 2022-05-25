<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slide extends CI_Controller {

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
        $data['judul'] = 'Slide';
        $data['konten'] = $this->load->view('admin/slide', $data, true);
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
		'column' => 'a.header',
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
		'param'		=> 0
		);		

	$query_total = $this->Modelku->select($select,'slide a',NULL,NULL,NULL,NULL,$where);
	$query_filter = $this->Modelku->select($select,'slide a',NULL,$where_like,$order,NULL,$where);
	$query = $this->Modelku->select($select,'slide a',$limit,$where_like,$order,NULL,$where);
	$response['data'] = array();
	if ($query<>false) {
		$no = $limit['start']+1;
		foreach ($query->result() as $val) {
			if ($val->id_slide>0) {
				$edit = '<button class="btn btn-circle btn-sm btn-success" type="button" onclick="edit_data('.$val->id_slide.')"><i class="fas fa-edit"></i></button>';
				$delete = '<button class="btn btn-circle btn-sm btn-danger" type="button" onclick="delete_data('.$val->id_slide.')"><i class="fas fa-trash"></i></button>';
				$image = '<a class="venobox" data-gall="slideGallery" title="slide '.$no.'" href="'.base_url('assets/image/slide/').$val->image.'"><img src="'.base_url('assets/image/slide/').$val->image.'" alt="image alt" width="100%"></a>';
				
				$response['data'][] = array(
                    $no,
                    $val->header,
                    $val->text,
                    $image,
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
		$id = $this->input->post('id');
        if($id > 0) {
            $data = $this->general_input_post();
            $where = [
                'id_slide' => $id
			];
			if(!empty($_FILES['image']['name'])){
				$upload = $this->do_upload();
				$data['image'] = $upload;
				$this->hapus_image($id);
			}
            $update = $this->Modelku->update('slide', $data, $where);
            if($update<>false) {
                $response['status'] = '200';
                $response['message'] = 'Data berhasil di update';
            } else {
                $response['status'] = '202';
                $response['message'] = 'gagal update data';
            }
        } else {
            $data = $this->general_input_post();
			$upload = $this->do_upload();
			$data['image'] = $upload;
            $insert = $this->db->insert('slide', $data);
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
            'header' => $this->input->post('header'),
            'text' => $this->input->post('text')
        ];

        return $data;
    }

    function do_upload() {
        $config['upload_path'] = 'assets/image/slide/'; // folder menyimpan gambar
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

	public function delete_data($id_slide) {
		$data['status_delete'] = 1;
		$where = [
			'id_slide' => $id_slide
		];
		$delete = $this->Modelku->update('slide', $data, $where);
		$this->hapus_image($id_slide);
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
    
    public function edit_data($id_slide) {
		$query = $this->db->query("SELECT * FROM slide WHERE id_slide = $id_slide AND status_delete = 0")->row();
        $response['value'] = [
            'id' => $query->id_slide,
            'header' => $query->header,
			'text' => $query->text,
			'image' => '<img src="'.base_url('assets/image/slide/').$query->image.'" alt="image alt" width="100%">'
        ];

        echo json_encode($response);
	}
	
	function hapus_image($id) {
		$query = $this->db->query("SELECT * FROM slide WHERE id_slide = $id")->row();
		if(file_exists('assets/image/slide/'.$query->image) && $query->image){
			unlink('assets/image/slide/'.$query->image);
		}
	}

}
