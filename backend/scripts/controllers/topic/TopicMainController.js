angular.module('app').controller('TopicMainController', function($scope, $compile, $cookies, $filter, $state, $routeParams, HTTPService, IndexOverlayFactory) {
    IndexOverlayFactory.overlayShow();
    
    var $user_session = sessionStorage.getItem('user_session');
    
    if($user_session != null){
        $scope.$parent.currentUser = angular.fromJson($user_session);
        if($scope.$parent.currentUser.UserType != 'admin'){
            alert('คุณไม่มีสิทธิ์ใช้งานหน้านี้');
            history.back();
            return false;
        }
    }else{
        IndexOverlayFactory.overlayHide();
        window.location.replace('#/guest/logon');
        return false;
    }

    $scope.$parent.menu_selected = 'manage';
    $scope.ChapterID = $routeParams.ChapterID;
    $scope.ChapterName = $routeParams.ChapterName;
    $scope.SubjectCode = $routeParams.SubjectCode;
    $scope.SubjectName = $routeParams.SubjectName;

    $scope.loadList = function(ChapterID, condition){
        IndexOverlayFactory.overlayShow();
        
        var params = {'currentPage': $scope.Pagination.currentPage
                    , 'limitRowPerPage': $scope.Pagination.limitRowPerPage
                    , 'condition' : condition
                    , 'ChapterID' : ChapterID
                    };

        HTTPService.clientRequest('topic/list/manage', params).then(function(result){
            console.log(result);
            $scope.DataList = result.data.DATA.DataList;
            $scope.Pagination.totalPages = result.data.DATA.Total;
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.search = function(ChapterID, condition){
        $scope.loadList(ChapterID, condition);
    }

    $scope.pageChanged = function() {
        $scope.loadList($scope.ChapterID, $scope.condition);
    };

    $scope.Pagination = {'totalPages' : 0, 'currentPage' : 0, 'limitRowPerPage' : 10, 'limitDisplay' : 10};
    $scope.condition = {'keyword' : null};
    // console.log($scope.ChapterCode);
    $scope.loadList($scope.ChapterID, $scope.condition);
    
});
