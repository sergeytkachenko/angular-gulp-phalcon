<?php


namespace lib\import\column;


class HeaderColumn
{
	/**
	 * @var string
	 */
	private $caption;

	/**
	 * @var string
	 */
	private $alias;

	/**
	 * @var int
	 */
	private $columnIndex;

	/**
	 * HeaderColumn constructor.
	 * @param $caption
	 * @param $alias
	 */
	public function __construct($caption, $alias) {
		$this->caption = trim(mb_strtolower($caption, 'UTF-8'));
		$this->alias = trim(mb_strtolower($alias, 'UTF-8'));
	}

	/**
	 * @return mixed
	 */
	public function getCaption() {
		return $this->caption;
	}

	/**
	 * @return mixed
	 */
	public function getAlias() {
		return $this->alias;
	}

	/**
	 * @return int
	 */
	public function getColumnIndex() {
		return $this->columnIndex;
	}

	/**
	 * @param int $columnIndex
	 */
	public function setColumnIndex($columnIndex) {
		$this->columnIndex = $columnIndex;
	}

}