<?php  

namespace App\Model;
class Topic extends \Illuminate\Database\Eloquent\Model {  
  	protected $table = 'Topics';
  	protected $primaryKey = 'AutoID';
  	public $timestamps = false;
  	protected $fillable = array(
                  // "AutoID",
                  "TopicID"
                  ,"TopicName"
                  ,"ChapterID"
                  ,"CreateDateTime"
                  ,"UpdateDateTime"
                  ,"UpdateByUserAccount"
  				);
}