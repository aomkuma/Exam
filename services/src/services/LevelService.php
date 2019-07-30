<?php
    
    namespace App\Service;
    
    use App\Model\Level;
    
    use Illuminate\Database\Capsule\Manager as DB;
    
    class LevelService {

    	public static function getListManage($condition , $currentPage, $limitRowPerPage){

            $currentPage = $currentPage - 1;

            $limit = $limitRowPerPage;
            $offset = $currentPage;
            $skip = $offset * $limit;

            $totalRows = count(Level::where(function($query) use ($condition){
                                if(!empty($condition['keyword'])){
                                    $query->where('LevelCode', 'LIKE', DB::raw("N'" . $condition['keyword'] . "'"));
                                    $query->orWhere('LevelName', 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                }
                            })->get());   

            $DataList =  Level::where(function($query) use ($condition){
                                if(!empty($condition['keyword'])){
                                    $query->where('LevelCode', 'LIKE', DB::raw("N'" . $condition['keyword'] . "'"));
                                    $query->orWhere('LevelName', 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                }
                            })
	                        ->skip($skip)
	                        ->take($limit)
	                        ->get();

            return ['DataList'=>$DataList, 'Total' => $totalRows]; 

        }
        
        public static function getList(){
            return Level::orderBy('LevelCode', 'ASC')->get();      
        }

        public static function getData($AutoID){
            return Level::find($AutoID);      
        }

        public static function updateData($obj){
            if(empty($obj['AutoID'])){
            	// $obj['AutoID'] = intval($obj['LevelCode']);
                // Generate AutoID
                $KeyID = LevelService::generateKeyID();
                
                $Data = LevelService::checkDuplicateKeyID($KeyID);
                while(!empty($Data)){
                    $KeyID = LevelService::generateKeyID();
                    $Data = LevelService::checkDuplicateKeyID($KeyID);
                }
                $obj['LevelID'] = $KeyID;
                $obj['CreateDateTime'] = date('Y-m-d H:i:s');
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                $model = Level::create($obj);
                return $model->AutoID;
            }else{
                $AutoID = $obj['AutoID'];
                unset($obj['AutoID']);
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                Level::where('AutoID', $AutoID)->update($obj);
                return $AutoID;
            }      
        }

        public static function removeData($AutoID){
            return Level::find($AutoID)->delete();      
        }

        public static function checkDuplicateKeyID($KeyID){
            return Level::where('LevelID', $KeyID)->first();
        }

        private static function generateKeyID(){
            return rand(10000000, 999999999);
        }

    }

?>