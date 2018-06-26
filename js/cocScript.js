// Include app dependency on ngMaterial
var app = angular.module('myApp', ['ngRoute',
    'ngMessages',
    'ngAria',
    'ngSanitize',
    'ui.select'

]);

//session Service
app.factory("session", ["$http", function($http){

    var focal_person_name = "";
    var center_id = "";
    var center_name = "";
    var loged_in = false;

    function createSession(centerId, centerName, focalName) {

      focal_person_name = focalName;
      center_id = centerId;
      center_name = centerName;
      loged_in = true;
    };

    function getUserName() {
      return focal_person_name;
    }

    function getCenterName() {
        return center_name;
    }
    function getCenterId() {
      return center_id;
    }

    function destroySession() {
      loged_in = false;
      focal_person_name = "";
      center_id = "";
      center_name="";

      $http({
        method : "GET",
        url : "backend/index.php/api/focal/log_out",
      }).then(function(response){ });

    };

    function isLoggedIn() {
      return loged_in;
    };

    function refresh() {
       $http({
        method : "GET",
        url : "backend/index.php/api/focal/is_session_active",
      }).then(function(response){

        if(response.data.is_active) {
          focal_person_name = response.data.focal_name;
          center_id = response.data.center_id;
          center_name = response.data.center_name;
          loged_in = true;
        }

      });

    }

  refresh();
return {
        create : createSession,
        destroy : destroySession,
        isLoggedIn : isLoggedIn,
        getUserName : getUserName,
        getCenterName: getCenterName,
        getCenterId : getCenterId
      };

}]);

app.controller("mainController", ["$scope", "$http", "session",  "$location", "$httpParamSerializerJQLike",
    function ($scope, $http, session, $location ,$httpParamSerializerJQLike) {
    console.log(session.isLoggedIn());

    $scope.isLogged = function() {
        return session.isLoggedIn();
  };

    $scope.logOut = function() {
        session.destroy();
                 $location.path("/pages/logIn");
    }

/*
            $('#logInModal').modal({
                backdrop: 'static',
                show: true,
                keyboard: false
            });

            $('#phoneModal').on('shown.bs.modal', function () {
                $('#candidatePhone').trigger('focus');
            });
    */

}]);

app.config(["$routeProvider", "$locationProvider", function ($routeProvider, $locationProvider) {

    $locationProvider.hashPrefix('');
    $routeProvider.caseInsensitiveMatch = true;

    $routeProvider.when('/', { templateUrl: "pages/home.html" });
    $routeProvider.when('/home', { templateUrl: "pages/home.html" });
    $routeProvider.when('/payment', { templateUrl: "pages/paymentManager.html" });
    $routeProvider.when('/register', { templateUrl: "pages/registrationManager.html" });
    $routeProvider.when('/admission', { templateUrl: "pages/admissionManager.html" });
    $routeProvider.when('/schedule', { templateUrl: "pages/scheduleManager.html" });
    $routeProvider.when('/schedule/:groupId', { templateUrl: "pages/scheduleDetail.html" });
    $routeProvider.when('/result', { templateUrl: "pages/resultManager.html" });
    $routeProvider.when('/result/:groupId', { templateUrl: "pages/resultDetail.html" });
    $routeProvider.when('/password', { templateUrl: "pages/passwordManager.html" });
    $routeProvider.when('/logIn', { templateUrl: "pages/logIn.html" });


}]);

//result detail controller
app.controller('resultDetailController', ["$scope", "$http", "$route", function ($scope, $http, $route) {
    var groupId = $route.current.params.groupId;
    console.log(groupId);
    $scope.ASSESSMENT_RESULTS = [];
    $scope.CENTER = '';
    $scope.OCCUPATION = '';
    $scope.GROUP = '';

    $http({
        method: 'GET',
        url: 'backend/index.php/api/result/group_result/' + groupId
    }).then(function (response) {
        $scope.ASSESSMENT_RESULTS = response.data;
        $scope.GROUP = response.data[0].gr_id;
        $scope.CENTER = response.data[0]._center_name;
        $scope.OCCUPATION = response.data[0].occ_name;
        $scope.ASSESSMENT_DATE = response.data[0].scheduled_date;
        $scope.OCC_CODE = response.data[0].occ_code;

    });

    $scope.print = function () {
        window.print();
    }

}]);

app.controller('scheduleDetailController', ['$scope', '$http', '$route', function ($scope, $http, $route) {

    var groupId = $route.current.params.groupId;
    console.log(groupId);
    $scope.ASSESSMENT_SCHEDULES = [];
    $scope.CENTER = '';
    $scope.OCCUPATION = '';
    $scope.GROUP = '';

    $http({
        method: 'GET',
        url: 'backend/index.php/api/schedule/group_schedule/' + groupId
    }).then(function (response) {
        $scope.ASSESSMENT_SCHEDULES = response.data;
        $scope.CENTER = response.data[0].center_name;
        $scope.OCCUPATION = response.data[0].occ_name;
        $scope.GROUP = response.data[0].gr_id;
    });
    $scope.print = function () {
        window.print();
    }

}]);
//registration page controller
app.controller("registrationController", ["$scope", "$http", "$httpParamSerializerJQLike",
    function ($scope, $http, $httpParamSerializerJQLike) {
        $("#phoneModal").modal({
            keyboard: false,
            show: true,
            backdrop: 'static'
        });
        $('#phoneModal').on('shown.bs.modal', function () {
            $('#candidatePhone').trigger('focus');
        });


        $scope.candidate = {
            basic_info: {
                id: '',
                reg_no: '',
            },
            assessment: {}
        };

        $scope.searchPhone = function () {

            $http({
                method: "GET",
                url: "backend/index.php/api/candidate/has_account/" + $scope.phoneNumber
            }).then(function (response) {
                console.log(response.data);
                if (response.data) {
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



        initializeOS = function (type, id = null) {
            osCode = (id) ? id : '';
            URL = (id) ? "backend/index.php/api/os/" + type + "/" + id : "backend/index.php/api/os/" + type;
            return $http({
                method: "GET",
                url: URL
            });
        };



        applicationFee = function (occ_code) {

            initializeOS('assessment_price', occ_code).then(function (response) {
                $scope.candidate.assessment.assessment_rate = response.data.result.amount_for_level;
            });
        };

        $scope.loadSectors = function (parentId = null) {
            initializeOS('sector', parentId).then(function (response) {
                if (parentId) { $scope.SECTORS = (response.data) ? response.data : []; } 
                else { $scope.PARENT_SECTORS = (response.data) ? response.data : []; }
            });

        };

        $scope.loadSectors();
        
        
        $scope.loadOccupations = function (sectorId) {
            initializeOS('occupation', sectorId).then(function (response) { $scope.OCCUPATIONS = (response.data) ? response.data : []; });
        }


        $scope.loadUCs = function (occupationId) {
            applicationFee(occupationId);
            initializeOS('unit_of_competency', occupationId).then(function (response) { $scope.UCS = (response.data) ? response.data : []; });
        }

        $scope.register = function () {

            return $http({
                method: "POST",
                url: "backend/index.php/api/candidate/",
                data: $httpParamSerializerJQLike($scope.candidate),
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).then(function (response) { });
        };
        $scope.REGIONS = [
            "Addis Ababa",
            "Oromian",
            "South", "Afar", "Amhara", "Tigray"];

        $scope.INISTITUTE_TYPES = ['Private', 'Government', 'NGO'];

    }]);

//home page controller
app.controller("homeController", ["$scope","$http", "session", "$location", function ($scope, $http, session, $location) {
    $scope.admissionCount = 0;
    $scope.scheduleCount = 0;
    $scope.resultCount = 0;
    $scope.paymentCount = 0;
    if(session.isLoggedIn()){
    $http.get('backend/index.php/api/dash/schedule/'+session.getCenterId()).then(function (response) { $scope.scheduleCount = response.data });
    $http.get('backend/index.php/api/dash/admission/'+session.getCenterId()).then(function (response) { $scope.admissionCount = response.data });
    $http.get('backend/index.php/api/dash/result/'+session.getCenterId()).then(function (response) { $scope.resultCount = response.data });
    $http.get('backend/index.php/api/dash/payment/'+session.getCenterId()).then(function (response) { $scope.paymentCount = response.data });
    } else {
        $location.path('/logIn');
    }

    $scope.isLogged = function() {
        return session.isLoggedIn();
    }
    
}]);


//payment managment page controller
app.controller("paymentController", ["$scope", "$http", "$httpParamSerializerJQLike", function ($scope, $http, $httpParamSerializerJQLike) {

    $scope.payment = {
        invoice_no: '',
        date: '',
        totalAmount: 0.0,
        center_code: '',
        examIds: [],
    }

    $scope.PENDING_PAYMENTS = '';

    $http.get('backend/index.php/api/payment')
                .then(function (response) {
                $scope.PENDING_PAYMENTS = response.data;
                response.data.forEach(function (paymentInfo) {
                $scope.payment.examIds.push(paymentInfo.exam_id);
                if(paymentInfo.amount_paid){
                $scope.payment.totalAmount = $scope.payment.totalAmount  + parseInt(paymentInfo.amount_paid);
                }
                console.log(paymentInfo);
        })
    })


    $scope.submitPayment = function () {

       $http({
            method: "POST",
            url: "backend/index.php/api/payment/add_invoice",
            data: $httpParamSerializerJQLike($scope.payment),
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response) {
                if (response.data.success) { $('#paymentResult').append('<div class="alert alert-success"> Invoice Saved Successfuly </div>'); } 
                else {   $('#paymentResult').append('<div class="alert alert-danger">Error Saveing Invoice!!!</div>'); }
        });
    }


}]);



//admission card printing page controller
app.controller("admissionController", ["$scope", "$http", function ($scope, $http) {

    $scope.candidates = [
        {full_name: 'Mikael Araya', reg_no: '10'}
      ];
      $scope.availableCandidates = [];
      $scope.selectedCandidates = [];
    
      removeCandidate = function(data){
        console.log(data);
      };
      $scope.getCandidates= function(val) {
       $http.get('backend/index.php/api/admission/filter', 
                        {params: {filter: val} }).then(function(response){
          $scope.availableCandidates = response.data;     
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
app.controller("scheduleController", ["$scope", "$http", "$httpParamSerializerJQLike", function ($scope, $http, $httpParamSerializerJQLike) {

    $scope.AVAILABLE_SCHEDULES = [];

    $http.get('backend/index.php/api/schedule')
                .then(function (response) { if (response.data) {  $scope.AVAILABLE_SCHEDULES = response.data;  }
    });
}]);


//result viewing page controller
app.controller("resultController", ["$scope", "$http", function ($scope, $http) {

    $scope.AVAILABLE_RESULTS = [];
    $http.get('backend/index.php/api/result/')
                    .then(function (response) {  $scope.AVAILABLE_RESULTS = response.data.result  });
}]);


//password reset controller
app.controller("passwordController", ["$scope", "$http", "$httpParamSerializerJQLike",
    function ($scope, $http, $httpParamSerializerJQLike) {

        $scope.account = {};

        $scope.changePassword = function () {

            return $http({
                method: "POST",
                url: "backend/index.php/api/password/change/",
                data: $httpParamSerializerJQLike($scope.account),
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            });
        }
    }]);




//log in Controller
app.controller('logInController', ["$scope", "$http", "session", "$location", "$httpParamSerializerJQLike",
    function ($scope, $http,session, $location, $httpParamSerializerJQLike) {

        $scope.user = {
            password: "",
            contact_person: ""
    
        };
        $scope.result = '';
        $scope.Submit = function () {
            return $http({
                method: "POST",
                url: "backend/index.php/api/focal/log_in",
                data: $httpParamSerializerJQLike($scope.user),
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
                .then(function (response) {
                    if (response.data.success) {
                        console.log(response.data);
                        session.create(response.data.center_id, 
                            response.data.center_name, 
                            response.data.focal_name);
                            $location.path('/home');
              
                        

                    } else {
                        $scope.result = 'Username or Password Incorrect';
                    }
                });
    
        };

    }]);