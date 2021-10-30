<?php

namespace App\Components\Helper;

/**
 * Class ImageProcessing
 * @package App\Components\Helper
 */

use Illuminate\Support\Facades\Storage;

class ImageProcessing
{
	/**
	 * @var Array [Config of ImageProcessing]
	 */
	protected $config;

	public function __construct()
	{
		$this->config = config('image-processing');
	}

	/**
	 * Image processing from base64 encoded image data
	 * @param  String $img [base64]
	 * @param  String $size [name of size on config]
	 * @param  String $key [keyword of image]
	 * @return String      [name of image]
	 */
	public function run(Object $img, String $key)
	{
		$name = $this->createName($key);
		$format = $this->config['format'];
		$resolution = $this->config['resolution'];	
		$location = $this->config['storage_location'];
		foreach ($resolution as $value) {
			$image = $this->createImage($img,$format,$value['x'], $value['y']);
			switch ($location) {
				case 'local':
					Storage::disk('public')->put($value['key'].'_'.$name.'.'.$format,$image);
					break;
				case 'gdrive':
					Storage::cloud()->put($value['key'].'_'.$name.'.'.$format, $image);
					break;
				default:
					break;
			}
		}
		return $name;
	}

	public static function getURL(String $name,String $size)
	{
		$config = config('image-processing');
		switch ($config['storage_location']) {
			case 'local':
				return Storage::url('public/'.$size.'_'.$name.'.png');
				break;
			case 'gdrive':
				$filename = $size.'_'.$name.'.png';
				$dir = '/';
				$recursive = false; // Có lấy file trong các thư mục con không?
				$contents = collect(Storage::cloud()->listContents($dir, $recursive));
				$file = $contents
				->where('type', '=', 'file')
				->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
				->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
				->first(); // có thể bị trùng tên file với nhau!
				if (is_null($file['path']))
					return "";
				return Storage::cloud()->url($file['path']);
				break;
			default:
				break;
		}
	}

	protected function createName(String $key)
	{
		return time().'_'.random_int(0, 1000).'_'.$key;
	}

	protected function createImage(String $img,String $format, int $x, int $y)
	{
		$image = \Image::make($img);
        $image->resize($x, $y, function ($constraint) {
                $constraint->aspectRatio();
                        });
        return $image->encode($format,90);
	}
}