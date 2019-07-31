angular.module('app').controller('QuestionUpdateController', function($scope, $compile, $cookies, $filter, $state, $routeParams, $uibModal, HTTPService, IndexOverlayFactory) {
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
    $scope.AutoID =  $routeParams.AutoID;

    var ckEditorConfig = {
            extraPlugins: 'uploadimage,filebrowser,colorbutton,eqneditor',
            height: 250,
            uploadUrl: '../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
            filebrowserBrowseUrl: '../ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: '../ckfinder/ckfinder.html?type=Images',
            filebrowserUploadUrl: '../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: '../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            contentsCss: [ CKEDITOR.basePath + 'contents.css', 'https://sdk.ckeditor.com/samples/assets/css/widgetstyles.css' ],
            image2_alignClasses: [ 'image-align-left', 'image-align-center', 'image-align-right' ],
            image2_disableResizer: true,
            height:'250px',
            toolbar : [
                { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                { name: 'Page', items: [ 'Page' ] },
                { name: 'EqnEditor', items: [ 'EqnEditor' ] }
                
            ]

        };


    $scope.getExamSetData = function(ExamSetCode){
        IndexOverlayFactory.overlayShow();
        
        var params = {'ExamSetCode' : ExamSetCode};

        HTTPService.clientRequest('exam-set/manage/get', params).then(function(result){
            console.log(result);
            $scope.ExamSetData = result.data.DATA;
            
            if(checkEmptyField($scope.AutoID)){
                $scope.loadData($scope.AutoID);
            }else{
                for(var i = 1; i <= 4; i++){
                    $scope.addChoice(i);
                }
            }

            if (CKEDITOR.instances.editor_question) CKEDITOR.instances.editor_question.destroy();

            CKEDITOR.config.extraPlugins = 'colorbutton,eqneditor';
            CKEDITOR.config.colorButton_enableAutomatic = false;

            CKEDITOR.replace( 'editor_question',ckEditorConfig );

            if (CKEDITOR.instances.editor_answer_desc) CKEDITOR.instances.editor_answer_desc.destroy();

            CKEDITOR.config.extraPlugins = 'colorbutton,eqneditor';
            CKEDITOR.config.colorButton_enableAutomatic = false;

            CKEDITOR.replace( 'editor_answer_desc',ckEditorConfig );

            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.loadData = function(AutoID){
        IndexOverlayFactory.overlayShow();
        
        var params = {'AutoID': AutoID};

        HTTPService.clientRequest('questions/manage/get', params).then(function(result){
            
            $scope.Data = result.data.DATA.Question;
            $scope.ChoiceList = result.data.DATA.ChoiceList;
            console.log($scope.ChoiceList);
            $scope.changeAnswer($scope.Data.CorrectChoiceID);
            // $scope.Data.CorrectChoiceID = parseInt($scope.Data.CorrectChoiceID);
            // $scope.Data.QuestionNo = parseInt($scope.Data.QuestionNo);

            console.log($scope.Data);
            if (CKEDITOR.instances.editor_question) CKEDITOR.instances.editor_question.destroy();

            CKEDITOR.config.extraPlugins = 'colorbutton,eqneditor';
            CKEDITOR.config.colorButton_enableAutomatic = false;

            CKEDITOR.replace( 'editor_question',ckEditorConfig );

            if (CKEDITOR.instances.editor_answer_desc) CKEDITOR.instances.editor_answer_desc.destroy();

            CKEDITOR.config.extraPlugins = 'colorbutton,eqneditor';
            CKEDITOR.config.colorButton_enableAutomatic = false;

            CKEDITOR.replace( 'editor_answer_desc',ckEditorConfig );

            IndexOverlayFactory.overlayHide();
        });
    }

    $scope.addChoice = function(index){
        $scope.ChoiceList.push({
                        'AutoID':''
                        ,'ChoiceNo':index
                        ,'ChoiceDescription':''
                        ,'ChoiceImageUrl':''
                        ,'QuestionID':$scope.Data.AutoID
                        ,'CreateDateTime':''
                        ,'UpdateDateTime':''
                        ,'UpdateByUserAccount':''
                    });
    }
    
    $scope.editChoice = function(ChoiceNo, index){
        console.log(ChoiceNo, index);
        $scope.Choice = $scope.ChoiceList[index];

        if (CKEDITOR.instances.editor_choice) CKEDITOR.instances.editor_choice.destroy();

        CKEDITOR.config.extraPlugins = 'colorbutton,eqneditor';
        CKEDITOR.config.colorButton_enableAutomatic = false;

        CKEDITOR.replace( 'editor_choice',ckEditorConfig );

        $scope.ShowChoiceDialog = true;
        
    }

    $scope.questionPreview = function(Data, ChoiceList){
        $scope.Data.QuestionDescription = CKEDITOR.instances.editor_question.getData();
        var modalInstance = $uibModal.open({
            animation : false,
            templateUrl : 'question-preview.html',
            size : 'lg',
            scope : $scope,
            controller : 'ModalDialogCtrl',
            resolve : {
                params : function() {
                    return {};
                } 
            },
        });

        modalInstance.result.then(function (valResult) {
            
        });
    }
    $scope.closeChoiceDialog = function(){
        $scope.Choice.ChoiceDescription = CKEDITOR.instances.editor_choice.getData();
        $scope.ShowChoiceDialog = false;
    }

    $scope.changeAnswer = function(ChoiceNo){
        $scope.AnswerHTML = null;
        for(var i = 0; i < $scope.ChoiceList.length; i++){
            if($scope.ChoiceList[i].ChoiceNo == ChoiceNo){
                $scope.AnswerHTML = $scope.ChoiceList[i].ChoiceDescription;
            }
        }
    }

    $scope.saveData = function(Data, ChoiceList){
        // Validate data

        /*if(CKEDITOR.instances.editor_question.getData() == ''){
            alert('กรุณาใส่รายละเอียดของโจทย์');
            return false;
        }

        var ChoiceError = false;
        for(var i = 0; i < ChoiceList.length; i++){
            var ChoiceDescription = ChoiceList[i].ChoiceDescription;
            if(ChoiceList[i].ChoiceDescription == ''){
                ChoiceError = true;
                break;
                
            }
        }

        if(ChoiceError){
            alert('กรุณาใส่รายละเอียดตัวเลือกข้อ ' + ChoiceList[i].ChoiceNo);
                return false;
        }*/


        $scope.alertMessage = 'ต้องการบันทึกข้อมูลโจทย์และตัวเลือกคำตอบข้อนี้ ใช่หรือไม่ ?';
        var modalInstance = $uibModal.open({
            animation : false,
            templateUrl : 'views/dialog_confirm.html',
            size : 'sm',
            scope : $scope,
            backdrop : 'static',
            controller : 'ModalDialogCtrl',
            resolve : {
                params : function() {
                    return {};
                } 
            },
        });

        modalInstance.result.then(function (valResult) {
            
            if(CKEDITOR.instances.editor_answer_desc.getData() != ''){
                Data.AnswerDescription = CKEDITOR.instances.editor_answer_desc.getData();
            }
            Data.QuestionDescription = CKEDITOR.instances.editor_question.getData();

            var params = {'Data' : Data, 'ChoiceList' : ChoiceList};
            HTTPService.uploadRequest('questions/manage/update', params).then(function(result){
                console.log(result);
                if(result.data.STATUS == 'OK'){
                    alert('บันทึกสำเร็จ');
                    window.location.href = '#/questions/manage/list/' + $scope.ExamSetCode;
                }else{
                    alert(result.data.DATA);
                }
                IndexOverlayFactory.overlayHide();
            });
        });

    }

    $scope.goBack = function(){
        window.location.href = '#/questions/manage/list/' + $scope.ExamSetCode;
    }

    $scope.AnswerHTML = null;
    $scope.ChoiceList = [];
    $scope.Data = {
        "AutoID" : ''
          ,"QuestionNo" : ''
          ,"QuestionType" : 'o' // s (objective, subjective)
          ,"QuestionDescription" : ''
          ,"AnswerDescription" : ""
          ,"VdoStatus" : 'N'
          ,"VdoUrl" : ""
          ,"Remark" : ""
          ,"RemarkVdoStatus" : 'N'
          ,"RemarkVdoUrl" : ""
          ,"HardLevel" : ''
          ,"Editable" : 1
          ,"ReleaseStatus" : 1
          ,"ExamSetCode" : $scope.ExamSetCode
          ,"TopicID" : ''
          ,"CorrectChoiceID" : ''
          ,"CreateDateTime" : ''
          ,"UpdateDateTime" : ''
          ,"UpdateByUserAccount" : ''
    };

    $scope.getExamSetData($scope.ExamSetCode);
    
});
