angular.module('app').config(function ($routeProvider, $locationProvider) {
    $routeProvider
            .when("/", {
                templateUrl: "views/home.html",
                controller: "HomeController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/HomeController.js"]
                            });
                        }]
                }
            })

            .when("/guest/logon", {
                templateUrl: "views/login.html",
                controller: "LoginController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/LoginController.js"]
                            });
                        }]
                }
            })

            .when("/user-account/admin", {
                templateUrl: "views/user-account/admin/main.html",
                controller: "UserAccountAdminMainController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/user-account/UserAccountAdminMainController.js"]
                            });
                        }]
                }
            })

            .when("/user-account/admin/update/:AutoID?", {
                templateUrl: "views/user-account/admin/update.html",
                controller: "UserAccountAdminUpdateController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/user-account/UserAccountAdminUpdateController.js"]
                            });
                        }]
                }
            })

            .when("/user-account/tutor", {
                templateUrl: "views/user-account/tutor/main.html",
                controller: "UserAccountTutorMainController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/user-account/UserAccountTutorMainController.js"]
                            });
                        }]
                }
            })

            .when("/user-account/tutor/update/:AutoID?", {
                templateUrl: "views/user-account/tutor/update.html",
                controller: "UserAccountTutorUpdateController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/user-account/UserAccountTutorUpdateController.js"]
                            });
                        }]
                }
            })

            .when("/user-account/ta", {
                templateUrl: "views/user-account/ta/main.html",
                controller: "UserAccountTAMainController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/user-account/UserAccountTAMainController.js"]
                            });
                        }]
                }
            })

            .when("/user-account/ta/update/:AutoID?", {
                templateUrl: "views/user-account/ta/update.html",
                controller: "UserAccountTAUpdateController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/user-account/UserAccountTAUpdateController.js"]
                            });
                        }]
                }
            })

            .when("/register/tutor", {
                templateUrl: "views/register/tutor/form.html",
                controller: "RegisterTutorFormController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/register/RegisterTutorFormController.js"]
                            });
                        }]
                }
            })

            .when("/subject", {
                templateUrl: "views/subject/main.html",
                controller: "SubjectMainController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/subject/SubjectMainController.js"]
                            });
                        }]
                }
            })

            .when("/subject/update/:AutoID?", {
                templateUrl: "views/subject/update.html",
                controller: "SubjectUpdateController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/subject/SubjectUpdateController.js"]
                            });
                        }]
                }
            })

            .when("/chapter/:SubjectCode/:SubjectName", {
                templateUrl: "views/chapter/main.html",
                controller: "ChapterMainController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/chapter/ChapterMainController.js"]
                            });
                        }]
                }
            })

            .when("/chapter/update/:SubjectCode/:SubjectName/:AutoID?", {
                templateUrl: "views/chapter/update.html",
                controller: "ChapterUpdateController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/chapter/ChapterUpdateController.js"]
                            });
                        }]
                }
            })

            .when("/topic/:SubjectCode/:SubjectName/:ChapterID/:ChapterName", {
                templateUrl: "views/topic/main.html",
                controller: "TopicMainController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/topic/TopicMainController.js"]
                            });
                        }]
                }
            })

            .when("/topic/update/:SubjectCode/:SubjectName/:ChapterID/:ChapterName/:AutoID?", {
                templateUrl: "views/topic/update.html",
                controller: "TopicUpdateController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/topic/TopicUpdateController.js"]
                            });
                        }]
                }
            })

            .when("/level", {
                templateUrl: "views/level/main.html",
                controller: "LevelMainController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/level/LevelMainController.js"]
                            });
                        }]
                }
            })

            .when("/level/update/:AutoID?", {
                templateUrl: "views/level/update.html",
                controller: "LevelUpdateController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/level/LevelUpdateController.js"]
                            });
                        }]
                }
            })

            .when("/exam-sources", {
                templateUrl: "views/exam-sources/main.html",
                controller: "ExamSourceMainController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/exam-sources/ExamSourceMainController.js"]
                            });
                        }]
                }
            })

            .when("/exam-sources/update/:AutoID?", {
                templateUrl: "views/exam-sources/update.html",
                controller: "ExamSourceUpdateController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/exam-sources/ExamSourceUpdateController.js"]
                            });
                        }]
                }
            })

            .when("/register/tutor/approval", {
                templateUrl: "views/register/tutor/approval.html",
                controller: "RegisterTutorApprovalController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/register/RegisterTutorApprovalController.js"]
                            });
                        }]
                }
            })

            .when("/register/tutor/approval/update/:AutoID", {
                templateUrl: "views/register/tutor/approval-update.html",
                controller: "RegisterTutorApprovalUpdateController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/register/RegisterTutorApprovalUpdateController.js"]
                            });
                        }]
                }
            })

            .when("/exam-set/manage/list", {
                templateUrl: "views/exam-set/main.html",
                controller: "ExamSetMainController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/exam-set/ExamSetMainController.js"]
                            });
                        }]
                }
            })

            .when("/exam-set/manage/update/:AutoID?", {
                templateUrl: "views/exam-set/update.html",
                controller: "ExamSetUpdateController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/exam-set/ExamSetUpdateController.js"]
                            });
                        }]
                }
            })

            .when("/questions/manage/list/:ExamSetCode", {
                templateUrl: "views/questions/main.html",
                controller: "QuestionMainController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/questions/QuestionMainController.js"]
                            });
                        }]
                }
            })

            .when("/questions/manage/update/:ExamSetCode/:AutoID?", {
                templateUrl: "views/questions/update.html",
                controller: "QuestionUpdateController",
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: ["scripts/controllers/questions/QuestionUpdateController.js"]
                            });
                        }]
                }
            })
            
            ;


    $locationProvider.hashPrefix('');
    // $locationProvider.html5Mode({
    //                 enabled: true,
    //                 requireBase: false
    //          });

});

/*app.config(function($routeProvider) {
 
 $routeProvider.when('/', {
 
 templateUrl: function(rd) {
 return 'views/home.html';
 },
 
 resolve: {
 load: function($q, $route, $rootScope) {
 
 var deferred = $q.defer();
 var dependencies = [
 'scripts/controllers/HomeController.js'
 ];
 
 $script(dependencies, function () {
 $rootScope.$apply(function() {
 deferred.resolve();
 });
 });
 
 console.log(deferred);
 return deferred.promise;
 }
 }
 });
 
 });*/