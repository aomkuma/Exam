<?php  

namespace App\Model;
class ExamSet extends \Illuminate\Database\Eloquent\Model {  
  	protected $table = 'ExamSets';
  	protected $primaryKey = 'AutoID';
  	public $timestamps = false;
  	protected $fillable = array(
                  // "AutoID"
                  "ExamSetCode"
                  ,"TotalProposition"
                  ,"Years"
                  ,"Months"
                  ,"ExamSetStatus"
                  ,"SubjectCode"
                  ,"LevelCode"
                  ,"ExamSourceCode"
                  ,"OwnerAccount"
                  ,"TutorCode"
                  ,"CreateDateTime"
                  ,"UpdateDateTime"
                  ,"FinishDateTime"
                  ,"UpdateByUserAccount"
  				);
}