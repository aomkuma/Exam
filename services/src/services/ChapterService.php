<?php
    
    namespace App\Service;
    
    use App\Model\Chapter;
    
    use Illuminate\Database\Capsule\Manager as DB;
    
    class ChapterService {

    	public static function getListManage($SubjectCode, $condition , $currentPage, $limitRowPerPage){

            $currentPage = $currentPage - 1;

            $limit = $limitRowPerPage;
            $offset = $currentPage;
            $skip = $offset * $limit;

            $totalRows = count(Chapter::where(function($query) use ($condition){
                                if(!empty($condition['keyword'])){
                                    $query->where('ChapterName', 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                    // $query->orWhere('ChapterName', 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                }
                            })
                        ->where('SubjectCode', $SubjectCode)
                        ->get());   

            $DataList =  Chapter::where(function($query) use ($condition){
                                if(!empty($condition['keyword'])){
                                    $query->where('ChapterName', 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                    // $query->orWhere('ChapterName', 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                }
                            })
                            ->where('SubjectCode', $SubjectCode)
	                        ->skip($skip)
	                        ->take($limit)
	                        ->get();

            return ['DataList'=>$DataList, 'Total' => $totalRows]; 

        }
        
        public static function getList($SubjectCode){
            return Chapter::where('SubjectCode', $SubjectCode)->get();      
        }

        public static function getData($AutoID){
            return Chapter::find($AutoID);      
        }

        public static function updateData($obj){
            if(empty($obj['AutoID'])){
            	$KeyID = ChapterService::generateKeyID();
                
                $Data = ChapterService::checkDuplicateKeyID($KeyID);
                while(!empty($Data)){
                    $KeyID = ChapterService::generateKeyID();
                    $Data = ChapterService::checkDuplicateKeyID($KeyID);
                }
                $obj['ChapterID'] = $KeyID;
                $obj['CreateDateTime'] = date('Y-m-d H:i:s');
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                $model = Chapter::create($obj);
                return intval($obj['AutoID'])/*$model->AutoID*/;
            }else{
                $AutoID = $obj['AutoID'];
                unset($obj['AutoID']);
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                Chapter::where('AutoID', $AutoID)->update($obj);
                return $AutoID;
            }      
        }

        public static function removeData($AutoID){
            return Chapter::find($AutoID)->delete();      
        }

        public static function checkDuplicateKeyID($KeyID){
            return Chapter::where('ChapterID', $KeyID)->first();
        }

        private static function generateKeyID(){
            return rand(10000000, 999999999);
        }

    }

?>