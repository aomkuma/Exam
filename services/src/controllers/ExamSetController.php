<?php

    namespace App\Controller;
    
    use App\Service\ExamSetService;

    class ExamSetController extends Controller {
        
        protected $logger;
        protected $db;
        
        public function __construct($logger, $db){
            $this->logger = $logger;
            $this->db = $db;
        }

        public function getListManage($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                $condition = $obj['obj']['condition'];
                $currentPage = $obj['obj']['currentPage'];
                $limitRowPerPage = $obj['obj']['limitRowPerPage'];

                $Result = ExamSetService::getListManage($condition , $currentPage, $limitRowPerPage);  

                $DataList = $Result['DataList'];
                $Total = $Result['Total'];
                
                $this->data_result['DATA']['Total'] = $Total;  
                $this->data_result['DATA']['DataList'] = $DataList;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        public function getList($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                
                $DataList = ExamSetService::getList();  

                $this->data_result['DATA']['DataList'] = $DataList;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        public function getData($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                $user_session = $obj['user_session'];
                $AutoID = $obj['obj']['AutoID'];
                $ExamSetCode = $obj['obj']['ExamSetCode'];

                if(!empty($AutoID)){
                    $Data = ExamSetService::getData($AutoID);
                }else{
                    $Data = ExamSetService::getDataByCode($ExamSetCode);
                }

                $this->data_result['DATA'] = $Data;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        public function updateData($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                $user_session = $obj['user_session'];
                $Data = $obj['obj']['Data'];

                // Check duplicate data
                $duplicate = ExamSetService::checkDuplicate($Data['ExamSetCode'], $Data['AutoID']);

                if($duplicate){
                    $this->data_result['STATUS'] = 'ERROR';
                    $this->data_result['DATA'] = 'รหัสชุดข้อสอบซ้ำ';
                    return $this->returnResponse(200, $this->data_result, $response, false);
                    exit();
                }
                $AutoID = ExamSetService::updateData($Data);  

                $this->data_result['DATA']['AutoID'] = $AutoID;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        public function deleteData($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                
                $obj = $request->getParsedBody();
                $user_session = $obj['user_session'];
                $AutoID = $obj['obj']['AutoID'];

                $result = ExamSetService::removeData($AutoID);  

                $this->data_result['DATA']['result'] = $result;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }
    }