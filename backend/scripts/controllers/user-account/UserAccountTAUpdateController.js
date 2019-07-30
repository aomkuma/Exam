angular.module('app').controller('UserAccountTAUpdateController', function($scope, $compile, $cookies, $filter, $state, $routeParams, HTTPService, IndexOverlayFactory) {
    IndexOverlayFactory.overlayShow();
    
    var $user_session = sessionStorage.getItem('user_session');
    
    if($user_session != null){
        $scope.$parent.currentUser = angular.fromJson($user_session);
        if($scope.$parent.currentUser.UserType != 'tutor'){
            alert('คุณไม่มีสิทธิ์ใช้งานหน้านี้');
            history.back();
            return false;
        }
    }else{
        IndexOverlayFactory.overlayHide();
        window.location.replace('#/guest/logon');
        return false;
    }

    $scope.$parent.menu_selected = 'user-account/ta';
    $scope.AutoID = $routeParams.AutoID;

    $scope.loadBankList = function(){
        IndexOverlayFactory.overlayShow();
        
        HTTPService.clientRequest('bank/list', null).then(function(result){
            console.log(result);
            $scope.BankList = result.data.DATA.DataList;
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.loadData = function(AutoID){
        IndexOverlayFactory.overlayShow();
        
        var params = {'AutoID': AutoID};

        HTTPService.clientRequest('user-account/get/ta', params).then(function(result){
            console.log(result);
            $scope.Data = result.data.DATA;
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.saveData = function(Data, SecretData){

        // IndexOverlayFactory.overlayShow();
        
        var params = {'Data': Data, 'SecretData' : SecretData};

        HTTPService.clientRequest('user-account/update/ta', params).then(function(result){
            console.log(result);
            if(result.data.STATUS == 'OK'){
                if(checkEmptyField($scope.Data.AutoID)){
                    // window.location.href = '#/user-account/ta/update/' + result.data.DATA.AutoID;
                }else{
                    $scope.Data.AutoID = result.data.DATA.AutoID;
                    // window.location.href = '#/user-account/ta/update/' + result.data.DATA.AutoID;
                }
                $scope.goBack();
            }else{
                alert(result.data.DATA);
            }
            
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.goBack = function(){
        window.location.href = '#/user-account/ta/';
    }

    $scope.Data = {
        "AutoID" : ""
          ,"UserAccount" : ""
          ,"TutorCode" : ""
          ,"RegisterType" : ""
          ,"NickName" : ""
          ,"FirstName" : ""
          ,"LastName" : ""
          ,"CardID" : ""
          ,"Mobile" : ""
          ,"BankCode" : null
          ,"BankAccType" : ""
          ,"BankAccName" : ""
          ,"BankAccNo" : ""
          ,"UserStatus" : "inactive"
          ,"UserType" : "ta"
          ,"ReportToTutorAccount" : $scope.currentUser.UserAccount
          ,"CreateDateTime" : ""
          ,"UpdateDateTime" : ""
          ,"UpdateByUserAccount" : ""
    };

    $scope.SecretData = {'NewPassword':'', 'ConfirmNewPassword':''};

    $scope.loadBankList();
    if(checkEmptyField($scope.AutoID)){
        $scope.loadData($scope.AutoID);
    }
    IndexOverlayFactory.overlayHide();
});