'use strict';
angular.module('eshipApp')
  .factory('businessSvc', ['authenticationSvc', '$location', '$rootScope', '$http', 'urlSvc',
  function (authenticationSvc, $location, $rootScope, $http, urlSvc) {
    var serviceUrl = urlSvc.getBaseUrl() + '/business';
    var businessSvc = {};

    businessSvc.getBusinessInfo = function (businessId) {
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
        $location.path('/login');
      }
    };

    businessSvc.getBusiness = function () {
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

    businessSvc.getInactiveBusiness = function () {
      // Check Authentication
      var userInfo = authenticationSvc.getUserInfo();
      if(userInfo){
        return $http({
          method: 'GET',
          url: serviceUrl + '/inactive'
        })
          .then(function (data) {return data;})
          .catch(function (error) {return error;});
      }
      else {
        $location.path('/login');
      }
    };

    businessSvc.getBusinessByClient = function (client_id) {
      // Check Authentication
      var userInfo = authenticationSvc.getUserInfo();
      if(userInfo){
        return $http({
          method: 'GET',
          url: urlSvc.getBaseUrl()+ '/owned_business/' + client_id
        })
          .then(function (data) {return data;})
          .catch(function (error) {return error;});
      }
      else {
        $location.path('/login');
      }
    };

    businessSvc.postBusinessClient = function (business) {
      // Check Authentication
      var userInfo = authenticationSvc.getUserInfo();
      if(userInfo){
        return $http({
          method: 'POST',
          url: serviceUrl + '/new_business',
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

    businessSvc.postBusinessCounselor = function (business) {
      // Check Authentication
      var userInfo = authenticationSvc.getUserInfo();
      if(userInfo){
        return $http({
          method: 'POST',
          url: serviceUrl + '/counselor/new_business',
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

    businessSvc.putBusiness = function (businessId, business) {
      // Check Authentication
      var userInfo = authenticationSvc.getUserInfo();
      if(userInfo){
        return $http({
          method: 'PUT',
          url: serviceUrl + '/edit' + businessId,
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

    return businessSvc;
  }]);
