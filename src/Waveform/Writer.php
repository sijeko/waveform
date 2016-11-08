<?php

namespace Sijeko\Waveform;


use BoyHagemann\Waveform\Waveform;
use BoyHagemann\Waveform\Generator;
use Sijeko\Exceptions\BaseError;

/**
 * Класс для получения изображения по айдиофайлу
 *
 * Основные методы - getImage и saveImage
 *
 * @package Sijeko\Waveform
 */
class Writer
{
	/** @var null|string Путь к изображению */
	private $fileName = null;
	/** @var int Ширина конечного изображения */
	private $width = 960;
	/** @var int Высота конечного изображения */
	private $height = 400;

	/**
	 * Writer constructor.
	 * @param string $fileName
	 */
	public function __construct($fileName)
	{
		$this->fileName = $fileName;
	}

	/**
	 * @param string $fileName
	 * @return $this
	 */
	public function setFileName($fileName)
	{
		$this->fileName = $fileName;
		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getFileName()
	{
		return $this->fileName;
	}

	/**
	 * @param int $width
	 * @return $this
	 */
	public function setWidth($width)
	{
		$this->width = (int)$width;
		return $this;
	}

	/**
	 * @param int $height
	 * @return $this
	 */
	public function setHeight($height)
	{
		$this->height = (int)$height;
		return $this;
	}

	public function getWidth()
	{
		return $this->width;
	}

	public function getHeight()
	{
		return $this->height;
	}

	/**
	 * Возвращает изображение
	 * @return mixed
	 */
	public function getImage()
	{
		$wavTmp = Convert::getWavFile($this->getFileName());

		if ($wavTmp) {
			$waveform = Waveform::fromFilename($wavTmp);
			$waveform->setGenerator(new Generator\Png)
				->setWidth($this->getWidth())
				->setHeight($this->getHeight());

			unlink($wavTmp);

			return $waveform->generate();
		}
		return null;
	}

	/**
	 * Сохраняет изображение по адресу
	 * @param string $saveAs
	 * @return bool
	 * @throws BaseError
	 */
	public function saveImage($saveAs)
	{
		$wavTmp = Convert::getWavFile($this->getFileName());

		if ($wavTmp) {
			$png = new Generator\Png();
			$png->setUseHeader(false)
				->setFilename($saveAs);

			$waveform = Waveform::fromFilename($wavTmp);
			unlink($wavTmp);
			$waveform->setGenerator($png)
				->setWidth($this->getWidth())
				->setHeight($this->getHeight())
				->generate();
			return true;
		}
		throw new BaseError('Can\'t get wav-file from `' . $this->getFileName() . '`');

	}


}