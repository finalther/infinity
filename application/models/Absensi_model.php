<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Absensi_model extends CI_Model {

	private $dataCabang;
	private $dataAbsensiPengajar;
	private $dataAbsensiSiswa;
	private $dataAbsensiPegawai;
	private $lastID;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function cekIdCabang($id)
	{
		$query = $this->db->select('id_cabang, nama, alamat, kode_pos, email, lat, lng, no_telp, no_fax, kecamatan.id_kecamatan, kabupaten.id_kabupaten, provinsi.id_provinsi, kecamatan.name as kecamatan, kabupaten.name as kabupaten, provinsi.name as provinsi')
							->join('kecamatan','kecamatan.id_kecamatan = cabang.id_kecamatan','left')
							->join('kabupaten','kabupaten.id_kabupaten = kecamatan.id_kabupaten','left')
							->join('provinsi','provinsi.id_provinsi = kabupaten.id_provinsi','left')
							->where('id_cabang', $id)
							->limit(1)
							->get('cabang');
		if($query->num_rows() == 1){
			$this->dataCabang = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function getDataCabang()
	{
		return $this->dataCabang;
	}

	public function cekAbsensiPengajar($hari, $jenis)
	{
		$query = $this->db->select('*')
								->where('jenis',$jenis)
								->where('time >=',$hari.' 00:00:00')
								->where('time <=',$hari.' 23:59:59')
								->limit(1)
								->get('absen_pengajar');
		if($query->num_rows() == 1){
			$this->dataAbsensiPengajar = $query->row_array();
			return false;
		}
		else{
			return true;
		}
	}

	public function insertAbsensiPengajar($data = array())
	{
		$this->db->insert('absen_pengajar', $data);

		if($this->db->affected_rows() == 1){
			$this->lastID = $this->db->insert_id();
			return true;
		}
		else{
			return false;
		}
	}

	public function getDataAbsensiPengajar()
	{
		return $this->dataAbsensiPengajar;
	}

	public function cekAbsensiSiswa($hari, $jenis)
	{
		$query = $this->db->select('*')
								->where('jenis',$jenis)
								->where('time >=',$hari.' 00:00:00')
								->where('time <=',$hari.' 23:59:59')
								->limit(1)
								->get('absen_siswa');
		if($query->num_rows() == 1){
			$this->dataAbsensiSiswa = $query->row_array();
			return false;
		}
		else{
			return true;
		}
	}

	public function insertAbsensiSiswa($data = array())
	{
		$this->db->insert('absen_siswa', $data);

		if($this->db->affected_rows() == 1){
			$this->lastID = $this->db->insert_id();
			return true;
		}
		else{
			return false;
		}
	}

	public function getDataAbsensiSiswa()
	{
		return $this->dataAbsensiSiswa;
	}

	public function cekAbsensiPegawai($hari, $jenis)
	{
		$query = $this->db->select('*')
								->where('jenis',$jenis)
								->where('time >=',$hari.' 00:00:00')
								->where('time <=',$hari.' 23:59:59')
								->limit(1)
								->get('absen_pegawai');
		if($query->num_rows() == 1){
			$this->dataAbsensiPegawai = $query->row_array();
			return false;
		}
		else{
			return true;
		}
	}

	public function insertAbsensiPegawai($data = array())
	{
		$this->db->insert('absen_pegawai', $data);

		if($this->db->affected_rows() == 1){
			$this->lastID = $this->db->insert_id();
			return true;
		}
		else{
			return false;
		}
	}

	public function getDataAbsensiPegawai()
	{
		return $this->dataAbsensiPegawai;
	}

	public function getLastID()
	{
		return $this->lastID;
	}

	public function getListAbsensiPengajar($id, $hari)
	{
		return $this->db->select('pengajar.nama, daftar_absen_pengajar.time')
							->join('pengajar','daftar_absen_pengajar.id_pengajar = pengajar.id_pengajar','left')
							->where('time >=',$hari.' 00:00:00')
							->where('time <=',$hari.' 23:59:59')
							->where('id_absen_pengajar',$id)
							->order_by('id_daftar_absen_pengajar','DESC')
							->get('daftar_absen_pengajar')
							->result_array();
	}

	public function getListAbsensiSiswa($id, $hari)
	{
		return $this->db->select('siswa.nama, daftar_absen_siswa.time')
							->join('siswa','daftar_absen_siswa.nis = siswa.nis','left')
							->where('time >=',$hari.' 00:00:00')
							->where('time <=',$hari.' 23:59:59')
							->where('id_absen_siswa',$id)
							->order_by('id_daftar_absen_siswa','DESC')
							->get('daftar_absen_siswa')
							->result_array();
	}

	public function getListAbsensiPegawai($id, $hari)
	{
		return $this->db->select('user.nama, daftar_absen_pegawai.time')
							->join('user','daftar_absen_pegawai.id_user = user.id_user','left')
							->where('time >=',$hari.' 00:00:00')
							->where('time <=',$hari.' 23:59:59')
							->where('id_absen_pegawai',$id)
							->order_by('id_daftar_absen_pegawai','DESC')
							->get('daftar_absen_pegawai')
							->result_array();
	}

}