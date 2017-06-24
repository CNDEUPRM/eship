'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:counselorListCtr
 * @description
 * # counselorListCtr
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('counselorListCtrl',
    ['$scope', '$rootScope', '$location', 'authenticationSvc', 'counselorSvc', 'adminSvc', '$window',
      function ($scope, $rootScope, $location, authenticationSvc, counselorSvc, adminSvc, $window) {
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
          counselor_id:'',
          status: 0
        };

        var getCounselors = function () {
          // Un comment when using the server
          counselorSvc.getCounselorList()
            .then(function (response) {
              $scope.counselors = response.data;
            })
            .catch(function (error) {
              console.log(error);
            });
        };

        $scope.addNewCounselor = function ()
        {
          $location.path('/admin/new_counselor');
        };

        $scope.activateButton = function (counselor_id)
        {
          $scope.report.status = 1;
          $scope.report.counselor_id = counselor_id;
          adminSvc.putCounselor($scope.report)
            .then(function (response)
            {
              console.log(response);
              getCounselors();
              if(response.status !==200)
              {
                $window.alert("We are having technical problem. Please refresh the page.");
              }
              else{
                $window.alert("This counselor has been activated successfully.");
              }
              $location.path('/counselor');
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
              }
            );
        };

        $scope.deactivateButton = function (counselor_id)
        {
          $scope.report.status = 0;
          $scope.report.counselor_id = counselor_id;
          adminSvc.putCounselor($scope.report)
            .then(function (response)
            {
              console.log(response);
              getCounselors();
              $location.path('/counselor');
              if(response.status !==200)
              {
                $window.alert("We are having technical problem. Please refresh the page.");
              }
              else{
                $window.alert("This counselor has been deactivated successfully.");
              }
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
              }
            );
        };

        getUser();
        getCounselors();
      }]);
