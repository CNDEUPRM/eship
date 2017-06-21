
'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:addNewAdminOrCounselorCtrl
 * @description
 * # addNewAdminOrCounselorCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('addNewAdminOrCounselorCtrl',
    ['$location', '$rootScope', '$scope', 'authenticationSvc', 'adminSvc', '$window',
      function ($location, $rootScope, $scope, authenticationSvc, adminSvc, $window )
      {
        /*
         * Get Current Logged User from Auth. Service
         */
        var getUser = function()
        {
          $scope.user = authenticationSvc.getUserInfo();
          if(!$scope.user) {
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
        $scope.new_user = {
          counselor_id: $scope.user.userId,
          email: '',
          role: ''
        };


        /*
         * Form Functions
         */
        $scope.isValid = function ()
        {
          var result = ($scope.new_user.email !== '' &&
          $scope.new_user.role>=0);
          return result;
        };

        $scope.postNewUser = function ()
        {
          console.log($scope.new_user);
          adminSvc.postNewCounselor($scope.new_user)
            .then(function (response) {
              console.log(response);
              if(response.status !==200){
                $window.alert("Your invitation was lost in the mail. Please try again.");
              }else{
                $window.alert('Your invitation has been sent successfully!');
                $location.path('/home');
              }
            })
            .catch(function (err)
              {
                if(err.status === 401 || err.status === 404)
                {
                  $window.alert("Your invitation was lost in the mail. Please try again.");
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
