<?php

namespace Lib\Import\Parser;
use \Lib\Import\LineIterator;

abstract class Controller
{
	/**
	 * @var LineIterator|Lines
	 */
	private $importIterator;

	/**
	 * @var bool|false
	 */
	protected $commitToDB;

	/**
	 * @var \Phalcon\Mvc\Model[]
	 */
	protected $parsedEntities = array();

	/**
	 * @param LineIterator|Lines $importIterator Итератор с данными, который умеет делать next()
	 * @param bool|false $commitToDB сохранять ли данные в БД
	 */
	public function __construct(LineIterator $importIterator, $commitToDB = false) {
		$this->importIterator = $importIterator;
		$this->commitToDB = $commitToDB;
	}

	public function parse() {
		while($line = $this->parseLine()) {
			$this->toModel($line->getColumns());
		}
		return $this;
	}

	/**
	 * @return \Lib\Import\Line
	 */
	protected function parseLine() {
		return $this->importIterator->next();
	}

	/**
	 * @param array $properties
	 * @return \Phalcon\Model
	 */
	protected abstract function toModel(array $properties);

	/**
	 * @param \Phalcon\Mvc\Model $model
	 *  @param \Lib\Import\Column[] $columns
	 * @return bool
	 */
	protected abstract function saveEntity(\Phalcon\Mvc\Model $model, array $columns);

	/**
	 * @return bool|false
	 */
	public function getCommitToDB() {
		return $this->commitToDB;
	}

	/**
	 * @return \Phalcon\Mvc\Model[]
	 */
	public function getParsedEntities() {
		return $this->parsedEntities;
	}

	/**
	 * @param \Phalcon\Mvc\Model $parsedEntity
	 */
	public function addParsedEntities($parsedEntity) {
		$this->parsedEntities[] = $parsedEntity;
	}

}