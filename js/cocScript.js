// Include app dependency on ngMaterial
var app = angular.module('myApp', ['ngRoute',
'ngMessages',
'ngAria',
'ngAnimate'

]);

app.controller("mainController", ["$scope", 
function($scope){

}]);

app.config(["$routeProvider", "$locationProvider", function($routeProvider, $locationProvider) {

    $locationProvider.hashPrefix('');
    $routeProvider.caseInsensitiveMatch = true;

    $routeProvider.when('/', {templateUrl: "pages/home.html"});
    $routeProvider.when('/home', {templateUrl: "pages/home.html"});
    $routeProvider.when('/payment', {templateUrl: "pages/paymentManager.html"});
    $routeProvider.when('/register', {templateUrl: "pages/registrationManager.html"});
    $routeProvider.when('/admission', {templateUrl: "pages/admissionManager.html"});
    $routeProvider.when('/schedule', {templateUrl: "pages/scheduleManager.html"});
    $routeProvider.when('/result', {templateUrl: "pages/resultManager.html"});
    $routeProvider.when('/password', {templateUrl: "pages/passwordManager.html"});
    $routeProvider.when('/logIn', {templateUrl: "pages/logIn.html"});
        

}]);

//registration page controller
app.controller("registrationController", ["$scope", "$http", "$httpParamSerializerJQLike", 
      function($scope, $http, $httpParamSerializerJQLike){
        $("#phoneModal").modal({
          keyboard: false,
          show: true,
          backdrop: 'static'
        });
        $('#phoneModal').on('shown.bs.modal', function () {
          $('#candidatePhone').trigger('focus');
        });
  $scope.candidate = {
                        basic_info:{

                        reg_no: '',
                        full_name: '',
                        sex: '',
                        age: '',
                        sub_city: '',
                        nationality: '',
                        wereda: '',
                        home_phone: '',
                        office_phone: '',
                        cell_phone: '',
                        marital_status: '',
                        disablity: '',
                        disablity_nature: '',
                        institute_type: '',
                        institute_name: '',
                        region: '',
                        city: '',
                        training_start: '',
                        training_end: '',
                        mode_of_training: '',
                        type_of_training: '',
                        occupation_trained_on: '',
                        education_background: '',
                        cooprative_training_center: '',
                        status_of_cooprative_center: '',
                        employment_condition: '',
                        status_of_company: '',
                        company_type: '',
                        company_name: '',
                        service_year: '',
                        field_of_employment: '',
                        full_name_am: '',
                        email: '', 
                        current_level: '',
                        graduated_level: '',
                        },
                        assessment: {
                          can_regno: '',
                          exam_id: '',
                          occ_code: '',
                          re_assessment: '',
                          amount_paid: '',
                          payment_status: '',
                          invoice_no: '',
                          registration_date: '',
                          apply_for_uc: '',
                          application_status: '',
                          branch_code: '',
                          excuse_payment: '',
                          graduated_status: '',
                          applied_for: '',
                          application: '',
                          registered_by: '',
                          assessment_rate: '',
                          center_code: '',
                          paid: ''

                    }
  };

 
  $scope.PARENT_SECTORS = [];
  $scope.SECTORS = [];
  $scope.OCCUPATIONS = [];
  $scope.UCS = [];
  $scope.APPLICATION_FEE = 0;


  $http({
    method : "GET",
    url : "backend/index.php/api/os/sector",
})
.then(function(response){
$scope.PARENT_SECTORS = response.data.result;
});

$scope.parentSector = function(x) {
  $http({
    method : "GET",
    url : "backend/index.php/api/os/sector",
})
.then(function(response){
$scope.PARENT_SECTORS = response.data.result;
});
}


$scope.applicationFee = function(fee) {
  $scope.APPLICATION_FEE = fee;
}

  $scope.loadSubSectors = function(parentId) {
    $http({
      method : "GET",
      url : "backend/index.php/api/os/sector/"+parentId,
  })
  .then(function(response){
  $scope.SECTORS = response.data.result;
  });
  
  } 
  $scope.loadOccupations = function(sectorId) {
    $http({
      method : "GET",
      url : "backend/index.php/api/os/occupation/"+sectorId,
  })
  .then(function(response){
  $scope.OCCUPATIONS = response.data.result;
  });
  }


  $scope.loadUCs = function(occupationId) {
    $http({
      method : "GET",
      url : "backend/index.php/api/os/unit_of_competency/"+occupationId,
  })
  .then(function(response){
  $scope.UCS = response.data.result;
  });
  }

  $scope.register = function() { 

     return $http({
                  method : "POST",
                  url : "backend/index.php/api/candidate/",
                  data :$httpParamSerializerJQLike($scope.candidate),
                  headers: {'Content-Type':'application/x-www-form-urlencoded'}
          })
          .then(function(response){
          });
        };
  $scope.REGIONS = [
                      "Addis Ababa", 
                      "Oromian", 
                      "South", "Afar", "Amhara", "Tigray"];
  
  $scope.INISTITUTE_TYPES = ['Private', 'Government', 'NGO'];

}]);

//home page controller
app.controller("homeController", ["$scope", function($scope){

}]);


//payment managment page controller
app.controller("paymentController", ["$scope", function($scope){
  
      $scope.payment = {
        invoice_no: '',
        date: '',
        amount: '',
        center_code: ''
      }

    $scope.assessmentPayments = [{
        firstName : "Mikael",
        lastName: "Araya",
        occupation: "Computer Scientist",
        price: 300
      },
      {
        firstName : "Dani",
        lastName: "Belay",
        occupation: "Accountant",
        price: 300
      }];

      $scope.payment = {
        invoiceNo: "",
        date: ""
      }

      $scope.changePassword = function() { 

        return $http({
                     method : "POST",
                     url : "backend/index.php/api/focal/confirm_payment/",
                     data :$httpParamSerializerJQLike($scope.password),
                     headers: { 'Content-Type':'application/x-www-form-urlencoded' }
                    });
            }


}]);


//admission card printing page controller
app.controller("admissionController", ["$scope", function($scope){

}]);


//schedule page controller
app.controller("scheduleController", ["$scope", function($scope){

  $scope.assessmentSchedules = [{
        scheduleId : "SCH-001",
        groupId: "G-001",
        location: "Vision College",
        occupation: "OCC-938",
        date: "1-13-2018",
        time: "09:00 ETC"
      },
      {
        scheduleId : "SCH-002",
        groupId: "G-002",
        location: "Vision College",
        occupation: "OCC-977",
        date: "1-13-2018",
        time: "09:00 ETC"
      }];

      $scope.payment = {
        invoiceNo: "",
        date: ""
      }
}]);


//result viewing page controller
app.controller("resultController", ["$scope", function($scope){


  $scope.assessmentResults = [{
    groupId: "G-001",
    location: "Vision College",
    occupation: "OCC-938",
    date: "1-13-2018",
    time: "09:00 ETC"
  },
  {
    groupId: "G-002",
    location: "Vision College",
    occupation: "OCC-977",
    date: "1-13-2018",
    time: "09:00 ETC"
  }];


}]);


//password reset controller
app.controller("passwordController", ["$scope", "$http", "$httpParamSerializerJQLike",
               function($scope, $http, $httpParamSerializerJQLike){

      $scope.password = {
        current: '',
        new: '',
        newRepeated: ''
      }

      $scope.changePassword = function() { 

        return $http({
                    method : "POST",
                    url : "backend/index.php/api/focal/password_change/",
                    data :$httpParamSerializerJQLike($scope.password),
                    headers: { 'Content-Type':'application/x-www-form-urlencoded' }
                    });
            }
}]);



//search controller used for searching events
app.controller('searchCtrl',["$scope", "$http", "$q", "$location",
                            function($scope, $http, $q, $location, $route){

    var searchValue = $scope.searchText;

      $scope.searchItemSelected = function(selected) {
                                $location.path('/eventDetail/'+selected.eventId);
                              };
      $scope.showEventDetail = function(eventId) {
                              $location.path('/eventDetail/'+eventId);
                            };

      $scope.getMatches = function(searchValue ){
                            return $http({
                                            method : 'GET',
                                            url : "includes/systemController.php",
                                            params : {get : "searchEvent", value : searchValue }
                                    })
                                    .then( function mySuccess(response){
                                              return response.data;
                                          },
                                            function myError(response){
                                              return response;
                                          });

                        };

}]);
//Search Controller End

//log in Controller
app.controller('logInController', ["$scope", "$http", "$httpParamSerializerJQLike",
                            function($scope, $http, $httpParamSerializerJQLike){
    var self = this;

    self.user = {
                  password: "",
                  email: ""

              };
      self.hide = function() {
        $mdDialog.hide();
      };
      self.cancel = function() {
        $mdDialog.cancel();
      };
      self.answer = function(answer) {
        $mdDialog.hide(answer);
      };

      self.Submit = function(){
        console.log('loged in');
                      /*    return $http({
                                          method : "POST",
                                          url : "includes/systemController.php",
                                          data : $httpParamSerializerJQLike({form : "log_in", data : self.user })
                                  })
                                  .then(function(response){
                                    console.log(response);
                                    session.create(response.data.organizerId, response.data.organizerName);
                                    self.hide();
                                  });
                                  */
                      };

}]);