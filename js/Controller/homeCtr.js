angular.module('myFbApp')
 .controller('homeCtr',['$scope','fbAlbum','$location','fbDownload','$rootScope',  function($scope,fbAlbum,$location,fbDownload,$rootScope){
    $scope.coverLink = [];
    $scope.isloggedin = true;
     
     fbAlbum.fetchCoverPhoto()
            .success(function(data){
               console.log(data);
                $scope.coverLink = data;
                /*for (var i = 0; i < data.length; i++) {
                      $scope.coverLink['url'] = data[i]['picture']['']
                }*/
            })
            .error(function(data){
              alert("Error in fetching Album");
            });

      $scope.sendId = function(id){
          console.log(id);
          $location.path('/slideshow/'+id);
          
      }

      $scope.download = function(id,name){
        console.log("Clicked");
         fbDownload.album(id,name)
                   .success(function(data){
                       console.log(data);
                       var file = new Blob([data], {type: 'application/zip'});
                       var fileURL = URL.createObjectURL(file);
                       console.log(fileURL);
                   })
                   .error(function(data){
                    alert("Unable to Download!!!");
                   });
      }   

      $scope.test = function(){
        fbDownload.test()
                  .success(function(data){
                    console.log(data);
                  })
                  .error(function(data){
                      alert("Unable to Download!!!");
                  });
      }  

      $scope.logout = function(){
      $http.get( $rootScope.server+'/api/logout.php')
           .success(function(data){
              $location.path('/');  
           })
           .error(function(data){

           });
    } 

                 
 }]);