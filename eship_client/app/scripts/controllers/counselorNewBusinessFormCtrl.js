
'use strict';

/**
 * @ngdoc function
 * @name eshipApp.controller:counselorNewBusinessFormCtrl
 * @description
 * # counselorNewBusinessFormCtrl
 * Controller of the eshipApp
 */
angular.module('eshipApp')
  .controller('counselorNewBusinessFormCtrl',
    ['$location', '$rootScope', '$scope', 'authenticationSvc', 'counselorSvc', '$window', 'businessSvc', 'Upload', 'cloudinary',
      function ($location, $rootScope, $scope, authenticationSvc, counselorSvc, $window, businessSvc, $upload, cloudinary) {
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
        $scope.business = {
          counselor_id: $scope.user.userId,
          first_name: '',
          last_name: '',
          initial: '',
          email: '',
          business_name: '',
          stage: '',
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
          email: /(^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$)/g
        };


        /*
         * Form Functions
         */
        $scope.isValid = function ()
        {
          var result = ($scope.business.first_name !== '' &&
            $scope.business.last_name !== '' &&
            $scope.business.initial !== '' &&
            $scope.business.email !== '' &&
            $scope.business.business_name !== '' &&
            $scope.business.stage !== '' &&
            $scope.business.business_link !== '' &&
            $scope.business.type_of_business !== '' &&
            $scope.business.description !== '' &&
            $scope.business.requested_help !== '' &&
            $scope.business.employees >= 0 &&
            $scope.business.business_competition !== ''
          );
          return result;
        };

        $scope.submitBusiness = function ()
        {
          console.log($scope.business);
          businessSvc.postBusinessCounselor($scope.business)
            .then(function (response) {
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
                  context: 'photo=' + $scope.business.business_name,
                  file: file
                }
              }).progress(function (e) {
                // % For the progress bar
                file.progress = Math.round((e.loaded * 100.0) / e.total);
                // If you want to display text instead of progress bar
                file.status = "Uploading... " + file.progress + "%";
              }).success(function (data, status, headers, config) {
                // Save in  the cloudinary image context the business name
                data.context = {custom: {photo: $scope.business.business_name}}; // debes cambiar esto en los otros controllers a el json que estes usando
                // This is to display image in the form as a preview
                file.result = data;
                // Save cloudinary URL as the logo in the business JSON
                $scope.business.logo = file.result.secure_url; // debes cambiar esto en los otros controllers a el json que estes usando
                // Transform the image link path to be stored in the DB.
                // This uses cloudinary image transformation so all images will be displayed in 100x100 no matter the size of the logo
                // En espanol jaja esto lo hago para que el URL que guardas en la DB te sea una foto 100x100 (tamano del logo en el template)
                $scope.business.logo = $scope.business.logo.replace('upload/','upload/c_pad,h_100,w_100/'); // debes cambiar esto en los otros controllers a el json que estes usando
              }).error(function (data, status, headers, config) {
                // Error handling is up to you. Maybe use a $window.alert("message").
                file.result = data;
              });
            }
          });
        };

        getUser();
      }]);
