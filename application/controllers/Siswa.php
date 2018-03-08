<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Siswa extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Siswa_model','siswa',true);
	}

	public function index()		
	{	
		$data = array(
			'title' => 'Data Siswa',
			'program' => $this->siswa->getProgram(),
			'provinsi' => $this->siswa->getProvinsi(),
			'halaman' => 'siswa/data_siswa/?cabangID=',
		);

		$this->_render('siswa/siswa',$data);
		$id = $this->input->get("cabangID",true);
		
		if($this->siswa->cekIdCabang($id)){
			$cabang = $this->siswa->getDataCabang();
			$data = array(
					'title' => 'Data Siswa Cabang ' . $cabang['nama'],
					'cabangID' => $id,
				);
			$this->_render('siswa/data_siswa',$data);
		}
	}

	public function data_siswa()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->siswa->cekIdCabang($id)){
			$cabang = $this->siswa->getDataCabang();
			$data = array(
					'title' => 'Data Siswa Cabang ' . $cabang['nama'],
					'cabangID' => $id,
				);
			$this->_render('siswa/data_siswa',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'siswa/data_siswa/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}

	}

	public function form_pendaftaran()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->siswa->cekIdCabang($id)){
			$cabang = $this->siswa->getDataCabang();
			$data = array(
					'title' => 'Form Pendaftaran Siswa Cabang ' . $cabang['nama'],
					'program' => $this->siswa->getProgram(),
					'cabang' => $cabang,
					'provinsi' => $this->siswa->getProvinsi(),
				);
			$this->_render('siswa/form_pendaftaran',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'siswa/form_pendaftaran/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function detail()
	{
		$this->load->helper('formatting');
		$nis = $this->input->get('NIS',true);
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->siswa->cekIdCabang($id) && $this->siswa->cekIdSiswa($nis)){
			$row = $this->siswa->getDataSiswa();
			$cabang = $this->siswa->getDataCabang();
			$tgl_lahir = $row['tgl_lahir'];
			$tgl_lahir = date('d-m-Y', strtotime($tgl_lahir));
			$dataLokasi = $this->siswa->getProvKabKec($row['id_kec_siswa']);
			$dataLokasi2 = $this->siswa->getProvKabKec($row['id_kec_wali']);

			$data = array(
					'title' => 'Edit Siswa ' . $row['nama'],
					'cabang' => $cabang,
					'dataSiswa' => $this->siswa->getDataSiswa(),
					'tgl_lahir' => $tgl_lahir,
					'program' => $this->siswa->getProgram(),
					'provinsi' => $this->siswa->getProvinsi(),
					'kabupaten' => $this->siswa->getKabupaten($dataLokasi['id_provinsi']),
					'kecamatan' => $this->siswa->getKecamatan($dataLokasi['id_kabupaten']),
					'kabupaten2' => $this->siswa->getKabupaten($dataLokasi2['id_provinsi']),
					'kecamatan2' => $this->siswa->getKecamatan($dataLokasi2['id_kabupaten']),
					'dataLokasi' => $dataLokasi,
					'dataLokasi2' => $dataLokasi2,
					'nis' => $nis,
					'pembayaran' => $this->siswa->getPembayaranKhusus($nis, $id),
				);
			$this->_render('siswa/form_pendaftaran_edit',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function delete()
	{
		$nis = $this->input->get('NIS',true);
		if($this->siswa->cekIdSiswa($nis)){
			$row = $this->siswa->getDataSiswa();
			if($this->siswa->deleteSiswa($nis)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menghapus data pendaftaran Siswa '.$row['nama']);
				redirect(base_url('siswa/data_siswa'));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menghapus data pendaftaran Siswa '.$row['nama']);
				redirect(base_url('siswa/data_siswa'));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function getProgram()
	{
		if($this->input->is_ajax_request()){
			$id = (int) $this->input->get('id',true);
			echo json_encode($this->siswa->getThisProgram($id));
		}
		else{
			redirect(base_url(),'refresh');
		}
	}

	private function generateNIS($jk, $program)
	{
		$resultID = array();
		$jk = ($jk == 'm')?'2':'1';
		$result = $this->siswa->getLastID(date('Y'));
		if($result->num_rows() == 1){
			$row = $result->row_array();
			$sub = substr($row['no_pendaftaran'], 2);
			$resultID = array(
							'no' => str_pad($sub + 1, 4, 0, STR_PAD_LEFT),
							'nis' => date('y').".".str_pad($sub + 1, 4, 0, STR_PAD_LEFT).".".$program.".".$jk,
							);
		}
		else{
			$resultID = array(
							'no' => "0001",
							'nis' => date('y').".0001.".$program.".".$jk,
							);
		}

		return $resultID;
	}

	public function action_daftar()
	{
		$jk = $this->input->post('jk',true);
		$program = $this->input->post('program_bimbel',true);
		$arr = $this->generateNIS($jk, $program);
		$tgl_lahir = $this->input->post('tanggal_lahir',true);
		$tgl_lahir = date('Y-m-d', strtotime($tgl_lahir));
		$id_cabang = $this->input->post('id_cabang',true);

		$data = array(
				'nis' => $arr['nis'],
				'virtual_account' => '',
				'id_cabang' => $id_cabang,
				'no_pendaftaran' => $arr['no'],
				'tahun' => date('Y'),
				'nama' => $this->input->post('nama',true),
				'email' => $this->input->post('email',true),
				'no_hp' => $this->input->post('no_hp',true),
				'tmpt_lahir' => $this->input->post('tempat_lahir',true),
				'tgl_lahir' => $tgl_lahir,
				'jk' => $jk,
				'alamat' => $this->input->post('alamat',true),
				'id_kec_siswa' => $this->input->post('kec_siswa',true),
				'asal_sekolah' => $this->input->post('asal_sekolah',true),
				'tahun_lulus' => $this->input->post('tahun_kelulusan',true),
				'jurusan' => $this->input->post('jurusan',true),
				'nama_wali' => $this->input->post('nama_wali',true),
				'alamat_wali' => $this->input->post('alamat_wali',true),
				'id_kec_wali' => $this->input->post('kec_wali',true),
				'no_hp_wali' => $this->input->post('no_hp_wali',true),
				'email_wali' => $this->input->post('email_wali',true),
				'id_program' => $program,
				'tanggal_input' => date('Y-m-d H:i:s'),
			);

		if($this->siswa->insertSiswa($data)){
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_data', 'Berhasil menambahkan data pendaftaran Siswa');
			redirect(base_url('siswa/detail/?cabangID='.$id_cabang.'&NIS='.$arr['nis']));
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Gagal menambahkan data pendaftaran Siswa');
			redirect(base_url('siswa/form_pendaftaran/?cabangID='.$id_cabang));
		}
	}

	public function action_edit()
	{	
		$nis = $this->input->get('NIS',true);
		if($this->siswa->cekIdSiswa($nis)){
			$row = $this->siswa->getDataSiswa();
			$jk = $this->input->post('jk',true);
			$program = $this->input->post('program_bimbel',true);
			$data = array();
			$data['nis'] = $this->input->post('nis',true);

			if($row['jk'] != $jk || $row['id_program'] != $program){
				$tmp = explode(".", $row['nis']);
				$new_jk = ($jk == 'm')?'2':'1';
				$data['nis'] = $tmp[0] .".".$tmp[1].".".$program.".".$new_jk;
			}

			$tgl_lahir = $this->input->post('tanggal_lahir',true);
			$tgl_lahir = date('Y-m-d', strtotime($tgl_lahir));

			$data['nama'] = $this->input->post('nama',true);
			$data['email'] = $this->input->post('email',true);
			$data['no_hp'] = $this->input->post('no_hp',true);
			$data['tmpt_lahir'] = $this->input->post('tempat_lahir',true);
			$data['tgl_lahir'] = $tgl_lahir;
			$data['jk'] = $jk;
			$data['alamat'] = $this->input->post('alamat',true);
			$data['id_kec_siswa'] = $this->input->post('kec_siswa',true);
			$data['asal_sekolah'] = $this->input->post('asal_sekolah',true);
			$data['tahun_lulus'] = $this->input->post('tahun_kelulusan',true);
			$data['jurusan'] = $this->input->post('jurusan',true);
			$data['nama_wali'] = $this->input->post('nama_wali',true);
			$data['alamat_wali'] = $this->input->post('alamat_wali',true);
			$data['id_kec_wali'] = $this->input->post('kec_wali',true);
			$data['no_hp_wali'] = $this->input->post('no_hp_wali',true);
			$data['email_wali'] = $this->input->post('email_wali',true);
			$data['id_program'] = $program;

			if($this->siswa->updateSiswa($row['nis'], $data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil mengubah data pendaftaran Siswa');
				redirect(base_url('siswa/detail/?cabangID='.$row['id_cabang'].'&NIS='.$data['nis']));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal mengubah data pendaftaran Siswa');
				redirect(base_url('siswa/detail/?cabangID='.$row['id_cabang'].'&NIS='.$data['nis']));
			}
		}
		else{
			$this->error_404();
		}
	}

	private function formatTanggal($tgl)
	{
		$data = explode('/', $tgl);
		$tglBaru = $data[2] .'-'. $data[1] .'-'. $data[0];
		return $tglBaru;
	}

	public function action_import()
	{
		if(! empty($_FILES) && $_FILES['userfile']['name'] != null){
			$namaFile = "import-" . md5(time() . rand(0,100)) . "." . strtolower(pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION));

			$this->load->library('excel_read');
			$configUpload['upload_path'] = FCPATH.'assets/data/excel/';
			$configUpload['allowed_types'] = 'xls|csv';
			$configUpload['max_size'] = '5000';
			$this->load->library('upload', $configUpload);

			$configUpload['file_name'] = $namaFile;
			$this->upload->initialize($configUpload);

			if($this->upload->do_upload('userfile')){
				$upload_data = $this->upload->data();
				$file_name = $upload_data['file_name'];

				$objReader =PHPExcel_IOFactory::createReader('Excel5'); 
				$objReader->setReadDataOnly(true);
				$objPHPExcel=$objReader->load(FCPATH.'assets/data/excel/'.$file_name);
				$baris = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
				$data = $objPHPExcel->setActiveSheetIndex(0);   

				$dataInsert = array();
				for ($i=2; $i<=$baris; $i++){
					$tgl_lahir = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($data->getCellByColumnAndRow(9,$i)->getValue()));
					$dataInsert[] = array(
							'nis' => $data->getCellByColumnAndRow(0,$i)->getValue(),
							'virtual_account' => $data->getCellByColumnAndRow(1,$i)->getValue(),
							'id_cabang' => $data->getCellByColumnAndRow(2,$i)->getValue(),
							'no_pendaftaran' => $data->getCellByColumnAndRow(3,$i)->getValue(),
							'tahun' => $data->getCellByColumnAndRow(4,$i)->getValue(),
							'nama' => $data->getCellByColumnAndRow(5,$i)->getValue(),
							'email' => $data->getCellByColumnAndRow(6,$i)->getValue(),
							'no_hp' => $data->getCellByColumnAndRow(7,$i)->getValue(),
							'tmpt_lahir' => $data->getCellByColumnAndRow(8,$i)->getValue(),
							'tgl_lahir' => $tgl_lahir,
							'jk' => ($data->getCellByColumnAndRow(10,$i)->getValue()=='l')?'m':'f',
							'alamat' => $data->getCellByColumnAndRow(11,$i)->getValue(),
							'id_kec_siswa' => NULL,
							'asal_sekolah' => $data->getCellByColumnAndRow(12,$i)->getValue(),
							'tahun_lulus' => $data->getCellByColumnAndRow(13,$i)->getValue(),
							'jurusan' => $data->getCellByColumnAndRow(14,$i)->getValue(),
							'nama_wali' => $data->getCellByColumnAndRow(15,$i)->getValue(),
							'alamat_wali' => $data->getCellByColumnAndRow(16,$i)->getValue(),
							'id_kec_wali' => NULL,
							'email_wali' => $data->getCellByColumnAndRow(17,$i)->getValue(),
							'no_hp_wali' => $data->getCellByColumnAndRow(18,$i)->getValue(),
							'id_program' => $data->getCellByColumnAndRow(19,$i)->getValue(),
							'tanggal_input' => date('Y-m-d H:i:s'),
						);
				}
				unlink(FCPATH.'assets/data/excel/'.$file_name);

				if($this->siswa->importSiswa($dataInsert)){
					$this->session->set_flashdata('alert_type', 'success');
					$this->session->set_flashdata('alert_data', 'Berhasil ngeimport data Siswa');
					redirect(base_url('siswa'),'refresh');
				}
				else{
					$this->session->set_flashdata('alert_type', 'danger');
					$this->session->set_flashdata('alert_data', 'Gagal mengimport data Siswa');
					redirect(base_url('siswa'),'refresh');
				}
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Silahkan Upload File!');
				redirect(base_url('siswa'),'refresh');
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Silahkan Upload File!');
			redirect(base_url('siswa'),'refresh');
		}
	}

	public function list_data()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}
		if($this->input->is_ajax_request()){
			$array = array(
				'limit' => (int) $this->input->get('limit', TRUE),
				'offset' => (int) $this->input->get('offset', TRUE),
				'search' => $this->input->get('search', TRUE)
				);
			$jumlah = $this->siswa->getListTotal($id, $array['search']);
			$i = ($array['offset'] == 0 || $array['offset'] == null)?1:$array['offset']+1;
			header('Content-type: application/json');
			$dataJSON = array();
			$dataJSON['total'] = $jumlah;
			$dataJSON['rows'] = array();
			foreach($this->siswa->getList($id, $array) as $result){
				$data = array(
						'no' => $i,
						'nis' => $result->nis,
						'nama' => $result->nama,
						'no_va' => (!empty($result->virtual_account))?$result->virtual_account:"Belum Mempunyai",
						'aksi' => "<a href=\"".base_url('siswa/detail/?cabangID='.$result->id_cabang.'&NIS='.$result->nis)."\" class=\"btn btn-xs btn-success\">Lihat Detail</a> <a onclick=\"doHapus('$result->nis','$result->nama')\" class=\"btn btn-xs btn-danger\">Hapus</a>"
					);
				array_push($dataJSON['rows'], $data);
				$i++;
			}
			echo json_encode($dataJSON);
		}
		else{
			$this->error_404();
		}
	}

	public function pengingat_pembayaran_siswa()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->siswa->cekIdCabang($id)){
			$cabang = $this->siswa->getDataCabang();
				$data = array(
					'title' => 'Form Penginat Pembayaran Siswa',
					'cabangID' => $id,
					'cabang' => $cabang,
				);
			$this->_render('siswa/form_pengingat_pembayaran',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'siswa/pengingat_pembayaran_siswa/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	/*
	MUTASI AKUN SISWA
	*/

	public function mutasi_siswa()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->siswa->cekIdCabang($id)){
			$cabang = $this->siswa->getDataCabang();
			$data = array(
					'title' => 'Data Siswa Cabang ' . $cabang['nama'],
					'cabangID' => $id,
					'cabang' => $cabang,
					'program' => $this->siswa->getProgram(),
					'provinsi' => $this->siswa->getProvinsi(),
				);
			$this->_render('siswa/mutasi_siswa',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'siswa/mutasi_siswa/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function daftar_mutasi_siswa()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->siswa->cekIdCabang($id)){
			$cabang = $this->siswa->getDataCabang();
			$data = array(
					'title' => 'Data Siswa Cabang ' . $cabang['nama'],
					'cabangID' => $id,
				);
			$this->_render('siswa/daftar_mutasi_siswa',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'siswa/daftar_mutasi_siswa/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function action_daftar_mutasi()
	{

	}

	public function list_data_mutasi_siswa()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}
		if($this->input->is_ajax_request()){
			$array = array(
				'limit' => (int) $this->input->get('limit', TRUE),
				'offset' => (int) $this->input->get('offset', TRUE),
				'search' => $this->input->get('search', TRUE)
				);
			$jumlah = $this->siswa->getListTotal($id, $array['search']);
			$i = ($array['offset'] == 0 || $array['offset'] == null)?1:$array['offset']+1;
			header('Content-type: application/json');
			$dataJSON = array();
			$dataJSON['total'] = $jumlah;
			$dataJSON['rows'] = array();
			foreach($this->siswa->getList($id, $array) as $result){
				$data = array(
						'no' => $i,
						'nis' => $result->nis,
						'nama' => $result->nama,
						'no_va' => (!empty($result->virtual_account))?$result->virtual_account:"Belum Mempunyai",
						'aksi' => "<a href=\"".base_url('siswa/detail/?cabangID='.$result->id_cabang.'&NIS='.$result->nis)."\" class=\"btn btn-xs btn-success\">Lihat Detail</a> <a onclick=\"doHapus('$result->nis','$result->nama')\" class=\"btn btn-xs btn-danger\">Hapus</a>"
					);
				array_push($dataJSON['rows'], $data);
				$i++;
			}
			echo json_encode($dataJSON);
		}
		else{
			$this->error_404();
		}
	}

}