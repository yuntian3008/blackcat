<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

//use App\Components\GoogleClient;
use App\Category;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $unicode = array(
    'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
    'd'=>'đ|Đ',
    'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
    'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
    'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
    'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
    'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    //protected $client;
    //public $imgProcess = new ImageProcessing();
    
    

    public function __construct(/*GoogleClient $client*/){
        //$this->imgProcess = "ok";//new ImageProcessing();
        //$this->client = $client->getClient();

        $categories = new Category;
        return view()->share('navbar_data', $categories->where('category_visible',1)->get());
    }

    public function sluger(String $str)
    {
    	$str = mb_strtolower($str,'UTF-8');
        foreach($this->unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }

        return str_replace(' ','-',trim($str));
    }

    /**
     * Image processing from base64 encoded image data
     *
     * @param string $img
     * @return string [Name of image]
     */
    // public function imageProcessing(String $img,String $path)
    // {
    //     $driveService = new \Google_Service_Drive($this->client);
    //     $imageName = time().'_'.random_int(0, 1000).'_'.$path;
    //     $fileid = [];
    //     $mode = [
    //         0 => [
    //             'key' => 'bg',
    //             'x' => 640,
    //             'y' => 480,
    //         ],
    //         1 => [
    //             'key' => 'sm',
    //             'x' => 320,
    //             'y' => 240,
    //         ]
    //     ]; //size lon va be
    //     foreach ($mode as $val) {

    //         $image = \Image::make($img);
    //         $image->resize($val['x'], $val['y'], function ($constraint) {
    //                         $constraint->aspectRatio();
    //                     });
    //         $image->encode('jpg',90);
    //         try
    //         {
    //             $fileMetadata = new \Google_Service_Drive_DriveFile([
    //                 'name' => $val['key'].'_'.$imageName.'.jpg',
    //                 'parents' => array('1A-XQE5sffAh6JP30Hghy7ZqMmV71K47-'),
    //             ]);
    //             $file = $driveService->files->create($fileMetadata, [
    //                 'data' => $image,
    //                 'uploadType' => 'multipart',
    //                 'fields' => 'id',
    //             ]);

    //                 // bắt đầu phân quyền
    //             $driveService->getClient()->setUseBatch(true);

    //             try
    //             {
    //                 $batch = $driveService->createBatch();
    //                 $userPermission = new \Google_Service_Drive_Permission([
    //                     //dành cho mọi người
    //                     'type' => 'anyone', // user | group | domain | anyone
    //                     // và chỉ được quyền xem
    //                     'role' => 'reader', // organizer | owner | writer | commenter | reader
    //                 ]);
    //                 $request = $driveService->permissions->create($file->id, $userPermission, ['fields' => 'id']);
    //                 $batch->add($request, 'user');
    //                 $results = $batch->execute();

    //             } catch (\Exception $e) {
    //                 return 'fail-permission';
    //             } finally {
    //                 $driveService->getClient()->setUseBatch(false);
    //             }
    //             array_push($fileid, array($val['key'] => $file->id));
    //         }
    //         catch (\Exception $e) {
    //             return 'fail-upload';
    //         }
    //     }

    //     return json_encode($fileid);

    //     // Storage::disk('local')->put('public/'.$path.'/lg_'.$imageName.'.jpg', $big);
    //     // Storage::disk('local')->put('public/'.$path.'/sm_'.$imageName.'.jpg', $small);
        
    // }

}
