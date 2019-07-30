<?php  

namespace App\Model;
class Question extends \Illuminate\Database\Eloquent\Model {  
  	protected $table = 'Questions';
  	protected $primaryKey = 'AutoID';
  	public $timestamps = false;
  	protected $fillable = array(
                  // "AutoID",
                  "QuestionID"
                  ,"QuestionNo"
                  ,"QuestionType"
                  ,"QuestionDescription"
                  ,"AnswerDescription"
                  ,"VdoStatus"
                  ,"VdoUrl"
                  ,"Remark"
                  ,"RemarkVdoStatus"
                  ,"RemarkVdoUrl"
                  ,"HardLevel"
                  ,"Editable"
                  ,"ReleaseStatus"
                  ,"ExamSetCode"
                  ,"TopicID"
                  ,"CorrectChoiceID"
                  ,"CreateDateTime"
                  ,"UpdateDateTime"
                  ,"UpdateByUserAccount"
  				);
}