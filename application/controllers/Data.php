<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
	//private $receiving_email = "fill here";
	private $receiving_email = 'consult@simplwe.com';

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
	}
	// hospital page
	public function getHosp($hid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->getHosp($hid));
	}
	public function getGallery($hid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->getGallery($hid));
	}
	public function getPromotion($hid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->getPromotion($hid));
	}
	public function getRatingAllDoctor($hid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->getRatingAllDoctor($hid));
	}
	public function getEditData($hid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->getEditData($hid));
	}
	public function getRatingAllHospital($hid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->getRatingAllHospital($hid));
	}
	public function getDoctors($hid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->getDoctors($hid));
	}
	public function getDoctor($did){
		$this->load->model('gdata');
		echo json_encode($this->gdata->getDoctor($did));
	}
	public function getComment($did){
		$this->load->model('gdata');
		echo json_encode($this->gdata->getComment($did));
	}

	//main page
	public function getStat(){
		$this->load->model('gdata');
		echo json_encode($this->gdata->getStat());
	}
	public function getVR(){
		$this->load->model('gdata');
		echo json_encode($this->gdata->getVR());
	}
	public function getAllHospital(){
		$this->load->model('gdata');
		echo json_encode($this->gdata->getAllHospital());

	}
	public function getHospitalByNum($num){
		$this->load->model('gdata');
		$result=$this->gdata->getHospitalByNum($num);
		$result->num=$num%9;
		echo json_encode($result);
	}

	//nav
	public function login(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('gdata');
		$result=$this->gdata->login($req);
		if($result){
			$this->session->set_userdata('uid',$result->UID);
			$success=true;
		}else{
			$success=false;
		}
		echo json_encode($success);
	}
	public function reset(){
		$email=$_GET['data'];

		$this->load->model('gdata');
		$result=$this->gdata->reset_find($email);
		if($result->cnt==1){
			$this->load->library('email');
			$this->email->from('admin@simplwe.com', 'simplwe');
			$code=$this->encrypt_decrypt('encrypt',$email);
			$this->email->to($email);
			$this->email->subject('Reset your password');
			$str='
			<a href="'.base_url("?reset_data=".$code)
			.'">Click this link to reset your password</a>
			';
			$this->email->message($str);
			$this->email->send();
			$success=true;
		}else{
			//if not user
			$success=false;
		}
		echo json_encode($success);
	}
	public function reset_pw($code,$pw){
		$email=$this->encrypt_decrypt('decrypt',urldecode($code));
		$this->load->model('gdata');
		$this->gdata->reset_pw($email,$pw);
		echo "
		<script>
		alert('Password has changed');
		location.href='/';
		</script>
		";
	}

	public function logout(){
		$this->session->sess_destroy();
		echo "
		<script>
		location.href='/';
		</script>
		";
	}


	//search
	public function getHospitalWithName(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('gdata');
		echo json_encode($this->gdata->getHospitalWithName($req));
	}

	//consult
	public function sendConsult(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		//send email with consult data
		$this->load->library('email');
		$this->email->from($req->email, 'client');
		$this->email->to("consult@simplwe.com");
		$this->email->subject('CONSULT RECEIVED');
		$str="";
		$str.="NAME: ";
		$str.=$req->name;
		$str.="<br/>";
		$str.="EMAIL: ";
		$str.=$req->email;
		$str.="<br/>";
		$str.="Message: ";
		$str.=$req->body;
		$this->email->message($str);
		$this->email->send();
	}

	//register
	public function registerUser(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('gdata');
		$this->gdata->register($req);
	}

	//consultation
	public function consultation($start){
		$this->load->model('gdata');
		echo json_encode($this->gdata->consultation($start));
	}
	public function numConsult(){
		$this->load->model('gdata');
		echo json_encode($this->gdata->numConsult());
	}
	public function deleteConsult($cid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->deleteConsult($cid));
	}
	public function editConsult($cid){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('gdata');
		echo json_encode($this->gdata->editConsult($req));
	}
	public function writeConsult(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('gdata');
		$this->gdata->writeConsult($req);
	}
	public function getConsult($cid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->getConsult($cid));
	}
	public function getConsultReply($cid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->getConsultReply($cid));
	}
	public function writeConsultReply(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('gdata');
		$this->gdata->writeConsultReply($req);
	}

	//add hospital
	public function deleteHospital($hid){
		$this->load->model('gdata');
		$this->gdata->deleteHospital($hid);
	}
	public function addHospital(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('gdata');
		$result=[];
		$result['log']=$this->gdata->addHospital($req);
		$result['result']=true;
		echo json_encode($result);
	}
	public function editNewHospital(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('gdata');
		$result=[];
		$result['log']=$this->gdata->editNewHospital($req);
		$result['result']=true;
		echo json_encode($result);
	}
	public function sendHospitalConsult(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$req->email;
		$req->body;
		$req->name;
		$req->hospital;

		$this->load->library('email');

		$this->email->from('admin@simplwe.com', 'simplwe');
		$this->email->to('consult@simplwe.com');
		$this->email->subject('Hospital Consult');
		$data.="hospital: ".$req->hospital."\n";
		$data.="email: ".$req->email."\n";
		$data.="name: ".$req->name."\n";
		$data.="body: ".$req->body."\n";
		$this->email->message($data);
		$this->email->send();
	}

	//hospital page
	public function sendReview(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('gdata');
		echo json_encode($this->gdata->sendReview($req));
	}
	public function send_hospital_review(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('gdata');
		echo json_encode($this->gdata->send_hospital_review($req));
	}


	//helper function
	private function encrypt_decrypt($action, $string) {
		$output = false;

		$encrypt_method = "AES-256-CBC";
		$secret_key = 'This is my secret key';
		$secret_iv = 'This is my secret iv';

		// hash
		$key = hash('sha256', $secret_key);

		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);

		if( $action == 'encrypt' ) {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		}
		else if( $action == 'decrypt' ){
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}

		return $output;
	}




}
