<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->id_user = $this->session->userdata("id_user");
	}
	public function index()
	{	
		$this->load->view('welcome_message2');
	}

	public function admin() {
		if($this->session->userdata("id_user")) { 
			$data['judul'] = 'Dashboard';
			$data['jumlah_anggota'] = $this->db->query("SELECT id_user FROM user WHERE status_delete = 0 AND status_approve = 1")->num_rows();
			$data['jumlah_unit'] = $this->db->query("SELECT id FROM unit WHERE status_delete = 0")->num_rows();
			$data['anggaran'] = number_format($this->db->query("SELECT jumlah FROM anggaran")->row()->jumlah);
			$data['konten'] = $this->load->view('dashboard', $data, true);
			$this->load->view('template/index', $data);
		} else {
			redirect(base_url('login'));
		}
	}

	public function message() {
		$query = $this->db->query("SELECT email FROM contact")->row();
		$to = $query->email; // this is your Email address
		$from = $_POST['email']; // this is the sender's Email address
		$subject = $_POST['subject'];;
		$message = $_POST['message'];;

		$headers = "From:" . $from;
		mail($to,$subject,$message,$headers);
		echo "success";	
	}

	public function count_pengumuman() {
		$query = $this->db->query("SELECT * FROM pengumuman WHERE status_delete = 0 ORDER BY created_at desc")->result();
		$count = 0;
		$pengumuman = '';
		foreach($query as $key => $row) {
			$cek = $this->db->query("SELECT id FROM notif_pengumuman WHERE id_pengumuman = $row->id AND id_user = $this->id_user")->row();
			$notif = '';
			if($cek == false) {
				$count++;
				$notif = ' style="background-color: #e5eaf7"';
			}
			if($key <= 2) {
				$pengumuman .= '<a class="dropdown-item d-flex align-items-center"'.$notif.' href="'.base_url('Welcome/admin').'">
									<div class="mr-3">
										<div class="icon-circle bg-primary">
										<i class="fas fa-file-alt text-white"></i>
										</div>
									</div>
									<div>
										<div class="small text-gray-500">'.date("d M Y", strtotime($row->tanggal)).'</div>
										<span class="font-weight-bold">'.$row->nama.'</span>
									</div>
								</a>';
			}

		}
		echo json_encode(["count" => $count, "pengumuman" => $pengumuman]);
	}
	public function load_data($id = 0) {
		if($id == 0) {
			$query = $this->db->query("SELECT * FROM pengumuman WHERE status_delete = 0 ORDER BY created_at desc LIMIT 6")->result();
			foreach($query as $key => $val) {
				if($val->tanggal != null) {
					$query[$key]->tanggal = date("d M Y", strtotime($val->tanggal));
				}
				$query[$key]->keterangan = substr($val->keterangan, 0, 20)."...";
				$cek = $this->db->query("SELECT id FROM notif_pengumuman WHERE id_pengumuman = $val->id AND id_user = $this->id_user")->row();
				$query[$key]->notif = 0;
				if($cek == false) {
					$query[$key]->notif = 1;
				}
			}
		} else {
			$query = $this->db->query("SELECT * FROM pengumuman WHERE id = $id")->row();
			
			$query->waktu = date("H:i", strtotime($query->waktu));
			if($query->tanggal != 0) {
				$query->tanggal = $this->tgl_indo($query->tanggal);
			} else {
				$query->tanggal = "-";
			}
			$cek = $this->db->query("SELECT id FROM notif_pengumuman WHERE id_pengumuman = $id AND id_user = $this->id_user")->row();
			if($cek == false) {
				$this->db->insert("notif_pengumuman", [
					"id_pengumuman" => $id,
					"id_user" => $this->id_user
				]);
			}
		}

		echo json_encode(["data" => $query]);
	}
	
	function tgl_indo($tanggal){
		$hr = date("D", strtotime($tanggal));
		$hari = array(
			'Sun' => 'Minggu',
			'Mon' => 'Senin',
			'Tue' => 'Selasa',
			'Wed' => 'Rabu',
			'Thu' => 'Kamis',
			'Fri' => 'Jumat',
			'Sat' => 'Sabtu'
		);

		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);
		
		// variabel pecahkan 0 = tahun
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tanggal
	 
		return $hari[$hr].', '. $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}
	public function load_kas() {
		$query = $this->db->query("SELECT a.jumlah, b.tanggal FROM kas_detail a LEFT JOIN kas b ON b.id=a.id_kas WHERE b.status_delete = 0 AND a.id_user = $this->id_user ORDER BY tanggal desc LIMIT 5")->result();
		foreach($query as $key => $val) {
			$query[$key]->jumlah = number_format($val->jumlah, 0, ',', '.');
		}

		echo json_encode(["data" => $query]);
	}
}
