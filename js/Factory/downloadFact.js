
'use strict';

angular.module('myFbApp')
       .factory('fbDownload', ['$http','$rootScope', function($http,$rootScope){
       	   var fbDownload = {};

                fbDownload.album = function(id,name){
                      var parameter = {aid:id,aname:name};
                      
          					return  $http({
          					  method  : 'POST',
          					  url     : $rootScope.server+'/api/downloadzip.php',
          					  data    :  parameter,  // pass in data as strings
          					  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
          				 });
                    }

                    fbDownload.test = function(){
                      return $http.get($rootScope.server+'/api/zip.php');
                    }

                    
            return fbDownload;
                
       }]);