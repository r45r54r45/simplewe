<div class="container search-page page"  ng-controller="main" ng-init="init()">
  <div class="row page-title">
    <div class="col-xs-12 text-center">
      <span>Find My Clinic<span>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 text-center">
        <span style="font-size:10px;">SORT BY</span>
      </div>
      <div class="col-xs-12 text-center">
        <button class="btn" ng-click="changeMode()">{{mode}}</button>
      </div>
    </div>
    <div class="row row-eq-height" style="margin-top:10px;">
      <div class="col-sm-8 col-sm-offset-2 moving_list">
        <div class="row">
          <div class="col-xs-6 col-sm-6 result-block" ng-click="moveTo(block_title[0])">
            <div class="dummy_for_height_half"></div>
            <div class="actual_block">
              <div class="content-area"   style="background-image: url('{{block_title[0].IMAGE}}'); background-size:cover;">
                <div>{{block_title[0].name}}</div>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-3 result-block" ng-click="moveTo(block_title[1])">
            <div class="dummy_for_height"></div>
            <div class="actual_block">
              <div class="content-area" style="background-image: url('{{block_title[1].IMAGE}}'); background-size:cover;">
                <div>{{block_title[1].name}}</div>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-3 result-block" ng-click="moveTo(block_title[2])">
            <div class="dummy_for_height"></div>
            <div class="actual_block">
              <div class="content-area" style="background-image: url('{{block_title[2].IMAGE}}'); background-size:cover;">
                <div>{{block_title[2].name}}</div>
              </div>
            </div>
          </div>



          <div class="col-xs-6 col-sm-3 result-block" ng-click="moveTo(block_title[3])">
            <div class="dummy_for_height"></div>
            <div class="actual_block">
              <div class="content-area" style="background-image: url('{{block_title[3].IMAGE}}'); background-size:cover;">
                <div>{{block_title[3].name}}</div>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-3 result-block" ng-click="moveTo(block_title[4])">
            <div class="dummy_for_height"></div>
            <div class="actual_block">
              <div class="content-area" style="background-image: url('{{block_title[4].IMAGE}}'); background-size:cover;">
                <div>{{block_title[4].name}}</div>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 result-block" ng-click="moveTo(block_title[5])">
            <div class="dummy_for_height_half"></div>
            <div class="actual_block">
              <div class="content-area" style="background-image: url('{{block_title[5].IMAGE}}'); background-size:cover;">
                <div>{{block_title[5].name}}</div>
              </div>
            </div>
          </div>


          <div class="col-xs-6 col-sm-6 result-block" ng-click="moveTo(block_title[6])">
            <div class="dummy_for_height_half"></div>
            <div class="actual_block">
              <div class="content-area" style="background-image: url('{{block_title[6].IMAGE}}'); background-size:cover;">
                <div>{{block_title[6].name}}</div>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-3 result-block" ng-click="moveTo(block_title[7])">
            <div class="dummy_for_height"></div>
            <div class="actual_block">
              <div class="content-area" style="background-image: url('{{block_title[7].IMAGE}}'); background-size:cover;">
                <div>{{block_title[7].name}}</div>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-3 result-block" ng-click="moveTo(block_title[8])">
            <div class="dummy_for_height"></div>
            <div class="actual_block">
              <div class="content-area" style="background-image: url('{{block_title[8].IMAGE}}'); background-size:cover;">
                <div>{{block_title[8].name}}</div>
              </div>
            </div>
          </div>


        </div>
      </div>
      <div class="col-md-1 vcenter hidden-xs" ng-show="mode!='Hospital'||maxHospital>currentHosNum+9">
        <div ng-click="moreHospital()" style="height:30px;">
          <i class="glyphicon glyphicon-chevron-right" style="font-size: 40px; color: black;"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid" style="background:#2e2e2e; margin: 20px 0px 0px; padding-bottom:50px;" ng-controller="main_stat">
    <div class="row">
      <div class="col-xs-12 text-center page-title">
        <span style="color:white">COMMUNITY</span>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-2 col-sm-offset-2 col-xs-4">
        <div class="text-center">
          <span class="number">{{community.HOSPITAL}}</span>
        </div>
        <div class="text-center">
          <span class="word">HOSPITALS<span>
          </div>
        </div>
        <div class="col-sm-2 col-sm-offset-1  col-xs-4">
          <div class="text-center">
            <span class="number">{{community.DOCTOR}}</span>
          </div>
          <div class="text-center">
            <span class="word">DOCTORS<span>
            </div>
          </div>
          <div class="col-sm-2 col-sm-offset-1  col-xs-4">
            <div class="text-center">
              <span class="number">{{community.PATIENT}}</span>
            </div>
            <div class="text-center">
              <span class="word">PATIENTS<span>
              </div>
            </div>
          </div>
        </div>
        <div class="container" style="padding:0px 0 40px 0;" ng-controller="main_veri_review">
          <div class="row">
            <div class="col-xs-12 page-title text-center">
              <span>Verified Patient Reviews</span>
            </div>
          </div>

          <!-- ////////// mobile///////// -->
          <div id="carousel-example-generic2" class="carousel slide visible-xs" data-ride="carousel">

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">

              <!-- hack for slider -->
              <div class="row item {{$index==0 && 'active' ||''}}" style="padding: 0 5%;" ng-repeat="i in patient_review">
                <div class="col-xs-12" >
                  <div class="profile_area">
                    <img class="img-circle-profile img img-responsive" src="/src/user_profile.jpg"/>
                  </div>
                  <div style="margin-top:-5px; font-size:12px;" class="text-center">
                    <span>{{i.NAME}}</span>
                  </div>
                  <div style="margin-top:7px; font-size:10px;" class="text-center">
                    <span>{{i.BODY}}</span>
                  </div>
                </div>
              </div>
              <!-- Controls -->
              <a class="left carousel-control" href="#carousel-example-generic2" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#carousel-example-generic2" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>

          </div>


          <!-- ////////// desktop ///////// -->


          <div id="carousel-example-generic" class="carousel slide hidden-xs" data-ride="carousel">


            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">



              <div class="row item active" style="padding: 0 5%;">
                <div class="col-sm-4" ng-repeat="i in patient_review" ng-show="$index<3">
                  <div class="profile_area">
                    <img class="img-circle-profile img img-responsive" src="/src/user_profile.jpg"/>
                  </div>
                  <div style="margin-top:-5px; font-size:12px;" class="text-center">
                    <span>{{i.NAME}}</span>
                  </div>
                  <div style="margin-top:7px; font-size:10px;" class="text-center">
                    <span>{{i.BODY}}</span>
                  </div>
                </div>


              </div>


              <div class="row item" style="padding: 0 5%;">
                <div class="col-sm-4" ng-repeat="i in patient_review" ng-show="$index>2">
                  <div class="profile_area">
                    <img class="img-circle-profile img img-responsive" src="/src/user_profile.jpg"/>
                  </div>
                  <div style="margin-top:-5px; font-size:12px;" class="text-center">
                    <span>{{i.NAME}}</span>
                  </div>
                  <div style="margin-top:7px; font-size:10px;" class="text-center">
                    <span>{{i.BODY}}</span>
                  </div>
                </div>


              </div>

            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>




        </div>
