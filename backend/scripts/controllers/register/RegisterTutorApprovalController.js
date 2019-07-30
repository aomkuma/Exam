angular.module('app').controller('RegisterTutorApprovalController', function($scope, $compile, $cookies, $filter, $state, $routeParams, HTTPService, IndexOverlayFactory) {
    IndexOverlayFactory.overlayShow();
    
    var $user_session = sessionStorage.getItem('user_session');
    
    if($user_session != null){
        $scope.$parent.currentUser = angular.fromJson($user_session);
        if($scope.$parent.currentUser.UserType != 'admin'){
            alert('คุณไม่มีสิทธิ์ใช้งานหน้านี้');
            history.back();
            return false;
        }
    }
    else{
        IndexOverlayFactory.overlayHide();
        window.location.replace('#/guest/logon');
        return false;
    }

    $scope.$parent.menu_selected = 'register/tutor/approval';

    $scope.loadList = function(condition){
        IndexOverlayFactory.overlayShow();
        
        var params = {'currentPage': $scope.Pagination.currentPage
                    , 'limitRowPerPage': $scope.Pagination.limitRowPerPage
                    , 'condition' : condition
                    };

        HTTPService.clientRequest('tutor/list/approval', params).then(function(result){
            console.log(result);
            $scope.DataList = result.data.DATA.DataList;
            $scope.Pagination.totalPages = result.data.DATA.Total;
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.search = function(condition){
        $scope.loadList(condition);
    }

    $scope.pageChanged = function() {
        $scope.loadList($scope.condition);
    };

    $scope.getStatusName = function(UserStatus){
        if(UserStatus == 'inactive'){
            return 'ระงับการใช้งาน';
        }else if(UserStatus == 'waitingForApprove'){
            return 'รอการอนุมัติ';
        }else if(UserStatus == 'active'){
            return 'อนุมัติแล้ว';
        }else{
            return '';
        }
    }

    $scope.getDateString = function(date){
        if(checkEmptyField(date)){
            return convertDateToFullThaiDate(new Date(date));
        }
    }

    $scope.Pagination = {'totalPages' : 0, 'currentPage' : 0, 'limitRowPerPage' : 10, 'limitDisplay' : 10};
    $scope.condition = {'keyword' : null};

    $scope.loadList($scope.condition);
    
});