<?php
    
    namespace App\Service;
    
    use App\Model\User;
    
    use Illuminate\Database\Capsule\Manager as DB;
    
    class LoginService {
        
        public static function checkPermission($UserID){
            return AccountRole::where('UserID', $UserID)->where('actives', 'Y')->first();      
        }

        public static function authenticate($username , $password){
            return User::where('UserAccount', $username)->where('UserPassword',$password)->first();      
        }

        public static function getTutorDataByUSerAccount($UserAccount){
            return User::select("Users.*", "Subjects.SubjectName")
                    ->join("Subjects", "Users.SubjectCode", '=', 'Subjects.SubjectCode')
                    ->where('UserAccount', $UserAccount)
                    ->first();      
        }
    }

?>