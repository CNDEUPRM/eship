
'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:statisticsCtrl
 * @description
 * # statisticsCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('statisticsCtrl',
    ['auth', '$scope', '$rootScope', '$location', 'authenticationSvc', 'statisticsSvc', '$window',
      function (auth, $scope, $rootScope, $location, authenticationSvc, statisticsSvc, $window) {
        // Get Current User from Service
        var getUser = function(){
          $scope.user = authenticationSvc.getUserInfo();
          if(!$scope.user){
            $rootScope.$emit('unLogin');
            $location.path('/');
          }
        };

        var getGeneralStatistics = function ()
        {
          statisticsSvc.getGeneralStatistics()
            .then(function (response)
            {
              $scope.stats = response.data;
              if(response.status !==200){
                $window.alert("We are having technical problem. Please refresh the page.");
              }
            })
            .catch(function (err) {
              if(err.status === 401 || err.status === 404)
              {
                $window.alert("We are having technical problem. Please refresh the page.");
              }
              else if(err.status === 500)
              {
                $location.path('/500');
              }
              $rootScope.$emit('unLogin');
              $location.path('/500');
              console.log(err);
            });

        };

        getUser();
        getGeneralStatistics();
      }]);
