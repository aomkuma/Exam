<?php  

namespace App\Model;
class Chapter extends \Illuminate\Database\Eloquent\Model {  
  	protected $table = 'Chapters';
  	protected $primaryKey = 'AutoID';
  	public $timestamps = false;
  	protected $fillable = array(
                  // "AutoID",
                  "ChapterID"
                  ,"ChapterName"
                  ,"SubjectCode"
                  ,"CreateDateTime"
                  ,"UpdateDateTime"
                  ,"UpdateByUserAccount"
  				);
}