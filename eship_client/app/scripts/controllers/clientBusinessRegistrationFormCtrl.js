
'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:clientBusinessRegistrationFormCtrl
 * @description
 * # clientBusinessRegistrationFormCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('clientBusinessRegistrationFormCtrl',
    ['$location', '$rootScope', '$scope', 'authenticationSvc', 'businessSvc', 'Upload', 'cloudinary', '$window',
      function ($location, $rootScope, $scope, authenticationSvc, businessSvc, $upload, cloudinary, $window)
      {
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
        $scope.registration = {
          client_id: $scope.user.userId,
          business_name: '',
          business_link: '',
          type_of_business: '',
          description: '',
          requested_help: '',
          employees: 0,
          website: '',
          facebook: '',
          twitter: '',
          business_competition: '',
          name_competition: '',
          award: '',
          logo: 'http://res.cloudinary.com/uprm-e-ship-network/image/upload/v1497428725/E-Ship-Network-Icon-100x100_xm6qjc.png'
        };

        $scope.regexs = {
          bigText: '[a-zA-Z\\d\\.\\:\\,\\;\\s\\-]+',
          email: /(^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$)/g,
          phone: /^(\d{3})([-\.\s]??\d{3}[-\.\s]??\d{4}|\(\d{3}\)\s*\d{3}[-\.\s]??\d{4}|\d{3}[-\.\s]??\d{4})$/g,
          password: '[a-zA-Z\\d]+',
          postal: '\\d{5,6}'
        };

        $scope.isValid = function ()
        {
          var result = ($scope.registration.business_name !== '' &&
            $scope.registration.business_link !== '' &&
            $scope.registration.type_of_business !== '' &&
            $scope.registration.description !== '' &&
            $scope.registration.requested_help !== '' &&
            $scope.registration.employees > 0
          );
          return result;
        };


        /*
         * Form Functions
         */
        $scope.submitBusiness = function ()
        {
          businessSvc.postBusinessClient($scope.registration)
            .then(function (response)
            {
              console.log(response);
              if(response.status !==200){
                $window.alert("Your business registration has failed. Please try again.");
              }else{
                $window.alert('Your business has been registered successfully!');
                $location.path('/business/'+response.data);
              }
            })
            .catch(function (err) {
              if(err.status === 401 || err.status === 404)
              {
                $window.alert("Your business registration has failed. Please try again.");
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


        $scope.uploadFiles = function(files){
          $scope.files = files;
          if (!$scope.files) return;
          angular.forEach(files, function(file){
            if (file && !file.$error) {
              file.upload = $upload.upload({
                url: "https://api.cloudinary.com/v1_1/" + cloudinary.config().cloud_name + "/upload",
                data: {
                  upload_preset: cloudinary.config().upload_preset,
                  tags: 'product',
                  context: 'photo=' + $scope.registration.business_name,
                  file: file
                }
              }).progress(function (e) {
                file.progress = Math.round((e.loaded * 100.0) / e.total);
                file.status = "Uploading... " + file.progress + "%";
              }).success(function (data, status, headers, config) {
                data.context = {custom: {photo: $scope.registration.business_name}};
                file.result = data;
                $scope.registration.logo = file.result.secure_url;
                // Transform image link
                $scope.registration.logo = $scope.registration.logo.replace('upload/','upload/c_pad,h_100,w_100/');
              }).error(function (data, status, headers, config) {
                file.result = data;
              });
            }
          });
        };

        getUser();

      }]);
