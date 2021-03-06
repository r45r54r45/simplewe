<?php

class Gdata extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  //hospital page
  public function send_hospital_review($req){
    $this->q("
    insert into RATING_H
    (NUM1,NUM2,NUM3,HID,UID)
    values
    ('$req->R1','$req->R2','$req->R3','$req->hid','$req->uid')
    ");
  }
  public function getGallery($hid){
    return $this->q("select * from HOSPITAL_IMAGE where HID='$hid'")->result_array();
  }
  public function getPromotion($hid){
    return $this->q("select * from PROMOTION where HID='$hid'")->row();
  }
  public function getHosp($hid){
    return $this->q("
    select *
    from HOSPITAL h
    left join HOSPITAL_MAIN_IMAGE hi on hi.HID=h.HID
    where h.HID='$hid'
    limit 1
    ")->row();
  }
  public function getRatingAllDoctor($hid){
    return $this->q("
    select (SUM(NUM1)+SUM(NUM2)+SUM(NUM3))/(COUNT(*)*3) as RATING_doctor from HOSPITAL h
    join DOCTOR d on h.HID=d.HID
    join RATING_D rd on rd.DID=d.DID
    where h.HID='$hid'")->row();
  }
  public function getRatingAllHospital($hid){
    return $this->q("
    select (SUM(NUM1)+SUM(NUM2)+SUM(NUM3))/(COUNT(*)*3) as RATING from HOSPITAL h
    join RATING_H rd on rd.HID=h.HID
    where h.HID='$hid'")->row();
  }
  public function getDoctors($hid){
    return $this->q("
    select
    d.NAME as NAME, d.MAJOR as MAJOR, d.DID as DID,
    d.PROFILE as PROFILE
    from HOSPITAL h
    join DOCTOR d on h.HID=d.HID
    where h.HID='$hid'")->result_array();
  }

  public function getDoctor($did){
    return $this->q("
    select (SUM(NUM1)+SUM(NUM2)+SUM(NUM3))/(COUNT(*)*3) as R_A,
    SUM(NUM1)/count(*) as R1,
    SUM(NUM2)/count(*) as R2,
    SUM(NUM3)/count(*) as R3,
    d.NAME as NAME,
    d.DESCRIPTION as DESCRIPTION,
    d.PROFILE as PROFILE
    from DOCTOR d
    join RATING_D r on d.DID=r.DID
    where d.DID='$did'
    ")->row();
  }
  public function getComment($did){
    return $this->q("
    select u.NAME as NAME, r.MAJOR as MAJOR,
    r.TIME as TIME, r.BODY as BODY, u.PROFILE as PROFILE
    from REVIEW r
    join USER u on u.UID=r.UID
    join DOCTOR d on d.DID=r.DID
    where d.DID='$did'
    ")->result_array();
  }
  public function sendReview($req){
    $this->q("
    insert into RATING_D
    (NUM1,NUM2,NUM3,DID,UID)
    values
    ('$req->R1','$req->R2','$req->R3','$req->did','$req->uid')
    ");
    $this->q("
    insert into REVIEW
    (BODY,MAJOR,UID,DID)
    values
    ('$req->body','$req->major','$req->uid','$req->did')
    ");
    return $this->q("
    select u.NAME as NAME, r.MAJOR as MAJOR,
    r.TIME as TIME, r.BODY as BODY, u.PROFILE as PROFILE
    from REVIEW r
    join USER u on u.UID=r.UID
    join DOCTOR d on d.DID=r.DID
    where d.DID='$req->did' order by TIME desc
    limit 1
    ")->row();
  }

  //main page
  public function getStat(){
    return $this->q("
    select
    (select count(*) from USER)-1 as PATIENT,
    (select count(*) from HOSPITAL) as HOSPITAL,
    (select count(*) from DOCTOR) as DOCTOR
    from USER
    ")->row();
  }
  public function getVR(){
    return $this->q("
    select *
    from CUSTOM_REVIEW
    ")->result_array();
  }

  public function getAllHospital(){
    return $this->q("select distinct HID,NAME as name,
    (select IMAGE from HOSPITAL_IMAGE hi where hi.HID=h.HID limit 1) as IMAGE
    from HOSPITAL h order by ORDERING")->result_array();
  }
  public function getHospitalByNum($num){
    return $this->q("select distinct HID,NAME as name,
    (select IMAGE from HOSPITAL_MAIN_IMAGE hi where hi.HID=h.HID limit 1) as IMAGE
    from HOSPITAL h order by ORDERING limit $num ,1")->row();
  }
  //nav
  //login
  public function login($req){
    return $this->q("
    select *
    from USER
    where EMAIL='$req->email' and
    PASSWORD='$req->password'
    ")->row();
  }
  //reset
  public function reset_find($email){
    return $this->q("
    select count(*) as cnt
    from USER
    where EMAIL='$email'
    ")->row();
  }
  public function reset_pw($email,$pw){
    return $this->q("
    update USER
    set PASSWORD='$pw'
    where EMAIL='$email'
    ");
  }


  //search
  public function getHospitalWithName($req){
    $name=urldecode($req->query);
    return $this->q("
    SELECT distinct h.NAME AS NAME, h.DESCRIPTION AS DESCRIPTION, (
    SELECT COUNT( * )
    FROM RATING_H r
    WHERE r.HID = h.HID
    ) AS REVIEW, h.HID AS HID,

    (select (SUM(NUM1)+SUM(NUM2)+SUM(NUM3))/(COUNT(*)*3)
    from RATING_H rd
    where rd.HID=h.HID) as RATING

    ,
    (select IMAGE from HOSPITAL_MAIN_IMAGE hmi where  hmi.HID=h.HID) as IMAGE
    FROM HOSPITAL h
    join DOCTOR d on d.HID=h.HID
    WHERE h.NAME LIKE  '%$name%'
    or d.MAJOR like '%$name%'
    order by HID desc
    limit $req->start, $req->num
    ")->result_array();
  }
  public function getEditData($hid){

    $data['main_image']=$this->q("
    select IMAGE from HOSPITAL_MAIN_IMAGE where HID='$hid'
    ");
    $data['hospital']=$this->q(
    "
    select * from HOSPITAL where HID='$hid'
    "
    )->result_array();
    $data['doctor']=$this->q(
    "
    select * from DOCTOR where HID='$hid'
    "
    )->result_array();
    $data['promotion']=$this->q(
    "
    select * from PROMOTION where HID='$hid'
    "
    )->result_array();
    $data['gallery']=$this->q(
    "
    select * from HOSPITAL_IMAGE where HID='$hid'
    "
    )->result_array();
    $main_image_temp=$this->q(
    "
    select IMAGE from HOSPITAL_MAIN_IMAGE where HID='$hid'
    "
    )->row();
    if(isset($main_image_temp->IMAGE)){
      $data['HOSPITAL_MAIN_IMAGE']=$main_image_temp->IMAGE;
    }else{
      $data['HOSPITAL_MAIN_IMAGE']="";
    }

    return $data;
  }
  //register
  public function register($req){
    return $this->q("
    insert into USER
    (EMAIL,NAME, PASSWORD)
    values
    ('$req->email','$req->name','$req->password')
    ");
  }
  public function numConsult(){
    return $this->q("select count(*) as cnt from CONSULTATION")->row();
  }
  public function deleteConsult($cid){
    $this->q("delete from CONSULTATION where CID='$cid'");
  }
  public function editConsult($req){
    $this->q("update CONSULTATION set BODY='$req->body', TITLE='$req->title' where CID='$req->CID'");
  }
  //consultation
  public function consultation($start){
    return $this->q("
    select * , (select count(*) from CONSULT_REPLY cr where c.CID=cr.CID) as count from
    CONSULTATION c
    order by time desc
    limit $start,10
    ")->result_array();
  }
  public function getConsult($cid){
    return $this->q("
    select * from
    CONSULTATION c
    where c.CID='$cid'
    ")->row();
  }
  public function getConsultReply($cid){
    return $this->q("
    select * from
    CONSULT_REPLY c
    where c.CID='$cid'
    order by TIME
    ")->result_array();
  }
  public function writeConsultReply($req){
    return $this->q("
    insert into
    CONSULT_REPLY
    (CID,BODY,AUTHOR)
    values
    ('$req->CID','$req->BODY','$req->AUTHOR')
    ");
  }
  public function writeConsult($req){
    return $this->q("
    insert into
    CONSULTATION
    (TITLE,AUTHOR,PASSWORD,BODY)
    values
    ('$req->title','$req->author','$req->password','$req->body')
    ");
  }
  public function deleteHospital($hid){
    $this->db->trans_start();
    $this->q("
    delete from HOSPITAL where HID='$hid'
    ");
    $this->q("
    delete from HOSPITAL_IMAGE where HID='$hid'
    ");
    $this->q("
    delete from HOSPITAL_MAIN_IMAGE where HID='$hid'
    ");
    $this->q("
    delete from PROMOTION where HID='$hid'
    ");
    $this->q("
    delete from DOCTOR where HID='$hid'
    ");
    $this->db->trans_complete();
  }
  public function editNewHospital($req){
    $hid=$req->hid;
    $doctor=$req->doctor;
    $gallery=$req->gallery;
    $hospital=$req->hospital[0];
    $promotion=$req->promotion;

    $tricare=$req->tricare;
    $specialtyList=$req->specialty;
    $specialty="";
    for($i=0; $i<count($specialtyList);$i++){
      $specialty.=$specialtyList[$i].",";
    }
    $langList=$req->lang;
    $lang="";
    if($langList->eng){
      $lang.="eng,";
    }
    if($langList->chi){
      $lang.="chi,";
    }
    if($langList->jap){
      $lang.="jap,";
    }

    $this->db->trans_start();
    $this->q("
    delete from HOSPITAL where HID='$hid'
    ");
    $this->q("
    delete from HOSPITAL_IMAGE where HID='$hid'
    ");
    $this->q("
    delete from PROMOTION where HID='$hid'
    ");
    $this->q("
    delete from HOSPITAL_MAIN_IMAGE where HID='$hid'
    ");
    $this->q("
    delete from DOCTOR where HID='$hid'
    ");
    for($i=0; $i<count($doctor); $i++){
      $data=$doctor[$i];
      $this->q("
      insert into DOCTOR
      (DID,HID,NAME, DESCRIPTION, PROFILE)
      values
      ('$data->DID','$hid','$data->NAME','$data->DESCRIPTION','$data->PROFILE')
      ");
    }
    $this->q("
    insert into HOSPITAL_MAIN_IMAGE (HID, IMAGE) values ('$hid','$req->HOSPITAL_MAIN_IMAGE')
    ");
    $this->q("
    insert into HOSPITAL
    (HID, NAME, DESCRIPTION, ORDERING, SPECIALTY, TRICARE, LANGUAGE)
    values
    ('$hid','$hospital->NAME','$hospital->DESCRIPTION','$hospital->ORDERING','$specialty','$tricare','$lang')
    ");
    for($i=0; $i<count($gallery); $i++){
      $data=$gallery[$i];
      $this->q("
      insert into HOSPITAL_IMAGE
      (HID,IMAGE)
      values
      ('$hid','$data->IMAGE')
      ");
    }
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
    {
      // generate an error... or use the log_message() function to log your error
      return log_message();
    }
  }
  //add hospital
  public function addHospital($req){
    $doctor=$req->doctor;
    $gallery=$req->gallery;
    $tricare=$req->tricare;
    $specialtyList=$req->specialty;
    $specialty="";
    for($i=0; $i<count($specialtyList);$i++){
      $specialty.=$specialtyList[$i].",";
    }
    $langList=$req->lang;
    $lang="";
    if($langList->eng){
      $lang.="eng,";
    }
    if($langList->chi){
      $lang.="chi,";
    }
    if($langList->jap){
      $lang.="jap,";
    }
    //insert hospital first and get new hid
    // ans insert doctors respectatively
    $this->db->trans_start();

    $this->q("
    insert into HOSPITAL
    (NAME, DESCRIPTION, ORDERING, SPECIALTY, TRICARE, LANGUAGE)
    values
    ('$req->hos_title','$req->hos_description','$req->ordering','$specialty','$tricare','$lang')
    ");
    $new_hospital=$this->q("
    select max(HID) as hid from HOSPITAL
    ")->row();
    $new_hid=$new_hospital->hid;


    for($i=0; $i<count($doctor); $i++){
      $data=$doctor[$i];
      $this->q("
      insert into DOCTOR
      (HID,NAME, DESCRIPTION, PROFILE)
      values
      ('$new_hid','$data->d_name','$data->d_description','$data->pic')
      ");
    }
    for($i=0; $i<count($gallery); $i++){
      $data=$gallery[$i];
      $this->q("
      insert into HOSPITAL_IMAGE
      (HID,IMAGE)
      values
      ('$new_hid','$data->image')
      ");
    }
    if($req->promotion!=''){
      $this->q("
      insert into PROMOTION
      (HID,PROMOTION)
      values
      ('$new_hid','$req->promotion')
      ");
    }
    $this->q("
    insert into HOSPITAL_MAIN_IMAGE (HID, IMAGE) values ('$new_hid','$req->HOSPITAL_MAIN_IMAGE')
    ");
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE)
    {
      // generate an error... or use the log_message() function to log your error
      return log_message();
    }
  }

  private function q($query){
    return $this->db->query($query);
  }
}
