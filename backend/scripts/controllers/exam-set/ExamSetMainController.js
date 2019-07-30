angular.module('app').controller('ExamSetMainController', function($scope, $compile, $cookies, $filter, $state, $routeParams, HTTPService, IndexOverlayFactory) {
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

    $scope.loadList = function(condition){
        IndexOverlayFactory.overlayShow();
        
        var params = {'currentPage': $scope.Pagination.currentPage
                    , 'limitRowPerPage': $scope.Pagination.limitRowPerPage
                    , 'condition' : condition
                    };

        HTTPService.clientRequest('exam-set/manage/list', params).then(function(result){
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

    $scope.getDayOfWork = function(CreateDateTime){
        // console.log(CreateDateTime);
        if(checkEmptyField(CreateDateTime)){
     
            var date2 = new Date();
            var date1 = makeDateTime(CreateDateTime);

            var one_day=1000*60*60*24;

            // Convert both dates to milliseconds
            var date1_ms = date1.getTime();
            var date2_ms = date2.getTime();

            // Calculate the difference in milliseconds
            var difference_ms = date2_ms - date1_ms;

            // Convert back to days and return
            return Math.round(difference_ms/one_day) + 1; 

        }else{
             return '';
        }
    }

    $scope.Pagination = {'totalPages' : 0, 'currentPage' : 0, 'limitRowPerPage' : 10, 'limitDisplay' : 10};
    $scope.condition = {'keyword' : null};

    $scope.loadList($scope.condition);
    
});
