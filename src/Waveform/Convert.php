<?php

namespace Sijeko\Waveform;


class Convert
{
	/**
	 * Возвращает путь к временному файлу в формате wav
	 * @param string $filePath - путь к изображению
	 * @return string|null
	 */
	public static function getWavFile($filePath)
	{
		$saveAs = "tmp" . time() . "-" . rand(1, 1000) . '.wav';
		if (file_exists($filePath)){
			exec('ffmpeg -i ' . $filePath . ' -acodec pcm_u8 -ar 22050 ' . $saveAs);
			return $saveAs;
		}
		return null;

	}
}