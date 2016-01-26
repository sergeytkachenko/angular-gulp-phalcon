<?php

namespace Lib\Import\Parser;

use Imports;
use Phalcon\Mvc\Model;

class Cars extends Controller
{
	const MODEL_TITLE = 'model.title';
	const BRAND_TITLE = 'brand.title';
	const COMPL_TITLE = 'compl.title';
	const CAR_TITLE = 'car.title';
	const CAR_MODEL_YEAR = 'car.model_year';
	const CAR_TYPE = 'car.type';
	const CAR_CLASS = 'car.class';
	const FUEL_TYPE = 'car.fuel_type';
	const FUEL_TRANSMISSION = 'car.transmission';
	const DOORS = 'car.doors';
	const ENGINE_CAPACITY = 'car.engine_capacity';
	const CAR_PRICE = '!car_price';

	/**
	 * Модель импорта, при условии, что данные сохраняются в БД (commitToDB == true)
	 * @var \Phalcon\Mvc\Model
	 */
	protected $import = null;

	/**
	 * @return Model
	 */
	public function getImport() {
		return $this->import;
	}

	/**
	 * @param Model $import
	 */
	public function setImport($import) {
		$this->import = $import;
	}

	/**
	 * @param \Lib\Import\Column[] $columns
	 * @return \Phalcon\Mvc\Model
	 */
	protected function toModel(array $columns) {
		$car = false;
		$paramsQuery = $this->getFilterQuery($columns);
		if ($paramsQuery) {
			$car = \Cars::findFirst($paramsQuery);
		}
		$car = $this->fillCar($columns, $car ?  $car : new \Cars());
		if($this->getCommitToDB()) {
			$this->saveEntity($car, $columns);
			return;
		}
		$this->addParsedEntities($car);
	}

	/**
	 * Фильтр, который выбирает уникальный набор полей, который идентифицирует автомобиль
	 * @param array $columns
	 * @return array|bool
	 */
	private function getFilterQuery(array $columns) {
		$carIdentificationProperties = array(
			self::MODEL_TITLE,
			self::BRAND_TITLE,
			self::COMPL_TITLE,
			self::CAR_MODEL_YEAR,
			self::CAR_TYPE,
			self::CAR_CLASS,
			self::FUEL_TYPE,
			self::FUEL_TRANSMISSION,
			self::ENGINE_CAPACITY
		);
		$filter = array();
		$bindParams = array();
		foreach($columns as $column) {
			$value = $column->getColumnType()->getValue();
			$property = $value instanceof Model ? $value->id : $value;
			if(in_array($column->getHeaderColumn()->getAlias(), $carIdentificationProperties)) {
				$columnType = $column->getColumnType();
				$col = $columnType->getModelColumnName();
				$filter[] = $col . " = :" .$col . ": ";
				$bindParams[$col] = $property;
			}
		}
		if(count(array_filter($bindParams)) < count($carIdentificationProperties)) {
			return false;
		}
		return array(
			implode(" AND ", $filter),
			'bind' => $bindParams
		);
	}

	/**
	 * @param \Lib\Import\Column[] $columns
	 * @param \Phalcon\Mvc\Model $car
	 * @return \Phalcon\Mvc\Model
	 */
	private function fillCar(array $columns, $car) {
		foreach($columns as $column) {
			$property = $column->getColumnType()->getModelColumn();
			if(!$property) {
				continue;
			}
			$car->$property = $column->getValue();
		}
		return $car;
	}

	/**
	 * @param \Phalcon\Mvc\Model $car
	 *  @param \Lib\Import\Column[] $columns
	 * @return bool|void
	 */
	protected function saveEntity(\Phalcon\Mvc\Model $car, array $columns) {
		if (!$car->id) {
			$car->save();
		}
		$priceColumn = $columns[self::CAR_PRICE];
		$price  = $priceColumn->getValue();
		$usd = doubleval($price / 25);
		$carPriceParams = array(
			'car_id' => $car->id,
			'usd' => $usd
		);
		$carPrices = \CarPrices::findFirst(array(
			'car_id = :car_id: AND usd = :usd: AND dealer_id IS NULL', // TODO изменить на реального dealer_id
			'bind' => $carPriceParams
		));
		$carPrices = $carPrices ? $carPrices : new \CarPrices();
		$carPrices->save($carPriceParams);
	}

}