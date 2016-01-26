<?php

namespace Lib\Import\Iterator;

use ErrorException;
use Iterator;
use Lib\Import\ImportException;
use Lib\Import\LineIterator;
use Lib\Import\ColumnMap;
use Lib\Import\Line;
use PHPExcel;
use PHPExcel_Cell;
use PHPExcel_IOFactory;

class ExcelList extends PHPExcel implements LineIterator
{

	private $currentLineIndex = 2;
	private $lastLineIndex = null;
	private $lastColumnIndex = null;
	private $activeSheet = null;

	/**
	 * @var ColumnMap
	 */
	private $columnMap;

	/**
	 * Текущая строка
	 * @var Line
	 */
	private $currentLine;

	public function __construct($file, ColumnMap $columnMap) {
		if (!file_exists($file) || !is_file($file)) {
			throw new ImportException('Не верный путь к файлу ' . $file);
		}
		try {
			$this->columnMap = $columnMap;
			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);

			$objPHPExcel = $objReader->load($file);
			$this->activeSheet = $objPHPExcel->getActiveSheet();

			$this->lastLineIndex = $this->activeSheet->getHighestRow();
			$this->lastColumnIndex = PHPExcel_Cell::columnIndexFromString($this->activeSheet->getHighestColumn());

			$this->currentLine = new Line($this->columnMap);
			$this->initLineHeaders();
		} catch (ErrorException $error) {
			throw new ImportException($error);
		}
	}

	private function initLineHeaders() {
		$headers = $this->getLine($this->columnMap->getHeaderLineIndex());
		if(!$headers) {
			throw new ImportException('Не найдены заголовки таблицы');
		}
		foreach($this->columnMap->getColumns() as $column) {
			$headerColumn = $column->getHeaderColumn();
			$caption = $headerColumn->getCaption();
			foreach($headers as $index => $headerCaption) {
				$headerCaption = trim(mb_strtolower($headerCaption, 'UTF-8'));
				if($caption !== $headerCaption) {
					continue;
				}
				$headerColumn->setColumnIndex($index);
			}
		}
		$this->currentLine->setHeaders($this->columnMap->getHeaders());
	}

	/**
	 * Возвращает следующую строку
	 * @return Line
	 */
	public function next() {
		$data = $this->getLine(++$this->currentLineIndex);
		if (!$data) {
			if($this->currentLineIndex < $this->lastColumnIndex) {
				return $this->next();
			}
		}
		if(!$data) {
			return false;
		}
		$this->currentLine->setColumnsData($data);
		return $this->currentLine;
	}

	/**
	 * Подсчитывет количество общих строк
	 * @return integer
	 */
	public function count() {
		return $this->lastLineIndex;
	}

	private function getCellValue($lineIndex, $columnIndex) {
		$cell = $this->activeSheet->getCellByColumnAndRow($columnIndex, $lineIndex)
			->getValue();
		return $cell;
	}

	/**
	 * Возвращает искомую строку
	 * @param integer $lineIndex id нужной строки
	 * @return null|array
	 */
	private function getLine($lineIndex) {
		$data = array();
		for ($columnIndex = 0; $columnIndex <= $this->lastColumnIndex; $columnIndex++) {
			$data[$columnIndex] = $this->getCellValue($lineIndex, $columnIndex);
		}
		if (array_filter($data) === array()) {
			return null;
		}
		return array_map('mb_strtolower', $data);
	}

	/**
	 * Return the current element
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 * @since 5.0.0
	 */
	public function current() {
		// TODO: Implement current() method.
	}

	/**
	 * Return the key of the current element
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return mixed scalar on success, or null on failure.
	 * @since 5.0.0
	 */
	public function key() {
		// TODO: Implement key() method.
	}

	/**
	 * Checks if current position is valid
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 * @since 5.0.0
	 */
	public function valid() {
		// TODO: Implement valid() method.
	}

	/**
	 * Rewind the Iterator to the first element
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 * @since 5.0.0
	 */
	public function rewind() {
		// TODO: Implement rewind() method.
	}
}