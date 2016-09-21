
'use strict';

angular.module('myFbApp')
       .factory('fbLoginUrl', ['$http','$rootScope', function($http,$rootScope){
       	   var fbLoginUrl = {};

                fbLoginUrl.getUrl = function(){
                      return $http.get($rootScope.server+'/api/login.php');
                    }

                fbLoginUrl.getStatus = function(){
                    return $http.get($rootScope.server+'/api/checkStatus.php');
                }    
            return fbLoginUrl;
                
       }])
       .factory('fbAlbum', ['$http','$rootScope', function($http,$rootScope){
       	    var fbAlbum = {};

       	        fbAlbum.fetchCoverPhoto = function(){
       	        	return $http.get($rootScope.server+'/api/fetchAlbum.php');
       	        }

       	        fbAlbum.albumIdPhoto = function(id){
       	        	 var parameter = {aid:id};
                      
          					return  $http({
          					  method  : 'POST',
          					  url     : $rootScope.server+'/api/albumIdPhoto.php',
          					  data    :  parameter,  // pass in data as strings
          					  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
          				 });
       	        }

       	        return fbAlbum;
       }]);
      