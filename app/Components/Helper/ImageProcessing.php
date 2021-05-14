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
	public function run(String $img, String $key)
	{
		$name = $this->createName($key);
		$format = $this->config['format'];
		$resolution = $this->config['resolution'];
		$location = $this->config['storage_location'];
		foreach ($resolution as $value) {
			$image = $this->createImage($img,$format,$value['x'], $value['y']);
			switch ($location) {
				case 'local':
					$this->storeLocal($value['key'].'_'.$name.'.'.$format,$image);
					break;
				case 'gdrive':
					# code...
					break;
				default:
					break;
			}
		}
		return $name;
	}

	public function getURL(String $name,String $size)
	{
		return Storage::url('public/'.$size.'_'.$name.'.jpg');
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

	protected function storeLocal($name, $data)
	{
			Storage::disk('public')->put($name, $data);
	}
}