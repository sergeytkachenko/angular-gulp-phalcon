<?php
use Lib\ArrayFilters;

/**
 * Class BaseModel
 * Служит базовым вспомагательным "класом" для потдержки общих методов моделей
 */
trait BaseModel
{

	/**
	 * тут храниться массив связей, который наполняется при вызове метода ->fetchRelations
	 * @var array
	 */
	public $relations = array();

	/**
	 * проверям нужно ли пометить этот елемент как is_new для этого пользователя
	 * @return bool
	 */
	public function getIsNewByUserSession() {
		$className = get_class($this);
		$user = $this->di->get('session')->get('user');
		if (!$user or !$className) {
			return false;
		}
		return true != $entity = EntityUsersViewed::findFirst(array(
			'user_id = :userId: AND entity_alias=:Entity: AND entity_last_edit < entity_last_viewed AND entity_id = ' . $this->id,
			'bind' => array(
				'userId' => $user->id,
				'Entity' => $className
			)
		));
	}

	/**
	 * Подгружает все связанные свойства из других таблиц и ложит все связи в свойство $this->relations
	 * Очень удобно когда вам нужно выбрать один методом сущность, а также все ее связи
	 * @return $this
	 */
	public function fetchRelations() {
		$relations = $this->getModelsManager()->getBelongsTo($this);
		foreach ($relations as $relation) {
			$this->assignRelation($relation);
		}
		$relations = $this->getModelsManager()->getHasMany($this);
		foreach ($relations as $relation) {
			$this->assignRelation($relation);
		}
		$relations = $this->getModelsManager()->getHasManyToMany($this);
		foreach ($relations as $relation) {
			$this->assignRelation($relation);
		}
		return $this;
	}

	/**
	 * Возвращет массив связей
	 * @return \Phalcon\Mvc\Model\Relation[]
	 */
	public function getRelations() {
		$relations = $this->getModelsManager()->getBelongsTo($this);
		$relations = array_merge($relations, $this->getModelsManager()->getHasMany($this));
		return array_merge($relations, $this->getModelsManager()->getHasManyToMany($this));
	}

	/**
	 * Обращается и подгружает связанные данные сущности
	 * @param $relation
	 * @return $this|void
	 */
	private function  assignRelation($relation) {
		$options = $relation->getOptions();
		$alias = @$options['alias'];

		if (!$alias) {
			return;
		}
		$data = $this->$alias;
		$this->relations[$alias] = $data ? $data->toArray() : $data;

		return $this;
	}

	/**
	 * Делает из обькта массив, с учетом свойства relations
	 * @return mixed
	 */
	public function toArrayRelations() {
		$data = $this->toArray();
		$data['relations'] = $this->relations;

		return $data;
	}

	/**
	 * Сохраняет в модели только те поля, которые в ней есть
	 * @param array $data
	 * @return mixed
	 */
	public function saveOnlyAttributes(array $data) {
		$data = ArrayFilters::filterColumnsModel(
			$data,
			$this->getModelsMetaData()->getAttributes($this)
		);
		foreach ($data as $key => $val) {
			if(empty($val)) {
				$data[$key] = null;
			}
		}

		return $this->save($data);
	}
}