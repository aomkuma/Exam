<?php  

namespace App\Model;
class Subject extends \Illuminate\Database\Eloquent\Model {  
  	protected $table = 'Subjects';
  	protected $primaryKey = 'AutoID';
  	public $timestamps = false;
  	protected $fillable = array(
                  // "AutoID",
                  "SubjectCode"
                  ,"SubjectName"
                  ,"LevelID"
                  ,"CreateDateTime"
                  ,"UpdateDateTime"
                  ,"UpdateByUserAccount"
  				);
}