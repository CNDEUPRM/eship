/**
 * Created by abi on 6/9/17.
 */
'use strict';
angular.module('eshipApp')
  .factory('urlSvc',
    function () {
      var urlSvc = {};
      urlSvc.getBaseUrl = function () {
        return 'http://eship-case.herokuapp.com';
      };
      return urlSvc;
    });
