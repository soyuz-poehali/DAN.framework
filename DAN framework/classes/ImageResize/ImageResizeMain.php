<?php

class ImageResizeMain
{
	function __construct($srcPath, $resPath, $resWidth, $resHeight, $imageOutputType=false)
	{
		$this->srcPath = $srcPath;
		$this->resPath = $resPath;
		$this->resHeight = $resHeight;
		$this->resWidth = $resWidth;
		$this->imageOutputType = $imageOutputType;	
	}

	public function deleteSource()
	{
		if(!file_exists($this->srcPath))
			return false;

		unlink($this->srcPath);
		return true;
	}

	public function run()
	{	
		if ($this->resHeight <= 0 && $this->resWidth <= 0)
			return false;

		if (@getimagesize($this->srcPath)) 
			$inputProp = getimagesize($this->srcPath);
		else 
			return;

		if (!$this->imageType)
			$this->imageType = $inputProp[2];
		
		$this->srcHeight = $inputProp[1];
		$this->srcWidth = $inputProp[0];

		switch ($this->imageType) {
			case 1:
				$this->srcImage = @imagecreatefromgif($this->srcPath);
				break;

			case 2:
				$this->srcImage = @imagecreatefromjpeg($this->srcPath);
				break;

			case 3:
				$this->srcImage = @imagecreatefrompng($this->srcPath);
				break;

			case 18:
				$this->srcImage = @imagecreatefromwebp($this->srcPath);
				break;

			default: //если залито что то не то, то он пошлёт нафиг и удалит залитое
				if (file_exists($this->srcPath)) {
					@chmod($this->srcPath,0755);
					unlink($this->srcPath);
					exit;
				}			
				return false;
		}
		return $this->resize();
	}


	protected function resize()
	{
		$this->resImage = imagecreatetruecolor($this->srcWidth, $this->srcHeight);
		imagecopyresampled($this->resImage, $this->srcImage,
			0, 0, 0, 0,
			$this->srcWidth, $this->srcHeight,
			$this->srcWidth, $this->srcHeight);

		if ($this->imageOutputType == 'webp') {
			imagewebp($this->resImage, $this->resPath, 70);
			if (filesize($this->resPath) % 2 == 1) {  // Исправляем баг gd2
			    file_put_contents($this->resPath, "\0", FILE_APPEND);
			}
		} else {
			imagejpeg($this->resImage, $this->resPath, 70);
		}

		return true;
	}

	function __destruct()
	{
		if($this->resImage != null)
			ImageDestroy($this->resImage);

		if($this->srcImage != null)
			ImageDestroy($this->srcImage);
	}

	protected $srcImage;
	protected $srcPath;
	protected $srcHeight;
	protected $srcWidth;

	protected $resImage;
	protected $resPath;
	protected $resHeight;
	protected $resWidth;

	protected $imageType;
	protected $imageOutputType;
};
