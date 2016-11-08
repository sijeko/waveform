<?php

namespace Sijeko\Waveform;


use Sijeko\Exceptions\FileNotExist;
use Sijeko\Exceptions\UnavailableType;

class Convert
{
	/** @var array Список доступных типов */
	public static $availableTypes = [
		'audio/mpeg',
		'audio/ogg',
		];

	/**
	 * Возвращает путь к временному файлу в формате wav
	 * @param string $filePath - путь к изображению
	 * @return string
	 * @throws FileNotExist
	 * @throws UnavailableType
	 */
	public static function getWavFile($filePath)
	{
		$saveAs = "tmp" . time() . "-" . rand(1, 1000) . '.wav';
		if (file_exists($filePath)){
			$mime = mime_content_type($filePath);
			if (array_search($mime, Convert::$availableTypes) !== false){
				exec('ffmpeg -i ' . $filePath . ' -acodec pcm_u8 -ar 22050 ' . $saveAs);
				return $saveAs;
			}
			throw new UnavailableType('File `' . $filePath . '` has a not available type - `' . $mime . '`');
		}
		throw new FileNotExist('File `' . $filePath . '` is not exists');

	}
}