<?php

namespace Lib\Import;

class ColumnMap
{

	/**
	 * @var int|null
	 */
	private $headerLineIndex;

	/**
	 * @var \Lib\Import\Column[]
	 */
	private $columns;

	/**
	 * @param \Lib\Import\Column[] $columns
	 * @param integer $headerLineIndex номер строки, на которой находиться заголовки столбцов
	 * @internal param array $data Карта столбцов
	 */
	public function __construct(array $columns, $headerLineIndex = null) {
		if($headerLineIndex) { // TODO else auto search headerLineIndex
			$this->headerLineIndex = $headerLineIndex;
		}
		foreach($columns as $column) {
			$header = $column->getHeaderColumn();
			$this->columns[$header->getAlias()] = $column;
		}
	}

	/**
	 * @return int|null
	 */
	public function getHeaderLineIndex() {
		return $this->headerLineIndex;
	}

	/**
	 * Возвращает колонку по ее alias.
	 * @param $columnAlias Column alias.
	 * @return Column
	 * @throws ImportException
	 */
	public function getColumn($columnAlias) {
		if(isset($this->columns[$columnAlias]) === false) {
			throw new ImportException($columnAlias . ' not found in columns');
		}
		return $this->columns[$columnAlias];
	}

	/**
	 * @return \Lib\Import\Column[]
	 */
	public function getColumns() {
		return $this->columns;
	}

	/**
	 * @param \Lib\Import\Column\HeaderColumn[] $headers
	 * @return \Lib\Import\Column\HeaderColumn[]
	 */
	public function getHeaders($headers = array()) {
		foreach($this->columns as $column) {
			$headers[] = $column->getHeaderColumn();
		}
		return $headers;
	}
}