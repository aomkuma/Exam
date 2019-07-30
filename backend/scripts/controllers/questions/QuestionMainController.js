angular.module('app').controller('QuestionMainController', function($scope, $compile, $cookies, $filter, $state, $routeParams, HTTPService, IndexOverlayFactory) {
    IndexOverlayFactory.overlayShow();
    
    var $user_session = sessionStorage.getItem('user_session');
    
    if($user_session != null){
        $scope.$parent.currentUser = angular.fromJson($user_session);
        if($scope.$parent.currentUser.UserType != 'tutor' && $scope.$parent.currentUser.UserType != 'ta'){
            alert('คุณไม่มีสิทธิ์ใช้งานหน้านี้');
            history.back();
            return false;
        }
    }else{
        IndexOverlayFactory.overlayHide();
        window.location.replace('#/guest/logon');
        return false;
    }

    $scope.$parent.menu_selected = 'exam-set/manage';
    $scope.ExamSetCode = $routeParams.ExamSetCode;

    $scope.getExamSetData = function(ExamSetCode){
        IndexOverlayFactory.overlayShow();
        
        var params = {'ExamSetCode' : ExamSetCode};

        HTTPService.clientRequest('exam-set/manage/get', params).then(function(result){
            console.log(result);
            $scope.ExamSetData = result.data.DATA;
            $scope.loadList($scope.ExamSetCode);
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.loadList = function(ExamSetCode){
        IndexOverlayFactory.overlayShow();
        
        var params = {'ExamSetCode': ExamSetCode};

        HTTPService.clientRequest('questions/manage/list', params).then(function(result){
            console.log(result);
            $scope.DataList = result.data.DATA.DataList;
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.search = function(condition){
        $scope.loadList(condition);
    }

    $scope.pageChanged = function() {
        $scope.loadList($scope.condition);
    };

    $scope.getExamSetData($scope.ExamSetCode);
    
});
