class MainController {
	constructor($scope, $rootScope, $window) {
		'ngInject';
		$scope.carGridId = 'cars-grid';
		var componentId = 'component-' + $scope.carGridId;
		Ext.onReady(function() {
			var config = {};
			var storages = {
				carClassStore: Ext.create('Ucar.store.CarClass'),
				carTypesStore: Ext.create('Ucar.store.CarTypes'),
				carComplStore: Ext.create('Ucar.store.CarCompl'),
				carTransmissionsStore: Ext.create('Ucar.store.CarTransmissions'),
				fuelTypesStore: Ext.create('Ucar.store.FuelTypes'),
				modelsStore: Ext.create('Ucar.store.Models'),
				brandsStore: Ext.create('Ucar.store.Brands'),
				climateControlsStore: Ext.create('Ucar.store.ClimateControls'),
				doorsStore: Ext.create('Ucar.store.Doors'),
				modelYearStore: Ext.create('Ucar.store.ModelYear')
			};
			Promise.all([
				storages.carClassStore.loadByPromise(),
				storages.carTypesStore.loadByPromise(),
				storages.carComplStore.loadByPromise(),
				storages.carTransmissionsStore.loadByPromise(),
				storages.fuelTypesStore.loadByPromise(),
				storages.modelsStore.loadByPromise(),
				storages.brandsStore.loadByPromise(),
				storages.climateControlsStore.loadByPromise(),
				storages.doorsStore.loadByPromise(),
				storages.modelYearStore.loadByPromise()
			]).then(function() {
				Ext.apply(config, {
					itemId: componentId,
					renderTo: $scope.carGridId
				});
				config.storages = storages;
				var carsGrid = Ext.create('Ucar.grid.Cars', config);
				$rootScope.$broadcast('cars:loaded', carsGrid);
			});
		});

		$rootScope
			.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams) {
				var gridEl = Ext.get($scope.carGridId);
				if (gridEl && gridEl.destroy) {
					gridEl.destroy();
				};
			});
		angular.element($window).bind("scroll", function(e) {
			$rootScope.headerGone = this.pageYOffset >= 64;
			$rootScope.$apply();
			$rootScope.$broadcast('scrollY:change', $rootScope.headerGone);
		});
	}
}
export default MainController;