<?php  

namespace App\Model;
class User extends \Illuminate\Database\Eloquent\Model {  
  	protected $table = 'Users';
  	protected $primaryKey = 'AutoID';
  	public $timestamps = false;
  	protected $fillable = array(
                  "AutoID",
                  "UserAccount"
                  ,"UserPassword"
                  ,"TutorCode"
                  ,"RegisterType"
                  ,"NickName"
                  ,"FirstName"
                  ,"LastName"
                  ,"CardID"
                  ,"CompanyName"
                  ,"CompanyOffice"
                  ,"CompanyAddress"
                  ,"Mobile"
                  ,"BankCode"
                  ,"BankAccType"
                  ,"BankAccName"
                  ,"BankAccNo"
                  ,"UserStatus"
                  ,"UserType"
                  ,"ReportToTutorAccount"
                  ,"TutorRegisterDateTime"
                  ,"TutorApproveDateTime"
                  ,"CreateDateTime"
                  ,"UpdateDateTime"
                  ,"UpdateByUserAccount"
  							);
}