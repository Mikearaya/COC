// Include app dependency on ngMaterial
var app = angular.module('myApp', ['ngRoute',
    'ngMessages',
    'ngAria',
    'ngAnimate',
    'ui.bootstrap',
    'ngSanitize',
    'ui.select',
    'ui-notification'

]);

//service used to pass data between controllers
app.factory("transporter", function () {

    var data = undefined;

    function set(transport) {  data = transport;   }

    function get() { return data;  }

    return {
      set: set,
    get: get
    };

});

app.config(function (NotificationProvider) {
    NotificationProvider.setOptions({
        delay: 10000,
        startTop: 20,
        startRight: 10,
        verticalSpacing: 20,
        horizontalSpacing: 20,
        positionX: 'right',
        positionY: 'top',
        replaceMessage: true
    });
});

//session Service
app.factory("session", ["$http", 'Notification', '$location', function ($http, Notification, $location) {

    var focal_person_name = "";
    var center_code = "";
    var center_name = "";
    var loged_in = false;

    function createSession(centerId, centerName, focalName) {

        focal_person_name = focalName;
        center_code = centerId;
        center_name = centerName;
        loged_in = true;
    }

    function getUserName() { return focal_person_name; }
    function getCenterName() {  return center_name;  }
    function getCenterId() {   return center_code;   }

    function destroySession() {

        $http({
            method: "GET",
            url: "backend/index.php/api/focal/log_out",
        }).then(function (response) {
            $location.path('/logIn');

            Notification({ title: 'Loged Out', message: 'Good bye  ' + focal_person_name });
            loged_in = false;
            focal_person_name = "";
            center_code = "";
            center_name = "";
        });

    }

    function isLoggedIn() { return loged_in;  }

    function refresh() {

        $http({
            method: "GET",
            url: "backend/index.php/api/focal/is_session_active",
        }).then(function (response) {

            if (response.data.is_active) {
                createSession(response.data.center_code, response.data.center_name, response.data.contact_person);
                focal_person_name = response.data.contact_person;
                center_code = response.data.center_code;
                center_name = response.data.center_name;
                loged_in = true;
            } else {
                $location.path('/logIn');
            }

        });

    }

    refresh();
    return {
        create: createSession,
        destroy: destroySession,
        isLoggedIn: isLoggedIn,
        getUserName: getUserName,
        getCenterName: getCenterName,
        getCenterId: getCenterId
    };

}]);

app.controller("mainController", ["$scope", "session",
    function ($scope, session) {
        $scope.isLogged = function () {   return session.isLoggedIn();   };
        $scope.logOut = function () {  session.destroy();  };

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
    $routeProvider.when('/admission/print', { templateUrl: "pages/slip.html" });


}]);

//result detail controller
app.controller('resultDetailController', ["$scope", "$http", "$route", function ($scope, $http, $route) {
    var groupId = $route.current.params.groupId;
    $scope.ASSESSMENT_RESULTS = [];
    $scope.CENTER = '';
    $scope.OCCUPATION = '';
    $scope.GROUP = '';
    $scope.OCC_CODE = '';
    $scope.TIME = '';
    $scope.ASSESSMENT_DATE = '';

    $http({
        method: 'GET',
        url: 'backend/index.php/api/result/group_result/' + groupId
    }).then(function (response) {
        $scope.ASSESSMENT_RESULTS = response.data;
        $scope.GROUP = response.data[0].gr_id;
        $scope.CENTER = response.data[0].center_name;
        $scope.OCCUPATION = response.data[0].occ_name;
        $scope.ASSESSMENT_DATE = response.data[0].scheduled_date;
        $scope.TIME = response.data[0].time;
        $scope.OCC_CODE = response.data[0].occ_code;

    });

    $scope.print = function () { window.print();  }

}]);

app.controller('scheduleDetailController', ['$scope', '$http', '$route', function ($scope, $http, $route) {

    var groupId = $route.current.params.groupId;
    console.log(groupId);
    $scope.ASSESSMENT_SCHEDULES = [];
    $scope.CENTER = '';
    $scope.OCCUPATION = '';
    $scope.GROUP = '';
    $scope.ASSESSMENT_DATE = '';
    $scope.TIME = '';
    $scope.OCC_CODE = '';

    $http({
        method: 'GET',
        url: 'backend/index.php/api/schedule/group_schedule/' + groupId
    }).then(function (response) {
        $scope.ASSESSMENT_SCHEDULES = response.data;
        $scope.CENTER = response.data[0].center_name;
        $scope.OCCUPATION = response.data[0].occ_name;
        $scope.GROUP = response.data[0].gr_id;
        $scope.ASSESSMENT_DATE = response.data[0].scheduled_date;
        $scope.TIME = response.data[0].time;
        $scope.OCC_CODE = response.data[0].occ_code;

    });
    $scope.print = function () {  window.print();  };


}]);
//registration page controller
app.controller("registrationController", ["$scope", "$http", "$httpParamSerializerJQLike",
    function ($scope, $http, $httpParamSerializerJQLike) {
        $scope.candidate = {
            basic_info: {
                id: '',
                reg_no: '',
            },
            assessment: {}
        };

        $scope.paymentStatus = function (val) {
            console.log(val);
        };
        // $('#mobile').mask('000-0-00-00-00');
        //$('#homePhone').mask('000-0-00-00-00');
        $scope.EXISTING_CANDIDATE = false;
        $scope.MARITAL_STATUS = [];
        $scope.TRAINING_MODES = [];
        $scope.TRAINING_TYPES = [];
        $scope.COMPANY_STATUS = [];
        $scope.NATIONALITIES = [];
        $scope.OCCUPATION_FEE = 0.0;
        $scope.LEVELS = [1, 2, 3, 4];

        //modal used to initialize form for returning candidate with previous infomation
        //using mobile number
        $("#phoneModal").modal({
            keyboard: false,
            show: true,
            backdrop: 'static'
        });
        $('#phoneModal').on('shown.bs.modal', function () {
                 $('#candidatePhone').trigger('focus');
        });

        //initialize select controls with data from server
        $http.get('backend/index.php/api/init/registration').then(function (response) {
            response.data.forEach(function (control) {
                switch (control.field) {
                    case 'marital_status': $scope.MARITAL_STATUS.push(control.value);
                        break;
                    case 'mode_of_training': $scope.TRAINING_MODES.push(control.value);
                        break;
                    case 'type_of_training': $scope.TRAINING_TYPES.push(control.value);
                        break;
                    case 'nationality': $scope.NATIONALITIES.push(control.value);
                        break;
                    case 'company_status_you_are_working_on': $scope.COMPANY_STATUS.push(control.value);
                        break;
                }
            })
        });


        $scope.searchPhone = function () {

            $http({
                method: "GET",
                url: "backend/index.php/api/candidate/has_account/" + $scope.phoneNumber
            }).then(function (response) {
                if (response.data) {
                    $scope.EXISTING_CANDIDATE = true;
                    $scope.candidate.basic_info = response.data;
                } else {
                    $scope.EXISTING_CANDIDATE = false;
                }
                $("#phoneModal").modal('hide');
            });
        }

        $scope.PARENT_SECTORS = [];
        $scope.SECTORS = [];
        $scope.OCCUPATIONS = [];
        $scope.UCS = [];
        $scope.APPLICATION_FEE = 0;
        $scope.ucCheck = function (val) {
            if (val && $scope.OCCUPATION_FEE.amount_for_uc) {
                $scope.candidate.assessment.amount_paid = $scope.OCCUPATION_FEE.amount_for_uc;
            } else if (val == false && $scope.OCCUPATION_FEE.amount_for_knowledge) {
                $scope.candidate.assessment.amount_paid = $scope.OCCUPATION_FEE.amount_for_knowledge;
            } else if (val && !$scope.OCCUPATION_FEE.amount_for_uc && $scope.OCCUPATION_FEE.amount_for_knowledge) {
                $scope.candidate.assessment.amount_paid = $scope.OCCUPATION_FEE.amount_for_knowledge;
            } else {
                $scope.candidate.assessment.amount_paid = 0;
            }
        }


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
                $scope.OCCUPATION_FEE = response.data;
                if ($scope.OCCUPATION_FEE.amount_for_knowledge) {
                    $scope.candidate.assessment.amount_paid = parseFloat($scope.OCCUPATION_FEE.amount_for_knowledge);
                } else {
                    $scope.candidate.assessment.amount_paid = 0.0;
                }
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
app.controller("homeController", ["$scope", "$http", "session", "$location", function ($scope, $http, session, $location) {
    $scope.admissionCount = 0;
    $scope.scheduleCount = 0;
    $scope.resultCount = 0;
    $scope.paymentCount = 0;
    if (session.isLoggedIn()) {
        $http.get('backend/index.php/api/dash/schedule/' + session.getCenterId()).then(function (response) { $scope.scheduleCount = response.data });
        $http.get('backend/index.php/api/dash/admission/' + session.getCenterId()).then(function (response) { $scope.admissionCount = response.data });
        $http.get('backend/index.php/api/dash/result/' + session.getCenterId()).then(function (response) { $scope.resultCount = response.data });
        $http.get('backend/index.php/api/dash/payment/' + session.getCenterId()).then(function (response) { $scope.paymentCount = response.data });
    } else {
        $location.path('/logIn');
    }

    $scope.isLogged = function () {  return session.isLoggedIn();   };

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
                if (paymentInfo.amount_paid) {
                    $scope.payment.totalAmount = $scope.payment.totalAmount + parseInt(paymentInfo.amount_paid);
                }
            })
        })


    $scope.submitPayment = function () {

        $http({
            method: "POST",
            url: "backend/index.php/api/payment/add_invoice",
            data: $httpParamSerializerJQLike($scope.payment),
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function (response) {
            if (response.data.success) { $('#paymentResult').append('<div class="alert alert-success"> Invoice Saved Successfuly </div>'); }
            else { $('#paymentResult').append('<div class="alert alert-danger">Error Saveing Invoice!!!</div>'); }
        });
    }


}]);

app.controller("admissionSlipController", ["$scope", "transporter", function ($scope, transporter) {
    $scope.CANDIDATES = [];
    if (transporter.get()) {
        $scope.CANDIDATES = transporter.get();
    }

    $scope.printAdmissions = function () {
        window.print();
    };
}]);

app.controller("admissionController", ["$scope", "$http", "transporter", "$location", function ($scope, $http, transporter, $location) {


    $scope.candidates = [];
    $scope.availableCandidates = [];
    $scope.selectedCandidates = [];

    $scope.onSelect = function (item, model) {
        $scope.selectedCandidates.push(item);
    }
    $scope.onRemove = function (item, model) {
        index = $scope.selectedCandidates.indexOf(item);
        $scope.selectedCandidates.splice(index, 1);
    }
    $scope.getCandidates = function (val) {
        $http.get('backend/index.php/api/admission/filter',
            { params: { filter: val } }).then(function (response) {
                $scope.availableCandidates = response.data;
            });
    };

    $scope.printAdmissions = function (val) {
        transporter.set($scope.selectedCandidates);
        $location.path("/admission/print");
    }
    $scope.modelOptions = {
        debounce: {
            default: 500,
            blur: 250
        }
    };
}]);


//schedule page controller
app.controller("scheduleController", ["$scope", "$http", function ($scope, $http) {

    $scope.AVAILABLE_SCHEDULES = [];
    $scope.totalItems = 0;
    $scope.loadSchedules = function (a_offset, a_limit) {
        return $http.get('backend/index.php/api/schedule/',
            { params: { 'limit-offset': a_offset, 'limit': a_limit } })
            .then(function (response) {
                $scope.AVAILABLE_SCHEDULES = response.data.rows;
                $scope.totalItems = response.data.total;
            });
    }

    $scope.loadSchedules(1, 20);

    $scope.currentPage = 0;

    $scope.setPage = function (pageNo) {
        $scope.currentPage = pageNo;
    };

    $scope.pageChanged = function () {
        $scope.loadSchedules($scope.currentPage, 15);
    };


    $scope.maxSize = 5;
}]);


//result viewing page controller
app.controller("resultController", ["$scope", "$http", function ($scope, $http) {
    $scope.AVAILABLE_RESULTS = [];
    $scope.totalItems;
    $scope.loadResults = function (a_offset, a_limit) {
        return $http.get('backend/index.php/api/result/',
            { params: { 'limit-offset': a_offset, 'limit': a_limit } })
            .then(function (response) {
                $scope.AVAILABLE_RESULTS = response.data.rows;
                $scope.totalItems = response.data.total;
            });
    }

    $scope.loadResults(1, 20);


    $scope.currentPage = 0;

    $scope.setPage = function (pageNo) {
        $scope.currentPage = pageNo;
    };

    $scope.pageChanged = function () {  $scope.loadResults($scope.currentPage, 20);   };


}]);


//password reset controller
app.controller("passwordController", ["$scope", "$http", "$httpParamSerializerJQLike", "Notification",
    function ($scope, $http, $httpParamSerializerJQLike, Notification) {

        $scope.account = {};

        $scope.changePassword = function () {

            $http({
                method: "POST",
                url: "backend/index.php/api/password/change/",
                data: $httpParamSerializerJQLike($scope.account),
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).then(function (response) {
                if (response.data.success) {
                    $scope.changed = true;
                    Notification.success({ title: 'Password Changed Successfully', message: 'Use your new password next time you log in' });
                } else {
                    $scope.changed = false;
                    Notification.error({ title: 'Password Change Failed', message: response.data.message });
                }

            });
        }
    }]);




//log in Controller
app.controller('logInController', ["$scope", "$http", "session", "$location", "$httpParamSerializerJQLike", "Notification",
    function ($scope, $http, session, $location, $httpParamSerializerJQLike, Notification) {

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
                        session.create(response.data.center_code,
                            response.data.center_name,
                            response.data.contact_person);
                        Notification({ title: 'Loged in', message: 'Welcome ' + response.data.contact_person });
                        $location.path('/home');
                       


                    } else {
                        $scope.result = 'Username or Password Incorrect';
                    }
                });

        };

    }]);
