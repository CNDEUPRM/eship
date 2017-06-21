
'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:performanceReviewFormCtrl
 * @description
 * # performanceReviewFormCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('performanceReviewFormCtrl',
    ['$location', '$rootScope', '$scope', 'authenticationSvc', 'performanceReviewSvc', '$window',
      function ($location, $rootScope, $scope, authenticationSvc, performanceReviewSvc, $window)
      {
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

        /*
         * Form fields
         */
        $scope.new_review = {
          counselor_id: $scope.user.userId,
          first_name: '',
          last_name: '',
          rate_services: 0,
          comment: '',
          usefulness: '',
          city: '',
          email: '',
          phone: ''
        };

        $scope.regexs = {
          email: /(^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$)/g,
          phone: /^(\d{3})([-\.\s]??\d{3}[-\.\s]??\d{4}|\(\d{3}\)\s*\d{3}[-\.\s]??\d{4}|\d{3}[-\.\s]??\d{4})$/g
        };

        /*
         * Form Functions
         */
        $scope.isValid = function ()
        {
          var result = ($scope.new_review.first_name !== '' &&
          $scope.new_review.last_name !== '' &&
          $scope.new_review.rate_services >= 0 &&
          $scope.new_review.usefulness !== '' &&
          $scope.new_review.city !== '' &&
          $scope.new_review.email !== '' &&
          $scope.new_review.phone !== '');
          return result;
        };

        $scope.submitReview = function ()
        {
          console.log($scope.new_review);
          performanceReviewSvc.postNewPerformanceReview($scope.new_review)
            .then(function (response) {
              if(response.status !==200){
                $window.alert("This Performance Review not been submitted successfully. Please try again.");
              }else{
                $window.alert('This Performance Review has been submitted successfully!');
                $location.path('/performance_review/');
              }
            })
            .catch(function (err) {
              if(err.status === 401 || err.status === 404)
              {
                $window.alert("This Performance Review not been submitted successfully. Please try again.");
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

      }]);
