
'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller: meetingReportHistoryCtrl
 * @description
 * # Meeting Report History Ctrl
 * Controller of the Meeting Reports View
 */
angular.module('eshipApp')
  .controller('meetingReportHistoryCtrl',
    [ 'business_id', '$location', '$rootScope', '$scope', 'authenticationSvc', 'meetingReportSvc', '$window',
    function (business_id, $location, $rootScope, $scope, authenticationSvc, meetingReportSvc, $window) {

      //Verify Auth User

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

      var getMeetingReports = function(business_id)
      {
        // Un comment when using the server
        meetingReportSvc.getMeetingReports(business_id)
          .then(function (response)
          {
            $scope.meetingReports = response.data;
          })
          .catch(function (err)
          {
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

      $scope.newReport = function ()
      {
        $location.path('/meeting_report/'+ business_id +'/new_report');
      };

      $scope.selectView = function (report_id)
      {
        $location.path('/meeting_report/'+ business_id +'/'+ report_id);

      };


      getUser();
      getMeetingReports(business_id);


    }]);
