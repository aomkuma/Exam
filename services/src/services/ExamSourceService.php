<?php
    
    namespace App\Service;
    
    use App\Model\ExamSource;
    
    use Illuminate\Database\Capsule\Manager as DB;
    
    class ExamSourceService {

    	public static function getListManage($condition , $currentPage, $limitRowPerPage){

            $currentPage = $currentPage - 1;

            $limit = $limitRowPerPage;
            $offset = $currentPage;
            $skip = $offset * $limit;

            $totalRows = count(ExamSource::where(function($query) use ($condition){
                                if(!empty($condition['keyword'])){
                                    $query->where('SourceCode', 'LIKE', DB::raw("N'" . $condition['keyword'] . "'"));
                                    $query->orWhere('SourceName', 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                }
                            })->get());   

            $DataList =  ExamSource::where(function($query) use ($condition){
                                if(!empty($condition['keyword'])){
                                    $query->where('SourceCode', 'LIKE', DB::raw("N'" . $condition['keyword'] . "'"));
                                    $query->orWhere('SourceName', 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                }
                            })
	                        ->skip($skip)
	                        ->take($limit)
	                        ->get();

            return ['DataList'=>$DataList, 'Total' => $totalRows]; 

        }
        
        public static function getList(){
            return ExamSource::orderBy('SourceCode', 'ASC')->get();      
        }

        public static function getData($AutoID){
            return ExamSource::find($AutoID);      
        }

        public static function updateData($obj){
            if(empty($obj['AutoID'])){
            	// $obj['AutoID'] = intval($obj['ExamSourceCode']);
                // Generate AutoID
                $KeyID = ExamSourceService::generateKeyID();
                
                $Data = ExamSourceService::checkDuplicateKeyID($KeyID);
                while(!empty($Data)){
                    $KeyID = ExamSourceService::generateKeyID();
                    $Data = ExamSourceService::checkDuplicateKeyID($KeyID);
                }
                $obj['SourceID'] = $KeyID;
                $obj['CreateDateTime'] = date('Y-m-d H:i:s');
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                $model = ExamSource::create($obj);
                return $model->AutoID;
            }else{
                $AutoID = $obj['AutoID'];
                unset($obj['AutoID']);
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                ExamSource::where('AutoID', $AutoID)->update($obj);
                return $AutoID;
            }      
        }

        public static function removeData($AutoID){
            return ExamSource::find($AutoID)->delete();      
        }

        public static function checkDuplicateKeyID($KeyID){
            return ExamSource::where('SourceID', $KeyID)->first();
        }

        private static function generateKeyID(){
            return rand(10000000, 999999999);
        }

    }

?>