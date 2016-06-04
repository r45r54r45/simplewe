<div ng-controller="private" ng-init="num=<?=$consult_num?>;uid='<?=$uid?>';init();">
  <div class="container" >
    <div class="row page-title">
      <div class="col-xs-12 text-center">
        <span>Consultation</span>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="top_line col-sm-8 col-sm-offset-2 col-xs-12 down_line">
        <div class="padding-10 consult-header pull-left inline-block">
          {{consult.TITLE}}
        </div>
        <div class="padding-10 consult-header pull-left inline-block">
          {{consult.AUTHOR}}
        </div>
        <div class="padding-10 consult-header pull-left inline-block">
          {{consult.TIME|Cdate}}
        </div>
        <div class="clearfix">
        </div>
      </div>

      <div class=" padding-20 col-sm-8 col-sm-offset-2 col-xs-12 down_line" ng-bind-html="consult.BODY">

      </div>
      <div class=" padding-20 col-sm-8 col-sm-offset-2 col-xs-12 down_line" style="background:#f5f5f5; padding:10px 20px; margin-bottom: 20px;">
        <textarea class="form-control" style="border-radius:0;" ng-model="replydata"></textarea>
        <div class="btn btn-primary pull-right" style="margin-top: 10px;" ng-click="submit()">
          Submit
        </div>
      </div>
      <!-- reply block -->
      <div class="top_line padding-20 col-sm-8 col-sm-offset-2 col-xs-12" ng-repeat="reply in replies">
        <div class="author_consult_comment">
          <div class="pull-left">
            {{reply.AUTHOR}}
          </div>
          <div class="pull-right">
            {{reply.TIME|Cdate}}
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="author_consult_body" ng-bind-html="reply.BODY">
        </div>
      </div>


    </div>

  </div>
