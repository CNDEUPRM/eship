'use strict';
angular.module('eshipApp')
  .factory('performanceReviewSvc', ['authenticationSvc', '$location', '$rootScope', '$http', 'urlSvc',
  function (authenticationSvc, $location, $rootScope, $http, urlSvc) {

    var serviceUrl = urlSvc.getBaseUrl()+'/performance_review';

    var performanceReviewSvc = {};

    performanceReviewSvc.getPerformanceReviewSummary = function () {
      // Check Authentication
      var userInfo = authenticationSvc.getUserInfo();
      if(userInfo){
        return $http({
          method: 'GET',
          url: serviceUrl + '/summary'
        })
          .then(function (data) {return data;})
          .catch(function (error) {return error;});
      }
      else {
        $location.path('/login.html');
      }
    };

    performanceReviewSvc.postNewPerformanceReview = function (review) {
      // Check Authentication
      var userInfo = authenticationSvc.getUserInfo();
      if(userInfo){
        return $http({
          method: 'POST',
          url: serviceUrl + '/new_review',
          dataType: 'json',
          headers : {'Content-Type': 'application/x-www-form-urlencoded'},
          data: review
        })
          .then(function (data) {return data;})
          .catch(function (error) {return error;});
      }
      else {
        $location.path('/login.html');
      }
    };

    return performanceReviewSvc;

  }]);
