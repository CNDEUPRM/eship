
'use strict';

/**
 * @ngdoc function
 * @name mvpApp.controller:loginCtrl
 * @description
 * # loginCtrl
 * Login Controller of the mvpApp
 */
angular.module('eshipApp')
  .controller('loginCtrl', ['$scope', '$rootScope', '$location', '$window', 'authenticationSvc',
    function ($scope, $rootScope, $location, $window, authenticationSvc){

      var getUser = function () {
        if(authenticationSvc.getUserInfo()){
          $location.path('/home');
        }
      };

      $scope.isWaiting = false;

      $scope.login = function(){
        $scope.isWaiting = true;
        if($scope.email && $scope.password){
          authenticationSvc.login($scope.email, $scope.password, $scope.counselor)
            .then(function(result){
              console.log(result);
              $scope.userInfo = result;
              $rootScope.$emit('Login');
              $location.path('/home');
            }).catch(function(error) {
            $window.alert('Invalid Credentials');
            console.log(error);
            $rootScope.$emit('unLogin');
            $location.path('/login');
            $scope.isWaiting = false;
          });
        }else {
          $window.alert('Please provide an email and a password.');
          //$scope.errorMessage = 'Please provide an email and a password.';
          $scope.isWaiting = false;
        }
      };

      $scope.forgotPasswordClient = function () {
        $location.path('/forgot_password/client');
      };

      $scope.forgotPasswordCounselor = function () {
        $location.path('/forgot_password/counselor');
      };

      $scope.registerClient = function () {
        $location.path('/register/client');
      };

      $scope.counselorLogin = function () {
        $scope.counselor = true;
      };

      $scope.clientLogin = function () {
        $scope.counselor = false;
      };

      getUser();

    }]);
