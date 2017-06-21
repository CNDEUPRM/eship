'use strict';
angular.module('eshipApp')
  .factory("authenticationSvc",
    ["$http","$q","$window", '$rootScope', 'md5', 'urlSvc', function ($http, $q, $window, $rootScope, md5, urlSvc) {

      var userInfo;
      var serviceUrl = urlSvc.getBaseUrl()+'/login';

      function login(email, password, type) {

        var url = serviceUrl;
        var deferred = $q.defer();
        if(type){
          url = serviceUrl + '/counselor';
        }
        $http({
          method: 'POST',
          url: url,
          dataType: 'json',
          headers : {'Content-Type': 'application/x-www-form-urlencoded'},
          data: {"email": email, "password": md5.createHash(password)}

        })
          .then(function (result) {
            userInfo = {
              userId: result.data.userId,
              role: result.data.role,
              isCounselor: type,
              userEmail: email
            };
            $window.sessionStorage["userInfo"] = JSON.stringify(userInfo);
            deferred.resolve(userInfo);
          }, function (error) {
            deferred.reject(error);
          });
        return deferred.promise;
      }

      function logout() {
        var deferred = $q.defer();

        try {
          userInfo = null;
          $window.sessionStorage["userInfo"] = null;
          deferred.resolve();
        }
        catch(err) {
          deferred.reject(err);
        }

        return deferred.promise;
      }

      function getUserInfo() {
        return userInfo;
      }

      function init() {
        if ($window.sessionStorage["userInfo"]) {
          userInfo = JSON.parse($window.sessionStorage["userInfo"]);
        }
      }

      init();

      return {
        login: login,
        logout: logout,
        getUserInfo: getUserInfo
      };

    }]);
