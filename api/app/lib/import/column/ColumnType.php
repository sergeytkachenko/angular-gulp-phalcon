<?php


namespace lib\import\column;


abstract class ColumnType
{

	/**
	 * @var string колонка обьекта
	 */
	protected $modelColumn;

	/**
	 * @param $modelColumn колонка обьекта
	 */
	public function __construct($modelColumn) {
		$this->modelColumn = $modelColumn;
	}

	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * Возвращает значение колонки учитывая ее тип.
	 * @return mixed
	 */
	public abstract function getValue();

	/**
	 * @return string не переобразованое значение из колонки
	 */
	public function getPrimaryValue() {
		return $this->value;
	}

	/**
	 * Проверка валидности значения колонки по типу.
	 * @return mixed
	 */
	public abstract function checkValue();

	/**
	 * Устанавливает значение колонки.
	 * @param $value
	 * @return mixed
	 */
	public function setValue($value) {
		$this->value = $value;
	}

	/**
	 * @return string
	 */
	public function getModelColumn() {
		return $this->modelColumn;
	}

	/**
	 * @return колонка|string
	 */
	public final function getModelColumnName() {
		return $this->modelColumn;
	}

}