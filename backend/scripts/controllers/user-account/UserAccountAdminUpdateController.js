angular.module('app').controller('UserAccountAdminUpdateController', function($scope, $compile, $cookies, $filter, $state, $routeParams, HTTPService, IndexOverlayFactory) {
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

    $scope.$parent.menu_selected = 'user-account/admin';
    $scope.AutoID = $routeParams.AutoID;

    $scope.loadData = function(AutoID){
        IndexOverlayFactory.overlayShow();
        
        var params = {'AutoID': AutoID};

        HTTPService.clientRequest('user-account/get/admin', params).then(function(result){
            console.log(result);
            $scope.Data = result.data.DATA;
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.saveData = function(Data, SecretData){

        if(checkEmptyField(SecretData.NewPassword) && checkEmptyField(SecretData.ConfirmNewPassword)){
            if(SecretData.NewPassword != SecretData.ConfirmNewPassword){
                alert('รหัสผ่านใหม่และยืนยันรหัสผ่านใหม่ไม่ตรงกัน กรุณาแก้ไข');
                return false;
            }
        }

        IndexOverlayFactory.overlayShow();
        
        var params = {'Data': Data, 'SecretData' : SecretData};

        HTTPService.clientRequest('user-account/update/admin', params).then(function(result){
            console.log(result);
            if(result.data.STATUS == 'OK'){
                if(checkEmptyField($scope.Data.AutoID)){
                    // window.location.href = '#/user-account/admin/update/' + result.data.DATA.AutoID;
                }else{
                    $scope.Data.AutoID = result.data.DATA.AutoID;
                    // window.location.href = '#/user-account/admin/update/' + result.data.DATA.AutoID;
                }
                $scope.goBack();
            }else{
                alert(result.data.DATA);
            }
            
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.goBack = function(){
        window.location.href = '#/user-account/admin/';
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
          ,"BankCode" : ""
          ,"BankAccType" : ""
          ,"BankAccName" : ""
          ,"BankAccNo" : ""
          ,"UserStatus" : "active"
          ,"UserType" : "admin"
          ,"ReportToTutorAccount" : ""
          ,"CreateDateTime" : ""
          ,"UpdateDateTime" : ""
          ,"UpdateByUserAccount" : ""
    };

    $scope.SecretData = {'NewPassword':'', 'ConfirmNewPassword':''};

    if(checkEmptyField($scope.AutoID)){
        $scope.loadData($scope.AutoID);
    }
    IndexOverlayFactory.overlayHide();
});