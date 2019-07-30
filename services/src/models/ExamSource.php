<?php  

namespace App\Model;
class ExamSource extends \Illuminate\Database\Eloquent\Model {  
  	protected $table = 'ExamSources';
  	protected $primaryKey = 'AutoID';
  	public $timestamps = false;
  	protected $fillable = array(
                  // "AutoID"
                  "SourceCode"
                  ,"SourceName"
                  ,"SourceID"
                  ,"CreateDateTime"
                  ,"UpdateDateTime"
                  ,"UpdateByUserAccount"
  				);
}