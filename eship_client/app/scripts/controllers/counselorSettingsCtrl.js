'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:counselorSettingsCtrl
 * @description
 * # counselorSettingsCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('counselorSettingsCtrl',
    ['$scope', '$rootScope', '$location', 'authenticationSvc',
      function ($scope, $rootScope, $location, authenticationSvc) {
        // Get Current User from Service
        var getUser = function(){
          $scope.user = authenticationSvc.getUserInfo();
          if(!$scope.user){
            $rootScope.$emit('unLogin');
            $location.path('/');
          }
        };


        $scope.changePassword = function ()
        {
          $location.path('/settings/counselor/change_password');
        };

        getUser();
      }]);
