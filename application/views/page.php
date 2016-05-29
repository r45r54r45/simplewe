<div class="container" >
  <div class="row page-title">
    <div class="col-xs-12 text-center">
      <span>Find My Clinic</span>
    </div>
  </div>
</div>

<div class="container" ng-controller="hospital" ng-init="HID=<?=$hid?>; init()">
  <div class="container-fluid" ng-show="gallery">
    <div class="row" style="background: #494949;">
      <div class="col-xs-12 text-center" style="padding-top:30px;">
        <span style="color:white; font-size:20px; font-weight:500;">Gallery</span>
      </div>
      <div class="col-xs-12" style="color:transparent;">
        <div id="ninja-slider" style="background: #494949;">
          <div class="slider-inner">
            <ul>
              <li>
                <img class="ns-img" src="/src/images/image-slider-1.jpg" />
              </li>
              <li>
                <img class="ns-img" src="/src/images/image-slider-2.jpg" />
              </li>
              <li>
                <img class="ns-img" src="/src/images/image-slider-3.jpg" />
              </li>
              <li>
                <img class="ns-img" src="/src/images/image-slider-4.jpg" />
              </li>
              <li>
                <img class="ns-img" src="/src/images/image-slider-5.jpg" />
              </li>
            </ul>
            <div class="fs-icon" title="Expand/Close"></div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 text-center" style="padding-bottom:30px;" ng-click="toggleGallery()">
        <div><i class="glyphicon glyphicon-remove" style="font-size: 15px; color:white"></i></div>
        <span style="color:white; font-size:8px; font-weight:300;">Close</span>
      </div>
    </div>
  </div>
  <div class="row row-eq-height" style="margin-top:10px;">
    <div class="col-sm-8 col-sm-offset-2">
      <!-- search result block -->
      <div class="row">
        <div class="col-xs-12">
          <div class="search-result-block">
            <div class="write_review">
              <button class=" write-review-button" type="button" >WRITE A REVIEW</button>
            </div>
            <div class="search-result-area col-xs-12 col-sm-5">
              <div class="" style="margin-bottom:10px;">
                <span class="search-result-title">{{hospital.NAME}}</span>
              </div>
              <div class="">
                <span class="search-result-body">{{hospital.DESCRIPTION}}
                </span>
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
                  <div class="text-center" style="font-weight:600; font-size:15px; color:white;">HOSPITAL RATING</div>
                  <div class="text-center" style="font-weight:600; font-size:49px; color:white;">{{hospital.RATING_hospital}}</div>
                  <div class="text-center" style="    margin-top: -10px;" ng-bind-html="H_R">

                  </div>
                </div>
              </div>
              <div class="col-xs-6 grey-back height-100" style="padding:15px 0 0 0px;">
                <div class="">
                  <div class="text-center" style="font-weight:600; font-size:15px; color:white;">DOCTOR RATING</div>
                  <div class="text-center" style="font-weight:600; font-size:49px; color:white;">{{hospital.RATING_doctor}}</div>
                  <div class="text-center" style="    margin-top: -10px;" ng-bind-html="D_R">

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6" style="margin-bottom:20px;">
          <div class="relative" style="padding-top:50%; overflow:hidden;">
            <div class="row absolute width-100 height-100" style="left: 15px;top:0; overflow:hidden;">
              <div class="col-xs-6 grey-back height-100" style="padding:0;" ng-click="toggleGallery()">
                <div class="">
                  <div class="text-center margin:auto auto;" style="padding-top: 46%;font-weight:600; font-size:15px; color:white;" >GALLERY</div>
                </div>
              </div>
              <div class="col-xs-6 blue-back height-100" style="padding:0px 0 0 0px;">
                <div class="" >
                  <div class="text-center margin:auto auto;" style="padding-top: 46%;font-weight:600; font-size:15px; color:white;">PROMOTION</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row page-title" style="margin-top:-10px;">
        <div class="col-xs-12 text-center">
          <span>Doctors</span>
        </div>
      </div>
      <div class="row" style="padding: 0 50px; margin-bottom:20px;">

        <div class="col-xs-6 col-sm-3" ng-repeat="i in doctor" ng-click="openDoctor(i.DID)">
          <div class="profile_area">
            <img class="img-circle img img-responsive" src="/src/user_profile.jpg"/>
          </div>
          <div style="margin-top:-5px; font-size:12px;" class="text-center">
            <span>{{i.NAME}}</span>
          </div>
          <div style="margin-top:7px; font-size:10px;" class="text-center">
            <span>{{i.MAJOR}}</span>
          </div>
        </div>

      </div>


      <div class="row"  ng-show="doctor_info">
        <div class="col-xs-12">
          <div class="search-result-block relative" style="height: auto; margin-bottom:0px;">
            <div class="absolute hidden-xs" style="right:-30px; top:5px; width:10px; hight:10px;">
              <i class="glyphicon glyphicon-remove" style="font-size: 20px; cursor:pointer;" ng-click="closeDoctor()"></i>
            </div>
            <div class="media">
              <div class="media-left" style="padding: 30px 20px;">
                <img class="img-circle img img-responsive" src="/src/user_profile.jpg"/>
                <div class="text-center" style="font-weight:600; font-size:45px; color:white;">{{doctor_area.R_A}}</div>
                <div class="text-center margin:auto auto;" style="margin-top:-10px;font-weight:600; font-size:15px; color:white;">Doctor Rating</div>
                <button class=" write-review-button" style="margin-top:10px;" type="button" onclick="$('#review_modal').modal('show')">WRITE A REVIEW</button>
                <div class="row visible-xs" style="margin-top:20px;">
                  <div class="col-xs-12">
                    <div style="font-weight:600; color:white; font-size:12px;">Overall Rating</div>
                    <div ng-bind-html="doctor_area.R_1">
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div style="font-weight:600; color:white; font-size:12px;">Bedside Manner</div>
                    <div ng-bind-html="doctor_area.R_2">
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div style="font-weight:600; color:white; font-size:12px;">Expertise</div>
                    <div ng-bind-html="doctor_area.R_3">
                    </div>
                  </div>

                </div>
              </div>
              <div class="media-body" style="padding: 20px 10px;">
                <div class="search-result-title">{{doctor_area.NAME}}</div>
                <div style="font-size: 9px; color:white; margin-top:10px;">
                  {{doctor_area.DESCRIPTION}}
                </div>
                <div class="row hidden-xs" style="margin-top:20px;">
                  <div class="col-xs-4">
                    <div style="font-weight:600; color:white; font-size:12px;">Overall Rating</div>
                    <div ng-bind-html="doctor_area.R_1">

                    </div>
                  </div>
                  <div class="col-xs-4">
                    <div style="font-weight:600; color:white; font-size:12px;">Bedside Manner</div>
                    <div ng-bind-html="doctor_area.R_2">
                    </div>
                  </div>
                  <div class="col-xs-4">
                    <div style="font-weight:600; color:white; font-size:12px;">Expertise</div>
                    <div ng-bind-html="doctor_area.R_3">

                    </div>
                  </div>

                </div>

              </div>
            </div>


          </div>
        </div>
      </div>
      <div class="row" ng-show="doctor_info">
        <div class="col-xs-12">
          <div class="media" style="background:#595959;margin-bottom:50px;">
            <div class="media-left hidden-xs"  style="padding: 30px 20px;">
              <button class=" write-review-button" style="margin-top:10px; opacity:0" type="button"></button>
            </div>
            <div class="media-body"  style="padding: 20px 10px;">
              <div class="search-result-title">Reviews</div>

              <!-- repeat reviews -->
              <div class="media" ng-repeat="i in comments" ng-show="$index < commentLimit">
                <div class="media-left" style="width: 20%; min-width: 90px;padding: 10px 10px 5px 0px;">
                  <div class="profile_area">
                    <img class="img-circle img img-responsive" src="/src/user_profile.jpg"/>
                  </div>
                  <div style="margin-top:-5px; font-size:12px;" class="text-center">
                    <span style="font-weight:600; color:white; font-size:12px;">{{i.NAME}}</span>
                  </div>
                  <div style="margin-top:3px; font-size:10px;" class="text-center">
                    <span style="font-weight:400; color:white; font-size:10px;">{{i.MAJOR}}</span>
                  </div>
                </div>
                <div class="media-body" style="padding: 10px 10px; vertical-align: bottom;">
                  <div style="font-weight:400; color:white; font-size:10px;">{{i.TIME}}</div>
                  <div style="font-weight:300; color:white; font-size:9px;margin-top:5px;">{{i.BODY}}</div>
                </div>
              </div>





            </div>
          </div>
          <div class="row"  ng-show="comments.length>commentLimit">
            <div class="col-xs-12 text-center" ng-click="loadMore()">
              <div class="review-btn-circle">Load More</div>
              <div class="review-btn-circle small-review-btn"></div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- modal for review -->
  <div class="modal fade" id="review_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" ng-init="review={};">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-12" style="padding: 20px 20px 0px; font-size: 18px; font-weight: 500;">
              <div class="">
                Review for Dr. Kim Soo Hyun
              </div>
            </div>
          </div>
          <div class="row">
            <div class="media">
              <div class="media-body" style="padding: 20px;">
                <div>
                  <span class="review_label major_click">Dermatology</span>
                  <span class=" major_click review_label">Eyeplasty</span>
                  <span class="major_click review_label">Rhinoplasty</span>
                  <span class="major_click review_label">Face</span>
                  <span class="major_click review_label">Breast</span>
                  <span class="major_click review_label">Body Contour</span>
                  <span class="major_click review_label">Hair Implant</span>
                  <span class="major_click review_label">Dentistry</span>
                  <br/>
                  <span class="major_click review_label">Medical Examination</span>
                  <span class="major_click review_label">Other</span>
                </div>
                <div>
                  <textarea class="placeholder form-control" rows="9" id="review_body" style="margin-top: 15px; border: 1px solid #494949; box-shadow: none; box-shadow:none;" placeholder="Please tell us about your experience" ng-model="review.body"></textarea>
                </div>
              </div>
              <div class="media-right" style="padding: 10px 10px;  width: 25%;  min-width: 120px;">
                <div class="row" style="">
                  <div class="col-xs-12" style="margin-bottom:10px;">
                    <div style="font-weight:600; color:#494949; font-size:12px;">Overall Rating</div>
                    <div >
                      <input type="number" name="your_awesome_parameter" id="some_id1" ng-model="review.R1" class="rating"  data-icon-lib="fa" data-active-icon="fa-circle" data-inactive-icon="fa-circle-o" />
                    </div>
                  </div>
                  <div class="col-xs-12" style="margin-bottom:10px;">
                    <div style="font-weight:600; color:#494949; font-size:12px;">Bedside Manner</div>
                    <div >
                      <input type="number" name="your_awesome_parameter" id="some_id2" ng-model="review.R2" class="rating"  data-icon-lib="fa" data-active-icon="fa-circle" data-inactive-icon="fa-circle-o" />
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div style="font-weight:600; color:#494949; font-size:12px;">Expertise</div>
                    <div >
                      <input type="number" name="your_awesome_parameter" id="some_id3" ng-model="review.R3" class="rating"  data-icon-lib="fa" data-active-icon="fa-circle" data-inactive-icon="fa-circle-o" />
                    </div>
                  </div>
                </div>
                <div class="row" style="padding-top: 40px;padding-left: 15px;">
                  <button class=" write-review-button" type="button" ng-click="reviewForm()">SUBMIT REVIEW</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>