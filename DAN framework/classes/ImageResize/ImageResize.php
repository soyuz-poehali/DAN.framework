<?php

include_once "ImageResizeMain.php";

class ImageResize extends ImageResizeMain
{
	protected function resize()
	{
		if ($this->resWidth > $this->resHeight)
			$this->resHeight = floor($this->srcHeight / ($this->srcWidth / $this->resWidth));
		else
			$this->resWidth = floor($this->srcWidth / ($this->srcHeight / $this->resHeight));

		$this->resImage = imagecreatetruecolor($this->resWidth, $this->resHeight);
		$white = imagecolorallocate($this->resImage, 255, 255, 255);
		imagefilledrectangle($this->resImage, 0, 0, $this->resWidth, $this->resHeight, $white);

		imagecopyresampled($this->resImage, $this->srcImage,
			0, 0, 0, 0,
			$this->resWidth, $this->resHeight,
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
};
