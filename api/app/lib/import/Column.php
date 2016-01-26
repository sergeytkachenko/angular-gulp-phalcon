<?php


namespace Lib\Import;


use lib\import\column\ColumnType;
use lib\import\column\HeaderColumn;

class Column
{
	/**
	 * @var HeaderColumn
	 */
	private $headerColumn;

	/**
	 * @var ColumnType
	 */
	private $columnType;

	/**
	 * Список ColumnRule для этой колонки
	 * @var ColumnRule[]
	 */
	private $columnRules;

	/**
	 * @var string[]
	 */
	private $dependencies;

	/**
	 * @var bool
	 */
	private $required;

	/**
	 * Column constructor.
	 * @param HeaderColumn $headerColumn
	 * @param ColumnType $columnType
	 * @param array $columnRules
	 * @param array $dependencies
	 * @param $required
	 */
	public function __construct(HeaderColumn $headerColumn, ColumnType $columnType,
			array $columnRules=array(), array $dependencies=array(), $required=false) {
		$this->headerColumn = $headerColumn;
		$this->columnType = $columnType;
		$this->columnRules = $columnRules;
		$this->dependencies = $dependencies;
		$this->required = $required;
	}

	/**
	 * @return HeaderColumn
	 */
	public function getHeaderColumn() {
		return $this->headerColumn;
	}

	/**
	 * @return ColumnType
	 */
	public function getColumnType() {
		return $this->columnType;
	}

	/**
	 * @return ColumnRule[]
	 */
	public function getColumnRules() {
		return $this->columnRules;
	}

	/**
	 * Возвращает значение колонки
	 * @return mixed
	 */
	public function getValue() {
		return $this->columnType->getValue();
	}

	public function setValue($value) {

	}
}