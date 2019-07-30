angular.module('app').controller('RegisterTutorApprovalUpdateController', function($scope, $compile, $cookies, $filter, $state, $routeParams, HTTPService, IndexOverlayFactory) {
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

    $scope.$parent.menu_selected = 'register/tutor';
    $scope.AutoID = $routeParams.AutoID;
    $scope.loadBankList = function(){
        IndexOverlayFactory.overlayShow();
        
        HTTPService.clientRequest('bank/list', null).then(function(result){
            console.log(result);
            $scope.BankList = result.data.DATA.DataList;
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.loadSubjectList = function(){
        IndexOverlayFactory.overlayShow();

        HTTPService.clientRequest('subject/list', null).then(function(result){
            console.log(result);
            $scope.SubjectList = result.data.DATA.DataList;
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.loadData = function(AutoID){
        IndexOverlayFactory.overlayShow();
        
        var params = {'AutoID': AutoID};

        HTTPService.clientRequest('user-account/get/tutor', params).then(function(result){
            console.log(result);
            $scope.Data = result.data.DATA;
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.saveData = function(Data, SecretData){

        IndexOverlayFactory.overlayShow();
        // Data.UserStatus = 'waitingForApprove';
        Data.TutorApproveDateTime = makeSQLDateTime(new Date());
        var params = {'Data': Data};

        HTTPService.clientRequest('user-account/approval/tutor', params).then(function(result){
            console.log(result);
            if(result.data.STATUS == 'OK'){
                // if(checkEmptyField($scope.Data.AutoID)){
                //     window.location.href = '#/user-account/admin/update/' + result.data.DATA.AutoID;
                // }else{
                //     $scope.Data.AutoID = result.data.DATA.AutoID;
                // }
                // alert('ลงทะเบียนเรียบร้อยแล้ว กรุณารอการอนุมัติและติดต่อกลับจากเจ้าหน้าที่');
                // window.location.href = '#/register/tutor/approval';
                $scope.goBack();
            }else{
                alert(result.data.DATA);
            }
            
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.goBack = function(){
        window.location.href = '#/register/tutor/approval';
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
          ,"UserStatus" : "active"
          ,"UserType" : "tutor"
          ,"ReportToTutorAccount" : ""
          ,"CreateDateTime" : ""
          ,"UpdateDateTime" : ""
          ,"UpdateByUserAccount" : ""
    };

    $scope.SecretData = {'NewPassword':'', 'ConfirmNewPassword':''};

    $scope.loadBankList();
    $scope.loadSubjectList();
    $scope.loadData($scope.AutoID);

    IndexOverlayFactory.overlayHide();
});