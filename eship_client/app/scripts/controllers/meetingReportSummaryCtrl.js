
'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:meetingReportSummaryCtrl
 * @description
 * # meetingReportSummaryCtrl
 * Business Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('meetingReportSummaryCtrl',
    ['meeting_report', '$scope', '$rootScope', '$location', 'authenticationSvc', 'meetingReportSvc', '$window',
      function (meeting_report, $scope, $rootScope, $location, authenticationSvc, meetingReportSvc, $window) {
        // Get Current User from Service
        var getUser = function(){
          $scope.user = authenticationSvc.getUserInfo();
          if(!$scope.user){
            $rootScope.$emit('unLogin');
            $location.path('/');
          }
        };

        $scope.newReport = function ()
        {
          $location.path('/work_report/'+ meeting_report.business_id + "/" + meeting_report.report_id);
        };

        var getMeetingReport = function () {
          // Un comment when using the server
          meetingReportSvc.getMeetingReportsInfo(meeting_report.business_id, meeting_report.report_id)
            .then(function (response) {
              $scope.meetingReportInfo = response.data[0];
              if(response.status===404){
                $location.path('/404');
              }
            })
            .catch(function (err) {
              if(err.status === 401 || err.status === 404)
              {
                $window.alert("We are having technical problem. Please refresh the page.");
              }
              else if(err.status === 500)
              {
                $location.path('/500');
              }
              $rootScope.$emit('unLogin');
              $location.path('/500');
              console.log(err);
            });

        };

        getUser();
        getMeetingReport();
      }]);
