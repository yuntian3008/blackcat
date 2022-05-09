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
	public function run($img, String $key)
	{
		$name = $this->createName($key);
		$format = $this->config['format'];
		$resolution = $this->config['resolution'];
		$location = $this->config['storage_location'];
		$image = $this->createImage($img,$format,$resolution);
		switch ($location) {
			case 'local':
				foreach ($image as $element)
					Storage::disk('public')->put($element['key'].'_'.$name.'.'.$format,$element['image']);
				break;
			case 'gdrive':
				foreach ($image as $img)
				Storage::cloud()->put($element['key'].'_'.$name.'.'.$format, $element['image']);
				break;
			default:
				break;
		}
		return $name;
	}

    public function runForArray($imgs, String $key, $dir = null)
	{
		$name = $dir ? $dir : $this->createName($key);
		$format = $this->config['format'];
		$resolution = $this->config['resolution'];
		$location = $this->config['storage_location'];
        $images = [];
        foreach ($imgs as $index => $img) {
            array_push($images,$this->createImage($img,$format,$resolution));
        }

		switch ($location) {
			case 'local':
                if (!$dir && !Storage::disk('public')->exists($name))
                    Storage::disk('public')->makeDirectory($name);
                foreach ($images as $index => $image) {
                    $namePerImage = $this->createName('image');
                    foreach ($image as $element) {
                        Storage::disk('public')->put($name.'/'.$element['key'].'_'.$namePerImage.'.'.$format,$element['image']);
                    }
                }


				break;
			// case 'gdrive':
			// 	foreach ($image as $img)
			// 	Storage::cloud()->put($element['key'].'_'.$name.'.'.$format, $element['image']);
			// 	break;
			default:
				break;
		}
		return $name;
	}

	public static function getURL(String $name,String $size)
	{
		$config = config('image-processing');
		switch ($config['storage_location']) {
			case 'local':
                // $img = array_filter(Storage::disk('public')->files($name), function ($item) use ($size) {
                //     //only png's
                //     return strpos($item, $size);
                //  });
                $img = Storage::disk('public')->files($name);

                //  dd($img);
				// return Storage::url('public/'.$size.'_'.$name.'.png');
                foreach ($img as $key => $value) {
                    return Storage::url('public/'.$value);
                }

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
				if (is_null($file))
					return "";
				return Storage::cloud()->url($file['path']);
				break;
			default:
				break;
		}
	}

    public static function getAllURL(String $name,String $size = 'sm')
	{
		$config = config('image-processing');
		switch ($config['storage_location']) {
			case 'local':
                $img = array_filter(Storage::disk('public')->files($name), function ($item) use ($size) {
                    //only png's
                    return strpos($item, $size);
                 });
                //  dd($img);
				// return Storage::url('public/'.$size.'_'.$name.'.png');
                foreach ($img as $key => $value) {
                    $img[$key] = Storage::url('public/'.$value);;
                }
                return array_values($img);
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
				if (is_null($file))
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

	protected function createImage($img,String $format,$resolution)
	{
		$originalImage = \Image::make($img);
		$image = [];
		foreach ($resolution as $value) {
			$temp = clone $originalImage;
			$temp->resize($value['x'], $value['y'], function ($constraint) {
	                	$constraint->aspectRatio();
	                });
                	$temp->encode($format,90);
                	array_push($image,[
                		'image' => $temp,
                		'key' => $value['key'],
                	] );
		}

        	return $image;
	}
}
