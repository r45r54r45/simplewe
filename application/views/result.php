<div class="container search-page page" ng-controller="search" ng-init="query='<?=$query?>'; init();">
  <div class="row page-title">
    <div class="col-xs-12 text-center">
      <span>Find My Clinic<span>
      </div>
    </div>
    <div class="row row-eq-height" style="margin-top:10px;">
      <div class="col-sm-8 col-sm-offset-2">
<? if($authorized){?>
        <!-- add block -->
        <div class="row">
          <div class="col-xs-12">
            <div class="search-result-block" style="background:#ececec; display: table; text-align: center;" ng-click="addHospital()">
              <i class="glyphicon glyphicon-plus" style="display: table-cell;  vertical-align: middle;  font-size: 40px; color: #39bbcf;"></i>
            </div>
          </div>
        </div>
<?}?>
        <!-- search result block -->
        <div class="row" ng-repeat="i in hospital_list" ng-show="$index < num_limit" ng-click="linkToHospital(i.HID)">
          <div class="col-xs-12">
            <div class="search-result-block">
              <div class="search-result-area col-xs-12 col-sm-5">
                <div class="" style="margin-bottom:10px;">
                  <span class="search-result-title" >{{i.NAME}}</span>
                </div>
                <div class="">
                  <span class="search-result-body">{{i.BODY}}
                  </span>
                </div>
                <div class="">
                  <div class="">
                    <span class="circle_rating"></span>
                    <span class="circle_rating rating_half"></span>
                    <span class="review_text">{{i.review}} Reviews</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- empty block -->
        <div class="row" ng-show="hospital_list.length==0">
          <div class="col-xs-12">
            <div class="search-result-block" style="background:#ececec; display: table; text-align: center;">
              <div style="display: table-cell; vertical-align: middle;  font-size: 20px; color: #39bbcf;">NO RESULT</div>
            </div>
          </div>
        </div>

        <!-- load more -->
        <div class="row animate-show" ng-show="hospital_list.length>=num_limit" ng-click="loadMore()">
          <div class="col-xs-12 text-center">
            <div class="review-btn-circle">Load More</div>
            <div class="review-btn-circle small-review-btn"></div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
