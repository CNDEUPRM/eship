
'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:updateReportFormCtrl
 * @description
 * # workReportFormCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('workReportFormCtrl',
    ['work_report_info', '$location', '$rootScope', '$scope', 'authenticationSvc', 'meetingReportSvc', 'workReportSvc', '$window',
      function (work_report_info, $location, $rootScope, $scope, authenticationSvc, meetingReportSvc, workReportSvc, $window)
      {
        /*
         * Get Current Logged User from Auth. Service
         */
        var getUser = function()
        {
          $scope.user = authenticationSvc.getUserInfo();
          if(!$scope.user) {
            $location.path('/login');
          }
          else {
            if(!$scope.user.isCounselor)
            {
              $location.path('/');
            }
          }
        };

        /*
         * Form fields
         */
        $scope.report = {
          counselor_id: $scope.user.userId,
          date: null,
          date_: null,
          notes : '',
          task_completed: '',
          task_in_progress: '',
          work_duration: 0
        };

        /*
         * Date Helper function
         */
        var formatDate = function formatDate(date) {
          var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

          if (month.length < 2)
          {
            month = '0' + month;
          }
          if (day.length < 2)
          {
            day = '0' + day;
          }

          return [year, month, day].join('-');
        };

        /*
         * DatePicker Functions
         */
        $scope.today = function()
        {
          $scope.report.date = new Date();
          //$scope.report.next_meeting = $scope.report.date;
        };

        $scope.today();

        $scope.clear = function()
        {
          $scope.report.date = null;
        };

        $scope.inlineOptions = {
          customClass: getDayClass,
          minDate: new Date(),
          showWeeks: true
        };

        $scope.dateOptions = {
          dateDisabled: disabled,
          formatYear: 'yy',
          maxDate: new Date(2020, 5, 22),
          minDate: new Date(),
          startingDay: 1
        };

        // Disable weekend selection
        function disabled(data)
        {
          var date = data.date,
            mode = data.mode;
          return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
        }

        $scope.toggleMin = function()
        {
          $scope.inlineOptions.minDate = $scope.inlineOptions.minDate ? null : new Date();
          $scope.dateOptions.minDate = $scope.inlineOptions.minDate;
        };

        $scope.toggleMin();

        $scope.open1 = function()
        {
          $scope.popup1.opened = true;
        };

        $scope.setDate = function(year, month, day)
        {
          $scope.report.date = new Date(year, month, day);
        };

        $scope.formats = ['yyyy/MM/dd'];
        $scope.format = $scope.formats[0];
        $scope.altInputFormats = ['yyyy/MM/dd'];

        $scope.popup1 = {
          opened: false
        };

        $scope.popup2 = {
          opened: false
        };

        var tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        var afterTomorrow = new Date();
        afterTomorrow.setDate(tomorrow.getDate() + 1);
        $scope.events = [
          {
            date: tomorrow,
            status: 'full'
          },
          {
            date: afterTomorrow,
            status: 'partially'
          }
        ];

        function getDayClass(data)
        {
          var date = data.date,
            mode = data.mode;
          if (mode === 'day')
          {
            var dayToCheck = new Date(date).setHours(0,0,0,0);

            for (var i = 0; i < $scope.events.length; i++) {
              var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

              if (dayToCheck === currentDay)
              {
                return $scope.events[i].status;
              }
            }
          }

          return '';
        }


        /*
         * Form Functions
         */
        $scope.isValid = function ()
        {
          $scope.work_duration = $scope.endM - $scope.startM;
          var result = ($scope.report.date !== '' &&
          $scope.report.notes !== '' &&
          $scope.report.task_completed !== '' &&
          $scope.report.public_investing !== '' &&
          $scope.report.work_duration >=0);
          return result;
        };

        $scope.postWork = function ()
        {
          $scope.report.work_duration = $scope.endM - $scope.startM;
          $scope.report.date = formatDate($scope.report.date_);
          console.log($scope.report);
          workReportSvc.postWorkReport(work_report_info.business_id, work_report_info.meeting_report_id, $scope.report)
            .then(function (response) {
              console.log(response);
              if(response.status !==200){
                $window.alert("This Work Report not been submitted successfully. Please try again.");
              }else{
                $window.alert('This Work Report has been submitted successfully!');
                $location.path('/work_report/'+work_report_info.business_id+'/'+work_report_info.meeting_report_id+'/'+response.data);
              }
            })
            .catch(function (err) {
              if(err.status === 401 || err.status === 404)
              {
                $window.alert("This Meeting Report not been submitted successfully. Please try again.");
              }
              else if(err.status === 500)
              {
                $location.path('/500');
              }
              $rootScope.$emit('unLogin');
              $location.path('/500');
              console.log(err);
              }
            );
        };
        getUser();

      }]);
