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
  var start=0;
  $scope.init=function(){
    $scope.block_title=[];
    $scope.currentHosNum=0;
    $scope.maxHospital;
    $scope.moreHospitalFlag=true;
    $scope.prevHospitalFlag=false;
    $scope.mode="Hospital";
    asyncGet(0,9);
  }

  var asyncGet=function(start,number){
    //target은 캐시되는 배열
    for(var i=start; i<start+number; i++ ){
      $http.get("/data/getHospitalByNum/"+i).then(function(res){
        //return also its number
        if(res.data.HID)
        $scope.block_title[res.data.num]=res.data;
        else{
          $scope.block_title[res.data.num]=null;
          $scope.moreHospitalFlag=false;
        }
      });
    }
  }

  $scope.changeMode=function(){
    if($scope.mode=="Hospital"){
      $scope.mode="Tricare";
      for(var i=0; i<9; i++){
        $scope.block_title[i]={};
        $scope.block_title[i].name=specialityList[i];
      }
    }
    else{
      $scope.currentHosNum=0;
      $scope.mode="Hospital";
      //get hospital info (image, hid, name)
      // $http.get("/data/getAllHospital").then(function(res){
      //   var data=res.data;
      //   for(var i=0; i<9; i++){
      //     $scope.block_title[i]={};
      //     $scope.block_title[i]=data[i+$scope.currentHosNum];
      //   }
      // });
      asyncGet(0,9);
    }
  }

  $scope.moveTo=function(data){
    if(data.HID){
      //hospital
      location.href="/hospital/"+data.HID;
    }else if(data==null){
      return;
    }else{
      location.href="/search?find="+data.name;
    }
  }

  $scope.prevHospital=function(){
    if($scope.mode=="Hospital"){
      $scope.nextHospitalFlag=true;
      asyncGet(start-=9,9);
      if(start==0){
        $scope.prevHospitalFlag=false;
        $scope.moreHospitalFlag=true;
      }
    }else{ //specialty 일 경우
      //other 메뉴로 연결
      // alert('other');
      location.href="/search?find=Other";
    }
  }
  $scope.nextHospital=function(){
    if($scope.mode=="Hospital"){
      $scope.prevHospitalFlag=true;
      asyncGet(start+=9,9);
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
  var data={};
  $scope.init=function(){
    $scope.hospital_list=[];
    var query=encodeURIComponent($scope.query);
    data.query=query;
    data.start=0;
    data.num=2;
    asyncGet(data);
  }

  var asyncGet=function(data){
    $http.post("/data/getHospitalWithName",data).then(function(res){
      var datum=res.data;
      if(datum.length==0&&data.start==0){
        $scope.empty_result=true;
        return;
      }else if(datum.length==0&&data.start!=0){
        $scope.more_result=false;
        return;
      }
      $scope.more_result=true;
      for(var i=0; i<datum.length; i++){
        var num=rating.floor(datum[i].RATING);
        datum[i].H_R=rating.draw(num);
      }
      $scope.hospital_list=$scope.hospital_list.concat(datum);
      console.log($scope.hospital_list);
    });
  }


  $scope.editHospital=function(hid){
    // link to hospital page
    location.href="/editHospital/"+hid;
  }
  $scope.deleteHospital=function(hid){
    if(confirm("Do you really want to delete this hospital? This procedure cannot be undone.")){
      $http.get("/data/deleteHospital/"+hid).then(function(){
        alert("Delete success!");
        location.reload();
      });
    }
  }
  $scope.linkToHospital=function(hid){
    // link to hospital page
    location.href="/hospital/"+hid;
  }
  $scope.loadMore=function(){
    data.start=data.start+data.num;
    asyncGet(data);
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
  $scope.start=0;
  $scope.init=function(){
    $scope.consultRange=[];
    getCustomNum($scope.start);
    $http.get("/data/numConsult").then(function(res){
      var count=res.data.cnt;
      for (var i = 1; i <= count/10+1; i++) {
        $scope.consultRange.push(i);
      }
    });
  }
  var getCustomNum=function(start){
    $scope.consultList=[];
    setTimeout(function(){
      $http.get("/data/consultation/"+$scope.start).then(function(res){
        $scope.consultList=res.data;
      });
    },500);
  }
  $scope.goConsult=function(num){
    $scope.start=(num-1)*10;
    getCustomNum($scope.start);
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
  $scope.specialityList=[
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
    $(".fixedHeight").css("height",$("#useThisHeight").height()+"px");

  }
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

  var defaultDoctorImg="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAZAAAAGQCAYAAACAvzbMAAAgAElEQVR4nO3deXxV5YH/8c+NMYQtBlnEJESEgCwBA1hAWYobIi3UWkDaWreujqXt79XpTKe2r9namWnLdFHacbooMyrtFGup2qqIsgiCgKwRqCwCAsGwhRAJhPTm98cTEENu7nbOec7yfb9eeSWGm3u/4D3PN2d7nlhTUxMiIiLpyrEdQEREgin37Bf79++3mUNERAKguLj43Ne5bTxOJIgKgW7nfVza/Lnred8raP5+LtAJyAc6tHiOlmrO+/oUcBKoAxqBo0AtcLj540jz56Pnfa5u8RwigacCkaApAvoAvZs/rjzv61Lce0+3VirpagT2ArubP94+7+vdwD4HXkPEMyoQ8aM8YBBQDlwNDOX9ksizlip7uZjy65Pgzxt4v0w2ARuBSmBL85+J+IoKRGwrwRTEUExZlAMDiOZ7Mw/o3/wx8bzvNwLbMGWyEVMulZi9GRFrYmcv49VJdPFAATCy+eNaYDTmnIRk5jCwClgJrG7+qLWaSELv/JPoKhBxUzdgPPDh5s9D0aXjbopj9k6WAUuB5ZiT9yKOUYGIWzoBE4CbgZsw5zHEri3AK8CLwBLMlWMiGVOBiJMqgMnALcB1RPPcRVA0Aq9hyuTPwAa7cSSIVCCSjXzgBmAK8FHMSXAJpn3Ac8CzmL2UU3bjSBCoQCRdHTB7GdObP3eyG0dcUIfZK5nf/Pmk3TjiVyoQSUU+piw+3fw5324c8dApTIk82fxZeyZyjgpEEsnBnPz+NHAb5rJbibZaYAGmTBZhrvSSCFOBSEulwOeB+zBThYi05gDwKPBLdBNjZKlABMzVUlMxxTER3Z8hqYtj9kZ+idk7abQbR7yk2XijrQxTGvcAPexGkYDKwfzSMRFzo+JcTJnssJhJLNBvndGQA0wDFgPbgb9D5SHO6IF5P23HvL+moXElMvQ/OtwKgb/FTBs+H3OXuIhbJmDeZ29j3ndOTIEvPqYCCafewMPAO8APMSfJRbxSinnf7ce8D3tbTSOuUYGEy1DM5ZbbgS+jG/7Erg6Y9+F2zPtyqN044jQVSDhcAzyPWSviU+jiCPGXXMz7ciPmfXqN3TjiFBVIsA3FzGO0BphkOYtIKiZh3q/PYibilABTgQTTIMzJyo2YCQ1FguajwHrM+1jT/geUCiRY+mOOJW/GXC4pEnTTMO/nJzHvbwkQFUgwlAKPAW9ijiXr/5uESQ7mff0m8D/oqsHA0EDkb4XA94G/YO4c18lxCbNc4C7M+/2H6D4S31OB+FMu8De8f9e4plKXKMnH3Ii4HbMd6Bcnn1KB+M8EzMnxnwHd7EYRsaobZjvYiFkFU3xGBeIfpZgrUhajq1JEzjcIeBmzfej8iI+oQOzLA74JbEVXVom0ZRrm/Mg3MduNWKYCsWss5lr4f8dM+yAibcvHbC/rMduPWKQCseNSzPoJr6LDVSKZGITZfn6J2Z7EAhWI927HHK76nO0gIiHwOcz2dLvtIFGkAvFOD+D/gN+jxZxEnNQDs13NR9uWp1Qg3piBuct2hu0gIiE2DbOdzbQdJCpUIO4qBH6D2fPQPR0i7uuG2eZ+g+5kd50KxD03YSaJ029DIt6bidkbucl2kDBTgTgvD/gx8BJQYjmLSJQVYbbDn6L7RlyhAnFWf2Al8DXbQUTknK8Ar6Pp4h2nAnHOXcAbwHDbQUTkAhWY7fMeyzlCRQWSvQ6YtTr+B+hkOYuIJNaJ97dVzfzgABVIdsowu8b3WM4hIqm7Cx3ScoQKJHPTMLvE5baDiEjayoE1aALTrKhA0peDWSVwPlBgOYuIZK4Asx1/H42FGdE/WnoKgT9hVgkUkXD4O+B5dONh2lQgqRuE2eWdZDuIiDhuImb71iHpNKhAUjMRc39Hme0gIuKaMmAFZnuXFKhAkrsPc9hK5ztEwq8As73fZztIEKhA2vY94NdAru0gIuKZXMx2/z3bQfxOBdK6PMxsnt+yHURErPkWZhzQPFoJqEAudCnwMppFV0TMOPAyWja3VSqQD+qDOVk+1nYQEfGNsZg71/vYDuI3KpD3VWDKQ9MbiEhLZZjxocJ2ED9RgRjjgaVoPWURSawHZpwYbzuIX6hAYDLmLlRdpisiyRQAL2LGjciLeoHMAP6IpnYWkdTlY8aNGbaD2BblAvkU5hI93eMhIunKxYwfn7IdxKaoFsg9wONE9+8vItnLwYwj91jOYU0UB9D7MKuSRfHvLiLOysHctR7JqU+iNojeg/mfLSLilBzgl0RwTyRKBfIpVB4i4o6zeyKROicSlQKZhs55iIi7zp4TicwyuVEYUCcDTxKNv6uI2JWDGW8icZ9I2AfVsZg1jzWbpoh4JQ8z7oR+Tr0wF0gFZmEY3SQoIl7rgBl/Qj13VlgLpAx4CU1PIiL2FGDGodAuhR3GAumGmduqm+0gIhJ5oR6PwlYgZ3cbQ9v4IhI4ZYT0cHqYCiQHMzfNSNtBRERaGIkZn8I05obqL/MzYKrtECIiCUzFjFOhEZYC+RvgS7ZDiIgk8SXMeBUKYSiQycDDtkOIiKToYUJyo2HQC2QQITyuKCKhdvZ8bbntINkK8sBbiFkVTPd6iEjQFAB/wIxjgRXUAskB/g9drisiwVVGwI+gBDX494GJtkOIiGRpEvDvtkNkKogFMg34W9shREQc8ncEdAr4oBVIf7QolIiEz68x41ugBKlAOgC/RyfNRSR8CjDjW6CmOwlSgfwXIbjsTUQkgXLMOBcYQSmQu5o/RETC7C7gHtshUhWEAulPyOaPERFpw8ME5HyI3wskD3O/RyfbQUREPNIJM+75filuvxfI9wn5kpAiIq2owIx/vubnArkJ+JrtECIilnwNMw76ll8LpBB4zHYIERHL/gcfz5fl1wL5L6DEdggREcuK8PGlvX4skBnATNshRER8YiZmXPQdvxVID3TJrohISz/DjI++4rcC+RnQzXYIERGf6YYPf7n2U4HcTkBnpBQR8cA0fDZG+qVALsWH7Soi4jM/w4yXvpBrO0Cz7wM9bYeQ6Kivr2f37t0cOHCAqqoqDh06xPHjxzl+/Dhnzpyhvr6eeDxOXl4eF198Mfn5+VxyySV06dKFnj170rNnT0pKSujVqxcXXXSR7b+OREcPzHj5edtBAGJNTU0A7N+/31aGscCrtl5coqG+vp5t27ZRWVnJtm3bqKqq4ux7PxsXX3wxV1xxBQMHDmTQoEH069dPhSJeGAcst/HCxcXF5762XSB5wHpgkI0Xl3A7c+YMa9euZc2aNVRWVnLmzBnXX7Njx45UVFQwcuRIysvLycnxy1FiCZktwDCgwesX9lOBfAv4no0XlvA6cuQIixcvZunSpdTV1VnLUVhYyHXXXcf1119Pt266uFAc9yDwb16/qF8KpBTYSsBW4BL/2r59OwsXLmTdunXE43Hbcc7Jyclh+PDh3HrrrfTp08d2HAmPk8BAYK+XL+qXApmPzy5Jk2DavXs3Tz/9NJs3b7YdJamhQ4dy2223ceWVV9qOIuHwFDDdyxf0Q4FMABZ7+YISPrW1tTz11FMsX77ckRPiXonFYowcOZLp06fTtWtX23Ek+K4Hlnj1YrYLJBdz4lzrm0tGmpqaWLp0KfPnz+fkyZO242QsLy+PqVOnMmnSJF25JdnYAlwNNHrxYrYL5Ev4eHZJ8bcjR47w6KOPsmXLFttRHFNSUsK9996r8yOSjQeAn3vxQjYLpADYiea7kgy88cYbPProo4He60gkJyeHqVOnMmXKFF36K5k4DPQFat1+ofMLxOt36oOoPCRN8XicefPmMWfOnFCWB5i/44IFC/iP//gPjh07ZjuOBE83zPjqKS/3QEqBvwD5br+QhEddXR0///nP2bp1q+0onuncuTP3338/AwcOtB1FguUU5rLe3W6+iK09kH9F5SFpOHToEN/97ncjVR4AJ06cYPbs2SxerAsVJS35mHHWM17tgQwCNuOf2X/F5/bs2cOPf/xjjh8/bjuKVRMnTmTmzJnEYjHbUSQY4pgrsirdegEbeyDf8/C1JOB27drFD37wg8iXB8DChQv5xS9+wV//+lfbUSQYcvBwL8SLQX0kcJsHryMhsHPnTmbPnh3ak+WZWLVqFQ8//DCNjZ5c5i/Bdxtm3HWdFwXi6TE5Ca59+/bxn//5n9TX19uO4jsbN25kzpw5KhFJlSeT1LpdIKOBiS6/hoRAdXU1s2fPVnm0YePGjTzyyCO+mihSfOsm4Dq3X8TtAvlHl59fQqC+vp6HHnpI5zxS8MYbb/Db3/7WdgwJBtfHXzcLZDQwycXnlxCIx+PMmTPH5oqYgfPSSy/pEl9JxUTMOOwaNwvkOy4+t4TE73//+1DNa+WVJ554gvXr19uOIf7n6l6IWwUyFJjs0nNLSKxfv57nn3/edoxAisfj/Pd//zf79u2zHUX8bRJmPHaFWwXy9y49r4TE8ePH+fWvfx2odTz85vTp08yZM0cXHkgyro3HbhRIb2CGC88rIfL444/z3nvv2Y4ReO+++y5z5861HUP8bQZmXHacGwXydcyiUSKtev3113njjTdsxwiN1atXs2LFCtsxxL9yMeOy45wukELgHoefU0Lk+PHjPP7447ZjhM6TTz7J0aNHbccQ/7oHMz47yukC+RzQyeHnlBB54okndOjKBfX19TqUJW3phBmfHeVkgeQCsxx8PgmZyspK1q5daztGaG3evJnVq1fbjiH+NQuHTy84WSC3YxaNErlAPB7XHdQe+M1vfqOrsiSRUsw47RgnC+QBB59LQubVV1/V3eYeqKmp4U9/+pPtGOJfjo7TThXIIGC8Q88lIdPY2MgzzzxjO0ZkLFy4kCNHjtiOIf40HjNeO8KpAvmiQ88jIbR06VJdIeShM2fOsGDBAtsxxL/ud+qJnCiQDsBdDjyPhFA8Htd0JRa89tprVFdX244h/nQnDl0t60SBzMSF64slHF5//XUdTrEgHo/z7LPP2o4h/lSIQ7OFOFEg9zrwHBJSL774ou0IkbVq1SpqampsxxB/+qwTT5JtgfQHxjoRRMJn165d7Nmzx3aMyGpsbOSVV16xHUP86TrM+J2VbAtEex+SkBY9sm/x4sVaR10SyXr8zqZActDJc0ng9OnTrFmzxnaMyKurq9PElZLIXWS5E5HND98AFGXz4hJe69ev5/Tp07ZjCLBs2TLbEcSfijDjeMayKZBPZ/PCEm4rV660HUGabd26lWPHjtmOIf6U1TieaYHk4/CcKhIe9fX1WufcR5qamnQ4URK5HTOeZyTTAvkoUJDpi0q4VVZW6sStz2gWZEmgADOeZyTTAvlkpi8o4bd+/XrbEaSFHTt2UFtbazuG+FPG43kmBdIBmJzpC0r4bd261XYEaaGpqUmHFSWRyZhxPW2ZFMhksjhmJuF24MAB3f3sU5s3b7YdQfwpnwx3CjIpkOmZvJBEw1tvvWU7giSgPRBpQ0bjeroFknFTSTTs3LnTdgRJoKamhsOHD9uOIf6U0ZGldAvkBhyaBljC6e2337YdQdqwa9cu2xHEnzqRwU2F6RbIlHRfQKLj9OnTHDhwwHYMacPevXttRxD/Snt8T7dAdPhKEqqqqqKpqcl2DGmDCkTakPb4nk6BlAOl6b6AREdVVZXtCJLEvn37bEcQ/yoFhqfzA+kUyNT0skjU6PCV/x07doyGhgbbMcS/0toLSadAbkkziETMoUOHbEeQFOhKLGlDWuN8qgXSCbOClUhCR48etR1BUqACkTaMJo0rbVMtkAlAbiZpJDqOHz9uO4KkQP+fpA25mPE+JakWiA5fSVInTpywHUFS8N5779mOIP6W8nifaoFktWqVhF88Hqe+vt52DEmBil6SSHm8T6VAugGDMs8iUaDfaoNDRS9JDAJ6pPLAVApkfHZZJAp0aWhw6GZPScHYVB6USoFcn2UQEfGRU6dO2Y4g/pfSuJ9KgaTURBJtOiwiEiopHXlKViAFwNDss4iIX7Rv3952BPG/csz436ZkBTIyhceI0K5dO9sRJEW5ubqlS5LKwYz/SR/UlqRPIAKQk6PfM4IiLy/PdgQJhtHJHpBsq7/WoSASch06dLAdQVKkvUVJ0ahkD0hWIEkbSATMoBSLxWzHkBR07tzZdgQJhqz2QEoxNxGKJJWTk0PHjh1tx5AUXHrppbYjSDB0A3q39YC2CiSthUVEOnVKeRJPsahr1662I0hwVLT1h20VyDCHg0jI6TfbYOjSpYvtCBIcbfZAWwXSZvOItKSByf/at2+vCx4kHW0eidIhLHHMZZddZjuCJFFUVGQ7ggRLRoewCoAS57NImKlA/K+4uNh2BAmWEtq4Iz1RgWj6dklbz549bUeQJEpK9HuhpK080R8kKpCEPyCSSM+ePXUviM+pQCQDCXcoEhXIYJeCSIjl5eXpRLrP6RyIZCBhHyQqkAEuBZGQ03kQ/+rcuTOXXHKJ7RgSPGnvgfR3KYiEnM6D+JcOX0mGyhL9QWsFkouZxkQkbVdccYXtCJLAlVdeaTuCBFMpphcu0FqB9E70YJFkevfubTuCJFBWlvAXSZG25JJgTqzWCkTvMslYcXGxFizyKRWIZKHVN09rBdLH5SASYrm5uTrW7kM9evTQNO6SjVZ7obUC0UFsyYrOg/hP3759bUeQYGt1o26tQHQCXbKi8yD+owKRLLXaCyoQcZyu9vGffv362Y4gwZZygegAtmSlV69etG/f3nYMaVZQUECvXr1sx5Bga7UXWisQzXUgWcnJydEVPz4yePBgzVEm2Wq1F1oWSDd0D4g44KqrrrIdQZoNGTLEdgQJvlygR8tvtiyQCx4gkolBg7QigB/EYjEGD9bcqOKIpAWiiYzEEb1796Zjx462Y0ReaWkpBQUJ1wMSSYf2QMQbsViMgQMH2o4ReeXlWtpHHKMCEe9UVLS5nLJ44Oqrr7YdQcIjaYEUehREImDIkCG6+seiSy65RFfDiZMu6IeWBaLl5MQxBQUFuqnQouHDh6vAxUkX9IP2QMRV11xzje0IkfWhD33IdgQJl6R7ICoQcZQKxI4uXbowYIBWphZHJS2QSz0KIhHRvXt3Ta5owejRo3X4SpyWtEDyPQoiEXLttdfajhA5+jcXF1zQDy0LpINHQSRCRo8eTU5Oa9OuiRuuvPJKTZ4obujU8hstt+oLHiCSrYKCAs3H5KFx48bZjiDhdMEORssCyfMoiESMBjVvtGvXjtGjR9uOIeGU9BCW9kDEFcOGDaOwUBf5uW3cuHFai0XckvQQlogrcnJyGD9+vO0YoRaLxbj++uttx5AIUYGIZ66//npyc7XcjFuGDBlCUZHWgxPv6BCWeKawsJBRo0bZjhFakydPth1Bwi3pISztkYirJk6cqBvcXFBWVqZVIMVtF/SDCkM8VVpaytChQ23HCJ2pU6fajiARpAIRz02ZMsV2hFApKyvTfTZiRcsCiVtJIZHSt29fLXTkoNtvv912BImGC/qhZYHUeRREIm7GjBma3sQBV199tZYOFq9c0A/agsWKoqIiPvzhD9uOEWg5OTnMmDHDdgyJMBWIWHPbbbfpruks3HjjjbrvQ6zSISyxpqCggFtvvdV2jEAqLCzk4x//uO0YEi1JD2E1eBREBIBbbrmFyy67zHaMwJk5c6b23sRrp1p+Q3sgYlVeXh6f+9zndEI9DRUVFbqjX2w42fIbLbfaCx4g4raysjJuvvlm2zECoWPHjtx99922Y0g0JT2EdcEuiogXbr/9di6//HLbMXzv3nvv1bT4YkvSQ1g1HgUR+YC8vDzuu+8+Hcpqww033MCIESNsx5DouqAfWm6tRz0KInKBsrIy3VWdQO/evZk5c6btGBJtSQtEeyBi1eTJk6moqLAdw1c6d+7MrFmzuPjii21HkWhLWiDHPAoi0qpYLMYXvvAFSkpKbEfxhdzcXB544AEuvfRS21FELugH7YGI77Rv355Zs2bRuXNn21GsisVi3HfffVrnQ/wi6R5ItUdBRNrUo0cPvva1r0X6ZrmZM2dy7bXX2o4hctYF/aACEd/q06cPs2bNIi8vz3YUz02fPp2JEyfajiFyvqQFctCjICIpGThwIF/5ylciUyKxWIxp06ZpfXPxI+2BSPAMHjyYr3/96+Tn59uO4qqcnBzuvvtuPvKRj9iOItKapAVyGGj0JotI6vr378+DDz4Y2quR2rVrx5e//GWtkSJ+1UgKBQJwwP0sIukrKSnhO9/5Dn379rUdxVHdu3fn29/+NsOGDbMdRSSRVnuhtQLZ53IQkYwVFhbyzW9+kxtvvNF2FEdcc801/NM//ZPuexG/a7UXclv53l7gOneziGQuNzeXO++8k8GDBzN37lxqa2ttR0pbfn4+d9xxBxMmTLAdRSQVe1v7ZmsFoj0QCYRhw4bRr18/5s2bx6pVq2hqarIdKSUVFRXceeeddO3a1XYUkVSlXCBvuxxExDGdOnXiC1/4AuPHj2fevHm88847tiMlVFRUxMyZMxkyZIjtKCLp2tPaN2Nnf2vbv3//2e9NAp73JpOIc5qamli9ejULFizg4EH/3NJUVFTElClTGDVqFLFYzHYckUzcCrwAUFxcfO6brRVIGbDd22wizmlqamLDhg289NJLbN261UqGWCxGeXk5N954I0OHDlVxSND1A3ZA8gLJBepp/fCWSKBUVVWxcuVK1qxZ48leSWlpKaNGjWLUqFE6xyFh0Qi0b/6ctEAAdgJ9PIsn4oHq6mo2bdrEtm3b2LlzJzU12U8+3aNHD/r27cuAAQMYMmQIXbp0cSCpiK/sAs7dfJVKgTyPORciElrHjh2jqqqKqqoqDh8+TG1tLbW1tTQ0NNDQ0HDuce3btycvL4+CggIKCwvp1q0bl19+OUVFRXTs2NHi30DEEwuBW87+x/kFkugw1TZUIBJyXbp0oUuXLgwaNMh2FBE/25LoD1q7Ex3gTZeCiIhIsCTsg0QFkrBxREQkUtLeA6l0KYiIiARLwj5IVCC1aEoTEZGo24fpg1YlKhCADc5nERGRAGmzB9oqkHUOBxERkWBpswfaKpD1DgcREZFgabMHtAciIiKJZHwIay9mjXQREYmew8Duth7QVoEArHIsioiIBEnS8T9Zgax0KIiIiATL68kekKxAVjsUREREgiXrPZDVQNyZLCIiEhBxUtiBSFYgtWhaExGRqKmkjTvQz0pWIADLss8iIiIBktK4n0qBLM4yiIiIBMvSVB6kPRAREWnJsT2Qw2h9EBGRqNgGVKfywFQKBOCVzLOISKqampo4duyY7RgSbYtSfWCqBfJihkFEHLNmzRoOHTpkO4YrGhoaWLJkCd/61rf4h3/4B7Zs0U6/WJPyeB9ramoCYP/+/W09rhNwDMjNKpZIBvbu3csf//hH1q1bRywWY+jQodx4442Ul5cTi8Vsx8tKVVUVy5cvZ9myZdTV1Z37fiwWo6KignHjxjF06FAuuugiiyklQhqBLkBdogcUFxef+zrVAgF4FRibdTyRFBw8eJA1a9awdu1a9u7d2+pjCgsLGT16NNdddx29evXyOGHmamtreeONN3jttdfYsWNH0scXFBQwevRoxo0bR0lJiQcJJcKWA+PaekCmBfJt4F+zyyaS2IEDB86Vxr596a2o3LNnTyoqKqioqKBfv37k5KR6dNYbVVVVbNy4kXXr1rFjxw7Obnfp6t27N2PHjmX06NF07NjR4ZQifAf4blsPyLRAKtAiU+KwY8eOsXLlSlasWMGBAwccec4OHTrQr18/rrrqKvr3788VV1xBbq53R1+bmpqoqqpix44dbNmyhb/85S/U1NQ4+hq5ubkMGzaMsWPHUl5e7rvClMAaQZK1oDItEIA9QGnm2UTg9OnTrFu3juXLl7N169aMfxtP1UUXXURRURGlpaWUlJRw2WWX0b17d7p37067du0yft6GhgYOHTpEdXU1hw4d4uDBg+zbt4933nmHU6dOOfg3aFthYSEjR47UIS7J1j4g6bHgbArkv4AvZZZNoqypqYmtW7eycuVK1qxZw+nTp21HAqB9+/YUFBTQuXNnOnXqxMUXX0xOTg7t27cHIB6PU19fD5jCOHHiBCdOnKC2ttY3f4fz9erV69whroKCAttxJFgeAe5P9qBsCmQy8KfMskkUHTp0iOXLl7NixQqOHDliO05k5OTkUF5ezpgxY6ioqCAvL892JPG/jwB/TvagbAokHziEuaxXpFV//etfWb9+PUuWLGHLli2uH6KStrVv355Ro0YxZswYysrKbMcRf6oDugNJj71mUyAA/wfMSDuehF51dTVLly5l+fLl1NYmnQlaLOjRowdjxoxhzJgxdO3a1XYc8Y/fAXek8sBsC2QaMD+9bBJWjY2NrFu3jiVLlrBt2zbtbQRELBZj4MCBjB07lhEjRugQl0wHnkrlgdkWSCfMYaz8tOJJqLz77rssWbKEFStWcOLECdtxJAs6xBV5pzCHrxLefX6+bAsE4PfA7en8gARfU1MTb775JosWLWLTpk3a2wihyy+/nGuvvZaxY8fSpUsX23HEG08Dn0j1wU4UiA5jRcipU6dYsWIFixYt4uDBg7bjiAfOXsU1fvx4KioqNBdXuKV8+AqcKZB84F1AF5qH2LvvvsvLL7/M8uXLz90LIdFTUFDA2LFjGTt2LJdffrntOOKsWuAyUrj66iwnCgTgMeCedH9I/O3sYaqXXnqJzZs36zCVnBOLxbjqqquYMGECI0aM8HR6GHHNXODedH7AqQK5CXgp3R8Sf2poaGDFihUsXLhQh6kkqbN7JRMmTKB79+6240jmbiaNBaTAuQLJAd4BitL9QfGPuro6Xn75ZRYtWvSB9ShEUhGLxRg8eDA333wzQ4YMCfz6LBFzECgG4un80PkFks0+aBz4X+CbWTyHWFJdXc0LL7zAihUraGhosB1HAqqpqYnKykoqKyu57LLLuOGGGxg3bty5ucTE1+aSZnm0lM0eCEB/4BR5mfQAAA3oSURBVC/ZBBBv7du3j+eee441a9YQj2f13hFpVX5+PmPGjGHixIn06NHDdhxJ7CrgrXR/yKlDWGdppcIA2LVrF8899xwbNmzQiXHxRCwWY8SIEdx666306dPHdhz5oNeAMZn8oNMFch/w60x/WNy1fft2nnnmGSorK21HkQjr378/kyZNoqKiQudJ/OGzwKOZ/KDTBdIB2A8UZvoE4ry3336bP/zhD2zevNl2FJFzSktLmTp1KsOHD1eR2FOLOXme0VUzThcIwMPAl7N5AnHGnj17WLBgARs2bLAdRSShXr16MXXqVEaMGKEi8d7PgQcy/WE3CmQQ8GY2TyDZOXLkCPPnz2f16tU6xyGB0atXL6ZPn86QIUNsR4mSwcCWTH/YjQIBWAqMz/ZJJD0nT57k2WefZdGiRTQ2NtqOI5KRAQMGMHPmTK644grbUcJuOTAumydwq0BmYBabEg/E43FefvllFixYwMmTJ23HEclaLBZjwoQJTJs2jQ4dOtiOE1Z3YBaPyphbBZIL7ARKs30iaduOHTt4/PHH2bt3r+0oIo4rLCzkM5/5DMOHD7cdJWz2An2BrA5VuFUgAH8L/NCJJ5IL1dXVMX/+fF599VWd55DQu+aaa7jrrrvo3Lmz7Shh8Q1gdrZP4maBFGLmx+rkxJPJ+zZt2sRjjz1GTU2N7SginiksLOSLX/wiAwYMsB0l6OqAXkDWA8j5BZKT7ZO1UIOZX0Uc0tDQwOOPP85PfvITlYdETk1NDT/84Q9ZvHix7ShBNxcHyqMlp/dAAHoD28luokYBDh48yMMPP8yBAwdsRxGx7rbbbuNjH/uY7RhB1Aj0A3Y78WRu7oGACZnVWX6Bbdu28S//8i8qD5FmCxYs0J5IZn6HQ+XRkhsFAvB9l543ErZs2cKPfvQjLSMr0sITTzzBnj17bMcIGtfGY7cKZBPwgkvPHWpVVVX89Kc/5cyZM7ajiPhOPB7nySeftB0jSF7AjMeucKtAAP7ZxecOpaamJn71q19pgSeRNmzfvp3q6mrbMYLC1XHYzQJZBSx08flDZ/Xq1ezatct2DBHfW79+ve0IQbAQMw67xs0CAe2FpCwej/P000/bjiESCBs3brQdIQhcH3/dLpDX0F5IStauXavdcpEUbd++XYd627YIM/66yu0CAfiOB68ReIsWLbIdQSQwGhsb2bFjh+0YfubJuOtFgawGFnjwOoFVXV2tjUEkTdu2bbMdwa+eweVzH2d5USBg2jDu0WsFzuuvv67JEUXSpAtOWhUHHvTqxbwqkEpgnkevFThat1wkfbt379YvXheahxlvPeFVgYDZCznl4esFwqlTp9i5c6ftGCKB895773HkyBHbMfzkFB6fc/ayQHYDD3n4eoHw9ttvE4/r6J5IJhycBDYM5uDSnFeJeFkgAN8DDnv8mr72zjvv2I4gElgHDx60HcEvDgP/6vWLel0gtcA/evyavqYNQCRzR48etR3BL/4ZM756yusCAfgFHp7k8btjx47ZjiASWCoQALYBj9h4YRsF0gjMsvC6vnTy5EnbEUQCS6t0AvAAZlz1nI0CAVgCPGXptX1Fa36IZO748eO2I9j2FPCKrRe3VSAAXwci/+v36dOnbUcQCayI78GfxIyj1tgskL2Yq7IiLS8vz3YEkcBqbLRy5MYvvocZR62xWSAAszEngCKrXbt2tiOIBFaE9+C3YcZPq2wXSAPwecsZrCooKLAdQSSwcnJsD2HWfBEzflrlh3/95cCjtkPY0q1bN9sRRAIronvwjwLLbIcAfxQIwDeASK6mVFJSYjuCSGDl5+fbjuC1asx46Quxs7NZ+mBOmWnAfNshRER8bDqWb4EoLi4+97Vf9kDA/KPo3hARkdb5boz0U4GAuaNSky2KiHzQYcz46Ct+K5BqfPiPJCJi2Sx8eJ7YbwUC8Dvgt7ZDiIj4hG/HRD8WCMD9wAHbIURELDuAuefDl/xaIDXA3bZDiIhYdjdmPPQlvxYIwCLgJ7ZDiIhY8hBmHPQtPxcIwN8DG2yHEBHx2AZ8dMNgIn4vkAbgDqDOdhAREY+cxIx71ue6SsbvBQLwFlrBUESi4wHMuOd7QSgQgLnA/9oOISLisicw410gBKVAwFzaW2k7hIiISyrx8SW7rQlSgZwEPgHU2g4iIuKwWsz4Fqg1eoNUIGCOC37WdggREYd9loCc9zhf0AoEzGyU1pdyFBFxyGx8NstuqoJYIGDuD1loO4SISJYWYsazQApqgcQx10nvsB1ERCRDOzDjWNx2kEwFtUDAzA/zcXRSXUSCpxYzfvl2nqtUBLlAwFz29mkC3OAiEjlxzLgV+NsSgl4gAM8BX7UdQkQkRV/FjFuBF4YCAZgDPGI7hIhIEo9gxqtQCEuBgJk/5hnbIUREEniGkC3ZHaYCiQOfBFbbDiIi0sJqzPgUqvO1YSoQMNMAfARd3isi/rEDMy4FapqSVIStQAAOA7c2fxYRsSnU41EYCwRM49+M7hEREXtqMeNQaI+IhLVAwCwJOYUQ7jaKiO+dxIw/oV6SO8wFArCMgCwNKSKhcXYp7mW2g7gt7AUC5oadzxCyqx9ExJfimPEmFDcKJhOFAgH4HXA3KhERcc/Z8vid7SBeiUqBgFlrWItRiYhbPgvMsx3CS1EqEDCL1X/edggRCZ3PY8aXSIlagQD8CrgXHc4SkezFMePJr2wHsSGKBQLmNwWdExGRbMQx48hcyzmsiWqBgDkn8kmg0XYQEQmcRsz48YTtIDZFuUDAXC3xceCU7SAiEhinMONGZK62SiTqBQLmeu1b0LQnIpJcLWa8iMR9HsmoQIxlwPVAte0gIuJb1ZhxIvR3mKdKBfK+dcAYYJftICLiO7sw48M620H8RAXyQTuAa4G1toOIiG+sxYwLoZ1VN1MqkAtVAx8G/mw7iIhY92d0eDshFUjrTgIfAx6xHURErHkEMw7U2Q7iVyqQxBqB+4GvohsORaIkDvw/zPav+8TaoAJJ7iHMesb6LUQk/Oow2/tPbAcJAhVIal7AnETTFVoi4bULs52/YDtIUKhAUlcJfAhYaDuIiDhuIWb7rrQdJEhUIOk5CtwKzLYdREQcMxuzXR+1HSRoVCDpiwPfAKaj8yIiQVaH2Y6/gS6UyYgKJHNPoV1ekaA6e0j6KdtBgkwFkp1twCgiPqWzSMA8gdlut9kOEnQqkOydBD6DWZVMh7RE/OskZt3yzzR/LVlSgThnLjAC2GA5h4hcaANm+3zUdpAwUYE46y3MrvFDtoOIyDkPoUNWrlCBOK8BM/3JzcABy1lEouwAZvGnr2K2S3GYCsQ9i4DBwG9tBxGJoN8BQ9CNv65SgbirBvhk84duUhJx31HM9nYH2uZcpwLxxm+BgeiacxE3PY3ZzrTX7xEViHeqMXe9TkeL04g46ey29Qm0bXlKBeK9pzC/JelyQpHszUV799aoQOw4irmhaRy6tFAkE9swS0/fi851WKMCsWs5cDXwIHDKchaRIDgFfAez3SyznCXyVCD2NQD/BlyFOQkoIq17GrOdfBfd1+ELKhD/2Is5CXgjsMVyFhE/2YK5MfcTmO1EfEIF4j+vYHbPHwAOW84iYtNhzHZwNebGXPEZFYg/NQI/B/oBP0LnRyRaGjDv+36Y7aDRbhxJRAXibzXA1zHHff8XbUgSbo2Y93k/zPu+xm4cSUYFEgx7gbsxc2vNQ8tvSrjEMXePD8a8z3WeIyBUIMHyFvBpzDFh3TglYfA05v38Scz7WwJEBRJMlZipG4YBz1nOIpKJ5zDv309g3s8SQCqQYNsATMEslvOC5SwiqXgB836dglbvDDwVSDisBm7FHAqYh062i780Ys5xDMO8T1fbjSNOUYGEyybMOZJ+wBzgpN04EnEnMZfhXoU5x6E9jpBRgYTTbmAWUAz8PbqqRby1F/O+K8bcCLjLbhxxiwok3GqAHwB9MSfdNfmcuGk55n3WF/O+030cIacCiYZGzGW/H8Zcaz8HqLWaSMKiFvN+GoxZnuApdA4uMlQg0bMFc3jrcuDzwCq7cSSgVmHeP8WY95MmAI2gWFNTEwD79++3HEUsGoBZmOdOoMhyFvGvA8ATwGNoIbTIKi4uPve1CkTOlwPchLmS6zagwG4c8YFaYAHwG2AhmkYn8s4vkFyLOcR/4phBYiGQD3wUUyaTmv9bouEU5oa/JzF3jGs2aGmV9kAkFR2AyZgrbCYDnezGERfUAX8G5jd/1j1E0iodwpJs5GMOc30Es4dSYjeOZGEfpiyexSzYpD0NSUoFIk6qwBTJLcBodFjUzxoxV0+9iDk0pTvDJW0qEHFLJ2ACpkxuAAZZTSNgLq99BXip+XOd3TgSdDqJLm6pw/xme3aK+R7AWOB6YDxQju49clMcMzX6MmBp8+dqq4kk1LQHIl4qAEZiDnVd2/x1N6uJgu0wZmbblZhDU6vRDAPiMu2BiC21mJO1i877Xilmz2QoZjr6oUB/9N48XyNmtb5NwEbMXsYmNEmmWKaNVGzb2/zx5/O+l4c5f1LO+6XSu/kjz9t4nmrAzKS8mw+WxZbmPxPxFR3CkqApAvrwfqFced7Xpfj7l6JGTFnubv54+7yvd2MuqxXxNR3CkiA70PyxPMGfF2LOq5z9uLT5c9fzvlfQ/P1czJVj+ZibJcGc5G9tCpda3p/G4xTmRrs6TCkcbf7zw80fR5o/Hz3vczWa3lxCRgUiYVPT/LHDdhCRsDt3CEtERCQduiZfREQyogIREZGM/H9rhjTxlD30wQAAAABJRU5ErkJggg==";

  $scope.addDoctor=function(){
    var data=$scope.doctor_info;
    if(data.d_name&&data.d_description){
      //info:delete &&data.pic
      if(data.pic==undefined){
        data.pic=defaultDoctorImg;
      }
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

  $scope.selectMainImage=function(){
    $("#mainimage_add_modal").modal('show');
  }
  $scope.mainimageSelect=function(data){
    var target=document.getElementById(data);
    image.toDataURI(target,function(d){
      $scope.hospital_data.HOSPITAL_MAIN_IMAGE=d;
      $scope.$apply();
      $("#mainimage_add_modal").modal('hide');
    });
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
    }else if(!data.specialty){
      alert('fill specialty info');
      return;
    }else if(!data.lang){
      alert('fill language info');
      return;
    }else if(!data.tricare){
      alert('fill tricare info');
      return;
    }else if(!data.HOSPITAL_MAIN_IMAGE){
      alert('select main image');
      return;
    }
    else{
      //success
      disableScroll();
      $scope.loading=true;
      $scope.loadingTop=$(window).height()+screen.height/2+"px";
      $scope.loadingHeight=$(document).height()+"px";
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
    $(".heightFixed").css("height",$("#useThisHeight").height()+"px");
    $http.get("/data/getEditData/"+hid).then(function(res){
      console.log(res.data);
      $scope.hospital_data=res.data;
      $scope.hospital_data.hid=hid;
      $scope.hospital_data.specialty=res.data.hospital[0].SPECIALTY.split(",");
      var lang=res.data.hospital[0].LANGUAGE.split(",");
      $scope.hospital_data.lang={
        jap:(lang.indexOf("jap")!=-1?"true":"false"),
        eng:(lang.indexOf("eng")!=-1?"true":"false"),
        chi:(lang.indexOf("chi")!=-1?"true":"false")
      };
      $scope.hospital_data.tricare=res.data.hospital[0].TRICARE;
    });
  }
  $scope.doctor_info={};
  $scope.specialityList=[
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

  $scope.selectMainImage=function(){
    $("#mainimage_add_modal").modal('show');
  }
  $scope.mainimageSelect=function(data){
    var target=document.getElementById(data);
    image.toDataURI(target,function(d){
      $scope.hospital_data.HOSPITAL_MAIN_IMAGE=d;
      $scope.$apply();
      $("#mainimage_add_modal").modal('hide');
    });
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
    }else if(!data.specialty){
      alert('fill specialty info');
      return;
    }else if(!data.lang){
      alert('fill language info');
      return;
    }else if(!data.tricare){
      alert('fill tricare info');
      return;
    }else if(!data.HOSPITAL_MAIN_IMAGE){
      alert('select main image');
      return;
    }
    else{
      //success
      //loading screen
      disableScroll();
      $scope.loading=true;
      $scope.loadingTop=$(window).height()+screen.height/2+"px";
      $scope.loadingHeight=$(document).height()+"px";
      //trim data
      data.hospital[0].NAME=data.hospital[0].NAME.trim();
      data.hospital[0].DESCRIPTION=data.hospital[0].DESCRIPTION.trim();
      for(var i=0; i<data.doctor.length;i++){
        data.doctor[i].NAME=data.doctor[i].NAME.trim();
        data.doctor[i].DESCRIPTION=data.doctor[i].DESCRIPTION.trim();
      }
      $http.post("/data/editNewHospital",data).then(function(res){
        //cancel rounded spinning
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
  $scope.delete=function(){
    $http.get("/data/deleteConsult/"+$scope.num).then(function(res){
      location.href="/consultation";
    });
  }
  $scope.editing=function(){
    $scope.edit.body=$scope.consult.BODY;
    $scope.edit.title=$scope.consult.TITLE;
    $("#edit_modal").modal('show');
  }
  $scope.editForm=function(edit){
    edit.CID=$scope.num;
    $http.post("/data/editConsult",edit).then(function(res){
      location.reload();
    });
  }
});
