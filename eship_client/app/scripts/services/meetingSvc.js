'use strict';
angular.module('eshipApp').factory('meetingReportSvc',
  ['authenticationSvc', '$location', '$rootScope', '$http', 'urlSvc',
  function (authenticationSvc, $location, $rootScope, $http, urlSvc) {

    var serviceUrl = urlSvc.getBaseUrl()+'/meeting_report';
    var meetingReportSvc = {};

    meetingReportSvc.getMeetingReportsInfo = function (businessId, meetingReportId) {
      // Check Authentication
      var userInfo = authenticationSvc.getUserInfo();
      if(userInfo){
        return $http({
          method: 'GET',
          url: serviceUrl + '/' + businessId + '/' + meetingReportId
          })
          .then(function (data) {return data;})
          .catch(function (error) {return error;});
      }
      else {
        $location.path('/login.html');
      }
    };


    meetingReportSvc.getMeetingReports = function (business_id){
      //Check Authentication
      var userInfo = authenticationSvc.getUserInfo();
      if(userInfo) {
        return $http({
          method: 'GET',
          url: serviceUrl + '/' + business_id
        })
          .then(function (data) {
            return data;
          })
          .catch(function (error) {
            return error;});
      }
      else{
        $location.path('/login.html');
      }
    };

    meetingReportSvc.postMeetingReport = function (businessId, report) {
      // Check Authentication
      var userInfo = authenticationSvc.getUserInfo();
      if(userInfo){
        return $http({
          method: 'POST',
          url: serviceUrl + '/' + businessId + '/new_report',
          dataType: 'json',
          headers : {'Content-Type': 'application/x-www-form-urlencoded'},
          data: report
        })
          .then(function (data) {return data;})
          .catch(function (error) {return error;});
      }
      else {
        $location.path('/login.html');
      }
    };

    return meetingReportSvc;
  }]);
