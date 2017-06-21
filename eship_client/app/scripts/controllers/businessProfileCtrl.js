
'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:businessProfileCtrl
 * @description
 * # businessProfileCtrl
 * Business Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('businessProfileCtrl',
    ['business_id', '$scope', '$rootScope', '$location', 'authenticationSvc', 'businessSvc', 'adminSvc', '$window',
      function ($business_id, $scope, $rootScope, $location, authenticationSvc, businessSvc, adminSvc, $window) {
        // Get Current User from Service
        var getUser = function(){
          $scope.user = authenticationSvc.getUserInfo();
          if(!$scope.user){
            $rootScope.$emit('unLogin');
            $location.path('/');
          }
        };

        /*
         * Form fields
         */
        $scope.report = {
          business_id:'',
          status: 0
        };

        var getBusiness = function ()
        {
          // Un comment when using the server
          businessSvc.getBusinessInfo($business_id)
            .then(function (response)
            {
              $scope.business = response.data[0];
              if(response.status===404){
                $location.path('/404');
              }
            })
            .catch(function (error) {
              console.log(error);
            });

        };

        $scope.activateButton = function ()
        {
          $scope.report.status = 1;
          $scope.report.business_id = $business_id;
          console.log($scope.report);
          adminSvc.putBusiness($scope.report)
            .then(function (response)
            {
              console.log(response);
              getBusiness();
              if(response.status !==200)
              {
                $window.alert("We are having technical problem. Please refresh the page.");
              }
              else{
                $window.alert("This business has been activated successfully.");
              }
              $location.path('/business/'+$business_id);
            })
            .catch(function (err)
              {
                if(err.status === 401 || err.status === 404)
                {
                  $window.alert("We are having technical problem. Please refresh the page.");
                }
                else if(err.status === 500)
                {
                  $location.path('/500');
                }
                $rootScope.$emit('unLogin');
                $location.path('/500');
                console.log(err);
              });
        };

        $scope.deactivateButton = function ()
        {
          $scope.report.status = 0;
          $scope.report.business_id = $business_id;
          console.log($scope.report);
          adminSvc.putBusiness($scope.report)
            .then(function (response)
            {
              console.log(response);
              getBusiness();
              if(response.status !==200){
                $window.alert("We are having technical problem. Please refresh the page.");
              }
              else{
                $window.alert("This business has been deactivated successfully.");
              }
              $location.path('/business/'+$business_id);
            })
            .catch(function (err)
              {
                if(err.status === 401 || err.status === 404)
                {
                  $window.alert("We are having technical problem. Please refresh the page.");
                }
                else if(err.status === 500)
                {
                  $location.path('/500');
                }
                $rootScope.$emit('unLogin');
                $location.path('/500');
                console.log(err);
              });
        };

        getUser();
        getBusiness();
      }]);
