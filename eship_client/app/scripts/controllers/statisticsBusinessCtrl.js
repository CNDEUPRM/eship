
'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:statisticsBusinessCtrl
 * @description
 * # statisticsBusinessCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('statisticsBusinessCtrl',
    ['business_id', '$scope', '$rootScope', '$location', 'authenticationSvc', 'statisticsSvc', '$window',
      function (business_id, $scope, $rootScope, $location, authenticationSvc, statisticsSvc, $window) {
        // Get Current User from Service
        var getUser = function(){
          $scope.user = authenticationSvc.getUserInfo();
          if(!$scope.user){
            $rootScope.$emit('unLogin');
            $location.path('/');
          }
        };

        var getStatisticsByBusiness = function ()
        {
          // Un comment when using the server
          statisticsSvc.getStatisticsByBusiness(business_id)
            .then(function (response)
            {
              $scope.business_stats = response.data[0];
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
        getStatisticsByBusiness();
      }]);
