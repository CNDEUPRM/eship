'use strict';
angular.module('eshipApp')
  .factory('adminSvc', ['authenticationSvc', '$location', '$rootScope', '$http', 'urlSvc',
    function (authenticationSvc, $location, $rootScope, $http, urlSvc) {

      var serviceUrl = urlSvc.getBaseUrl() + '/admin';
      var adminSvc = {};

      adminSvc.postNewCounselor = function (counselor) {
        // Check Authentication
        var userInfo = authenticationSvc.getUserInfo();
        if(userInfo){
          return $http({
            method: 'POST',
            url: serviceUrl + '/new_counselor',
            dataType: 'json',
            headers : {'Content-Type': 'application/x-www-form-urlencoded'},
            data: counselor
          })
            .then(function (data) {return data;})
            .catch(function (error) {return error;});
        }
        else {
          $location.path('/login.html');
        }
      };

      adminSvc.putBusiness = function (business) {
        // Check Authentication
        var userInfo = authenticationSvc.getUserInfo();
        if(userInfo){
          return $http({
            method: 'PUT',
            url: serviceUrl + '/business',
            dataType: 'json',
            headers : {'Content-Type': 'application/x-www-form-urlencoded'},
            data: business
          })
            .then(function (data) {return data;})
            .catch(function (error) {return error;});
        }
        else {
          $location.path('/login.html');
        }
      };

      adminSvc.putCounselor = function (counselor) {
        // Check Authentication
        var userInfo = authenticationSvc.getUserInfo();
        if(userInfo){
          return $http({
            method: 'PUT',
            url: serviceUrl + '/counselors',
            dataType: 'json',
            headers : {'Content-Type': 'application/x-www-form-urlencoded'},
            data: counselor
          })
            .then(function (data) {return data;})
            .catch(function (error) {return error;});
        }
        else {
          $location.path('/login.html');
        }
      };
      return adminSvc;
    }]);
