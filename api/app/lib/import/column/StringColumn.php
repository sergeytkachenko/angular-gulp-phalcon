<?php


namespace lib\import\column;


class StringColumn extends ColumnType
{

	/**
	 * Возвращает значение колонки учитывая ее тип
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Проверка валидности значения колонки по типу
	 * @return mixed
	 */
	public function checkValue() {
		// TODO: Implement checkValue() method.
	}
}