'use strict';
angular.module('eshipApp')
  .factory('statisticsSvc',
  ['authenticationSvc', '$location', '$rootScope', '$http', 'urlSvc',
    function (authenticationSvc, $location, $rootScope, $http, urlSvc) {

      var serviceUrl = urlSvc.getBaseUrl()+'/statistics';
      var statisticsSvc = {};

      statisticsSvc.getGeneralStatistics = function () {
        // Check Authentication
        var userInfo = authenticationSvc.getUserInfo();
        if(userInfo){
          return $http({
            method: 'GET',
            url: serviceUrl
          })
            .then(function (data) {return data;})
            .catch(function (error) {return error;});
        }
        else {
          $location.path('/login.html');
        }
      };

      statisticsSvc.getStatisticsByBusiness = function (businessId) {
        // Check Authentication
        var userInfo = authenticationSvc.getUserInfo();
        if(userInfo){
          return $http({
            method: 'GET',
            url: serviceUrl + '/' + businessId
          })
            .then(function (data) {return data;})
            .catch(function (error) {return error;});
        }
        else {
          $location.path('/login.html');
        }
      };

      //verify
      statisticsSvc.postGeneralStatisticsDate = function (statistics) {
        // Check Authentication
        var userInfo = authenticationSvc.getUserInfo();
        if(userInfo){
          return $http({
            method: 'POST',
            url: serviceUrl + '/date',
            dataType: 'json',
            headers : {'Content-Type': 'application/x-www-form-urlencoded'},
            data: statistics
          })
            .then(function (data) {return data;})
            .catch(function (error) {return error;});
        }
        else {
          $location.path('/login.html');
        }
      };

      return statisticsSvc;
    }]);
