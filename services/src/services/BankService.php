<?php
    
    namespace App\Service;
    
    use App\Model\Bank;
    
    use Illuminate\Database\Capsule\Manager as DB;
    
    class BankService {
        
        public static function getList(){
            return Bank::all();      
        }

    }

?>