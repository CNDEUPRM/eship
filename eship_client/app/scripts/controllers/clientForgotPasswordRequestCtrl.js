'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:clientForgotPasswordCtrl
 * @description
 * # clientForgotPasswordCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('clientForgotPasswordRequestCtrl', ['$location', '$rootScope', '$scope', 'changePasswordSvc', '$window',
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

        changePasswordSvc.postClientForgot($scope.resetEmail)
          .then(function(response) {
            console.log(response);
            $location.path('/login');
            if (response.status !== 200) {
              $window.alert("The email you entered does not match our records. Please try again with another email");
              $location.path('/forgot_password/client');
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
