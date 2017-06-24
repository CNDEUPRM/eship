'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:clientRegistrationCtrl
 * @description
 * # clientRegistrationCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('clientRegistrationCtrl',
    ['$location', '$rootScope', '$scope', '$window', 'md5', 'clientSvc', 'Upload', 'cloudinary', '$filter',
      function ($location, $rootScope, $scope, $window, md5, clientSvc, $upload, cloudinary, $filter)
      {
        /*
         * Form fields
         */
        $scope.registration = {
          first_name: '',
          last_name: '',
          initial: '',
          email: '',
          phone: '',
          password_: '',
          confirm_password_: '',
          address1: '',
          address2: '',
          city: '',
          country: '',
          relationship_with_uprm: '',
          businessNotInCNDE: '',
          zip_code: '',
          learn_of_services: '',
          faculty: '',
          age: '',
          gender: '',
          business_name: '',
          business_link: '',
          type_of_business: '',
          description: '',
          requested_help: '',
          employees: '',
          website: '',
          facebook: '',
          twitter: '',
          business_competition: '',
          name_competition: '',
          award: '',
          logo: 'http://res.cloudinary.com/uprm-e-ship-network/image/upload/v1497428725/E-Ship-Network-Icon-100x100_xm6qjc.png',
          confirm_password: '',
          password: ''
        };

        $scope.validPassword = function (){
          return angular.equals($scope.registration.password_, $scope.registration.confirm_password_);
        };

        $scope.regexs = {
          bigText: '[a-zA-Z\\d\\.\\:\\,\\;\\s\\-]+',
          email: /(^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$)/g,
          phone: /^(\d{3})([-\.\s]??\d{3}[-\.\s]??\d{4}|\(\d{3}\)\s*\d{3}[-\.\s]??\d{4}|\d{3}[-\.\s]??\d{4})$/g,
          user_password: '[a-zA-Z\\d]+',
          postal: '\\d{5,6}'
        };


        /*
         * Form Functions
         */
        $scope.isValid = function ()
        {
          var result = ($scope.registration.first_name !== '' &&
            $scope.registration.last_name !== '' &&
            $scope.registration.email !== '' &&
            $scope.registration.phone !== '' &&
            $scope.registration.password_ !== '' &&
            $scope.registration.confirm_password_ !== '' &&
            $scope.registration.address1 !== '' &&
            $scope.registration.city !== '' &&
            $scope.registration.zip_code !== '' &&
            $scope.registration.country !== '' &&
            $scope.registration.relationship_with_uprm !== '' &&
            $scope.registration.learn_of_services !== '' &&
            $scope.registration.faculty !== '' &&
            $scope.registration.age > 0 &&
            $scope.registration.gender !== '' &&
            $scope.registration.business_name !== '' &&
            $scope.registration.business_link !== '' &&
            $scope.registration.type_of_business !== '' &&
            $scope.registration.description !== '' &&
            $scope.registration.requested_help !== '' &&
            $scope.registration.employees > 0
          );
          return result;
        };

        $scope.submitClient = function ()
        {
            $scope.registration.password = md5.createHash($scope.registration.password_);
            $scope.registration.confirm_password = md5.createHash($scope.registration.confirm_password_);
            clientSvc.postClient($scope.registration)
                .then(function (response)
                {
                    console.log(response);
                    if(response.status !==200){
                        $window.alert("Your registration has been unsuccessful. Please try again.");
                    }else{
                      $window.alert('You have registered successfully! Check your email for further instructions.');
                      $location.path('/login');
                    }
                })
                .catch(function (err)
                    {
                        if(err.status === 401 || err.status === 404)
                        {
                            $window.alert("Your registration has been unsuccessful. Please try again.");
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


      }]);
