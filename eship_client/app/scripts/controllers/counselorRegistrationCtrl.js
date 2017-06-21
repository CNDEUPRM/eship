
'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:counselorRegistrationCtrl
 * @description
 * # counselorRegistrationCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('counselorRegistrationCtrl',
    ['counselor_request_id','$location', '$rootScope', '$scope', '$window', 'counselorSvc', 'md5',
      function (counselor_request_id, $location, $rootScope, $scope, $window, counselorSvc, md5 )
      {
        /*
         * Form fields
         */
        $scope.registration = {
          first_name: '',
          last_name: '',
          initial: '',
          email: '',
          phone: '',
          password: '',
          confirm_password: '',
          password_: '',
          confirm_password_: '',
          position_uprm: '',
          department: '',
          cnde_organization: '',
          age: 0,
          gender: '',
          expertise: ''
        };

        $scope.validPassword = function (){
          return angular.equals($scope.registration.password_, $scope.registration.confirm_password_);
        };

        $scope.regexs = {
          bigText: '[a-zA-Z\\d\\.\\:\\,\\;\\s\\-]+',
          phone: /^(\d{3})([-\.\s]??\d{3}[-\.\s]??\d{4}|\(\d{3}\)\s*\d{3}[-\.\s]??\d{4}|\d{3}[-\.\s]??\d{4})$/g,
          password: '[a-zA-Z\\d]+',
          postal: '\\d{5,6}'
        };


        /*
         * Form Functions
         */
        $scope.isValid = function ()
        {
          var result = ($scope.registration.first_name !== '' &&
            $scope.registration.last_name !== '' &&
            $scope.registration.initial !== '' &&
            $scope.registration.email !== '' &&
            $scope.registration.phone !== '' &&
            $scope.registration.password !== '' &&
            $scope.registration.confirm_password !== '' &&
            $scope.registration.age >= 0 &&
            $scope.registration.gender !== '' &&
            $scope.registration.department !== '' &&
            $scope.registration.cnde_organization !== '',
            $scope.registration.expertise !==''
          );
          return result;
        };

        $scope.submitClient = function ()
        {
          if($scope.validPassword() === true && $scope.isValid()===true)
          {
            console.log($scope.registration);
            $scope.registration.password = md5.createHash($scope.registration.password_);
            $scope.registration.confirm_password = md5.createHash($scope.registration.confirm_password_);
            console.log($scope.registration);
            counselorSvc.postCounselor(counselor_request_id, $scope.registration)
                .then(function (response)
                {
                    console.log(response);
                    $location.path('/login');
                    if(response.status !==200){
                        $window.alert("This invitation is not valid. Please contact the page admin to get a new one.");
                    }else{
                        $window.alert('You have registered successfully! Please login.');
                    }
                })
                .catch(function (err)
                    {
                        if(err.status === 401 || err.status === 404)
                        {
                            $window.alert("This invitation is not valid. Please contact the page admin to get a new one.");
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
          else {
            $window.alert('Your Password does not match, please change it.');
          }
        };

      }]);
