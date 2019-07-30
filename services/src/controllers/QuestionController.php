<?php

    namespace App\Controller;
    
    use App\Service\QuestionService;

    class QuestionController extends Controller {
        
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
                $ExamSetCode = $obj['obj']['ExamSetCode'];
                
                $DataList = QuestionService::getListManage($ExamSetCode);  
                
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
                
                $DataList = QuestionService::getList();  

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

                $Data = QuestionService::getData($AutoID);  

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

                $Data['UpdateByUserAccount'] = $user_session['AutoID'];

                $AutoID = QuestionService::updateData($Data);  

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

                $result = QuestionService::removeData($AutoID);  

                $this->data_result['DATA']['result'] = $result;
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }
    }