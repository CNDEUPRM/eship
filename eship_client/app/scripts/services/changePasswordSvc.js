'use strict';
angular.module('eshipApp')
  .factory('changePasswordSvc', ['authenticationSvc', '$location', '$rootScope', '$http', 'urlSvc',
    function (authenticationSvc, $location, $rootScope, $http, urlSvc) {
      var serviceUrl = urlSvc.getBaseUrl();
      var changePasswordSvc = {};

      changePasswordSvc.postClientForgot = function (client) {
        return $http({
          method: 'POST',
          url: serviceUrl + '/forgot_password/client',
          dataType: 'json',
          headers : {'Content-Type': 'application/x-www-form-urlencoded'},
          data: client
        })
          .then(function (data) {return data;})
          .catch(function (error) {return error;});
      };

      changePasswordSvc.postCounselorForgot = function (counselor) {
        return $http({
          method: 'POST',
          url: serviceUrl + '/forgot_password/counselor',
          dataType: 'json',
          headers : {'Content-Type': 'application/x-www-form-urlencoded'},
          data: counselor
        })
          .then(function (data) {return data;})
          .catch(function (error) {return error;});
      };

      changePasswordSvc.putCounselorForgot = function (request_id, counselor) {
        return $http({
          method: 'PUT',
          url: serviceUrl + '/forgot_password/counselor/'+request_id,
          dataType: 'json',
          headers : {'Content-Type': 'application/x-www-form-urlencoded'},
          data: counselor
        })
          .then(function (data) {return data;})
          .catch(function (error) {return error;});
      };

      changePasswordSvc.putClientForgot = function (request_id, client) {
        return $http({
          method: 'PUT',
          url: serviceUrl + '/forgot_password/client/'+request_id,
          dataType: 'json',
          headers : {'Content-Type': 'application/x-www-form-urlencoded'},
          data: client
        })
          .then(function (data) {return data;})
          .catch(function (error) {return error;});
      };

      changePasswordSvc.putCounselorChange = function (counselor) {
        // Check Authentication
        var userInfo = authenticationSvc.getUserInfo();
        if(userInfo){
          return $http({
            method: 'PUT',
            url: serviceUrl + '/settings/change_password/counselor',
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

      changePasswordSvc.putClientChange = function (client) {
        // Check Authentication
        var userInfo = authenticationSvc.getUserInfo();
        if(userInfo){
          return $http({
            method: 'PUT',
            url: serviceUrl + '/settings/change_password/client',
            dataType: 'json',
            headers : {'Content-Type': 'application/x-www-form-urlencoded'},
            data: client
          })
            .then(function (data) {return data;})
            .catch(function (error) {return error;});
        }
        else {
          $location.path('/login.html');
        }
      };

      return changePasswordSvc;
    }]);
