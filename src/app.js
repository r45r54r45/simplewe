var app = angular.module("app",["ngRoute","ngSanitize","ngAnimate"]);
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

app.service("image",function(){
  var reduceSize=function(base64, width, height) {
    var canvas = document.createElement("canvas");
    canvas.width = width;
    canvas.height = height;
    var context = canvas.getContext("2d");
    var deferred = $.Deferred();
    $("<img/>").attr("src",base64).load(function() {
      context.scale(width/this.width,  height/this.height);
      context.drawImage(this, 0, 0);
      deferred.resolve($("<img/>").attr("src", canvas.toDataURL()));
    });
    return deferred.promise();
  }
  this.toDataURI=function(input,callback){
    if(input.files[0].size>2000000){
      alert("Images should not be over 2mb");
      return;
    }
    //id selector of file input form as a input
    var file,fr;
    if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
      alert('The File APIs are not fully supported in this browser.');
      return;
    }
    file = input.files[0];
    fr = new FileReader();
    fr.readAsDataURL(file);
    fr.onload = function(){
      // callback(reduceSize(fr.result,100,100));
      callback(fr.result);
    }
  }

});

app.filter('Cdate', function() {
  return function(input) {
    var d=new Date(Date.parse(input));
    return d.toLocaleDateString('en-GB', {
      day : 'numeric',
      month : 'short',
      year : 'numeric'
    }).split(' ').join('-');;
  }
});
app.directive('backImg', function(){
  return function(scope, element, attrs){
    var url = attrs.backImg;
    element.css({
      'background-image': 'url(' + url +')',
      'background-size' : 'cover'
    });
  };
});
