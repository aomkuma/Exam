angular.module('app').controller('TopicUpdateController', function($scope, $compile, $cookies, $filter, $state, $routeParams, HTTPService, IndexOverlayFactory) {
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
    $scope.AutoID = $routeParams.AutoID;
    $scope.ChapterID = $routeParams.ChapterID;
    $scope.ChapterName = $routeParams.ChapterName;
    $scope.SubjectCode = $routeParams.SubjectCode;
    $scope.SubjectName = $routeParams.SubjectName;

    $scope.loadData = function(AutoID){
        IndexOverlayFactory.overlayShow();
        
        var params = {'AutoID': AutoID};

        HTTPService.clientRequest('topic/get', params).then(function(result){
            console.log(result);
            $scope.Data = result.data.DATA;
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.saveData = function(Data, SecretData){

        IndexOverlayFactory.overlayShow();
        
        var params = {'Data': Data};

        HTTPService.clientRequest('topic/update', params).then(function(result){
            console.log(result);
            if(result.data.STATUS == 'OK'){
                if(checkEmptyField($scope.Data.AutoID)){
                    // window.location.href = '#/chapter/update/' + result.data.DATA.AutoID;
                }else{
                    $scope.Data.AutoID = result.data.DATA.AutoID;
                    // window.location.href = '#/chapter/update/' + result.data.DATA.AutoID;
                }
                $scope.goBack();
            }else{
                alert(result.data.DATA);
            }
            
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.goBack = function(){
        window.location.href = '#/topic/' + $scope.SubjectCode + '/' + $scope.SubjectName + '/' + $scope.ChapterID + '/' + $scope.ChapterName;
    }

    $scope.Data = {
        "AutoID" : ""
          ,"TopicID" : ""
          ,"TopicName" : ""
          ,"ChapterID" : $scope.ChapterID
          ,"CreateDateTime" : ""
          ,"UpdateDateTime" : ""
          ,"UpdateByUserAccount" : ""
    };

    if(checkEmptyField($scope.AutoID)){
        $scope.loadData($scope.AutoID);
    }
    IndexOverlayFactory.overlayHide();
});