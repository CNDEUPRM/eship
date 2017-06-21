
'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:clientForgotPasswordCtrl
 * @description
 * # clientForgotPasswordCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('clientForgotPasswordCtrl',
    ['request_id', '$location', '$rootScope', '$scope', 'changePasswordSvc', '$window', 'md5',
      function (request_id, $location, $rootScope, $scope, changePasswordSvc, $window, md5)
      {


        /*
         * Form fields
         */
        $scope.reset = {
          confirm_password_: '',
          new_password_: ''
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

        $scope.regexs = {
          password: '[a-zA-Z\\d]+'
        };

        $scope.validPassword = function (){
          return angular.equals($scope.reset.new_password_, $scope.reset.confirm_password_);
        };

        $scope.submitRequest = function ()
        {
          $scope.post.new_password = md5.createHash($scope.reset.new_password_);
          $scope.post.confirm_password = md5.createHash($scope.reset.confirm_password_);
          if($scope.isValid()===true && $scope.validPassword())
          {
            console.log($scope.post);
            changePasswordSvc.putClientForgot(request_id, $scope.post)
              .then(function (response) {
                console.log(response);
                if(response.status !==200){
                  $location.path('/forgot_password/counselor/'+request_id);
                  $window.alert("You entered and invalid email. Please try again");
                }else{
                  $window.alert('Your request has been successful.');
                  $location.path('/login');
                }
              })
              .catch(function (err) {
                if(err.status === 401 || err.status === 404)
                {
                  $window.alert("You entered and invalid email. Please try again");
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
          }
          else{
            $window.alert('Your request is invalid');
          }

        };

      }]);
