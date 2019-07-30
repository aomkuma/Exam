<?php
    
    namespace App\Service;
    
    use App\Model\Topic;
    
    use Illuminate\Database\Capsule\Manager as DB;
    
    class TopicService {

    	public static function getListManage($ChapterID, $condition , $currentPage, $limitRowPerPage){

            $currentPage = $currentPage - 1;

            $limit = $limitRowPerPage;
            $offset = $currentPage;
            $skip = $offset * $limit;

            $totalRows = count(Topic::where(function($query) use ($condition){
                                if(!empty($condition['keyword'])){
                                    $query->where('TopicName', 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                    // $query->orWhere('TopicName', 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                }
                            })
                        ->where('ChapterID', $ChapterID)
                        ->get());   

            $DataList =  Topic::where(function($query) use ($condition){
                                if(!empty($condition['keyword'])){
                                    $query->where('TopicName', 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                    // $query->orWhere('TopicName', 'LIKE', DB::raw("N'%" . $condition['keyword'] . "%'"));
                                }
                            })
                            ->where('ChapterID', $ChapterID)
	                        ->skip($skip)
	                        ->take($limit)
	                        ->get();

            return ['DataList'=>$DataList, 'Total' => $totalRows]; 

        }
        
        public static function getList($ChapterID){
            return Topic::where('ChapterID', $ChapterID)->get();      
        }

        public static function getData($AutoID){
            return Topic::find($AutoID);      
        }

        public static function updateData($obj){
            if(empty($obj['AutoID'])){
            	$KeyID = TopicService::generateKeyID();
                
                $Data = TopicService::checkDuplicateKeyID($KeyID);
                while(!empty($Data)){
                    $KeyID = TopicService::generateKeyID();
                    $Data = TopicService::checkDuplicateKeyID($KeyID);
                }
                $obj['TopicID'] = $KeyID;
                $obj['CreateDateTime'] = date('Y-m-d H:i:s');
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                $model = Topic::create($obj);
                return $model->AutoID;
            }else{
                $AutoID = $obj['AutoID'];
                unset($obj['AutoID']);
                $obj['UpdateDateTime'] = date('Y-m-d H:i:s');
                Topic::where('AutoID', $AutoID)->update($obj);
                return $AutoID;
            }      
        }

        public static function removeData($AutoID){
            return Topic::find($AutoID)->delete();      
        }

        public static function checkDuplicateKeyID($KeyID){
            return Topic::where('TopicID', $KeyID)->first();
        }

        private static function generateKeyID(){
            return rand(10000000, 999999999);
        }

    }

?>