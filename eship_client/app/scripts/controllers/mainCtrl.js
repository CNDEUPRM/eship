'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('MainCtrl',
    [ '$location', '$rootScope', '$scope', '$window', 'authenticationSvc', 'businessSvc',
      function ($location, $rootScope, $scope, $window, authenticationSvc, businessSvc) {

        /*
         * Get Current Logged User from Auth. Service
         */
        var getUser = function(){
          $scope.user = authenticationSvc.getUserInfo();
          $scope.openLogout = false;
          $rootScope.Loggedin = ($scope.user)? true:false;
          if(!$scope.user){
            $location.path('/login');
          }
          else {
            if($scope.user.isCounselor){
              // Retrieve working business from window session
              if($window.sessionStorage["business"]){
                $scope.business = JSON.parse($window.sessionStorage["business"]);
              }
            }
          }
        };

        /*
         * Logout
         */
        $scope.signOut = function(){
          authenticationSvc.logout();
          $rootScope.$emit('unLogin');
        };

        /*
         * Listen to Login and unLogin messages
         */
        $rootScope.$on('Login',
          function(){
            $scope.user = authenticationSvc.getUserInfo();
            $rootScope.Loggedin = true;
          });

        $rootScope.$on('unLogin',
          function(){
            $scope.user = null;
            $window.sessionStorage["business"] = null;
            $scope.business = null;
            authenticationSvc.logout();
            $rootScope.Loggedin = false;
            $location.path('/login');
          });

        /*
         * Receive businessId from other child controllers
         */
        $rootScope.$on('business', function (event, businessId) {
          // Get Business Info from server
          businessSvc.getBusinessInfo(businessId)
            .then(function (response) {
              console.log(response);
              $scope.business = response.data[0];
              // Save working business in the window session
              $window.sessionStorage["business"] = JSON.stringify($scope.business);
            })
            .catch(function (error) {
              console.log(error);
            });
        });

        /*
         * Redirect to Business Owned By a Client
         */
        $scope.clientOwned = function ()
        {
          $location.path('/owned_business/'+$scope.user.userId);
        };

        $scope.dateStatistics = function ()
        {
          $location.path('/statistics/date');
        };

        $scope.statistics = function ()
        {
          $location.path('/statistics');
        };

        $scope.home = function ()
        {
          $location.path('/home');
        };

        /*
         * Redirect to Business Statistics View
         */
        $scope.businessStatistics = function () {
          if($scope.business){
            $location.path('/statistics/'+$scope.business.business_id);
          }
        };

        /*
         * Redirect to Add Meeting Report View
         */
        $scope.addMeetingReport = function () {
          if($scope.business){
            $location.path('/meeting_report/'+$scope.business.business_id+'/new_report');
          }
        };

        /*
         * Redirect to  Meeting Report History View
         */
        $scope.viewMeetingReportHistory = function () {
          if($scope.business){
            $location.path('/meeting_report/'+$scope.business.business_id);
          }
        };

        /*
         * Redirect to Add Work Report View
         */
        $scope.addWorkReport = function () {
          if($scope.business){
            //'/work_report/:business_id/new_report'
            $location.path('/work_report/'+$scope.business.business_id+'/new_report');
          }
        };

        /*
         * Redirect to View Work Report View
         */
        $scope.viewWorkReportHistory = function () {
          if($scope.business){
            $location.path('/work_report/'+$scope.business.business_id);
          }
        };

        /*
         * Redirect to View Work Report View
         */
        $scope.editBusinessGrowth = function () {
          if($scope.business){
            $location.path('/business/'+$scope.business.business_id+'/growth/edit');
          }
        };

        /*
         * Redirect to View Business Growth View
         */
        $scope.viewBusinessGrowth = function () {
          if($scope.business){
            $location.path('/business/'+$scope.business.business_id+'/growth');
          }
        };

        /*
         * Redirect to Performance Review
         */

        $scope.performanceReview = function () {
          $location.path('/performance_review');
        };

        /*
         * Redirect to Counselor Settings View
         */
        $scope.counselorSettings = function ()
        {
          $location.path('/settings/counselor');
        };

        $scope.clientSettings = function ()
        {
          $location.path('/settings/client');
        };

        getUser();

      }]);
