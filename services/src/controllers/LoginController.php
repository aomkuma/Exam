<?php

    namespace App\Controller;
    
    use App\Service\LoginService;

    class LoginController extends Controller {
        
        protected $logger;
        protected $db;
        
        public function __construct($logger, $db){
            $this->logger = $logger;
            $this->db = $db;
        }

        public function checkPermission($request, $response, $args){
    //         error_reporting(E_ERROR);
    // error_reporting(E_ALL);
    // ini_set('display_errors','On');
            try{
                $error_msg = '';

                $loginObj = $request->getParsedBody();
                $UserID = $loginObj['obj']['UserID'];
                
                // System login
                $permission = LoginService::checkPermission($UserID);    
                
                $this->logger->info($permission);
                if(!empty($permission)){
                    
                    $this->data_result['DATA']['result'] = true;
                    // $this->data_result['DATA']['MenuList'] = $menuList;
                }else{
                    $this->data_result['STATUS'] = 'ERROR';
                    $this->data_result['DATA'] = false;
                }
                
                return $this->returnResponse(200, $this->data_result, $response, false);
                
            }catch(\Exception $e){
                return $this->returnSystemErrorResponse($this->logger, $this->data_result, $e, $response);
            }
            
        }

        
        public function authenticate($request, $response, $args){
            // error_reporting(E_ERROR);
            // error_reporting(E_ALL);
            // ini_set('display_errors','On');
            try{
                // echo base64_encode('Aommy2806');exit;
                $error_msg = '';

                $loginObj = $request->getParsedBody();
                $username = $loginObj['obj']['Username'];
                $password = base64_encode($loginObj['obj']['Password']);
                
                $this->logger->info('Find by username : '. $username . " Password : " . $password);
                // System login
                $user = LoginService::authenticate($username , $password);    
                // exit;
                $this->logger->info($user);
                if(!empty($user[AutoID])){

                    if($user['UserStatus'] == 'active'){
                        unset($user[UserPassword]);
                        $this->data_result['DATA']['UserData'] = $user;

                        if($user['UserType'] == 'ta'){
                            // load tutor data by Tutor's UserAccount
                            $user['TutorData'] = LoginService::getTutorDataByUSerAccount($user['ReportToTutorAccount']);
                        }
                    }else{
                        
                        $this->data_result['STATUS'] = 'ERROR';
                        $this->data_result['DATA']['ErrorMsg'] = 'บัญชีผู้ใช้งานขอบคุณถูกระงับ กรุณาติดต่อผู้ดูแลระบบ';
                    }
                    
                    // unset($user[UserPassword]);
                    // $this->data_result['DATA']['UserData'] = $user;
                }else{
                    $this->data_result['STATUS'] = 'ERROR';
                    $this->data_result['DATA']['ErrorMsg'] = 'ไม่พบผู้ใช้งานนี้';
                }
                
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