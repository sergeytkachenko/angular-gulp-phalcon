<?php


namespace Lib\Import\Column;


use Phalcon\Mvc\Model;

class LookupColumn extends ColumnType
{
	/**
	 * @var Model
	 */
	private $refModel;
	private $refColumn;

	/**
	 * LookupColumn constructor.
	 * @param mixed $refModel Модель связанной модели
	 * @param $refColumn колонка связаной модели
	 * @param $modelColumn колонка текущей модели
	 */
	public function __construct($refModel, $refColumn, $modelColumn) {
		$this->refModel = $refModel;
		$this->refColumn = $refColumn;
		$this->modelColumn = $modelColumn;
	}

	/**
	 * Возвращает значение колонки учитывая ее тип
	 * @return mixed
	 */
	public function getValue() {
		$class = call_user_func('\\' . $this->refModel . '::findFirst', array(
			$this->refColumn . ' = :value:',
			'bind' => array('value' => $this->value)
		));
		if(!$class) {
			$property = $this->refColumn;
			$class = new $this->refModel();
			$class->$property = $this->value;
		}
		return $class;
	}

	/**
	 * Возвращает ссылку на relation
	 * @override
	 * @return \Phalcon\Mvc\Model|null
	 */
	public function getModelColumn() {
		$model = new $this->refModel();
		/**
		 * @var $relations \Phalcon\Mvc\Model\Relation[]
		 */
		$relations = $model->getRelations();
		foreach($relations as $relation) {
			if($relation->getReferencedFields() == $this->modelColumn) {
				$refModel = '\\' . $relation->getReferencedModel();
				$refModel = new $refModel();
				foreach($refModel->getRelations() as $rel) {
					/**
					 * @var $rel \Phalcon\Mvc\Model\Relation
					 */
					if($rel->getFields() == $this->modelColumn) {
						return $rel->getOption('alias');
					}
				}
			}
		}
	}

	/**
	 * Проверка валидности значения колонки по типу
	 * @return mixed
	 */
	public function checkValue() {
		// TODO: Implement checkValue() method.
	}
}