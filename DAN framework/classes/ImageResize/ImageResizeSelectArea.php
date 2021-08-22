<?php

include_once "ImageResizeMain.php";

class ImageResizeSelectArea extends ImageResizeMain
{
	public function setArea($_x, $_y, $_w, $_h)
	{
		$this->x = $_x;
		$this->y = $_y;
		$this->w = $_w;
		$this->h = $_h;		
	}

	protected function resize()
	{
		$canvasSrcWidth = $this->resWidth;
		$canvasSrcHeight = $this->resHeight;

		$this->resImage = imagecreatetruecolor($this->resWidth, $this->resHeight);
		$white = imagecolorallocate($this->resImage, 255, 255, 255);
		imagefilledrectangle($this->resImage, 0, 0, $this->resWidth, $this->resHeight, $white);

		imagecopyresampled($this->resImage, $this->srcImage,
			0, 0, $this->x, $this->y,
			$this->resWidth, $this->resHeight,
			$this->w, $this->h);

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

	private $x = 0;
	private $y = 0;
	private $w = 0;
	private $h = 0;	
};
