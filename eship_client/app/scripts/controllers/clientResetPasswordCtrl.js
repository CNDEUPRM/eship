'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:clientResetPasswordCtrl
 * @description
 * # clientResetPasswordCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('clientResetPasswordCtrl',
    ['$location', '$rootScope', '$scope', 'changePasswordSvc', 'md5', '$window', 'authenticationSvc',
      function ($location, $rootScope, $scope, changePasswordSvc, md5, $window, authenticationSvc)
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
            if($scope.user.isCounselor)
            {
              $location.path('/');
            }
          }
        };

        /*
         * Form fields
         */
        $scope.change = {
          client_id: $scope.user.userId,
          current_password: '',
          new_password: '',
          confirm_password: '',
          current_password_: '',
          new_password_: '',
          confirm_password_: ''
        };

        $scope.regexs = {
          password: '[a-zA-Z\\d]+'
        };

        $scope.isPosting = false;

        $scope.validPassword = function (){
          return angular.equals($scope.change.new_password_, $scope.change.confirm_password_);
        };


        $scope.postChange = function ()
        {
          $scope.isPosting = true;
          $scope.change.current_password = md5.createHash($scope.change.current_password_);
          $scope.change.new_password = md5.createHash($scope.change.new_password_);
          $scope.change.confirm_password = md5.createHash($scope.change.confirm_password_);
          if($scope.validPassword()===true)
          {
            changePasswordSvc.putClientChange($scope.change)
              .then(function (response)
              {
                console.log(response);
                if(response.status !==200){
                  $window.alert("Your current password does not match our records");
                  $scope.isPosting = false;
                }else{
                  $window.alert('Your password has been changed successfully!');
                  $scope.isPosting = false;
                  $location.path('/home');
                }
              })
              .catch(function (err)
                {
                  if(err.status === 401 || err.status === 404)
                  {
                    $window.alert("Your current password does not match our records");
                  }
                  else if(err.status === 500)
                  {
                    $location.path('/500');
                  }
                  $rootScope.$emit('unLogin');
                  $location.path('/500');
                  console.log(err);
                  $scope.isPosting = false;
                }
              );
          }
          else{
            $window.alert("Your new password does not match.");
            $scope.isPosting = false;
          }

        };
        getUser();
      }]);
