'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:performanceReviewSummaryCtrl
 * @description
 * # performanceReviewSummaryCtrl
 * Performance Review Summary Ctrl of the eshipApp
 */
angular.module('eshipApp')
  .controller('performanceReviewSummaryCtrl',
    ['$scope', '$rootScope', '$location', 'authenticationSvc', 'performanceReviewSvc', '$window',
      function ($scope, $rootScope, $location, authenticationSvc, performanceReviewSvc, $window) {
        /*
         * Get Current Logged User from Auth. Service
         */
        var getUser = function()
        {
          $scope.user = authenticationSvc.getUserInfo();
          if(!$scope.user)
          {
            $location.path('/login');
          }
          else {
            if(!$scope.user.isCounselor)
            {
              $location.path('/');
            }
          }
        };

        var getReview = function () {
          // Un comment when using the server
          performanceReviewSvc.getPerformanceReviewSummary()
            .then(function (response) {
              $scope.review = response.data;
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


        $scope.addNewReview = function ()
        {
          $location.path('/performance_review/new_review');
        };

        getUser();
        getReview();
      }]);
