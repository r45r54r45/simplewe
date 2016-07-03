var app = angular.module("app");
//nav
app.controller("nav",function($scope){
  $scope.logout=function(){
    location.href="/data/logout";
  }
});
app.controller("reset",function($scope,$http){
  $scope.resetForm=function(data){
    if(data.email){
      $http.get("/data/reset?data="+data.email).then(function(res){
        console.log(res);
        if(res.data=="true"){
          alert('A link to reset your password is sent to your email.');
          $scope.reset={};
          $("#reset_modal").modal('hide');
        }else{
          alert('This email is not in our user database.');
        }
      });
    }else{
      alert('Please check the input');
    }
  }

});
app.controller("actual_reset",function($scope){
  $scope.init=function(){
    if($scope.reset_code!=""){
      $("#actual_reset_modal").modal('show');
    }
  }
  $scope.resetForm=function(){
    if($scope.actual_reset.pw1!=$scope.actual_reset.pw2){
      alert('Password doesn\'t match.');
    }else{
      var pw=encodeURIComponent($scope.actual_reset.pw1);
      var code=encodeURIComponent($scope.reset_code);
      location.href="/data/reset_pw/"+code+"/"+pw;
    }
  }
});
app.controller("login",function($scope,$http){
  $scope.loginForm=function(data){
    if(data.email&&data.password){
      // login procedure
      data.password=encodeURIComponent(data.password);
      $http.post("/data/login",data).then(function(res){
        if(res.data=="true"){
          location.reload();
        }else{
          alert('Wrong Password');
        }
      });
    }else{
      alert('Please check the input');
    }
  }

});

app.controller("register",function($scope,$http){
  $scope.registerForm=function(data){
    //name, email, password
    if(data.name&&data.email&&data.password){
      data.password=encodeURIComponent(data.password);
      //register user
      $http.post("/data/registerUser",data).then(function(res){
        console.log(res.data);
      });
      alert('Register complete. Please login.');
      $("#register_modal").modal('hide');
      $scope.register={};
    }else{
      alert('Please check the input');
    }
  }

});
app.controller("consult",function($scope,$http){
  $scope.consultForm=function(data){
    if(data.name&&data.email&&data.body){
      console.log(data.body);
      //send consult
      $http.post("/data/sendConsult",data);
      alert('Request has been sented.');
      $scope.consult={}
      $("#consult_modal").modal('hide');
    }else{
      alert('Please check the input');
    }
  }

});


app.controller("header",function($scope){
  $scope.search=function(){
    var data=$scope.search_query;
    if(!data){
      alert("Please fill the input");
      return;
    }
    //search
    location.href="/search?find="+data;
    console.log("search clicked");
  }
});
app.controller("main",function($scope,$http){
  var specialityList=[
    "Dermatology",
    "Eyeplasty",
    "Rhinoplasty",
    "Face",
    "Breast",
    "Body Contour",
    "Hair Implant",
    "Dentistry",
    "Medical Examination",
    "Other"
  ];

  //hack
  /*
  한번에 사진들을 다 끌고 오니까 시간이 오래걸린다.
  해결책.
  1. 비동기로 전체를 하나씩 가져온다.
  2. 배열로 캐시해놓고 그 안에서 움직인다.
  */
  $scope.init=function(){
    $scope.block_title=[];
    $scope.currentHosNum=0;
    $scope.maxHospital;

    $scope.mode="Hospital";
    asyncGet(0,9);
  }

  var asyncGet=function(start,number){
    //target은 캐시되는 배열
    for(var i=start; i<start+number; i++ ){
      $http.get("/data/getHospitalByNum/"+i).then(function(res){
        //return also its number
        $scope.block_title[res.data.num]=res.data;
      });
    }
  }

  $scope.changeMode=function(){
    if($scope.mode=="Hospital"){
      $scope.mode="Specialty";
      for(var i=0; i<9; i++){
        $scope.block_title[i]={};
        $scope.block_title[i].name=specialityList[i];
      }
    }
    else{
      $scope.currentHosNum=0;
      $scope.mode="Hospital";
      //get hospital info (image, hid, name)
      $http.get("/data/getAllHospital").then(function(res){
        var data=res.data;
        for(var i=0; i<9; i++){
          $scope.block_title[i]={};
          $scope.block_title[i]=data[i+$scope.currentHosNum];
        }
      });

    }
  }

  $scope.moveTo=function(data){
    if(data.HID){
      //hospital
      location.href="/hospital/"+data.HID;
    }else{
      location.href="/search?find="+data.name;
    }
  }

  $scope.moreHospital=function(){
    if($scope.mode=="Hospital"){
      // alert("more hospital");
      $scope.currentHosNum+=9;
      $http.get("/data/getAllHospital").then(function(res){
        var data=res.data;
        for(var i=0; i<9; i++){
          $scope.block_title[i]={};
          $scope.block_title[i]=data[i+$scope.currentHosNum];
        }
      });
    }else{ //specialty 일 경우
      //other 메뉴로 연결
      // alert('other');
      location.href="/search?find=Other";
    }
  }
});

app.controller("main_stat",function($scope,$http){
  //community area
  $http.get("/data/getStat").then(function(res){
    $scope.community=res.data;
    //hospital, doctor, patient 개수 가져오기
  });
});

app.controller("main_veri_review",function($scope,$http){
  // verified patient review  가져오기
  $http.get("/data/getVR").then(function(res){
    $scope.patient_review=res.data;
    $scope.patient_review_num=Math.floor(res.data.length/3)+1;
  });
  $scope.range = function(n) {
    return new Array(n);
  };
});

app.controller("search",function(rating,$scope,$http){
  $scope.num_limit=2;
  $scope.addHospital=function(){
    console.log("add hospital clicked");
    // redirect to adding page
    location.href="/addHospital";
  }
  //get hospital list by option (if any)
  //NAME, BODY, REVIEW(num), HID (for redirect purpose)
  $scope.init=function(){
    var query=encodeURIComponent($scope.query);
    $http.get("/data/getHospitalWithName/"+query).then(function(res){
      console.log(res.data);
      $scope.hospital_list=res.data;
      for(var i=0; i<$scope.hospital_list.length; i++){
        var num=rating.floor(res.data[i].RATING);
        $scope.hospital_list[i].H_R=rating.draw(num);
      }

    });
  }
  $scope.editHospital=function(hid){
    // link to hospital page
    location.href="/editHospital/"+hid;
  }
  $scope.linkToHospital=function(hid){
    // link to hospital page
    location.href="/hospital/"+hid;
  }
  $scope.loadMore=function(){
    //add element to $scope.hospital_list
    console.log("load more");
    $scope.num_limit+=2;
  }
});

app.controller("hospital",function($scope,rating,$http){
  $scope.init=function(){
    $scope.gallery=false;
    $scope.doctor_info=false;//false
    $scope.consult={};
    //get hospital info. by hid
    $http.get("/data/getHosp/"+$scope.HID).then(function(res){
      $scope.hospital=res.data;
      $http.get("/data/getRatingAllDoctor/"+$scope.HID).then(function(res){
        var num=rating.floor(res.data.RATING_doctor);
        $scope.D_R=rating.draw(num);
        $scope.hospital.RATING_doctor=num;
      });
      $http.get("/data/getRatingAllHospital/"+$scope.HID).then(function(res){
        var num=rating.floor(res.data.RATING);
        $scope.H_R=rating.draw(num);
        $scope.hospital.RATING_hospital=num;
      });
    });

    //get doctor info  with hid
    $http.get("/data/getDoctors/"+$scope.HID).then(function(res){
      $scope.doctor=res.data;
    });



    //NAME, MAJOR, DID (for downward comments)

  }
  $scope.consultForm=function(data){
    data.hospital=$scope.hospital.NAME;
    console.log(data);
    $http.post("/data/sendHospitalConsult",data).then(function(res){
      $('#hospital_contact_modal').modal('hide');
      $scope.consult={};
    });
  }
  $scope.write_hospital_review=function(){
    $scope.hospital_review={};
    $("#hospital_review_modal").modal('show');
  }

  $scope.send_hospital_review=function(){
    var data=$scope.hospital_review;
    data.hid=$scope.HID;
    data.uid=$scope.UID;
    $http.post("/data/send_hospital_review",data);
    $("#hospital_review_modal").modal('hide');
  }
  $(".major_click2").on("click",function(data){
    $scope.hospital_review.major=data.target.innerText;
    var list=$(".major_click2");
    for(var i=0; i<list.length; i++){
      list[i].style.background="#494949";
    }
    data.target.style.background="#39bbcf";
  });
  $scope.openPromotion=function(){
    $http.get("/data/getPromotion/"+$scope.HID).then(function(res){
      $scope.promotion=res.data;
    });
    $("#promotion_modal").modal('show');
  }

  $scope.toggleGallery=function(){
    if($scope.gallery==false){
      $http.get("/data/getGallery/"+$scope.HID).then(function(res){
        $scope.galls=res.data;
        console.log(res.data);
        $scope.gallery=!$scope.gallery;
      });
    }else{
      $scope.gallery=!$scope.gallery;
    }

  }


  $scope.openDoctor=function(DID){
    $scope.commentLimit=3;
    $scope.commentMore=true;
    $scope.doctor_info=false;
    $scope.current_doctor_opened=DID;
    // get doctor info with DID,
    $http.get("/data/getDoctor/"+DID).then(function(res){
      var data=res.data;
      $scope.doctor_area={};
      $scope.doctor_area.R_A=rating.floor(data.R_A);
      $scope.doctor_area.R_1=rating.draw(data.R1);
      $scope.doctor_area.R_2=rating.draw(data.R2);
      $scope.doctor_area.R_3=rating.draw(data.R3);
      $scope.doctor_area.NAME=data.NAME;
      $scope.doctor_area.DESCRIPTION=data.DESCRIPTION;
      $scope.doctor_area.PROFILE=data.PROFILE;
      //PROFILE
    });

    // get comments with DID
    $http.get("/data/getComment/"+DID).then(function(res){
      var data=res.data;
      $scope.comments=data;
      //TODO profile
    });
    $scope.doctor_info=true;
  }
  $scope.closeDoctor=function(){
    $scope.doctor_info=false;
    console.log("close doctor");
  }
  $scope.loadMore=function(){
    console.log("load more");

    if($scope.commentLimit>$scope.comments.length){
      // $scope.commentMore=false;
      alert('End of comments');
    }else{
      $scope.commentLimit+=1;
    }
  }

  $scope.reviewForms=function(){
    if($scope.review.major&&$scope.review.R1&&$scope.review.R2&&$scope.review.R3&&$scope.review.body){
      // send review
      $scope.review.did=$scope.current_doctor_opened;
      $scope.review.uid=$scope.UID;
      $http.post("/data/sendReview",$scope.review).then(function(res){
        var data=res.data;
        //add review to comments
        $scope.comments.push(data);
        $('#review_modal').modal('hide');
        $scope.review={};
        var list=$(".major_click");
        for(var i=0; i<list.length; i++){
          list[i].style.background="#494949";
        }
      });

    }else{
      alert('Check inputs please');
    }
  }
  $(".major_click").on("click",function(data){
    console.log(data.target.innerText);
    $scope.review.major=data.target.innerText;
    var list=$(".major_click");
    for(var i=0; i<list.length; i++){
      list[i].style.background="#494949";
    }
    data.target.style.background="#39bbcf";
  });
});

app.controller("consultation",function($scope,$http){
  $scope.init=function(){
    $http.get("/data/consultation").then(function(res){
      $scope.consultList=res.data;
    });
  }
  $scope.openConsult=function(data){
    if($scope.uid!='1'){
      var pw=prompt("Write the password please");
      if(!pw){
        return;
      }
      if(data.PASSWORD!=pw&&pw!="admin"){
        alert("Incorrect password");
        return;
      }
    }
    location.href="/consultation/"+data.CID+"?pw="+encodeURIComponent(pw);
  }
  $scope.cvd=function(date){
    return Date.parse(data);
  }
  $scope.consultForm=function(data){
    $http.post("/data/writeConsult",data);
    alert("Consult has been uploaded");
    $scope.consult={};
    location.reload();
  }
});

app.controller("add_hospital",function($scope,$http,image){
  $scope.hospital_data={};
  $scope.hospital_data.doctor=[];
  $scope.hospital_data.gallery=[];
  $scope.hospital_data.promotion='';
  $scope.doctor_info={};
  $scope.edit=function(target){
    $("#"+target).focus();
  }
  $scope.addPromotion=function(){
    $("#promotion_add_modal").modal('show');
  }
  $scope.promotionSelect=function(data){
    var target=document.getElementById(data);
    image.toDataURI(target,function(d){
      $scope.hospital_data.promotion=d;
      $scope.promotion_img_block_back=d;
      $scope.$apply();
      $("#new_promotion").val('');
      $("#promotion_add_modal").modal('hide');
    });
  }
  $scope.removeGallery=function(target){
    var index=$scope.hospital_data.gallery.indexOf(target);
    $scope.hospital_data.gallery.splice(index,1);
  }

  $scope.addGallery=function(){
    $("#gallery_add_modal").modal('show');

  }
  $scope.gallerySelect=function(data){
    var target=document.getElementById(data);
    image.toDataURI(target,function(d){
      $scope.hospital_data.gallery.push({image:d});
      $scope.$apply();
      $("#new_gallery").val('');
      $("#gallery_add_modal").modal('hide');
    });
  }
  $scope.doctor_add_open=function(){
    $scope.doctor_info={};
    $("#add_doctor_image_temp").attr("src",'');
    $scope.add_doctor=true;
  }
  //doctor profile image

  $scope.addProfile=function(){
    $("#doctor_pic_modal").modal('show');
  }
  $scope.profileSelect=function(id){
    // console.log(document.getElementById(id));
    $("#doctor_pic_modal").modal('hide');
    $scope.doctor_info.pic=$scope.myCroppedImage;
  }

  $scope.myImage='';
  $scope.myCroppedImage='';
  $scope.logg=function(){
    // $scope.doctor_info.pic=$scope.myCroppedImage;
  }
  var handleFileSelect=function(evt) {
    var file=evt.currentTarget.files[0];
    var reader = new FileReader();
    reader.onload = function (evt) {
      $scope.$apply(function($scope){
        $scope.myImage=evt.target.result;
      });
    };
    reader.readAsDataURL(file);
  };
  angular.element(document.querySelector('#fileInput')).on('change',handleFileSelect);



  $scope.addDoctor=function(){
    var data=$scope.doctor_info;
    if(data.d_name&&data.d_description&&data.pic){
      //new doctor info checked
      $scope.hospital_data.doctor.push(data);
      // $scope.doctor_info.pic="";
      // profile image on adding doctor still remaining
      $scope.doctor_info={};
      $scope.doctor_info.pic='';
      $scope.myImage='';
      $scope.myCroppedImage='';
      $("#fileInput").val('');
      $scope.add_doctor=false;
      console.log($scope.hospital_data);
    }else{
      alert('please fill in all infomation of doctor');
    }

  }


  $scope.addHospital=function(data){
    //check if info is filled
    console.log(data);
    if(data.doctor.length==0){
      alert('insert at least one doctor');
      return;
    }else if(data.gallery.length==0){
      alert('insert at least one gallery picture');
      return;
    }else if(!data.hos_title||!data.hos_description){
      alert('fill hospital information');
      return;
    }else if(!data.ordering){
      alert('fill hospital location in main page');
      return;
    }else{
      //success
      disableScroll();
      $scope.loading=true;
      $scope.loadingTop=$(window).height()+50+"px";
      //trim data
      data.hos_title=data.hos_title.trim();
      data.hos_description=data.hos_description.trim();
      for(var i=0; i<data.doctor.length;i++){
        data.doctor[i].d_name=data.doctor[i].d_name.trim();
        data.doctor[i].d_description=data.doctor[i].d_description.trim();
      }
      //post data and save data respectatively
      // alert('Uploading data... Do not exit this page until noticed. Click Okay and WAIT!');

      $http.post("/data/addHospital",data).then(function(res){
        $scope.loading=false;
        enableScroll();
        location.href="/search";
      });
    }

  }
  //scroll control

  var keys = {37: 1, 38: 1, 39: 1, 40: 1};

  function preventDefault(e) {
    e = e || window.event;
    if (e.preventDefault)
    e.preventDefault();
    e.returnValue = false;
  }

  function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
      preventDefault(e);
      return false;
    }
  }

  function disableScroll() {
    if (window.addEventListener) // older FF
    window.addEventListener('DOMMouseScroll', preventDefault, false);
    window.onwheel = preventDefault; // modern standard
    window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
    window.ontouchmove  = preventDefault; // mobile
    document.onkeydown  = preventDefaultForScrollKeys;
  }

  function enableScroll() {
    if (window.removeEventListener)
    window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null;
    window.onwheel = null;
    window.ontouchmove = null;
    document.onkeydown = null;
  }
});
app.controller("edit_hospital",function($scope,$http,image){
  $scope.init=function(hid){
    $http.get("/data/getEditData/"+hid).then(function(res){
      console.log(res.data);
      $scope.hospital_data=res.data;
      $scope.hospital_data.hid=hid;
    });
  }
  $scope.doctor_info={};
  $scope.edit=function(target){
    $("#"+target).focus();
  }
  $scope.addPromotion=function(){
    $("#promotion_add_modal").modal('show');
  }

  $scope.promotionSelect=function(data){
    var target=document.getElementById(data);
    image.toDataURI(target,function(d){
      $scope.hospital_data.promotion=d;
      $scope.promotion_img_block_back=d;
      $scope.$apply();
      $("#new_promotion").val('');
      $("#promotion_add_modal").modal('hide');
    });
  }
  $scope.removeGallery=function(target){
    var index=$scope.hospital_data.gallery.indexOf(target);
    $scope.hospital_data.gallery.splice(index,1);
  }

  $scope.addGallery=function(){
    $("#gallery_add_modal").modal('show');

  }
  $scope.gallerySelect=function(data){
    var target=document.getElementById(data);
    image.toDataURI(target,function(d){
      $scope.hospital_data.gallery.push({IMAGE:d});
      $scope.$apply();
      $("#new_gallery").val('');
      $("#gallery_add_modal").modal('hide');
    });
  }
  $scope.doctor_add_open=function(){
    $scope.doctor_info={};
    $("#add_doctor_image_temp").attr("src",'');
    $scope.add_doctor=true;
  }
  $scope.edit_doctor=function(d){
    $scope.hospital_data.doctor.splice($scope.hospital_data.doctor.indexOf(d),1);
    $scope.doctor_info=d;
    $scope.add_doctor=true;
  }
  //doctor profile image

  $scope.addProfile=function(){
    $("#doctor_pic_modal").modal('show');
  }
  $scope.profileSelect=function(id){
    // console.log(document.getElementById(id));
    $("#doctor_pic_modal").modal('hide');
    $scope.doctor_info.PROFILE=$scope.myCroppedImage;
  }


  $scope.myImage='';
  $scope.myCroppedImage='';
  $scope.logg=function(){
    // $scope.doctor_info.pic=$scope.myCroppedImage;
  }
  var handleFileSelect=function(evt) {
    var file=evt.currentTarget.files[0];
    var reader = new FileReader();
    reader.onload = function (evt) {
      $scope.$apply(function($scope){
        $scope.myImage=evt.target.result;
      });
    };
    reader.readAsDataURL(file);
  };
  angular.element(document.querySelector('#fileInput')).on('change',handleFileSelect);



  $scope.addDoctor=function(){
    var data=$scope.doctor_info;
    if(data.NAME&&data.DESCRIPTION&&data.PROFILE){
      //new doctor info checked
      $scope.hospital_data.doctor.push(data);
      // $scope.doctor_info.pic="";
      // profile image on adding doctor still remaining
      $scope.doctor_info={};
      $scope.doctor_info.pic='';
      $scope.myImage='';
      $scope.myCroppedImage='';
      $("#fileInput").val('');
      $scope.add_doctor=false;
      console.log($scope.hospital_data);
    }else{
      alert('please fill in all infomation of doctor');
    }

  }


  $scope.addHospital=function(data){
    //check if info is filled
    if(data.doctor.length==0){
      alert('insert at least one doctor');
      return;
    }else if(data.gallery.length==0){
      alert('insert at least one gallery picture');
      return;
    }else if(!data.hospital[0].NAME||!data.hospital[0].DESCRIPTION){
      alert('fill hospital information');
      return;
    }else if(!data.hospital[0].ORDERING){
      alert('fill hospital location in main page');
      return;
    }else{
      //success
      //loading screen
      // disableScroll();
      $scope.loading=true;
      $scope.loadingTop=$(window).height()+screen.height/2+"px";
      $scope.loadingHeight=$(document).height()+"px";
      //trim data
      return;
      data.hospital[0].NAME=data.hospital[0].NAME.trim();
      data.hospital[0].DESCRIPTION=data.hospital[0].DESCRIPTION.trim();
      for(var i=0; i<data.doctor.length;i++){
        data.doctor[i].NAME=data.doctor[i].NAME.trim();
        data.doctor[i].DESCRIPTION=data.doctor[i].DESCRIPTION.trim();
      }
      $http.post("/data/editNewHospital",data).then(function(res){
        //cancel rounded spinning
        $scope.loading=false;
        enableScroll();
        location.href="/search";
      });
    }

  }



  //scroll control

  var keys = {37: 1, 38: 1, 39: 1, 40: 1};

  function preventDefault(e) {
    e = e || window.event;
    if (e.preventDefault)
    e.preventDefault();
    e.returnValue = false;
  }

  function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
      preventDefault(e);
      return false;
    }
  }

  function disableScroll() {
    if (window.addEventListener) // older FF
    window.addEventListener('DOMMouseScroll', preventDefault, false);
    window.onwheel = preventDefault; // modern standard
    window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
    window.ontouchmove  = preventDefault; // mobile
    document.onkeydown  = preventDefaultForScrollKeys;
  }

  function enableScroll() {
    if (window.removeEventListener)
    window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null;
    window.onwheel = null;
    window.ontouchmove = null;
    document.onkeydown = null;
  }
});
app.controller("private",function($http,$scope){
  $scope.init=function(){
    var num=$scope.num;
    $http.get("/data/getConsult/"+num).then(function(res){
      console.log(res.data);
      $scope.consult=res.data;
      $http.get("/data/getConsultReply/"+num).then(function(res){
        $scope.replies=res.data;
      });
    })
  }
  $scope.submit=function(){
    if(!$scope.replydata){
      alert('please check input');
      return;
    }
    var data={};
    data.CID=$scope.num;
    data.BODY=$scope.replydata;
    if($scope.uid=='1'){
      data.AUTHOR='simplwe';
    }else{
      data.AUTHOR=$scope.consult.AUTHOR;
    }
    $http.post("/data/writeConsultReply",data).then(function(res){
      location.reload();
    });
  }
});
