'use strict';

/**
 * @ngdoc overview
 * @name eshipApp
 * @description
 * # eshipApp
 *
 * Main module of the application.
 */
angular
  .module('eshipApp', [
    'angular-md5',
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
    'ui.bootstrap',
    'ngFileUpload',
    'cloudinary'
  ])
  .config(['$routeProvider', '$locationProvider', '$httpProvider', 'cloudinaryProvider', function ($routeProvider, $locationProvider, $httpProvider, cloudinaryProvider) {

    cloudinaryProvider
      .set("cloud_name", "uprm-e-ship-network")
      .set("upload_preset", "xu8oboaj");

    // Configuration to access a back end hosted in different server
    $httpProvider.defaults.useXDomain = true;
    $httpProvider.defaults.withCredentials = false;
    delete $httpProvider.defaults.headers.common["X-Requested-With"];
    $httpProvider.defaults.headers.common["Accept"] = "application/json";
    $httpProvider.defaults.headers.common["Content-Type"] = "application/json";


    // Angular Routes
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/business', {
        templateUrl: 'views/businesses.html',
        controller: 'businessesCtrl',
        resolve: {
          auth: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_ADMIN' || user.role[0] === 'ROLE_COUNSELOR' ){
              return $q.when(user);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/owned_business/:client_id', {
        templateUrl: 'views/clientOwnedBusiness.html',
        controller: 'ownedBusinessCtrl',
        resolve: {
          client_id: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user){
              var params = $route.current.params;
              return $q.when(params.client_id);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/business/new_business', {
        templateUrl: 'views/businessRegistration.html',
        controller: 'clientBusinessRegistrationFormCtrl',
        resolve: {
          auth: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_CLIENT'){
              return $q.when(user);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/business/counselor/new_business', {
        templateUrl: 'views/counselorNewBusiness.html',
        controller: 'counselorNewBusinessFormCtrl',
        resolve: {
          auth: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_ADMIN' || user.role[0] === 'ROLE_COUNSELOR'){
              return $q.when(user);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/business/:business_id', {
        templateUrl: 'views/businessProfile.html',
        controller: 'businessProfileCtrl',
        resolve: {
          business_id: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user){
              var params = $route.current.params;
              return $q.when(params.business_id);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }})
      .when('/counselor', {
        templateUrl: 'views/counselorsList.html',
        controller: 'counselorListCtrl',
        resolve: {
          auth: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_ADMIN'){
              return $q.when(user);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/meeting_report/:business_id', {
        templateUrl: 'views/meetingReportHistory.html',
        controller: 'meetingReportHistoryCtrl',
        resolve: {
          business_id: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_ADMIN' || user.role[0] === 'ROLE_COUNSELOR' ){
              var params = $route.current.params;
              return $q.when(params.business_id);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/meeting_report/:business_id/new_report', {
        templateUrl: 'views/meetingReportForm.html',
        controller: 'meetingReportFormCtrl',
        resolve: {
          business_id: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user){
              if(user.role[0] === 'ROLE_ADMIN' || user.role[0] === 'ROLE_COUNSELOR' ){
                var params = $route.current.params;
                return $q.when(params.business_id);
              }
              else {
                return $q.reject({authenticated: false});
              }
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/meeting_report/:business_id/:report_id', {
        templateUrl: 'views/meetingReportSummary.html',
        controller: 'meetingReportSummaryCtrl',
        resolve: {
          meeting_report: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_ADMIN' || user.role[0] === 'ROLE_COUNSELOR' ){
              var params = $route.current.params;
              var meeting_report = {business_id: params.business_id, report_id: params.report_id};
              return $q.when(meeting_report);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/performance_review', {
        templateUrl: 'views/performanceReviewSummary.html',
        controller: 'performanceReviewSummaryCtrl',
        resolve: {
          auth: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_ADMIN' || user.role[0] === 'ROLE_COUNSELOR' ){
              return $q.when(user);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/performance_review/new_review', {
        templateUrl: 'views/performanceReviewForm.html',
        controller: 'performanceReviewFormCtrl',
        resolve: {
          auth: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_ADMIN' || user.role[0] === 'ROLE_COUNSELOR' ){
              return $q.when(user);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/statistics', {
        templateUrl: 'views/generalStatistics.html',
        controller: 'statisticsCtrl',
        resolve: {
          auth: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_ADMIN' || user.role[0] === 'ROLE_COUNSELOR' ){
              return $q.when(user);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/statistics/date', {
        templateUrl: 'views/dateStatistics.html',
        controller: 'statisticsDateCtrl',
        resolve: {
          auth: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_ADMIN' || user.role[0] === 'ROLE_COUNSELOR' ){
              return $q.when(user);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/statistics/:business_id', {
        templateUrl: 'views/businessStatistics.html',
        controller: 'statisticsBusinessCtrl',
        resolve: {
          business_id: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_ADMIN' || user.role[0] === 'ROLE_COUNSELOR' ){
              var params = $route.current.params;
              return $q.when(params.business_id);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/register/client', {
        templateUrl: 'views/clientRegistration.html',
        controller: 'clientRegistrationCtrl'
      })
      .when('/register/counselor/:counselor_request_id', {
        templateUrl: 'views/counselorRegistration.html',
        controller: 'counselorRegistrationCtrl',
        resolve:{
          counselor_request_id: function ($route, $q){
            var params = $route.current.params;
            if(params.counselor_request_id){
              return $q.when(params.counselor_request_id);
            }
            else{
              return $q.when(null);
            }
          }
        }
      })
      .when('/admin/new_counselor', {
        templateUrl: 'views/addNewAdminOrCounselor.html',
        controller: 'addNewAdminOrCounselorCtrl',
        resolve: {
          auth: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_ADMIN'){
              return $q.when(user);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/work_report/:business_id/:meeting_report_id/', {
        templateUrl: 'views/workReportHistory.html',
        controller: 'workReportHistoryCtrl',
        resolve: {
          work_report_info: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_ADMIN' || user.role[0] === 'ROLE_COUNSELOR' ){
              var params = $route.current.params;
              var work_report_info = {business_id: params.business_id, meeting_report_id: params.meeting_report_id};
              return $q.when(work_report_info);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/work_report/:business_id/:meeting_report_id/new_report', {
        templateUrl: 'views/workReportForm.html',
        controller: 'workReportFormCtrl',
        resolve: {
          work_report_info: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_ADMIN' || user.role[0] === 'ROLE_COUNSELOR' ){
              var params = $route.current.params;
              var work_report_info = {business_id: params.business_id, meeting_report_id: params.meeting_report_id};
              return $q.when(work_report_info);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/work_report/:business_id/:meeting_report_id/:work_report_id', {
        templateUrl: 'views/workReportSummary.html',
        controller: 'workReportSummaryCtrl',
        resolve: {
          work_report_info: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_ADMIN' || user.role[0] === 'ROLE_COUNSELOR' ){
              var params = $route.current.params;
              var work_report_info = {business_id: params.business_id, meeting_report_id: params.meeting_report_id,
                work_report_id: params.work_report_id};
              return $q.when(work_report_info);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/login', {
        templateUrl: 'views/login.html'
      })
      .when('/forgot_password/client', {
        templateUrl: 'views/forgotPasswordRequest.html',
        controller: 'clientForgotPasswordRequestCtrl'
      })
      .when('/forgot_password/counselor', {
        templateUrl: 'views/forgotPasswordRequest.html',
        controller: 'counselorForgotPasswordRequestCtrl'
      })
      .when('/settings/counselor', {
        templateUrl: 'views/counselorSettings.html',
        controller: 'counselorSettingsCtrl',
        resolve: {
          auth: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_ADMIN' || user.role[0] === 'ROLE_COUNSELOR'){
              return $q.when(user);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/settings/client', {
        templateUrl: 'views/clientSettings.html',
        controller: 'clientSettingsCtrl',
        resolve: {
          auth: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_CLIENT'){
              return $q.when(user);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/settings/counselor/change_password', {
        templateUrl: 'views/changePassword.html',
        controller: 'counselorResetPasswordCtrl',
        resolve: {
          auth: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_ADMIN' || user.role[0] === 'ROLE_COUNSELOR'){
              return $q.when(user);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/settings/client/change_password', {
        templateUrl: 'views/changePassword.html',
        controller: 'clientResetPasswordCtrl',
        resolve: {
          auth: function ($route, $q, authenticationSvc) {
            var user = authenticationSvc.getUserInfo();
            if(user.role[0] === 'ROLE_CLIENT'){
              return $q.when(user);
            }else {
              return $q.reject({authenticated: false});
            }
          }
        }
      })
      .when('/forgot_password/client/:request_id', {
        templateUrl: 'views/forgotPassword.html',
        controller: 'clientForgotPasswordCtrl',
        resolve:{
          request_id: function ($route, $q){
            var params = $route.current.params;
            if(params.request_id){
              return $q.when(params.request_id);
            }
            else{
              return $q.when(null);
            }
          }
        }
      })
      .when('/forgot_password/counselor/:request_id', {
        templateUrl: 'views/forgotPassword.html',
        controller:'counselorForgotPasswordCtrl',
        resolve:{
          request_id: function ($route, $q){
            var params = $route.current.params;
            if(params.request_id){
              return $q.when(params.request_id);
            }
            else{
              return $q.when(null);
            }
          }
        }
      })
      .when('/404', {
        templateUrl: 'views/404.html'
      })
      .when('/500', {
        templateUrl: 'views/500.html'
      })
      .otherwise({
        redirectTo: '/'
      });

    //$locationProvider.html5Mode(true).hashPrefix('');
    $locationProvider.hashPrefix('');
  }]);

// Route Auth Verification Runner Function
angular.module('eshipApp').run(['$rootScope', '$location',
  function($rootScope, $location){
    $rootScope.$on('$routeChangeError', function (event, current, previous, eventObj){
      //Redirect to main page if the error was caused by authentication
      if(eventObj.authenticated === false){
        $location.path('/login');
      }
    });
  }]);
