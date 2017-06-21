'use strict';
angular.module('eshipApp')
  .factory('counselorSvc', ['authenticationSvc', '$location', '$rootScope', '$http', 'urlSvc',
  function (authenticationSvc, $location, $rootScope, $http, urlSvc) {

    var serviceUrl = urlSvc.getBaseUrl()+'/counselor';

    var counselorSvc = {};

    counselorSvc.getCounselorList = function () {
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
        $location.path('/login');
      }
    };

    counselorSvc.getCounselor= function (counselorId) {
      // Check Authentication
      var userInfo = authenticationSvc.getUserInfo();
      if(userInfo){
        return $http({
          method: 'GET',
          url: serviceUrl + '/' + counselorId
        })
          .then(function (data) {return data;})
          .catch(function (error) {return error;});
      }
      else {
        $location.path('/login.html');
      }
    };

    counselorSvc.putCounselor = function (counselor) {
      // Check Authentication
      var userInfo = authenticationSvc.getUserInfo();
      if(userInfo){
        return $http({
          method: 'PUT',
          url: serviceUrl + '/'+counselor.counselorId+'/edit',
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

    counselorSvc.postCounselor = function (counselor_request_id, counselor) {
      return $http({
        method: 'POST',
        url: urlSvc.getBaseUrl() + '/register/counselor/'+counselor_request_id,
        dataType: 'json',
        headers : {'Content-Type': 'application/x-www-form-urlencoded'},
        data: counselor
      })
        .then(function (data) {return data;})
        .catch(function (error) {return error;});
    };

    return counselorSvc;

  }]);

