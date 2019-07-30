<?php  

namespace App\Model;
class Level extends \Illuminate\Database\Eloquent\Model {  
  	protected $table = 'Levels';
  	protected $primaryKey = 'AutoID';
  	public $timestamps = false;
  	protected $fillable = array(
                  // "AutoID"
                  "LevelCode"
                  ,"LevelName"
                  ,"LevelID"
                  ,"CreateDateTime"
                  ,"UpdateDateTime"
                  ,"UpdateByUserAccount"
  				);
}