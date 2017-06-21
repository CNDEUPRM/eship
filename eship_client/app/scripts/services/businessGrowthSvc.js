"use strict";
angular.module('eshipApp')
  .factory('businessGrowthSvc', ['authenticationSvc', '$location', '$rootScope', '$http', 'urlSvc',
    function (authenticationSvc, $location, $rootScope, $http, urlSvc) {
      /**
       * Unfinished do to requirements
       */
      var serviceUrl = urlSvc.getBaseUrl() + 'business_growth';
      var businessGrowthSvc = {};
      return businessGrowthSvc;

    }]);
