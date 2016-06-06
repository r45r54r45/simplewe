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
    join HOSPITAL_IMAGE hi on hi.HID=h.HID
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
  public function getHospitalWithName($name){
    $name=urldecode($name);
    return $this->q("
    SELECT distinct h.NAME AS NAME, h.DESCRIPTION AS DESCRIPTION, (
    SELECT COUNT( * )
    FROM RATING_H r
    WHERE r.HID = h.HID
    ) AS REVIEW, h.HID AS HID,
    (select IMAGE from HOSPITAL_IMAGE hi where  hi.HID=h.HID limit 1) as IMAGE
    FROM HOSPITAL h
    join DOCTOR d on d.HID=h.HID
    WHERE h.NAME LIKE  '%$name%'
    or d.MAJOR like '%$name%'
    order by HID desc
    ")->result_array();
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

  //consultation
  public function consultation(){
    return $this->q("
    select * , (select count(*) from CONSULT_REPLY cr where c.CID=cr.CID) as count from
    CONSULTATION c
    order by time desc
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

  //add hospital
  public function addHospital($req){
    $doctor=$req->doctor;
    $gallery=$req->gallery;
    //insert hospital first and get new hid
    // ans insert doctors respectatively
    $this->db->trans_start();

    $this->q("
    insert into HOSPITAL
    (NAME, DESCRIPTION, ORDERING)
    values
    ('$req->hos_title','$req->hos_description','$req->ordering')
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
