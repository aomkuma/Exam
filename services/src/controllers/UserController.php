<?php

    namespace App\Controller;
    
    use App\Service\UserService;

    class UserController extends Controller {
        
        protected $logger;
        protected $db;
        
        public function __construct($logger, $db){
            $this->logger = $logger;
            $this->db = $db;
        }

        public function getAdminList($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                $condition = $obj['obj']['condition'];
                $currentPage = $obj['obj']['currentPage'];
                $limitRowPerPage = $obj['obj']['limitRowPerPage'];

                $Result = UserService::getAdminList($condition , $currentPage, $limitRowPerPage);  

                $DataList = $Result['DataList'];
                $Total = $Result['Total'];

                $this->data_result['DATA']['Total'] = $Total;  
                $this->data_result['DATA']['DataList'] = $DataList;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        public function getAdminData($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                $AutoID = $obj['obj']['AutoID'];

                $Data = UserService::getAdminData($AutoID);  
                unset($Data['UserPassword']);
                $this->data_result['DATA'] = $Data;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        public function updateAdminData($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                $Data = $obj['obj']['Data'];
                $SecretData = $obj['obj']['SecretData'];

                // check duplicate users
                $duplicate = UserService::checkDuplicate($Data['UserAccount'], $Data['AutoID']);

                if($duplicate){
                    $this->data_result['STATUS'] = 'ERROR';
                    $this->data_result['DATA'] = 'ชื่อผู้ใช้งานดังกล่าวไม่สามารถใช้งานได้';
                    return $this->returnResponse(200, $this->data_result, $response, false);
                    exit();
                }

                if(!empty($SecretData['NewPassword']) && !empty($SecretData['ConfirmNewPassword'])){
                    if($SecretData['NewPassword'] == $SecretData['ConfirmNewPassword']){
                        $Data['UserPassword'] = base64_encode($SecretData['NewPassword']);
                    }
                }

                $AutoID = UserService::updateAdminData($Data);  
                // unset($Data['UserPassword']);
                $this->data_result['DATA']['AutoID'] = $AutoID;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        public function getTutorList($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                $condition = $obj['obj']['condition'];
                $currentPage = $obj['obj']['currentPage'];
                $limitRowPerPage = $obj['obj']['limitRowPerPage'];

                $Result = UserService::getTutorList($condition , $currentPage, $limitRowPerPage);  

                $DataList = $Result['DataList'];
                $Total = $Result['Total'];

                $this->data_result['DATA']['Total'] = $Total;  
                $this->data_result['DATA']['DataList'] = $DataList;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        public function getTutorListApproval($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                $condition = $obj['obj']['condition'];
                $currentPage = $obj['obj']['currentPage'];
                $limitRowPerPage = $obj['obj']['limitRowPerPage'];

                $Result = UserService::getTutorListApproval($condition , $currentPage, $limitRowPerPage);  

                $DataList = $Result['DataList'];
                $Total = $Result['Total'];

                $this->data_result['DATA']['Total'] = $Total;  
                $this->data_result['DATA']['DataList'] = $DataList;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        public function getTutorData($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                $AutoID = $obj['obj']['AutoID'];

                $Data = UserService::getTutorData($AutoID);  
                unset($Data['UserPassword']);
                $this->data_result['DATA'] = $Data;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        public function searchTutorData($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                $TutorCode = $obj['obj']['TutorCode'];

                $Data = UserService::searchTutorData($TutorCode);  
                unset($Data['UserPassword']);
                $Data['UserAccount'] = '';
                $Data['CardID']=='             '?$Data['CardID'] = '':$Data['CardID']=$Data['CardID'];
                $Data['Mobile']=='          '?$Data['Mobile'] = '':$Data['Mobile']=$Data['Mobile'];

                $this->data_result['DATA'] = $Data;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        public function updateTutorData($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                $Data = $obj['obj']['Data'];
                $SecretData = $obj['obj']['SecretData'];

                // check duplicate users
                $duplicate = UserService::checkDuplicateTutorCode($Data['TutorCode'], $Data['AutoID']);

                if($duplicate){
                    $this->data_result['STATUS'] = 'ERROR';
                    $this->data_result['DATA'] = 'รหัส tutor ดังกล่าวไม่สามารถใช้งานได้';
                    return $this->returnResponse(200, $this->data_result, $response, false);
                    exit();
                }

                if(!empty($SecretData['NewPassword']) && !empty($SecretData['ConfirmNewPassword'])){
                    if($SecretData['NewPassword'] == $SecretData['ConfirmNewPassword']){
                        $Data['UserPassword'] = base64_encode($SecretData['NewPassword']);
                    }
                }

                $AutoID = UserService::updateTutorData($Data);  
                // unset($Data['UserPassword']);
                $this->data_result['DATA']['AutoID'] = $AutoID;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        public function approvalTutorData($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                $Data = $obj['obj']['Data'];

                // if($Data['UserStatus'] == ''){

                // }
                
                $AutoID = UserService::updateTutorData($Data);  
                // unset($Data['UserPassword']);
                $this->data_result['DATA']['AutoID'] = $AutoID;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        public function getTAList($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                $condition = $obj['obj']['condition'];
                $currentPage = $obj['obj']['currentPage'];
                $limitRowPerPage = $obj['obj']['limitRowPerPage'];

                $Result = UserService::getTAList($condition , $currentPage, $limitRowPerPage);  

                $DataList = $Result['DataList'];
                $Total = $Result['Total'];

                $this->data_result['DATA']['Total'] = $Total;  
                $this->data_result['DATA']['DataList'] = $DataList;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        public function getTAData($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                $AutoID = $obj['obj']['AutoID'];

                $Data = UserService::getTAData($AutoID);  
                unset($Data['UserPassword']);
                $this->data_result['DATA'] = $Data;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        public function updateTAData($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                $Data = $obj['obj']['Data'];
                $SecretData = $obj['obj']['SecretData'];

                // check duplicate users
                $duplicate = UserService::checkDuplicateTA($Data['ReportToTutorAccount'], $Data['UserAccount'], $Data['AutoID']);

                if($duplicate){
                    $this->data_result['STATUS'] = 'ERROR';
                    $this->data_result['DATA'] = 'ไม่สามารถเพิ่มข้อมูลได้ เนื่องจากมีข้อมูล TA นี้ในระบบแล้ว';
                    return $this->returnResponse(200, $this->data_result, $response, false);
                    exit();
                }

                if(!empty($SecretData['NewPassword']) && !empty($SecretData['ConfirmNewPassword'])){
                    if($SecretData['NewPassword'] == $SecretData['ConfirmNewPassword']){
                        $Data['UserPassword'] = base64_encode($SecretData['NewPassword']);
                    }
                }

                $AutoID = UserService::updateTAData($Data);  
                // unset($Data['UserPassword']);
                $this->data_result['DATA']['AutoID'] = $AutoID;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        private function diff($date1, $date2) {
            $to_time = strtotime($date2);
            $from_time = strtotime($date1);
            return round(abs($to_time - $from_time) / 60,2);
        }


    }
?>