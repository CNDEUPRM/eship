
'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:counselorForgotPasswordCtrl
 * @description
 * # counselorForgotPasswordCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('counselorForgotPasswordCtrl',
    ['request_id', '$location', '$rootScope', '$scope', 'changePasswordSvc', '$window', 'md5',
      function (request_id, $location, $rootScope, $scope, changePasswordSvc, $window, md5)
      {


        /*
         * Form fields
         */
        $scope.reset = {
          new_password_: '',
          confirm_password_: ''
        };

        $scope.post = {
          new_password: '',
          confirm_password: ''
        };

        $scope.isValid = function ()
        {
          var result = ($scope.reset.confirm_password_ !== '' &&
          $scope.reset.new_password_!=='');
          return result;
        };

        $scope.validPassword = function (){
          return angular.equals($scope.reset.new_password_, $scope.reset.confirm_password_);
        };

        $scope.regexs = {
          password: '[a-zA-Z\\d]+'
        };

        $scope.submitRequest = function ()
        {
          $scope.post.new_password = md5.createHash($scope.reset.new_password_);
          $scope.post.confirm_password = md5.createHash($scope.reset.confirm_password_);
          if($scope.isValid()===true && $scope.validPassword())
          {
            changePasswordSvc.putCounselorForgot(request_id, $scope.post)
              .then(function (response) {
                console.log(response);
                $location.path('/login');
                if(response.status !==200){
                  $location.path('/forgot_password/counselor/'+request_id);
                  $window.alert("You entered and invalid email combination. Please try again");
                }else{
                  $window.alert('Your request has been successful.');
                }
              })
              .catch(function (err) {
                  console.log(err);
                }
              );
          }
          else{
            $window.alert('Your request is invalid');
          }

        };

      }]);
