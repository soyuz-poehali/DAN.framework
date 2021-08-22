<?php

include_once "ImageResizeMain.php";

class ImageResizeCutting extends ImageResizeMain
{
	protected function resize()
	{
		if($this->resHeight <= 0 || $this->resWidth <= 0)
			return false;

		$canvasSrcWidth = $this->srcWidth;
		$canvasSrcHeight = $this->srcHeight;
		$canvasSrcPaddingX = 0;
		$canvasSrcPaddingY = 0;

		$ratioX = $this->srcWidth / $this->resWidth;
		$ratioY = $this->srcHeight / $this->resHeight;

		if ($ratioX < $ratioY) {
			$canvasSrcHeight = intval($this->resHeight * $ratioX);
			$canvasSrcPaddingY = intval(($this->srcHeight - $canvasSrcHeight) / 2);
		} else {
			$canvasSrcWidth = intval($this->resWidth * $ratioY);
			$canvasSrcPaddingX = intval(($this->srcWidth - $canvasSrcWidth) / 2);
		}

		$this->resImage = imagecreatetruecolor($this->resWidth, $this->resHeight);
		$white = imagecolorallocate($this->resImage, 255, 255, 255);
		imagefilledrectangle($this->resImage, 0, 0, $this->resWidth, $this->resHeight, $white);

		imagecopyresampled($this->resImage, $this->srcImage,
			0, 0, $canvasSrcPaddingX, $canvasSrcPaddingY,
			$this->resWidth, $this->resHeight,
			$canvasSrcWidth, $canvasSrcHeight);

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
