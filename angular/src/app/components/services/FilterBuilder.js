class FilterBuilder {

	constructor() {
		/**
		 * Сформированный обьект запроса, который отправляется на сервер для фильтрации.
		 * @type {Object}
		 */
		this.criteria = {};

		/**
		 * Обьект условий для фильрации.
		 * @type {Object}
		 */
		this.filters = {};

		this.init();
	}

	init() {}

	/**
	 * Добавляет еще одно условие фильрации.
	 * @param {String} filterType Тип фильтра позвавшего событие (select, range, buttons, etc.).
	 * @param {String} entityColumn Колонка, к которой применяется фильрация.
	 * @param {Array} values Значения колонки, которые подходят под условия фильрации.
	 * @param {String} [entityName] Название модели, в которой находиться колонка фильрации.
	 */
	add(filterType, entityColumn, values, entityName) {
		this.filters[entityColumn] = {
			filterType: filterType,
			entityColumn: entityColumn,
			values: values,
			entityName: entityName
		};
	}

	/**
	 * Формирует JSON фильтрации в формате \Phalcon\Mvc\Model\Criteria, который будет оправляется на сервер.
	 * @return {Object}
	 */
	build() {
		var where = [];
		Ext.iterate(this.filters, function(column, filter) {
			if (!filter.values || filter.values.length === 0) {return;}
			where.push(column + ' IN (' + filter.values.join(',') + ')');
		}.bind(this));
		if (where.length === 0) {
			delete this.criteria.where;
		} else {
			this.criteria.where = where.join(' AND ');
		}
		return this.criteria;
	}
}

export default FilterBuilder;
