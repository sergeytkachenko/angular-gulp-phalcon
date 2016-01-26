<?php

namespace Lib\Import;

/**
 * Текущая строка из таблицы строк
 * Class Line
 * @package Lib\Import
 */
class Line
{

	/**
	 * @var ColumnMap
	 */
	private $columnMap;

	/**
	 * @var \Lib\Import\Column\HeaderColumn[]
	 */
	private $headers;

	/**
	 * Line constructor.
	 * @param ColumnMap $columnMap
	 */
	public function __construct(ColumnMap $columnMap) {
		$this->columnMap = $columnMap;
	}

	/**
	 * @param $headers \Lib\Import\Column\HeaderColumn[]
	 */
	public function setHeaders(array $headers) {
		foreach($headers as $header) {
			$this->headers[$header->getColumnIndex()] = $header;
		}
	}

	/**
	 * @param array $data
	 * @throws ImportException
	 */
	public function setColumnsData(array $data) {
		if(!$this->headers) {
			throw new ImportException('Please invoke setHeaders before run setColumnsData');
		}
		foreach($data as $key => $value) {
			if(isset($this->headers[$key]) === false) {
				continue;
			}
			$header = $this->headers[$key];
			$alias = $header->getAlias();
			$column = $this->columnMap->getColumn($alias);
			$column->getColumnType()->setValue($value);
		}
	}

	/**
	 * @param string $columnAlias
	 * @return Column
	 */
	public function getColumn($columnAlias) {
		return $this->columnMap->getColumn($columnAlias);
	}

	/**
	 * @return Column[]
	 */
	public function getColumns() {
		return $this->columnMap->getColumns();
	}
}