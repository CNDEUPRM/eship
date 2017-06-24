
'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:statisticsCtrl
 * @description
 * # statisticsCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('statisticsDateCtrl',
    ['$scope', '$rootScope', '$location', 'authenticationSvc', 'statisticsSvc', '$window',
      function ($scope, $rootScope, $location, authenticationSvc, statisticsSvc, $window) {
        // Get Current User from Service
        var getUser = function(){
          $scope.user = authenticationSvc.getUserInfo();
          if(!$scope.user){
            $rootScope.$emit('unLogin');
            $location.path('/');
          }
        };

        /*
         * Form fields
         */
        $scope.report = {
          start: '',
          end: ''
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
          $scope.report.start_ = new Date();
          $scope.report.end_ = $scope.report.start_;
        };

        $scope.today();

        $scope.clear = function()
        {
          $scope.report.start_ = null;
          $scope.report.end_ = null;
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
          $scope.report.start_= new Date(year, month, day);
        };

        $scope.setNextMeeting = function(year, month, day)
        {
          $scope.report.end_ = new Date(year, month, day);
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
          var result = ($scope.report.start_ !== '' &&
          $scope.report.end_ !== '');
          return result;
        };



        $scope.postDate = function ()
        {
          $scope.report.start = formatDate($scope.report.start_ );
          $scope.report.end = formatDate($scope.report.end_);
          statisticsSvc.postGeneralStatisticsDate($scope.report)
            .then(function (response)
            {
              console.log(response);
              if(response.status !==200){
                $window.alert("This Meeting Report not been submitted successfully. Please try again.");
              }else{
                $scope.statistics_date = response.data;
                if(response.status !==200){
                  $window.alert("We are having technical problem. Please refresh the page.");
                }
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
