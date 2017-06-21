'use strict';


angular.module('eshipApp')
  .controller('workReportHistoryCtrl',
    ['work_report_info','$scope', '$rootScope', '$location', 'authenticationSvc', 'workReportSvc', '$window',
      function (work_report_info, $scope, $rootScope, $location, authenticationSvc, workReportSvc, $window) {
        // Get Current User from Service
        var getUser = function(){
          $scope.user = authenticationSvc.getUserInfo();
          $scope.openLogout = false;
          $rootScope.Loggedin = ($scope.user)? true:false;
          if(!$scope.user)
          {
            $location.path('/login');
          }
          else {
            if(!$scope.user.isCounselor){
              $location.path('/');
            }
          }
        };

        $scope.search = '';

        $scope.newReport = function ()
        {
          $location.path('/work_report/'+ work_report_info.business_id + '/' + work_report_info.meeting_report_id + '/new_report');
        };

        $scope.selectView = function (report_id)
        {
          $location.path('/work_report/'+ work_report_info.business_id + '/' + work_report_info.meeting_report_id + '/' + report_id);

        };


        var getWorkReports = function () {
          console.log(work_report_info);
          // Un comment when using the server
          workReportSvc.getWorkReports(work_report_info.business_id, work_report_info.meeting_report_id)
            .then(function (response) {
              console.log(response);
              if(response.status === 200){
                $scope.workReports = response.data;
              }
              else{
                $scope.workReports = [];
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
        getWorkReports();
      }]);
