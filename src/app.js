var app = angular.module("app",["ngRoute","ngSanitize"]);
// ["ngCookies",]
app.service('rating', function(){
    this.draw= function(num){
      var base=Math.floor(num*10);
      num=(base-base%5)/10;
      var head=Math.floor(num);
      var half=0;
      if(num!=head){
        half=1;
      }
      var tail=5-head-half;

      var result="";

      for(var i=0; i<head; i++){
        result+='<span class="circle_rating"></span>';
      }
      for(var i=0; i<half; i++){
        result+='<span class="circle_rating rating_half"></span>';
      }
      for(var i=0; i<tail; i++){
        result+='<span class="circle_rating_empty"></span>';
      }
      return result;
    };
    this.floor= function(num){
      var base=Math.floor(num*10);
      var result= (base-base%5)/10;
      return result.toFixed(1);
    };
});
