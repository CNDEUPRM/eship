'use strict';
angular.module('eshipApp')
  .factory('clientSvc', ['authenticationSvc', '$location', '$rootScope', '$http', 'urlSvc',
    function (authenticationSvc, $location, $rootScope, $http, urlSvc) {

      var serviceUrl = urlSvc.getBaseUrl() + '/client';
      var clientSvc = {};

      clientSvc.getClient= function (clientId) {
        // Check Authentication
        var userInfo = authenticationSvc.getUserInfo();
        if(userInfo){
          return $http({
            method: 'GET',
            url: serviceUrl + '/' + clientId
          })
            .then(function (data) {return data;})
            .catch(function (error) {return error;});
        }
        else {
          $location.path('/login.html');
        }
      };

      clientSvc.putClient = function (client) {
        // Check Authentication
        var userInfo = authenticationSvc.getUserInfo();
        if(userInfo){
          return $http({
            method: 'PUT',
            url: serviceUrl + '/'+client.clientId+'/edit',
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

      //Abi please verify, user shouldn't be logged in
      clientSvc.postClient = function (client) {
        return $http({
          method: 'POST',
          url: urlSvc.getBaseUrl() + '/register/client',
          dataType: 'json',
          headers : {'Content-Type': 'application/x-www-form-urlencoded'},
          data: client
        })
          .then(function (data) {return data;})
          .catch(function (error) {return error;});
      };

      return clientSvc;

    }]);

