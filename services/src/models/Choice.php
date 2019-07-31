<?php  

namespace App\Model;
class Choice extends \Illuminate\Database\Eloquent\Model {  
  	protected $table = 'Choices';
  	protected $primaryKey = 'AutoID';
  	public $timestamps = false;
  	protected $fillable = array(
                  // "AutoID"
                  "ChoiceNo"
                  ,"ChoiceDescription"
                  ,"ChoiceImageUrl"
                  ,"QuestionID"
                  ,"CreateDateTime"
                  ,"UpdateDateTime"
                  ,"UpdateByUserAccount"
  				);
}