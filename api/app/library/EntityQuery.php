<?php

class EntityQuery
{
	/**
	 * Формирует \Phalcon\Mvc\Model\Criteria из json обьекта пришедшего с браузера
	 * @param $jsonParams {entity: 'Cars', 'criteriaMethods': {andWhere: "id = :id:", 'bind': {id: 12}}}
	 * @return \Phalcon\Mvc\Model\Criteria
	 */
	public static function buildCriteria($jsonParams) {
		$params = json_decode($jsonParams, true);
		$criteriaMethods = $params['criteriaMethods'];
		$entityClass = $params['entity'];
		/**
		 * @var $criteria \Phalcon\Mvc\Model\Criteria
		 */
		$criteria = $entityClass::query();
		foreach($criteriaMethods as $criteriaMethod => $arguments) {
			$reflectionMethod = new ReflectionMethod('\Phalcon\Mvc\Model\Criteria', $criteriaMethod);
			$criteria = $reflectionMethod->invokeArgs($criteria, array($arguments));
		}
		return $criteria;
	}
}