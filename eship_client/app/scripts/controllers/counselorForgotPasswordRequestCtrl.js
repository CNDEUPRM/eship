'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:counselorForgotPasswordCtrl
 * @description
 * # counselorForgotPasswordCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('counselorForgotPasswordRequestCtrl', ['$location', '$rootScope', '$scope', 'changePasswordSvc', '$window',
    function($location, $rootScope, $scope, changePasswordSvc, $window) {
      /*
       * Form fields
       */
      $scope.resetEmail = {
        email: ''
      };

      $scope.isValid = function() {
        return $scope.resetEmail.email !== '';
      };


      $scope.submitRequest = function() {

        console.log($scope.resetEmail);
        changePasswordSvc.postCounselorForgot($scope.resetEmail)
          .then(function(response) {
            console.log(response);
            $location.path('/login');
            if (response.status !== 200) {
              $window.alert("The email you entered does not match our records. Please try again with another email");
              $location.path('/forgot_password/counselor');
            } else {
              $window.alert('Your request has been successful. Please check your email for further instructions');
            }
          })
          .catch(function(err) {
            console.log(err);
          });


      };

    }
  ]);
