class FilterController {

	constructor($scope, $timeout, $rootScope, filterBuilder) {
		'ngInject';
		console.log(filterBuilder);
		this.$timeout = $timeout;
		this.$rootScope = $rootScope;
		this.carsGrid = null;

		$scope.filterClosed = true;
		$scope.minx = 20;
		$scope.maxx = 80;
		$scope.filerButtonClick = function() {
			$scope.filterClosed = !$scope.filterClosed;
			this.fixGridMarginTop($scope, $scope.headerGone);
		}.bind(this);
		$scope.$on('cars:loaded', function(e, carsGrid) {
			this.carsGrid = carsGrid;
			Ext.iterate(carsGrid.storages, function(key, val) {
				$scope[key] = val.getRange();
			});
		}.bind(this));
		$scope.$on('filter:change', function(e, filterModelName, filterType) {
			filterBuilder.add(filterType, filterModelName, $scope[filterModelName]);
			var criteria = filterBuilder.build();
			var params = {
				criteriaMethods: criteria,
				entity: 'Cars'
			};
			this.carsGrid.store.load({
				params: {
					queryParams: Ext.JSON.encode(params)
				}
			});
		}.bind(this));
		$scope.$on('scrollY:change', this.fixGridMarginTop.bind(this));
	}

	fixGridMarginTop($scope, headerGone) {
		var filterEl = angular.element('[ui-view="filter"]');
		this.$timeout(function() {
			var h = filterEl.height();
			var gridEl = filterEl.next();
			gridEl.css({
				'margin-top': headerGone ? h : 0
			});
		}, 35);
	}
}

export default FilterController;

