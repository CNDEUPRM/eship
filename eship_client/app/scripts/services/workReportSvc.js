'use strict';
angular.module('eshipApp')
  .factory('workReportSvc',
    ['authenticationSvc', '$location', '$rootScope', '$http', 'urlSvc',
      function (authenticationSvc, $location, $rootScope, $http, urlSvc) {

        var serviceUrl = urlSvc.getBaseUrl()+'/work_report';
        var workReportSvc = {};

        workReportSvc.getWorkReports = function(business_id, report_id){
          //Check Authentication
          var userInfo = authenticationSvc.getUserInfo();
          if(userInfo){
            return $http({
              method: 'GET',
              url: serviceUrl + '/' + business_id + '/'+ report_id
            })
              .then(function (data) {return data;})
              .catch(function (error) {return error;});
          }
          else {
            $location.path('/login.html');
          }
        };


        workReportSvc.getWorkReport = function (businessId, meetingReportId, updateId) {
          // Check Authentication
          var userInfo = authenticationSvc.getUserInfo();
          if(userInfo){
            return $http({
              method: 'GET',
              url: serviceUrl + '/' + businessId + '/' + meetingReportId+'/'+ updateId
            })
              .then(function (data) {return data;})
              .catch(function (error) {return error;});
          }
          else {
            $location.path('/login.html');
          }
        };

        workReportSvc.postWorkReport = function (businessId, meetingReportId, report) {
          // Check Authentication
          var userInfo = authenticationSvc.getUserInfo();
          if(userInfo){
            return $http({
              method: 'POST',
              url: serviceUrl + '/' + businessId + '/' + meetingReportId+'/new_report',
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

        return workReportSvc;
      }]);
