<?php
namespace Multiple\Rest\Controllers;

use Cars;

class HelperController extends ControllerBase {


	public function findDoorsAllAction() {
		$doors = Cars::query()
			->columns(array('doors'))
			->groupBy('doors')
			->execute();

		return array(
			'data' => $doors? $doors->toArray() : $doors,
			'count' => $doors->count()
		);
	}

	public function findModelYearAllAction() {
		$doors = Cars::query()
			->columns(array('model_year'))
			->groupBy('model_year')
			->execute();

		return array(
			'data' => $doors? $doors->toArray() : $doors,
			'count' => $doors->count()
		);
	}
}

