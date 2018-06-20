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
                        id: '',
                        reg_no: '',                       
                        },
                        assessment: { }
  };

  $scope.searchPhone = function() {
    
    $http({
      method : "GET",
      url : "backend/index.php/api/candidate/has_account/"+$scope.phoneNumber
  }).then(function(response){
    console.log(response.data);
        if(response.data) {
          $scope.candidate.basic_info = response.data;
        }
        $("#phoneModal").modal('hide');
  });
  }
 
  $scope.PARENT_SECTORS = [];
  $scope.SECTORS = [];
  $scope.OCCUPATIONS = [];
  $scope.UCS = [];
  $scope.APPLICATION_FEE = 0;



initializeOS = function(type, id = null) {
  osCode = (id) ? id : '';
  URL = (id) ? "backend/index.php/api/os/"+type+"/"+id : "backend/index.php/api/os/"+type;
  return $http({
    method : "GET",
    url : URL
});
};



applicationFee = function(occ_code) {

    initializeOS('assessment_price', occ_code ).then(function(response){
      $scope.candidate.assessment.assessment_rate = response.data.result.amount_for_level;
    });
};

  $scope.loadSectors = function(parentId = null) {
    initializeOS('sector', parentId).then(function(response){
      if(parentId) {
        $scope.SECTORS = response.data.result;
      } else {
        $scope.PARENT_SECTORS = response.data.result;
      }
  });
  
  };
 $scope.loadSectors(); 
  $scope.loadOccupations = function(sectorId) {
    initializeOS('occupation', sectorId).then(function(response){
          $scope.OCCUPATIONS = response.data.result;
      });

      
  }


  $scope.loadUCs = function(occupationId) {
    applicationFee(occupationId);
   initializeOS('unit_of_competency', occupationId).then(function(response){
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