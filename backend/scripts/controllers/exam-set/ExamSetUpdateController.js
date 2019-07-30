angular.module('app').controller('ExamSetUpdateController', function($scope, $compile, $cookies, $filter, $state, $routeParams, HTTPService, IndexOverlayFactory) {
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
    $scope.AutoID = $routeParams.AutoID;

    $scope.loadSubjectList = function(){
        IndexOverlayFactory.overlayShow();
       
        HTTPService.clientRequest('subject/list', null).then(function(result){
            // console.log(result);
            $scope.SubjectList = result.data.DATA.DataList;
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.loadLevelList = function(){
        IndexOverlayFactory.overlayShow();
       
        HTTPService.clientRequest('level/list', null).then(function(result){
            // console.log(result);
            $scope.LevelList = result.data.DATA.DataList;
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.loadExamSourceList = function(){
        IndexOverlayFactory.overlayShow();
       
        HTTPService.clientRequest('exam-sources/list', null).then(function(result){
            // console.log(result);
            $scope.ExamSourceList = result.data.DATA.DataList;
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.loadData = function(AutoID){
        IndexOverlayFactory.overlayShow();
        
        var params = {'AutoID': AutoID};

        HTTPService.clientRequest('exam-set/manage/get', params).then(function(result){
            console.log(result);
            $scope.Data = result.data.DATA;
            $scope.Data.TotalProposition = parseInt($scope.Data.TotalProposition);
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.saveData = function(Data){

        IndexOverlayFactory.overlayShow();
        
        var params = {'Data': Data};

        HTTPService.clientRequest('exam-set/manage/update', params).then(function(result){
            console.log(result);
            if(result.data.STATUS == 'OK'){
                if(checkEmptyField($scope.Data.AutoID)){
                    // window.location.href = '#/exam-set/update/' + result.data.DATA.AutoID;
                }else{
                    $scope.Data.AutoID = result.data.DATA.AutoID;
                    // window.location.href = '#/exam-set/update/' + result.data.DATA.AutoID;
                }
                $scope.goBack();
            }else{
                alert(result.data.DATA);
            }
            
            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.goBack = function(){
        window.location.href = '#/exam-set/manage/list';
    }

    $scope.Data = {
        "AutoID" : ""
          ,"ExamSetCode" : ""
          ,"TotalProposition" : ""
          ,"Years" : null
          ,"Months" : null
          ,"ExamSetStatus" : "processing" // Processing, Draft, TutorProcessing, TutorComplete, Release
          ,"SubjectCode" : null
          ,"LevelCode" : null
          ,"ExamSourceCode" : null
          ,"OwnerAccount" : $scope.currentUser.UserAccount
          ,"CreateDateTime" : ""
          ,"UpdateDateTime" : ""
          ,"FinishDateTime" : null
          ,"UpdateByUserAccount" : ""
    };

    $scope.MonthList = getMonthListTxt();
    $scope.YearList = getYearListTxt(50);

    $scope.loadSubjectList();
    $scope.loadLevelList();
    $scope.loadExamSourceList();

    if(checkEmptyField($scope.AutoID)){
        $scope.loadData($scope.AutoID);
    }
    IndexOverlayFactory.overlayHide();
});