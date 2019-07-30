var serviceUrl = '../services/public/';

var app = angular.module('app', ['ui.bootstrap' , 'ngRoute' , 'ngAnimate', 'ngCookies', 'ui.router', 'oc.lazyLoad', 'ngFileUpload', 'angular-bind-html-compile']);

app.config(function($controllerProvider, $compileProvider, $filterProvider, $provide) {
  app.register = {
    controller: $controllerProvider.register,
    directive: $compileProvider.directive,
    filter: $filterProvider.register,
    factory: $provide.factory,
    service: $provide.service
  };
});

angular.module('app').controller('AppController', ['$cookies','$scope', '$filter', '$uibModal','IndexOverlayFactory', 'HTTPService', function($cookies, $scope, $filter, $uibModal, IndexOverlayFactory, HTTPService) {
	$scope.overlay = IndexOverlayFactory;
	$scope.overlayShow = false;
	$scope.currentUser = null;
    $scope.TotalLogin = 0;
    $scope.menu_selected = '';

    
    $scope.logout = function(){
        sessionStorage.setItem('user_session', null);
        sessionStorage.removeItem('user_session');
        $scope.currentUser = null;
        console.log(sessionStorage.getItem('user_session'));
        setTimeout(function(){
            window.location.replace('#/guest/logon');    
        },500);
        
    }

}]);
