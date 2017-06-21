
'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:workReportSummaryCtrl
 * @description
 * # workReportSummaryCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('workReportSummaryCtrl',
    ['work_report_info', '$scope', '$rootScope', '$location', 'authenticationSvc', 'workReportSvc', '$window',
      function (work_report_info, $scope, $rootScope, $location, authenticationSvc, workReportSvc, $window) {
        // Get Current User from Service
        var getUser = function(){
          $scope.user = authenticationSvc.getUserInfo();
          if(!$scope.user){
            $rootScope.$emit('unLogin');
            $location.path('/');
          }
        };

        var getReport = function () {
          // Un comment when using the server
          workReportSvc.getWorkReport(work_report_info.business_id, work_report_info.meeting_report_id,
            work_report_info.work_report_id)
            .then(function (response) {
              $scope.view_report= response.data[0];
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
        getReport();
      }]);
