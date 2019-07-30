<?php
    
    namespace App\Service;
    
    use App\Model\ExamSet;
    
    use Illuminate\Database\Capsule\Manager as DB;
    
    class ExamSetService {

    	public static function getListManage($condition , $currentPage, $limitRowPerPage){

            $currentPage = $currentPage - 1;

            $limit = $limitRowPerPage;
            $offset = $currentPage;
            $skip = $offset * $limit;

            $totalRows = count(ExamSet::where(function($query) use ($condition){
                                if(!empty($condition['keyword'])){
                                    $query->where('ExamSetCode', 'LIKE', DB::raw("N'" . $condition['keyword'] . "'"));
                                    // $query->orWhere('SourceName', 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                }
                            })->get());   

            $DataList =  ExamSet::select('ExamSets.*'
                                        , 'Subjects.SubjectName'
                                        , 'Levels.LevelName'
                                        , 'ExamSources.SourceName'
                                    )
                            ->join('Subjects', 'Subjects.SubjectCode', '=', 'ExamSets.SubjectCode')
                            ->join('Levels', 'Levels.LevelCode', '=', 'ExamSets.LevelCode')
                            ->join('ExamSources', 'ExamSources.SourceCode', '=', 'ExamSets.ExamSourceCode')
                            ->where(function($query) use ($condition){
                                if(!empty($condition['keyword'])){
                                    $query->where('ExamSetCode', 'LIKE', DB::raw("N'" . $condition['keyword'] . "'"));
                                    // $query->orWhere('SourceName', 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                }
                            })
	                        ->skip($skip)
	                        ->take($limit)
	                        ->get();

            return ['DataList'=>$DataList, 'Total' => $totalRows]; 

        }
        
        public static function getList(){
            return ExamSet::all();      
        }

        public static function getData($AutoID){
            return ExamSet::find($AutoID);      
        }

        public static function getDataByCode($ExamSetCode){
            return ExamSet::select('ExamSets.*'
                                        , 'Subjects.SubjectName'
                                        , 'Levels.LevelName'
                                        , 'ExamSources.SourceName'
                                    )
                        ->join('Subjects', 'Subjects.SubjectCode', '=', 'ExamSets.SubjectCode')
                        ->join('Levels', 'Levels.LevelCode', '=', 'ExamSets.LevelCode')
                        ->join('ExamSources', 'ExamSources.SourceCode', '=', 'ExamSets.ExamSourceCode')
                        ->where('ExamSetCode', $ExamSetCode)
                        ->first();      
        }

        public static function updateData($obj){
            if(empty($obj['AutoID'])){
            	// $obj['AutoID'] = intval($obj['ExamSetCode']);
                // Generate AutoID
                // $KeyID = ExamSetService::generateKeyID();
                
                // $Data = ExamSetService::checkDuplicateKeyID($KeyID);
                // while(!empty($Data)){
                //     $KeyID = ExamSetService::generateKeyID();
                //     $Data = ExamSetService::checkDuplicateKeyID($KeyID);
                // }
                // $obj['SourceID'] = $KeyID;
                $obj['CreateDateTime'] = date('Y-m-d H:i:s');
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                $model = ExamSet::create($obj);
                return $model->AutoID;
            }else{
                $AutoID = $obj['AutoID'];
                unset($obj['AutoID']);
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                ExamSet::where('AutoID', $AutoID)->update($obj);
                return $AutoID;
            }      
        }

        public static function removeData($AutoID){
            return ExamSet::find($AutoID)->delete();      
        }

        public static function checkDuplicate($KeyID, $AutoID = ''){
            $data = ExamSet::where('ExamSetCode', $KeyID)
                            ->where(function($query) use ($AutoID){
                                    if(!empty($AutoID)){
                                        $query->where('AutoID', '<>', $AutoID);
                                    }
                                })
                            ->first();
            return !(empty($data));
        }

        private static function generateKeyID(){
            return rand(10000000, 999999999);
        }

    }

?>