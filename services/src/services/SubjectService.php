<?php
    
    namespace App\Service;
    
    use App\Model\Subject;
    
    use Illuminate\Database\Capsule\Manager as DB;
    
    class SubjectService {

    	public static function getListManage($condition , $currentPage, $limitRowPerPage){

            $currentPage = $currentPage - 1;

            $limit = $limitRowPerPage;
            $offset = $currentPage;
            $skip = $offset * $limit;

            $totalRows = count(Subject::where(function($query) use ($condition){
                                if(!empty($condition['keyword'])){
                                    $query->where('SubjectCode', 'LIKE', DB::raw("N'" . $condition['keyword'] . "'"));
                                    $query->orWhere('SubjectName', 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                }
                            })->get());   

            $DataList =  Subject::where(function($query) use ($condition){
                                if(!empty($condition['keyword'])){
                                    $query->where('SubjectCode', 'LIKE', DB::raw("N'" . $condition['keyword'] . "'"));
                                    $query->orWhere('SubjectName', 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                }
                            })
	                        ->skip($skip)
	                        ->take($limit)
	                        ->get();

            return ['DataList'=>$DataList, 'Total' => $totalRows]; 

        }
        
        public static function getList(){
            return Subject::orderBy('SubjectCode', 'ASC')->get();      
        }

        public static function getData($AutoID){
            return Subject::find($AutoID);      
        }

        public static function updateData($obj){
            if(empty($obj['AutoID'])){
            	$obj['AutoID'] = intval($obj['SubjectCode']);
                $obj['LevelID'] = 2;
                $obj['CreateDateTime'] = date('Y-m-d H:i:s');
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                $model = Subject::create($obj);
                return intval($obj['SubjectCode'])/*$model->AutoID*/;
            }else{
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                Subject::where('AutoID', $obj['AutoID'])->update($obj);
                return $obj['AutoID'];
            }      
        }

        public static function removeData($AutoID){
            return Subject::find($AutoID)->delete();      
        }

    }

?>