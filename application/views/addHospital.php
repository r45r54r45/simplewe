<div class="container" >
  <div class="row page-title">
    <div class="col-xs-12 text-center">
      <span>Add Hospital</span>
    </div>
  </div>
</div>

<div class="container" ng-controller="add_hospital">
  <div ng-show="loading" style="position:absolute; left:0; top:0; height:{{loadingHeight}}; width:100%;; z-index:9999; background:rgb(0,0,0); opacity:0.7;display:table;">
    <div style="text-align: center;
    vertical-align: middle;
    display: table-cell; color:#D3D3D3; margin-top:{{loadingTop}}">
    Loading...
  </div>
  </div>
  <div class="row row-eq-height" style="margin-top:10px;">
    <div class="col-sm-8 col-sm-offset-2">
      <!-- search result block -->
      <div class="row">
        <div class="col-xs-12">
          <div class="search-result-block">
            <div class="search-result-area col-xs-12 col-sm-6">
              <div class="" style="margin-bottom:10px;">
                <div style="display:inline-block" class="search-result-title" >
                  <input class="embedded_input"  type="text" id="hos_title"  placeholder="HOSPITAL NAME" ng-model="hospital_data.hos_title">
                </div>
                <div style="display:inline-block; margin-left: 10px;"  ng-click="edit('hos_title')"><i class="glyphicon glyphicon-pencil"></i></div>

              </div>
              <div class="">
                <div style="display:inline-block; width:100%"  class="search-result-body">
                  <div style="display: inline-block;
                  width: 90%;">
                  <textarea  class="embedded_input"  type="text" id="hos_description"
                  style="width: 100%;height: 100px;resize:none;"
                  placeholder="HOSPITAL DESCRIPTION" ng-model="hospital_data.hos_description"></textarea>
                </div>

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
                  <input class="form-control embedded_input"
                  type="number" placeholder="position"  ng-model="hospital_data.ordering">


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
              <i class="glyphicon glyphicon-plus" style="display: table-cell;  vertical-align: middle;  font-size: 20px; color: white;"  ng-click="addGallery()"></i>
            </div>
            <!-- gallery modal start -->
            <div class="modal fade" id="gallery_add_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-body" style="text-align: center;padding: 20px 10px;">
                    <input class="form-control" type="file" id="new_gallery">
                    <button class=" write-review-button" style="margin-top:10px;" type="button" ng-click="gallerySelect('new_gallery')">Select File</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- gallery modal finish -->
            <div class="col-xs-6 blue-back height-100 text-center relative" style="padding:0px 0 0 0px;display:table; text-align:center; background-size: cover;" id="promotion_block">
              <img ng-src="{{promotion_img_block_back}}" style="    position: absolute;
              top: 0;
              left: 0;
              width: 100%; height:100%;"/>
              <div class="absolute" style="top:15px; left: 50%;
              margin-left: -46px; font-weight:600; font-size:15px; color:white;
              ">PROMOTION</div>
              <i class="glyphicon glyphicon-plus" style="display: table-cell;  vertical-align: middle;  font-size: 20px; color: white;" ng-click="addPromotion()"></i>
            </div>
            <!-- promotion modal start -->
            <div class="modal fade" id="promotion_add_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-body" style="text-align: center;padding: 20px 10px;">
                    <input class="form-control" type="file" id="new_promotion">
                    <button class=" write-review-button" style="margin-top:10px;" type="button" ng-click="promotionSelect('new_promotion')">Select File</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- promotion modal finish -->
          </div>
        </div>
      </div>


      <div class="col-xs-12 col-sm-3" style="margin-bottom:20px;" ng-repeat="i in hospital_data.gallery">
        <div class="relative blue-back" style="padding-top:100%; overflow:hidden;" back-img="{{i.image}}">
        </div>
        <div class="absolute" style="top: 0.2em;
    right: 1.4em; " ng-click="removeGallery(i)">
          <i class="glyphicon glyphicon-remove" style="font-size: 1em;"></i>
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
    <div class="col-xs-6 col-sm-3" style="margin-bottom: 15px;">
      <div class="profile_area text-center" style="border-radius:50%; background:#dedede; height: 100px;
      width: 100px;display:table;margin: auto;">
      <i class="glyphicon glyphicon-plus" style="display: table-cell;  vertical-align: middle;  font-size: 20px; color: #39bbcf;" ng-click="doctor_add_open()"></i>
    </div>
    <div style="margin-top:5px; font-size:12px;" class="text-center">
      <span>Add doctor</span>
    </div>
  </div>

  <!-- added doctor -->
  <div class="col-xs-6 col-sm-3" ng-repeat="i in hospital_data.doctor" style="margin-bottom: 15px;">
    <div class="profile_area text-center" style="border-radius:50%; height: 100px;
    width: 100px;position: relative;
    overflow: hidden;margin:auto;">
    <img ng-src="{{i.pic}}" class="img img-circle" style="position: absolute;
    left: 0;
    top: 0;
    width: 100px;"/>
  </div>
  <div style="margin-top:5px; font-size:12px;" class="text-center">
    <span>{{i.d_name}}</span>
  </div>
</div>

</div>


<div class="row animate-show" style="margin-bottom:0px;"  ng-show="add_doctor">
  <div class="col-xs-12">
    <div class="search-result-block relative" style="height: auto; margin-bottom:0px;">
      <div class="media">
        <div class="media-left" style="padding: 30px 20px;">
          <div class="profile_area text-center" style="border-radius:50%; background:#dedede; height: 100px;
          width: 100px;display:table; position: relative;
          overflow: hidden">
          <img id="add_doctor_image_temp" ng-src="{{doctor_info.pic}}" style="    position: absolute;
          top: 0;
          left: 0;
          width: 100px;"/>
          <i class="glyphicon glyphicon-plus" style="display: table-cell;  vertical-align: middle;  font-size: 20px; color: #39bbcf;" ng-click="addProfile()"></i>
        </div>
      </div>
      <div class="media-body" style="padding: 20px 10px;">
        <div style="display:inline-block" class="search-result-title"
        >
        <input class="embedded_input"  type="text" id="d_name"  placeholder="DOCTOR NAME" ng-model="doctor_info.d_name">
      </div>
      <div style="display:inline-block; margin-right:10px; float:right;"  ng-click="edit('d_name')"><i class="glyphicon glyphicon-pencil"></i></div>


      <div style="font-size: 12px; color:white; margin-top:10px;margin-right:10px;">
        <textarea class="embedded_input"  type="text" id="d_description"  placeholder="DOCTOR DESCRIPTION" style="width: 80%;
        height: 100px;"  ng-model="doctor_info.d_description"></textarea>

      </div>


      <button class=" write-review-button" style="margin-top:15px;" type="button" ng-click="addDoctor()">ADD DOCTOR</button>
      <br>


    </div>
  </div>


</div>
</div>
</div>

<div id="bottom-bar-add" style="background-color:#808080;height:40px;margin-bottom:20px;" ></div>

<div class="row text-center" style="margin-bottom:50px;">
  <button class=" write-review-button" style="width:50px;height:50px; border-radius:50%;" type="button" ng-click="addHospital(hospital_data)">ADD</button>
</div>
</div>
</div>

<div class="modal fade" id="doctor_pic_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body" style="text-align: center;padding: 20px 10px;">
        <input class="form-control" type="file" id="fileInput">
        <div class="cropArea">
          <img-crop image="myImage" result-image="myCroppedImage" on-change="logg()"></img-crop>
        </div>
        <button class=" write-review-button" style="margin-top:10px;" type="button" ng-click="profileSelect('fileInput')">Select File</button>
      </div>
    </div>
  </div>
</div>
</div>
