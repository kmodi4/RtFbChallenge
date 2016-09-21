(function(){
var app = angular.module("myFbApp",['ngRoute','ngAnimate','ngTouch']);

 app.config(['$routeProvider',function($routeProvider){
  $routeProvider.
     when('/',{
          templateUrl :  'Templates/fblogin.html',
        controller  :  'fbloginCtr'
     }).
     when('/home',{
          templateUrl :  'Templates/home.html',
        controller  :  'homeCtr'
     }).
     when('/slideshow/:id',{
          templateUrl :  'Templates/slideshow.html',
        controller  :  'slideshowCtr'
     }).
      otherwise({
        redirectTo : '/'
      });
 }]);

 app.controller('MainCtr', ['$rootScope', function($rootScope){
    $rootScope.server = "https://angfbheroku.herokuapp.com";  //http://kmodi4.byethost4.com
    
 }]);



 }());
