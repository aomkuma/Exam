<?php
    
    namespace App\Service;
    
    use App\Model\User;
    
    use Illuminate\Database\Capsule\Manager as DB;
    
    class UserService {
        
        public static function getAdminList($condition , $currentPage, $limitRowPerPage){

            $currentPage = $currentPage - 1;

            $limit = $limitRowPerPage;
            $offset = $currentPage;
            $skip = $offset * $limit;

            $totalRows = count(User::where('UserType', 'admin')
                            ->where(function($query) use ($condition){
                                if(!empty($condition['keyword'])){
                                    $query->where('NickName', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                                    $query->orWhere(DB::raw("CONCAT(FirstName, ' ', LastName)"), 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                    $query->orWhere('UserAccount', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                                }
                            })->get());   

            $DataList =  User::select("AutoID"
                                  ,"UserAccount"
                                  ,"TutorCode"
                                  ,"RegisterType"
                                  ,"NickName"
                                  ,"FirstName"
                                  ,"LastName"
                                  ,"CardID"
                                  ,"Mobile"
                                  ,"BankCode"
                                  ,"BankAccType"
                                  ,"BankAccName"
                                  ,"BankAccNo"
                                  ,"UserStatus"
                                  ,"UserType"
                                  ,"ReportToTutorAccount"
                                  ,"CreateDateTime"
                                  ,"UpdateDateTime"
                                  ,"UpdateByUserAccount")
                        ->where('UserType', 'admin')
                        ->where(function($query) use ($condition){
                            if(!empty($condition['keyword'])){
                                $query->where('NickName', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                                $query->orWhere(DB::raw("CONCAT(FirstName, ' ', LastName)"), 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                $query->orWhere('UserAccount', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                            }
                        })
                        ->skip($skip)
                        ->take($limit)
                        ->get();

            return ['DataList'=>$DataList, 'Total' => $totalRows]; 

        }

        public static function checkDuplicate($UserAccount, $AutoID = ''){
            $data = User::where('UserAccount', $UserAccount)
                        ->where(function($query) use ($AutoID){
                            if(!empty($AutoID)){
                                $query->where('AutoID', '<>', $AutoID);
                            }
                        })->first();
            return !(empty($data));
        }

        public static function getAdminData($AutoID){
            return User::find($AutoID);
        }

        public static function updateAdminData($obj){
            if(empty($obj['AutoID'])){
                
                // Generate AutoID
                $KeyID = UserService::generateKeyID();
                
                $Data = UserService::checkDuplicateKeyID($KeyID);
                while(!empty($Data)){
                    $KeyID = UserService::generateKeyID();
                    $Data = UserService::checkDuplicateKeyID($KeyID);
                }

                $obj['AutoID'] = $KeyID;
                $obj['ReportToTutorAccount'] = NULL;
                $obj['CreateDateTime'] = date('Y-m-d H:i:s');
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                $model = User::create($obj);
                return $model->AutoID;
            }else{
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                User::where('AutoID', $obj['AutoID'])->update($obj);
                return $obj['AutoID'];
            }
        }

        public static function getTutorList($condition , $currentPage, $limitRowPerPage){

            $currentPage = $currentPage - 1;

            $limit = $limitRowPerPage;
            $offset = $currentPage;
            $skip = $offset * $limit;

            $totalRows = count(User::where('UserType', 'tutor')
                            ->where(function($query) use ($condition){
                                if(!empty($condition['keyword'])){
                                    $query->where('NickName', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                                    $query->orWhere('TutorCode', 'LIKE', DB::raw("N'" . $condition['keyword'] . "'"));
                                    $query->orWhere(DB::raw("CONCAT(FirstName, ' ', LastName)"), 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                    $query->orWhere('UserAccount', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                                }
                            })->get());   

            $DataList =  User::select("AutoID"
                                  ,"UserAccount"
                                  ,"TutorCode"
                                  ,"RegisterType"
                                  ,"NickName"
                                  ,"FirstName"
                                  ,"LastName"
                                  ,"CardID"
                                  ,"Mobile"
                                  ,"BankCode"
                                  ,"BankAccType"
                                  ,"BankAccName"
                                  ,"BankAccNo"
                                  ,"UserStatus"
                                  ,"UserType"
                                  ,"ReportToTutorAccount"
                                  ,"CreateDateTime"
                                  ,"UpdateDateTime"
                                  ,"UpdateByUserAccount")
                        ->where('UserType', 'tutor')
                        ->where(function($query) use ($condition){
                            if(!empty($condition['keyword'])){
                                $query->where('NickName', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                                $query->orWhere('TutorCode', 'LIKE', DB::raw("N'" . $condition['keyword'] . "'"));
                                $query->orWhere(DB::raw("CONCAT(FirstName, ' ', LastName)"), 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                $query->orWhere('UserAccount', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                            }
                        })
                        ->skip($skip)
                        ->take($limit)
                        ->get();

            return ['DataList'=>$DataList, 'Total' => $totalRows]; 

        }

        public static function getTutorListApproval($condition , $currentPage, $limitRowPerPage){

            $currentPage = $currentPage - 1;

            $limit = $limitRowPerPage;
            $offset = $currentPage;
            $skip = $offset * $limit;

            $totalRows = count(User::join('Subjects', 'Subjects.SubjectCode', '=', 'Users.SubjectCode')
                            ->where('UserType', 'tutor')
                            ->where(function($query) use ($condition){
                                if(!empty($condition['keyword'])){
                                    $query->where('NickName', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                                    $query->orWhere('TutorCode', 'LIKE', DB::raw("N'" . $condition['keyword'] . "'"));
                                    $query->orWhere(DB::raw("CONCAT(FirstName, ' ', LastName)"), 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                    $query->orWhere('UserAccount', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                                    $query->orWhere('Mobile', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                                    $query->orWhere('Subjects.SubjectCode', 'LIKE', DB::raw("N'" . $condition['keyword'] . "'"));
                                    $query->orWhere('Subjects.SubjectName', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                                }
                            })
                            ->whereNotNull('TutorRegisterDateTime')
                            ->get());   

            $DataList =  User::select("Users.AutoID"
                                  ,"UserAccount"
                                  ,"TutorCode"
                                  ,"RegisterType"
                                  ,"NickName"
                                  ,"FirstName"
                                  ,"LastName"
                                  ,"CardID"
                                  ,"Mobile"
                                  ,"CompanyName"
                                  ,"UserStatus"
                                  ,"ReportToTutorAccount"
                                  ,"TutorRegisterDateTime"
                                  ,"Subjects.SubjectCode"
                                  ,"Subjects.SubjectName"
                              )
                        ->join('Subjects', 'Subjects.SubjectCode', '=', 'Users.SubjectCode')
                        ->where('UserType', 'tutor')
                        ->where(function($query) use ($condition){
                            if(!empty($condition['keyword'])){
                                $query->where('NickName', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                                $query->orWhere('TutorCode', 'LIKE', DB::raw("N'" . $condition['keyword'] . "'"));
                                $query->orWhere(DB::raw("CONCAT(FirstName, ' ', LastName)"), 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                $query->orWhere('UserAccount', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                                $query->orWhere('Mobile', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                                $query->orWhere('Subjects.SubjectCode', 'LIKE', DB::raw("N'" . $condition['keyword'] . "'"));
                                $query->orWhere('Subjects.SubjectName', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                            }
                        })
                        ->whereNotNull('TutorRegisterDateTime')
                        ->skip($skip)
                        ->take($limit)
                        ->get();

            return ['DataList'=>$DataList, 'Total' => $totalRows]; 

        }

        public static function checkDuplicateTutorCode($TutorCode, $AutoID = ''){
            $data = User::where('TutorCode', $TutorCode)
                        ->where(function($query) use ($AutoID){
                            if(!empty($AutoID)){
                                $query->where('AutoID', '<>', $AutoID);
                            }
                        })->first();
            return !(empty($data));
        }

        public static function getTutorData($AutoID){
            return User::find($AutoID);
        }

        public static function searchTutorData($TutorCode){
            return User::where('TutorCode', $TutorCode)
                    ->where('UserStatus', 'inactive')
                    ->whereNull('SubjectCode')
                    ->first();
        }

        public static function updateTutorData($obj){
            if(empty($obj['AutoID'])){

                // Generate AutoID
                $KeyID = UserService::generateKeyID();
                
                $Data = UserService::checkDuplicateKeyID($KeyID);
                while(!empty($Data)){
                    $KeyID = UserService::generateKeyID();
                    $Data = UserService::checkDuplicateKeyID($KeyID);
                }

                // Generate UserAccount
                $UserAccount = UserService::generateUserAccount();
                $UserAccount = ''.$UserAccount;
                $Account = UserService::checkDuplicateUserAccount($UserAccount);
                // print_r($Account);
                // exit;
                while(!empty($Account)){
                    $UserAccount = UserService::generateUserAccount();
                    $UserAccount = ''.$UserAccount;
                    $Account = UserService::checkDuplicateUserAccount($UserAccount);
                }

                // Generate UserPassword
                $UserPassword = UserService::generateUserPassword();

                $obj['AutoID'] = $KeyID;
                $obj['UserAccount'] = base64_encode($UserAccount);
                $obj['UserPassword'] = base64_encode($UserPassword);
                $obj['ReportToTutorAccount'] = NULL;
                $obj['CreateDateTime'] = date('Y-m-d H:i:s');
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                // print_r($obj);exit;
                $model = User::create($obj);
                return $KeyID/*$model->AutoID*/;
            }else{
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                User::where('AutoID', $obj['AutoID'])->update($obj);
                return $obj['AutoID'];
            }
        }

        public static function getTAList($condition , $currentPage, $limitRowPerPage){

            $currentPage = $currentPage - 1;

            $limit = $limitRowPerPage;
            $offset = $currentPage;
            $skip = $offset * $limit;

            $totalRows = count(User::where('UserType', 'ta')
                            ->where('ReportToTutorAccount', $condition['ReportToTutorAccount'])
                        
                            ->where(function($query) use ($condition){
                                if(!empty($condition['keyword'])){
                                    $query->where('NickName', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                                    $query->orWhere(DB::raw("CONCAT(FirstName, ' ', LastName)"), 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                    $query->orWhere('UserAccount', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                                }
                            })->get());   

            $DataList =  User::select("AutoID"
                                  ,"UserAccount"
                                  ,"TutorCode"
                                  ,"RegisterType"
                                  ,"NickName"
                                  ,"FirstName"
                                  ,"LastName"
                                  ,"CardID"
                                  ,"Mobile"
                                  ,"BankCode"
                                  ,"BankAccType"
                                  ,"BankAccName"
                                  ,"BankAccNo"
                                  ,"UserStatus"
                                  ,"UserType"
                                  ,"ReportToTutorAccount"
                                  ,"CreateDateTime"
                                  ,"UpdateDateTime"
                                  ,"UpdateByUserAccount")
                        ->where('UserType', 'ta')
                        ->where('ReportToTutorAccount', $condition['ReportToTutorAccount'])
                        ->where(function($query) use ($condition){
                            if(!empty($condition['keyword'])){
                                $query->where('NickName', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                                $query->orWhere(DB::raw("CONCAT(FirstName, ' ', LastName)"), 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                $query->orWhere('UserAccount', 'LIKE', DB::raw("N'" . $condition['keyword'] . "%'"));
                            }
                        })
                        ->skip($skip)
                        ->take($limit)
                        ->get();

            return ['DataList'=>$DataList, 'Total' => $totalRows]; 

        }

        public static function getTAData($AutoID){
            return User::find($AutoID);
        }

        public static function checkDuplicateTA($ReportToTutorAccount, $UserAccount, $AutoID){
            return User::where('UserType', 'ta')
                        ->where('ReportToTutorAccount', $ReportToTutorAccount)
                        ->where(function($query) use ($AutoID){
                            if(!empty($AutoID)){
                                $query->where('AutoID', '<>', $AutoID);
                            }
                        })
                        ->first();
        }

        public static function updateTAData($obj){
            if(empty($obj['AutoID'])){

                // Generate AutoID
                $KeyID = UserService::generateKeyID();
                
                $Data = UserService::checkDuplicateKeyID($KeyID);
                while(!empty($Data)){
                    $KeyID = UserService::generateKeyID();
                    $Data = UserService::checkDuplicateKeyID($KeyID);
                }

                $obj['AutoID'] = $KeyID;
                // $obj['UserAccount'] = base64_encode($UserAccount);
                // $obj['UserPassword'] = base64_encode($obj['UserPassword']);
                // $obj['ReportToTutorAccount'] = NULL;
                $obj['CreateDateTime'] = date('Y-m-d H:i:s');
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                // print_r($obj);exit;
                $model = User::create($obj);
                return $KeyID/*$model->AutoID*/;
            }else{
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                User::where('AutoID', $obj['AutoID'])->update($obj);
                return $obj['AutoID'];
            }
        }
        
        public static function checkDuplicateKeyID($KeyID){
            return User::find($KeyID);
        }

        public static function checkDuplicateUserAccount($UserAccount){
            return User::where('UserAccount', $UserAccount)->first();
        }

        private static function generateKeyID(){
            return rand(10000000000000, 99999999999999);
        }

        private static function generateUserAccount(){
            return rand(100000, 999999);
        }

        private static function generateUserPassword(){
            return rand(10000000, 99999999);
        }
    }

?>