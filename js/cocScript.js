// Include app dependency on ngMaterial
var app = angular.module('myApp', ['ngRoute',
'ngMessages',
'ngAria',
'ngAnimate',
'angular.chips',
'ui.bootstrap'

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
    $routeProvider.when('/schedule/:groupId', {templateUrl: "pages/scheduleDetail.html"});
    $routeProvider.when('/result', {templateUrl: "pages/resultManager.html"});
    $routeProvider.when('/result/:groupId', {templateUrl: "pages/resultDetail.html"});
    $routeProvider.when('/password', {templateUrl: "pages/passwordManager.html"});
    $routeProvider.when('/logIn', {templateUrl: "pages/logIn.html"});
        

}]);

//result detail controller
app.controller('resultDetailController', ["$scope", "$http", "$route", function($scope, $http, $route){
  var groupId = $route.current.params.groupId;
  console.log(groupId);
  $scope.ASSESSMENT_RESULTS = [];
  $scope.CENTER = '';
  $scope.OCCUPATION = '';
  $scope.GROUP = '';
    
              $http({
                method: 'GET',
                url: 'backend/index.php/api/result/group_result/'+groupId
              }).then(function(response){                
                  $scope.ASSESSMENT_RESULTS = response.data;
                  $scope.GROUP = response.data[0].gr_id;
                  $scope.CENTER = response.data[0]._center_name;
                  $scope.OCCUPATION = response.data[0].occ_name;
                  $scope.ASSESSMENT_DATE = response.data[0].scheduled_date;

              });

              $scope.print = function() {
                window.print();
              }

}]);

app.controller('scheduleDetailController', ['$scope', '$http', '$route', function($scope, $http, $route){

      var groupId = $route.current.params.groupId;
      console.log(groupId);
      $scope.ASSESSMENT_SCHEDULES = [];
      $scope.CENTER = '';
      $scope.OCCUPATION = '';
      $scope.GROUP = '';

      $http({
        method: 'GET',
        url: 'backend/index.php/api/schedule/group_schedule/'+groupId
      }).then(function(response){
          $scope.ASSESSMENT_SCHEDULES = response.data;
          $scope.CENTER = response.data[0].center_name;
          $scope.OCCUPATION = response.data[0].occ_name;
          $scope.GROUP = response.data[0].gr_id;
      });
      $scope.print = function() {
        window.print();
      }
    
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
app.controller("paymentController", ["$scope", "$http","$httpParamSerializerJQLike", function($scope, $http, $httpParamSerializerJQLike){
  
      $scope.payment = {
        invoice_no: '',
        date: '',
        totalAmount: 0.0,
        center_code: '',
        examIds: [],
      }

      $scope.PENDING_PAYMENTS = '';

      $http({
        method: 'GET',
        url: 'backend/index.php/api/payment'
      }).then(function(response){
        $scope.PENDING_PAYMENTS = response.data.result;
        $scope.PENDING_PAYMENTS.forEach(function(paymentInfo){
          $scope.payment.examIds.push(paymentInfo.exam_id);
          $scope.payment.totalAmount = parseFloat($scope.payment.totalAmount) + parseFloat(paymentInfo.amount_paid);
          console.log($scope.payment.totalAmount);
          $
        })
      })

  
      $scope.submitPayment = function() { 

        return $http({
                     method : "POST",
                     url : "backend/index.php/api/payment/add_invoice",
                     data :$httpParamSerializerJQLike($scope.payment),
                     headers: { 'Content-Type':'application/x-www-form-urlencoded' }
                    });
            }
      }]);

      

//admission card printing page controller
app.controller("admissionController", ["$scope","$http", function($scope, $http){

  $scope.candidates = [
    {full_name: 'Mikael Araya', reg_no: '10'}
  ];
  $scope.availableCandidates = [
    {full_name: 'meseret Abebeb', reg_no: '100'}
  ];
  $scope.selectedCandidates = [];

  removeCandidate = function(data){
    console.log(data);
  };
  $scope.getCandidates= function(val) {
    return $http.get('backend/index.php/api/admission/'+val).then(function(response){
      return response.data.map(function(item){
        return item;
      });
    });
  };

  $scope.modelOptions = {
    debounce: {
      default: 500,
      blur: 250
    }
  };
}]);


//schedule page controller
app.controller("scheduleController", ["$scope", "$http", "$httpParamSerializerJQLike",  function($scope, $http, $httpParamSerializerJQLike){

          $scope.AVAILABLE_SCHEDULES = [];

          $http({
            method: 'GET',
            url: 'backend/index.php/api/schedule'
          }).then(function(response){
                  if(response) {
                    $scope.AVAILABLE_SCHEDULES = response.data.result;
                  }
          });
}]);


//result viewing page controller
app.controller("resultController", ["$scope", "$http", function($scope, $http){

  $scope.AVAILABLE_RESULTS = [];
      $http({
        method: 'GET',
        url: 'backend/index.php/api/result/'
      }).then(function(response){
        $scope.AVAILABLE_RESULTS = response.data.result
      })
}]);


//password reset controller
app.controller("passwordController", ["$scope", "$http", "$httpParamSerializerJQLike",
               function($scope, $http, $httpParamSerializerJQLike){

      $scope.account= { };

      $scope.changePassword = function() { 

        return $http({
                    method : "POST",
                    url : "backend/index.php/api/password/change/",
                    data :$httpParamSerializerJQLike($scope.account),
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

    $scope.user = {
                  password: "",
                  contact_person: ""

              };
      $scope.result = '';

      $scope.Submit = function(){
                        return $http({
                                          method : "POST",
                                          url : "backend/index.php/api/focal",
                                          data : $httpParamSerializerJQLike($scope.user),
                                          headers: { 'Content-Type':'application/x-www-form-urlencoded' }
                                  })
                                  .then(function(response){
                                    if(response.success == 'true'){
                                    alert('welcome');
                                    } else {
                                      $scope.result = 'Username or Password Incorrect';
                                    }
                                    });
                                
                      };

}]);