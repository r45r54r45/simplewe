<style>
.new{
  color: #49c4d5;
  background-color: white;
  border: 1px solid #49c4d5;
  font-weight: 400;
  margin-left: 10px;
}
</style>
<div ng-controller="private" ng-init="num=<?=$consult_num?>;uid='<?=$uid?>';init();">
  <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body" style="padding:0">
          <div class="row" >
            <div class="col-xs-12">
              <div class="well" ng-init="edit={}" style="margin-bottom:0;">

              <div class="form-group has-feedback-none has-feedback-left-none">
                <input type="text" class="placeholder form-control no-border" placeholder="Title" ng-model="edit.title" />
              </div>
              <div class="form-group has-feedback-none has-feedback-left-none">
                <textarea  style="resize:none;border:none;"class="placeholder form-control" rows="5" style="border:none; box-shadow:none;" placeholder="Message" ng-model="edit.body" ></textarea>
              </div>
              <div class="btn btnForm btn-block" ng-click="editForm(edit)">EDIT</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
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
        <div class="label new pull-right" style="margin-top: 10px;color:#D3D3D3; border:1px solid #D3D3D3;" ng-click="delete()">
          delete
        </div>
        <div class="label new pull-right" style="margin-top: 10px;" ng-click="editing()">
          edit
        </div>

        <div class="clearfix">
        </div>
      </div>

      <div class=" padding-20 col-sm-8 col-sm-offset-2 col-xs-12 down_line" ng-bind-html="consult.BODY">

      </div>
      <div class=" padding-20 col-sm-8 col-sm-offset-2 col-xs-12 down_line" style="background:#f5f5f5; padding:10px 20px; margin-bottom: 20px;">
        <textarea class="form-control" style="border-radius:0;" ng-model="replydata"></textarea>
        <div class="banner-button pull-right" style="margin-top: 10px;" ng-click="submit()">
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
