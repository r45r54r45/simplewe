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
  $scope.init=function(){
    $scope.block_title=[];
    $scope.currentHosNum=0;
    $scope.maxHospital;

    $scope.mode="Hospital";
    $http.get("/data/getAllHospital").then(function(res){
      var data=res.data;
      $scope.maxHospital=data.length;
      for(var i=0; i<9; i++){
        $scope.block_title[i]={};
        $scope.block_title[i]=data[i+$scope.currentHosNum];
      }
    });
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
    console.log(res.data);
    $scope.patient_review=res.data;
  });
});

app.controller("search",function($scope,$http){
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
    });
  }
  $scope.linkToHospital=function(hid){
    //TODO link to hospital page
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
    //get hospital info. by hid
    $http.get("/data/getHosp/"+$scope.HID).then(function(res){
      $scope.hospital=res.data;
    });
    //NAME, DESCRIPTION, RATING_hospital,
    //TODO RATING_hospital (hospital rating)

    // $scope.H_R=rating.draw(data.RATING_hospital);
    $http.get("/data/getRatingAllDoctor/"+$scope.HID).then(function(res){
      var num=rating.floor(res.data.RATING_doctor);
      $scope.D_R=rating.draw(num);
      $scope.hospital.RATING_doctor=num;
    });

    //get doctor info  with hid
    $http.get("/data/getDoctors/"+$scope.HID).then(function(res){
      $scope.doctor=res.data;
      console.log(res.data);
    });



    //NAME, MAJOR, DID (for downward comments)

  }



  $scope.toggleGallery=function(){
    $scope.gallery=!$scope.gallery;
    console.log("gallery toggle");
  }

  //temp for rating
  // $scope.doctor_area={};
  // $scope.doctor_area.R_1=rating.draw(3.5);
  // $scope.doctor_area.R_2=rating.draw(4.5);
  // $scope.doctor_area.R_3=rating.draw(1);

  $scope.openDoctor=function(DID){
    $scope.commentLimit=3;
    $scope.commentMore=true;
    $scope.doctor_info=false;
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
      //TODO PROFILE
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

  $scope.reviewForm=function(){
    if($scope.review.major&&$scope.review.R1&&$scope.review.R2&&$scope.review.R3&&$scope.review.body){
      //TODO send review

      //TODO add review to comments


      $('#review_modal').modal('hide');
      $scope.review={};
      var list=$(".major_click");
      for(var i=0; i<list.length; i++){
        list[i].style.background="#494949";
      }
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
    console.log("consultation test");
    $http.get("/data/consultation").then(function(res){
      $scope.consultList=res.data;
    });
  }
  $scope.openConsult=function(data){
    var pw=prompt("Write the password please");
    if(!pw){
      return;
    }
    if(data.PASSWORD!=pw){
      alert("Incorrect password");
      return;
    }else{
      //correct
      console.log("correct");
      //TODO response check and upload
    }
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
  $scope.promotion_data=[];
  $scope.edit=function(target){
    $("#"+target).focus();
  }
  $scope.addPromotion=function(){
    //TODO promotion data add
    $scope.promotion_data.push(new Date());
  }
  $scope.doctor_add_open=function(){
    $scope.doctor_info={};
    $scope.add_doctor=true;
  }
  //TODO doctor profile image
  $scope.addProfile=function(){
    $("#doctor_pic_modal").modal('show');
  }
  $scope.profileSelect=function(id){
    console.log(document.getElementById(id));
    image.toDataURI(document.getElementById(id),function(data){
      $scope.doctor_info.pic=data;
      // console.log(data); //returned data for image
      console.log($scope.doctor_info);
      $("#doctor_pic_modal").modal('hide');
      $scope.$apply();
    });
  }
  $scope.addDoctor=function(){
    var data=$scope.doctor_info;
    if(data.d_name&&data.d_description&&data.pic){
      //new doctor info checked
      $scope.hospital_data.doctor.push(data);
      // $scope.doctor_info.pic="";
      //TODO profile image on adding doctor still remaining
      $scope.doctor_info={};
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
    }else if(!data.hos_title||!data.hos_description){
      alert('fill hospital information');
      return;
    }else if(!data.ordering){
      alert('fill hospital location in main page');
      return;
    }else{
      //success
      //trim data
      data.hos_title=data.hos_title.trim();
      data.hos_description=data.hos_description.trim();
      for(var i=0; i<data.doctor.length;i++){
        data.doctor[i].d_name=data.doctor[i].d_name.trim();
        data.doctor[i].d_description=data.doctor[i].d_description.trim();
      }
      //post data and save data respectatively
      alert('Uploading data... Do not exit this page until noticed. Click Okay and WAIT!');
      $http.post("/data/addHospital",data).then(function(res){
        console.log(res.data);
        if(res.data.result=="true"){
          alert('upload complete');
          location.href="/hospital";
        }
      });
    }

  }

});
