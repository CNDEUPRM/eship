'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:meetingReportFormCtrl
 * @description
 * # meetingReportFormCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('meetingReportFormCtrl',
    ['business_id', '$location', '$rootScope', '$scope', 'authenticationSvc', 'meetingReportSvc', '$window',
      function (business_id, $location, $rootScope, $scope, authenticationSvc, meetingReportSvc, $window )
      {
        /*
         * Get Current Logged User from Auth. Service
         */
        var getUser = function()
        {
          $scope.user = authenticationSvc.getUserInfo();
          if(!$scope.user)
          {
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
          meeting_duration: 0,
          stage_of_development: '',
          discussed_issues: '',
          current_number_of_employees: '',
          private_investing: '',
          public_investing: '',
          suggestions_and_agreements: '',
          client_pending_matters: '',
          business_plan: 'http://localhost/test.pdf',
          counselor_pending_matters: '',
          hour_next_meeting: '',
          next_meeting: null,
          next_meeting_: null
        };

        /*
         * Date Helper function
         */
        var formatDate = function formatDate(date) {
          var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

          if (month.length < 2) month = '0' + month;
          if (day.length < 2) day = '0' + day;

          return [year, month, day].join('-');
        };

        /*
         * DatePicker Functions
         */
        $scope.today = function()
        {
          $scope.report.date = new Date();
          $scope.report.next_meeting = $scope.report.date;
        };

        $scope.today();

        $scope.clear = function()
        {
          $scope.report.date = null;
          $scope.report.next_meeting = null;
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

        $scope.open2 = function()
        {
          $scope.popup2.opened = true;
        };

        $scope.setDate = function(year, month, day)
        {
          $scope.report.date = new Date(year, month, day);
        };

        $scope.setNextMeeting = function(year, month, day)
        {
          $scope.report.next_meeting = new Date(year, month, day);
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
          $scope.meeting_duration = $scope.endM - $scope.startM;
          var result = ($scope.report.stage_of_development !== '' &&
          $scope.report.date !== '' &&
          $scope.report.discussed_issues !== '' &&
          $scope.report.current_number_of_employees >= 0 &&
          $scope.report.private_investing >= 0 &&
          $scope.report.public_investing >= 0 &&
          $scope.report.suggestions_and_agreements !== '' &&
          $scope.report.counselor_pending_matters !== '' &&
          $scope.report.client_pending_matters !== '' &&
          $scope.report.meeting_duration >=0);
          return result;
        };

        $scope.setIdea = function ()
        {
          $scope.report.stage_of_development = 'Idea in Development';
        };

        $scope.setStartup = function ()
        {
          $scope.report.stage_of_development = 'Startup';
        };

        $scope.setBusinessInDev = function ()
        {
          $scope.report.stage_of_development = 'Business in Development';
        };

        $scope.setExpanding = function ()
        {
          $scope.report.stage_of_development = 'Expanding Business';
        };

        $scope.setDecline= function ()
        {
          $scope.report.stage_of_development = 'Decline';
        };

        $scope.postMeeting = function ()
        {
          $scope.report.meeting_duration = $scope.endM - $scope.startM;
          $scope.report.date = formatDate($scope.report.date_);
          $scope.report.next_meeting = formatDate($scope.report.next_meeting_);
          console.log($scope.report);
          meetingReportSvc.postMeetingReport(business_id, $scope.report)
            .then(function (response)
            {
              console.log(response);
              if(response.status !==200){
                $window.alert("This Meeting Report not been submitted successfully. Please try again.");
              }else{
                $window.alert('This Meeting Report has been submitted successfully!');
                $location.path('/meeting_report/'+business_id+'/'+response.data);
              }
            })
            .catch(function (err)
              {
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
