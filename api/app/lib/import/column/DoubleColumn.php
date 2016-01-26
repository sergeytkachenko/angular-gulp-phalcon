<?php


namespace lib\import\column;


class DoubleColumn extends ColumnType
{

	/**
	 * Возвращает значение колонки учитывая ее тип
	 * @return mixed
	 */
	public function getValue() {
		return doubleval(str_replace(',', '.', $this->value));
	}

	/**
	 * Проверка валидности значения колонки по типу
	 * @return mixed
	 */
	public function checkValue() {
		// TODO: Implement checkValue() method.
	}
}