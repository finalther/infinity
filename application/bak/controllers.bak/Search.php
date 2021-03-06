<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Search_model','search',true);
	}

	public function kepala_cabang()
	{
		if($this->input->is_ajax_request()){
			$keyword = $this->uri->segment(3);
			$hasilCari = $this->search->searchKepalaCabang($keyword);

			$arr = array();
			foreach($hasilCari as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=> $row['nama'],
					'id_user'	=> $row['id_user'],
				);
			}
			echo json_encode($arr);
		}
		else{
			echo "Nothing";
		}
	}

	public function cabang()
	{
		if($this->input->is_ajax_request()){
			$keyword = $this->uri->segment(3);
			$hasilCari = $this->search->searchCabang($keyword);

			$arr = array();
			foreach($hasilCari as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=> $row['nama'],
					'id_cabang'	=> $row['id_cabang'],
				);
			}
			echo json_encode($arr);
		}
		else{
			echo "Nothing";
		}
	}

	public function siswa()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->input->is_ajax_request()){
			$keyword = str_replace("/","",$this->input->get('keyword',true));
			$hasilCari = $this->search->searchSiswa($id,$keyword);

			$arr = array();
			foreach($hasilCari as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=> $row['nama'],
					'nis' => $row['nis'],
					'alamat' => $row['alamat'] .", ".$row['nama_kec'].", ".$row['nama_kab'].", ".$row['nama_prov'],
					'program' => $row['nama_program'],
				);
			}
			echo json_encode($arr);
		}
		else{
			echo "Nothing";
		}
	}

}