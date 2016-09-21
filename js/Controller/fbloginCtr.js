angular.module('myFbApp')
 .controller('fbloginCtr',['$scope','fbLoginUrl','$location',  function($scope,fbLoginUrl,$location){
     $scope.title = "hey";
     $scope.isloaded = false;
     $scope.status = false;
     $scope.url = "#";
     $scope.isloggedin = false;

     $scope.LoginStatus =  function(){
        console.log("funCall");
        fbLoginUrl.getStatus()
                  .success(function(data){
                      $scope.isloaded = true;
                      console.log(data);
                      if(data['success']){
                         $location.path('/home');
                      }
                      else{
                         $scope.getFbUrl();
                      }

                  })
                  .error(function(data){
                    $scope.isloaded = true;
                     alert("some thiing went wrong!!!");
                  })
     }

     $scope.LoginStatus();

     
        
     

     $scope.getFbUrl = function(){
            fbLoginUrl.getUrl()
                 .success(function(data){
                     console.log(data);
                     $scope.url = data['loginurl'];
                 })
                 .error(function(data){
                  alert("Error");
                 });
    };    
     
            



                 
 }]);