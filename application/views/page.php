<div ng-controller="hospital" ng-init="HID=<?=$hid?>;UID='<?=$uid?>' ;init()">
  <div class="container" >
    <div class="row page-title">
      <div class="col-xs-12 text-center">
        <span>Find My Clinic</span>
      </div>
    </div>
  </div>

  <div class="container-fluid" style="background: #494949;color: transparent;">
    <div class="container-fluid animate-show" ng-show="gallery">
      <div class="row" style="background: #494949;">
        <div class="col-xs-12 text-center" style="padding:30px;">
          <span style="color:white; font-size:20px; font-weight:500;">Gallery</span>
        </div>
        <style media="screen">
        .item>img{
          width: 100%;
        }
        </style>
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
          </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <div class="item {{$index==0?'active':''}}" ng-repeat="g in galls">
              <img ng-src="{{g.IMAGE}}" style="    width: 66%;
              max-width: 800px;
              margin: auto;">
            </div>

          </div>

          <!-- Controls -->
          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <img class="icon-prev" src="/src/left.png">
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <img class="icon-next" src="/src/right.png">
          </a>
        </div>

        <div class="col-xs-12 text-center" style="padding:30px;" ng-click="toggleGallery()">
          <div><i class="glyphicon glyphicon-remove" style="font-size: 15px; color:white"></i></div>
          <span style="color:white; font-size:8px; font-weight:300;">Close</span>
        </div>
      </div>
    </div>

  </div>
  <div class="container-fluid" >

    <div class="row row-eq-height" style="margin-top:10px;">
      <div class="col-sm-8 col-sm-offset-2" style="max-width:800px; margin:auto;">
        <!-- search result block -->
        <div class="row">
          <div class="col-xs-12">
            <div class="search-result-block background-img"
            ng-style="{'background-image': 'linear-gradient(to bottom, rgba(0,0,0,0.4) 0%,rgba(0,0,0,0.6) 100%),url(' +hospital.IMAGE + ')'}"
            >
            <?if($login){?>
              <div class="write_review">
                <button class=" write-review-button" type="button" ng-click="write_hospital_review()">WRITE A REVIEW</button>
              </div>
              <?}?>

              <!-- write review start-->
              <div class="modal fade" id="hospital_review_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" ng-init="hospital_review={};">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-xs-12" style="padding: 20px 20px 0px; font-size: 18px; font-weight: 500;">
                          <div class="">
                            Review for {{hospital.NAME}}
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="media">
                          <div class="media-body" style="padding: 20px;">
                            <div>
                              <span class="review_label major_click2">Dermatology</span>
                              <span class=" major_click2 review_label">Eyeplasty</span>
                              <span class="major_click2 review_label">Rhinoplasty</span>
                              <span class="major_click2 review_label">Face</span>
                              <span class="major_click2 review_label">Breast</span>
                              <span class="major_click2 review_label">Body Contour</span>
                              <span class="major_click2 review_label">Hair Implant</span>
                              <span class="major_click2 review_label">Dentistry</span>
                              <br/>
                              <span class="major_click2 review_label">Medical Examination</span>
                              <span class="major_click2 review_label">Other</span>
                            </div>

                          </div>
                          <div class="media-right" style="padding: 10px 10px;  width: 25%;  min-width: 120px;">
                            <div class="row" style="">
                              <div class="col-xs-12" style="margin-bottom:10px;">
                                <div style="font-weight:600; color:#494949; font-size:12px;">Overall Rating</div>
                                <div >
                                  <input type="number" name="your_awesome_parameter" id="some_id1" ng-model="hospital_review.R1" class="rating"  data-icon-lib="fa" data-active-icon="fa-circle" data-inactive-icon="fa-circle-o" />
                                </div>
                              </div>
                              <div class="col-xs-12" style="margin-bottom:10px;">
                                <div style="font-weight:600; color:#494949; font-size:12px;">Bedside Manner</div>
                                <div >
                                  <input type="number" name="your_awesome_parameter" id="some_id2" ng-model="hospital_review.R2" class="rating"  data-icon-lib="fa" data-active-icon="fa-circle" data-inactive-icon="fa-circle-o" />
                                </div>
                              </div>
                              <div class="col-xs-12">
                                <div style="font-weight:600; color:#494949; font-size:12px;">Expertise</div>
                                <div >
                                  <input type="number" name="your_awesome_parameter" id="some_id3" ng-model="hospital_review.R3" class="rating"  data-icon-lib="fa" data-active-icon="fa-circle" data-inactive-icon="fa-circle-o" />
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>

                      </div>
                      <div class="row" style="text-align: center;">
                        <button class=" write-review-button" type="button"  ng-click="send_hospital_review()">SUBMIT REVIEW</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- write review finish-->
              <!-- hospital contact modal-->
                <div class="modal fade" id="hospital_contact_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                  <div class="modal-dialog modal-sm" style="width:375px;">
                    <div class="modal-content">
                      <div class="modal-header text-center">
                        <span class="modal-title">{{hospital.NAME}}</span>
                      </div>
                      <div class="modal-body">
                        <div class="form-group has-feedback has-feedback-left">
                          <input type="text" class="placeholder form-control no-border" placeholder="Name"  ng-model="consult.name" />
                          <img class="form-padding form-control-feedback" src="/src/name.svg">
                        </div>
                        <div class="form-group has-feedback has-feedback-left">
                          <input type="email" class="placeholder form-control no-border"  placeholder="Email" ng-model="consult.email" />
                          <img class="form-padding form-control-feedback" src="/src/email.svg">
                        </div>
                        <div class="form-group has-feedback has-feedback-left">
                          <textarea class="placeholder form-control" rows="8" id="consult_body" style="resize:none;border:none; box-shadow:none;" placeholder="Message" ng-model="consult.body" ></textarea>
                          <i class="form-control-feedback glyphicon "></i>
                        </div>
                        <div class="btn btnForm btn-block" ng-click="consultForm(consult)">SEND</div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- hospital contact modal end-->
              <div class="search-result-area col-xs-12 col-sm-5">
                <div class="" style="margin-bottom:12px;">
                  <span class="search-result-title">{{hospital.NAME}}</span>
                </div>
                <div class="contact_hospital">
                  <button class="contact-hospital-button" type="button" onclick="$('#hospital_contact_modal').modal('show')">CONTACT HOSPITAL</button>
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
                <div class="col-xs-6 grey-back height-100 center-table">
                  <div class="center-cell">
                    <div class="text-center" style="font-weight:600; font-size:14px; color:white;">HOSPITAL RATING</div>

                    <div class="text-center" style="font-weight:600; font-size:40px; color:white;">{{hospital.RATING_hospital}}</div>
                    <div class="text-center" style="    margin-top: -10px;" ng-bind-html="H_R">

                    </div>
                  </div>
                </div>
                <div class="col-xs-6 grey-back height-100 center-table" style="">
                  <div class="center-cell">
                    <div class="text-center" style="font-weight:600; font-size:15px; color:white;">DOCTOR RATING</div>
                    <div class="text-center" style="font-weight:600; font-size:40px; color:white;">{{hospital.RATING_doctor}}</div>
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
                <div class="col-xs-6 grey-back height-100 center-table hand" style="padding:0;" ng-click="toggleGallery()">
                  <div class="center-cell">
                    <div class="text-center" style="font-weight:600; font-size:15px; color:white;" >GALLERY</div>
                  </div>
                </div>
                <div class="col-xs-6 blue-back height-100 center-table hand" style="padding:0px 0 0 0px;">
                  <div class="center-cell" ng-click="openPromotion()">
                    <div class="text-center margin:auto auto;" style="font-weight:600; font-size:15px; color:white;" >PROMOTION</div>
                  </div>
                </div>
              </div>


              <div class="modal fade" id="promotion_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-body" style="padding: 30px;">
                      <img class="img img-responsive" ng-src="{{promotion.PROMOTION}}">
                    </div>
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
            <div class="profile_area hand">
              <img class="img-circle img img-responsive" ng-src="{{i.PROFILE}}"/>
            </div>
            <div style="margin-top:5px; font-size:12px;" class="text-center">
              <span>{{i.NAME}}</span>
            </div>
            <div style="margin-top:0px; font-size:10px;" class="text-center">
              <span>{{i.MAJOR}}</span>
            </div>
          </div>

        </div>



        <div class="row animate-show" ng-show="doctor_info" style="
        <?if($login==false){?>
          margin-bottom:30px;
          <? } ?>
          ">
          <div class="col-xs-12">
            <div class="search-result-block relative" style="height: auto; margin-bottom:0px;">
              <div class="absolute hidden-xs" style="right:-30px; top:5px; width:10px; hight:10px;">
                <i class="glyphicon glyphicon-remove" style="font-size: 20px; cursor:pointer;" ng-click="closeDoctor()"></i>
              </div>
              <div class="media">
                <div class="media-left" style="padding: 30px 20px;min-width: 135px;">
                  <img class="img-circle img img-responsive" ng-src="{{doctor_area.PROFILE}}"/>
                  <div class="text-center" style="font-weight:600; font-size:45px; color:white;">{{doctor_area.R_A}}</div>
                  <div class="text-center margin:auto auto;" style="margin-top:-10px;font-weight:600; font-size:15px; color:white;">Doctor Rating</div>
                  <?if($login){?>
                    <button class=" write-review-button" style="margin-top:10px;" type="button" onclick="$('#review_modal').modal('show')">WRITE A REVIEW</button>
                    <?}?>
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
                    <div style="font-size: 12px; color:white; margin-top:10px;margin-right:10px;">
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
          <?if($login=="true"){?>

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
                      <div class="media-left">
                        <div class="profile_areaComment">
                          <img class="img-circle img img-responsive" src="/src/user_profile.jpg"/>
                        </div>
                        <div style="margin-top:5%; font-size:12px;" class="text-center">
                          <span style="font-weight:600; color:white; font-size:12px;">{{i.NAME}}</span>
                        </div>
                        <div style="margin-top:3%; font-size:10px;" class="text-center">
                          <span style="font-weight:400; color:white; font-size:10px;">{{i.MAJOR}}</span>
                        </div>
                      </div>
                      <div class="media-body" style="padding: 10px 10px; vertical-align: middle;">
                        <div style="font-weight:400; color:#9F9F9F; font-size:8px;">{{i.TIME|Cdate}}</div>
                        <div style="font-weight:300; color:white; font-size:10px;margin-top:5px;">{{i.BODY}}</div>
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
          <?}?>
        </div>
        <!-- modal for review -->
        <div class="modal fade" id="review_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" ng-init="review={};">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">
                <div class="row">
                  <div class="col-xs-12" style="padding: 20px 20px 0px; font-size: 18px; font-weight: 500;">
                    <div class="">
                      Review for {{doctor_area.NAME}}
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
                      <div class="row" style="padding-top: 40px;padding-left: 15px;position: absolute;bottom: 35px;">
                        <button class=" write-review-button" type="button"  ng-click="reviewForms()">SUBMIT REVIEW</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
