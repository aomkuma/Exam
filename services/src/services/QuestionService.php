<?php
    
    namespace App\Service;
    
    use App\Model\Question;
    
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

        public static function updateData($obj){
            if(empty($obj['AutoID'])){
            	$obj['CreateDateTime'] = date('Y-m-d H:i:s');
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                $model = Question::create($obj);
                return $model->AutoID;
            }else{
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                Question::where('AutoID', $obj['AutoID'])->update($obj);
                return $obj['AutoID'];
            }      
        }

        public static function removeData($AutoID){
            return Question::find($AutoID)->delete();      
        }

    }

?>