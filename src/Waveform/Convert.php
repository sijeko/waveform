<?php

namespace Sijeko\Waveform;


use Sijeko\Exceptions\FileNotExist;
use Sijeko\Exceptions\UnavailableType;

class Convert
{
	/** @var array Список доступных типов. Поставлено ограничение только на те типы, которые точно можно сконвертировать в wav используя ffmpeg */
	private $availableTypes = [
		'audio/mpeg',
		'audio/ogg',
		'audio/x-wav',
	];

	/**
	 * Добавляет допустимые типы
	 * @param string|string[] $types
	 * @return $this
	 */
	public function addAvailableTypes($types)
	{
		if (is_array($types)){
			$this->availableTypes = array_merge($this->availableTypes, $types);
		} else {
			array_push($this->availableTypes, $types);
		}
		return $this;
	}

	/**
	 * Возвращает путь к временному файлу в формате wav
	 * Protected по той причине, что создает лишь временный файл, который должен быть удален после
	 * @param string $filePath - путь к изображению
	 * @return string
	 * @throws FileNotExist
	 * @throws UnavailableType
	 */
	protected function getTemporaryWavFile($filePath)
	{
		$saveAs = "tmp" . time() . "-" . rand(1, 1000) . '.wav';
		if (file_exists($filePath)) {
			$mime = mime_content_type($filePath);
			if (array_search($mime, $this->availableTypes) !== false) {
				exec('ffmpeg -i ' . $filePath . ' -acodec pcm_u8 -ar 22050 ' . $saveAs);
				return $saveAs;
			}
			throw new UnavailableType('File `' . $filePath . '` has a not available type - `' . $mime . '`');
		}
		throw new FileNotExist('File `' . $filePath . '` is not exists');

	}
}