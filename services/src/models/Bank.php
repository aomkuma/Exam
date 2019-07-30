<?php  

namespace App\Model;
class Bank extends \Illuminate\Database\Eloquent\Model {  
  	protected $table = 'Banks';
  	protected $primaryKey = 'AutoID';
  	public $timestamps = false;
  	protected $fillable = array(
                  "AutoID"
                  ,"BankCode"
                  ,"BankNameEN"
                  ,"BankNameTH"
  							);
}