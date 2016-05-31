<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		if($this->session->userdata('uid')){
			$data['uid']=$this->session->userdata('uid');
			$data['login']=true;
		}else{
			$data['uid']="";
			$data['login']=false;
		}
		if(isset($_GET['reset_data'])){
			$code=$_GET['reset_data'];
			$data['reset_code']=$code;
		}else{
			$data['reset_code']="";
		}
		$this->load->view('common/header',$data);
	}
	public function index()
	{
		$this->load->view('find');
		$this->load->view('common/footer');
	}
	public function search()
	{
		//TODO check if admin or hospital user
		if($this->session->userdata('uid')==1){
			$data['authorized']=true;
		}else{
			$data['authorized']=false;
		}
		if(isset($_GET['find'])){
			$data['query']=$_GET['find'];
		}else{
			$data['query']="";
		}

		$this->load->view('result',$data);
		$this->load->view('common/footer');
	}
	public function hospital($HID)
	{
		if(!$HID)redirect("/");
		$data['hid']=$HID;
		$this->load->view('page',$data);
		$this->load->view('common/footer');
	}
	public function consultation(){
		$this->load->view('consultation');
		$this->load->view('common/footer');
	}
	public function addHospital()
	{
		$this->load->view('addHospital');
		$this->load->view('common/footer');
	}

}
