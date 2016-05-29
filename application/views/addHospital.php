<div class="container" >
  <div class="row page-title">
    <div class="col-xs-12 text-center">
      <span>Add Hospital</span>
    </div>
  </div>
</div>

<div class="container" ng-controller="add_hospital">
  <div class="row row-eq-height" style="margin-top:10px;">
    <div class="col-sm-8 col-sm-offset-2">
      <!-- search result block -->
      <div class="row">
        <div class="col-xs-12">
          <div class="search-result-block">
            <div class="search-result-area col-xs-12 col-sm-5">
              <div class="" style="margin-bottom:10px;">
                <div style="display:inline-block" class="search-result-title"
                id="hos_title" >
                HOSPITAL NAME
              </div>
              <div style="display:inline-block"  ng-show="!editStatus.hos_title||editStatus.hos_title==false"  ng-click="edit('hos_title')"><i class="glyphicon glyphicon-pencil"></i></div>
              <div style="display:inline-block"  ng-show="editStatus.hos_title==true"  ng-click="save('hos_title')">
                <i class="glyphicon glyphicon-ok"></i>
              </div>
            </div>
            <div class="">
              <div style="display:inline-block"  class="search-result-body" id="hos_description" >
                HOSPITAL DESCRIPTION
              </div>
              <div style="display:inline-block"  ng-show="!editStatus.hos_description||editStatus.hos_description==false"  ng-click="edit('hos_description')"><i class="glyphicon glyphicon-pencil"></i></div>
              <div style="display:inline-block"  ng-show="editStatus.hos_description==true"  ng-click="save('hos_description')">
                <i class="glyphicon glyphicon-ok"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row" >
      <div class="col-xs-12 col-sm-6" style="margin-bottom:20px;">
        <div class="relative" style="padding-top:50%; overflow:hidden;">
          <div class="row absolute width-100 height-100" style="left: 15px;top:0; overflow:hidden;">
            <div class="col-xs-6 grey-back height-100" style="padding:15px 0 0 15px;">
              <div class="">
                <div class="text-center" style="font-weight:600; font-size:15px; color:white;">POSITION</div>

              </div>
            </div>
            <div class="col-xs-6 grey-back height-100" style="padding:15px 10px 0 0px;">
              <div class="">
                <div class="text-center" style="font-weight:600; font-size:15px; color:white;">
                  <input class="form-control"
                  type="number" ng-model="hospital_data.ordering">


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6" style="margin-bottom:20px;">
        <div class="relative" style="padding-top:50%; overflow:hidden;">
          <div class="row absolute width-100 height-100" style="left: 15px;top:0; overflow:hidden;">
            <div class="col-xs-6 grey-back height-100 text-center relative" style="padding:0;display:table; text-align:center" >
              <div class="absolute" style="top:15px; left: 50%;
              margin-left: -32px; font-weight:600; font-size:15px; color:white;
              ">GALLERY</div>
              <i class="glyphicon glyphicon-plus" style="display: table-cell;  vertical-align: middle;  font-size: 40px; color: white;"></i>
            </div>
            <div class="col-xs-6 blue-back height-100 text-center relative" style="padding:0px 0 0 0px;display:table; text-align:center">
              <div class="absolute" style="top:15px; left: 50%;
              margin-left: -46px; font-weight:600; font-size:15px; color:white;
              ">PROMOTION</div>
              <i class="glyphicon glyphicon-plus" style="display: table-cell;  vertical-align: middle;  font-size: 40px; color: white;" ng-click="addPromotion()"></i>
            </div>
          </div>
        </div>
      </div>


      <div class="col-xs-12 col-sm-3" style="margin-bottom:20px;" ng-repeat="i in promotion_data">
        <div class="relative blue-back" style="padding-top:100%; overflow:hidden;">
          <!-- <div class="col-xs-6 height-100 text-center relative" style="padding:0;display:table; text-align:center" >
          <i class="glyphicon glyphicon-plus" style="display: table-cell;  vertical-align: middle;  font-size: 40px; color: white;"></i>
        </div> -->
      </div>
    </div>


  </div>
  <div class="row page-title" style="margin-top:-10px;">
    <div class="col-xs-12 text-center">
      <span>Add Doctors</span>
    </div>
  </div>
  <div class="row" style="padding: 0 50px; margin-bottom:20px;">

    <!-- add doctor -->
    <div class="col-xs-6 col-sm-3">
      <div class="profile_area text-center" style="border-radius:50%; background:#dedede; height: 100px;
      width: 100px;display:table;">
      <i class="glyphicon glyphicon-plus" style="display: table-cell;  vertical-align: middle;  font-size: 40px; color: #39bbcf;" ng-click="doctor_add_open()"></i>
    </div>
    <div style="margin-top:5px; font-size:12px;" class="text-center">
      <span>None</span>
    </div>
  </div>

  <!-- added doctor -->
  <div class="col-xs-6 col-sm-3" ng-repeat="i in hospital_data.doctor">
    <div class="profile_area text-center" style="border-radius:50%; background:#dedede; height: 100px;
    width: 100px;">
  </div>
  <div style="margin-top:5px; font-size:12px;" class="text-center">
    <span>None</span>
  </div>
</div>

</div>


<div class="row" style="margin-bottom:20px;"  ng-show="add_doctor">
  <div class="col-xs-12">
    <div class="search-result-block relative" style="height: auto; margin-bottom:0px;">
      <div class="media">
        <div class="media-left" style="padding: 30px 20px;">
          <div class="profile_area text-center" style="border-radius:50%; background:#dedede; height: 100px;
          width: 100px;display:table;">
          <i class="glyphicon glyphicon-plus" style="display: table-cell;  vertical-align: middle;  font-size: 40px; color: #39bbcf;" ng-click="addProfile()"></i>
        </div>
      </div>
      <div class="media-body" style="padding: 20px 10px;">
        <div style="display:inline-block" class="search-result-title"
        id="d_name" >
        DOCTOR NAME
      </div>
      <div style="display:inline-block"  ng-show="!editStatus.d_name||editStatus.d_name==false"  ng-click="D_edit('d_name')"><i class="glyphicon glyphicon-pencil"></i></div>
      <div style="display:inline-block"  ng-show="editStatus.d_name==true"  ng-click="D_save('d_name')">
        <i class="glyphicon glyphicon-ok"></i>
      </div>

      <div style="font-size: 9px; color:white; margin-top:10px; " id="d_description">
        DOCTOR DESCRIPTION
      </div>
      <div  ng-show="!editStatus.d_description||editStatus.d_description==false"  ng-click="D_edit('d_description')"><i class="glyphicon glyphicon-pencil"></i></div>
      <div style="display:inline-block"  ng-show="editStatus.d_description==true"  ng-click="D_save('d_description')">
        <i class="glyphicon glyphicon-ok"></i>
      </div>

      <button class=" write-review-button" style="margin-top:10px;" type="button" ng-click="">ADD DOCTOR</button>


    </div>
  </div>


</div>
</div>
</div>

<div class="row text-center" style="margin-bottom:50px;">
  <button class=" write-review-button" style="width:50px;height:50px; border-radius:50%;" type="button" ng-click="addHospital(hospital_data)">ADD</button>
</div>
</div>
</div>
</div>
