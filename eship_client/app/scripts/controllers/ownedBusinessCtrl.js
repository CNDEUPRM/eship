
'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:ownedBusinessCtrl
 * @description
 * # ownedBusinessCtrl
 */
angular.module('eshipApp')
  .controller('ownedBusinessCtrl',
    ['$scope', '$rootScope', '$location', 'authenticationSvc', 'businessSvc', '$window',
      function ($scope, $rootScope, $location, authenticationSvc, businessSvc, $window) {
        // Get Current User from Service
        var getUser = function(){
          $scope.user = authenticationSvc.getUserInfo();
          if(!$scope.user){
            $rootScope.$emit('unLogin');
            $location.path('/');
          }
        };

        var getBusiness = function () {
          // Un comment when using the server
          businessSvc.getBusinessByClient($scope.user.userId)
            .then(function (response) {
              $scope.business = response.data;
              if(response.status !==200){
                $window.alert("We are having technical problem. Please refresh the page.");
              }
            })
            .catch(function (err) {
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

        $scope.addNewBusiness = function ()
        {
          $location.path('/business/new_business');
        };

        $scope.selectBusiness = function (business_id) {
          $rootScope.$emit('business', business_id);
          $location.path('/business/'+business_id);
        };

        getUser();
        getBusiness();



      }]);
