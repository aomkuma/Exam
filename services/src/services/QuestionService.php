<?php
    
    namespace App\Service;
    
    use App\Model\Question;
    use App\Model\Choice;

    use Illuminate\Database\Capsule\Manager as DB;
    
    class QuestionService {

    	public static function getListManage($ExamSetCode){
            return Question::where('ExamSetCode', $ExamSetCode)
                            ->orderBy('QuestionNo')
	                        ->get();
        }
        
        public static function getList(){
            return Question::orderBy('QuestionCode', 'ASC')->get();      
        }

        public static function getData($AutoID){
            return Question::find($AutoID);      
        }

        public static function getChoiceData($QuestionID){
            return Choice::where('QuestionID', $QuestionID)->get();      
        }

        public static function updateData($obj){
            $AutoID = $obj['AutoID'];
            unset($obj['AutoID']);
            
            if(empty($AutoID)){
            	$obj['CreateDateTime'] = date('Y-m-d H:i:s');
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                $model = Question::create($obj);
                return $model->AutoID;
            }else{
                // print_r($obj);
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                Question::where('AutoID', $AutoID)->update($obj);
                return $AutoID;
            }      
        }

        public static function updateChoiceData($obj){
            $AutoID = $obj['AutoID'];
            unset($obj['AutoID']);
            
            if(empty($AutoID)){

                $obj['CreateDateTime'] = date('Y-m-d H:i:s');
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                $model = Choice::create($obj);
                return $model->AutoID;
            }else{
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                Choice::where('AutoID', $AutoID)->update($obj);
                return $AutoID;
            }      
        }

        public static function removeData($AutoID){
            return Question::find($AutoID)->delete();      
        }

        public static function checkDuplicateKeyID($KeyID){
            return Question::find($KeyID);
        }

        private static function generateKeyID(){
            return rand(10000000000000, 99999999999999);
        }

        public static function checkDuplicateChoiceKeyID($KeyID){
            return Question::find($KeyID);
        }

    }

?>