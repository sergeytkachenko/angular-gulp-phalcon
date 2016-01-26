class ButtonsFilter {

	/*@ngInject*/
	constructor() {
		this.scope = {
			filterHeader: '=filterHeader',
			filterCircle: '=filterCircle',
			filterId: '=filterId',
			filterTitle: '=filterTitle',
			filterStore: '=filterStore',
			ngChange: '=ngChange',
			ngModel: '=ngModel'
		};
		this.templateUrl = 'app/components/directives/buttons-filter/buttons-filter.html';
		this.replace = true;
	}

	link(scope, element, attributes) {

		/**
		 * Выбранные кнопки
		 * @type {Array}
		 */
		scope.$parent[attributes.ngModel] = [];
		scope.activeClass = 'md-primary';

		scope.reset = function() {
			scope.$parent[attributes.ngModel] = [];
			angular
				.element(element)
				.find('button[data-id]')
				.removeClass(scope.activeClass);
			resolveButtonsClass();
			triggerChange();
		}

		scope.click = function(id) {
			toggleChangedId(id);
			var btnEl = angular
				.element(element)
				.find('[data-id=' + id + ']');
			btnEl.toggleClass(scope.activeClass);
			resolveButtonsClass();
			triggerChange();
		};

		function resolveButtonsClass() {
			var btnAllEl = angular
				.element(element)
				.find('button:not([data-id])');
			if (Ext.isEmpty(scope.$parent[attributes.ngModel])) {
				btnAllEl.addClass(scope.activeClass);
			} else {
				btnAllEl.removeClass(scope.activeClass);
			}
		}

		function toggleChangedId(id) {
			if (Ext.Array.contains(scope.$parent[attributes.ngModel], id)) {
				return Ext.Array.remove(scope.$parent[attributes.ngModel], id);
			}
			scope.$parent[attributes.ngModel].push(id);
		}

		function triggerChange() {
			scope.$parent.$broadcast('filter:change', attributes.ngModel, 'buttons')
		}
	}
}

export default ButtonsFilter;