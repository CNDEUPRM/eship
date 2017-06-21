(function () {
    'use strict';
    /**
     * @ngdoc overview
     * @name EShip
     * @description
     * # Capstone Project
     *
     * Main module of the application.
     */
    angular.module('Eship', [
    'ui.router',
    ]).config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {

       $urlRouterProvider.when('/dashboard', '/dashboard/business');
        $urlRouterProvider.when('/changepassword','/dashboard/changepassword');
        $urlRouterProvider.when('/clientsettings','/dashboard/clientsettings');
        $urlRouterProvider.when('/adminorcounselorsettings','/dashboard/adminorcounselorsettings');
        $urlRouterProvider.when('/meetingreportform','/dashboard/meetingreportform');
        $urlRouterProvider.when('/meetingreporthistory','/dashboard/meetingreporthistory');
        $urlRouterProvider.when('/meetingreportsummary','/dashboard/meetingreportsummary');
        $urlRouterProvider.when('/updatereportsummary','/dashboard/updatereportsummary');
        $urlRouterProvider.when('/updatereporthistory','/dashboard/updatereporthistory');
        $urlRouterProvider.when('/updatereportsummary','/dashboard/updatereportsummary');
        $urlRouterProvider.when('/counselorreportsummary','/dashboard/counselorreportsummary');
        $urlRouterProvider.when('/businessgroethprogress','/dashboard/businessgrowthprogress');
        $urlRouterProvider.when('/businessgroethprogresssummary','/dashboard/businessgrowthprogresssummary');
        $urlRouterProvider.when('/addnewadminoircounselor','/dashboard/addnewadminorcounselor');
        $urlRouterProvider.when('/adminbusinesscrud','/dashboard/adminbusinesscrud');
        $urlRouterProvider.when('/businessprofile','/dashboard/businessprofile');
        $urlRouterProvider.when('/admincounselorlist','/dashboard/admincounselorlist');
        $urlRouterProvider.when('/clientprofile','/dashboard/clientprofile');
        $urlRouterProvider.when('/admincounselorprofile','/dashboard/admincounselorprofile');


        $urlRouterProvider.otherwise('/login');

        $stateProvider
          .state('base', {
              abstract: true,
              url: '',
              templateUrl: 'views/base.html'
          })

            .state('login', {
                url: '/login',
                parent: 'base',
                templateUrl: 'views/login.html'
                // controller: 'LoginCtrl'
            })

            .state('dashboard', {
                url: '/dashboard',
                parent: 'base',
                templateUrl: 'views/dashboard.html'
                // controller: 'DashboardCtrl'
            })

            .state('home', {
                url: '/home',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/home.html'
            })

            .state('changepassword', {
                url: '/changepassword',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/changepassword.html'

            })

            .state('clientsettings', {
                url: '/clientsettings',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/clientsettings.html'

            })

            .state('adminorcounselorsettings', {
                url: '/settings',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/adminorcounselorsettings.html'

            })

            .state('meetingreportform', {
                url: '/meetingreportform',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/meetingreportform.html'

            })

            .state('meetingreporthistory', {
                url: '/meetingreporthistory',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/meetingreporthistory.html'

            })

            .state('meetingreportsummary', {
                url: '/meetingreportsummary',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/meetingreportsummary.html'

            })

            .state('updatereportform', {
                url: '/updatereportform',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/updatereportform.html'

            })

            .state('updatereporthistory', {
                url: '/updatereporthistory',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/updatereporthistory.html'

            })

            .state('updatereportsummary', {
                url: '/updatereportsummary',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/updatereportsummary.html'

            })

            .state('counselorreportsummary', {
                url: '/counselorreportsummary',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/counselorreportsummary.html'

            })

            .state('businessgrowthprogress', {
                url: '/businessgrowthprogress',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/businessgrowthprogress.html'

            })

            .state('businessgrowthprogresssummary', {
                url: '/businessgrowthprogresssummary',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/businessgrowthprogresssummary.html'

            })

            .state('addnewadminorcounselor', {
                url: '/addnewadminorcounselor',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/addnewadminorcounselor.html'

            })

            .state('adminbusinesscrud', {
                url: '/adminbusinesscrud',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/adminbusinesscrud.html'

            })

            .state('businessprofile', {
                url: '/businessprofile',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/businessprofile.html'

            })

            .state('admincounselorlist', {
                url: '/admincounselorlist',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/admincounselorlist.html'

            })

            .state('clientprofile', {
                url: '/clientprofile',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/clientprofile.html'

            })

            .state('admincounselorprofile', {
                url: '/admincounselorprofile',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/admincounselorprofile.html'

            })

            .state('business', {
                url: '/business',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/businesses.html',
                controller: 'BusinessCtrl'
            });

    }]);

})();
