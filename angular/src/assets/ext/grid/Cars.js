Ext.define('Ucar.grid.Cars', {
	extend: 'Ext.grid.Panel',

	require: [
		'Ucar.store.Brands',
		'Ucar.store.CarClass',
		'Ucar.store.CarTypes',
		'Ucar.store.FuelTypes',
		'Ucar.store.PowerTypes',
		'Ucar.store.Models',
		'Ucar.store.ClimateControls',
	],

	constructor: function() {
		var grid = this;
		this.store = Ext.create('Ucar.store.Cars');
		this.store.on('load', function() {
			grid.fireEvent('loadItems', this);
			grid.setHeight();
		});
		this.callParent(arguments);
	},

	width: '100%',
	lineHeight: 94,
	title: 'Автомобили',
	header: false,
	store: null,
	forceFit: true,
	viewConfig: {
		style: {
			overflow: 'auto',
			overflowX: 'hidden',
			forceFit: true
		}
	},

	viewConfig: {
		stripeRows: false,
		getRowClass: function(record, rowIndex, rowParams, store){
			return 'row-width-img';
		}
	},

	listeners: {
		loadItems: function(store) {

		}
	},

	setHeight: function() {
		var gridHeight = this.lineHeight * this.store.getCount();
		this.callParent([gridHeight + 35]); // TODO высота header
	},

	columns: [{
		text: 'Фото',
		width: 130,
		sortable: true,
		dataIndex: 'general_img',
		renderer: function(val) {
			var img = val? val : '/assets/img/car-no-photo.png';
			return '<img src=' + img + ' class="car-grid-img" />';
		}
	}, {
		text: 'Модель',
		flex: 1,
		sortable: true,
		dataIndex: 'model_id',
		renderer: function(val) {
			var model = this.storages['modelsStore'].getById(val);
			if(null===model) {return ''};
			return model.get('title');
		}
	}, {
		header: 'Виробник',
		flex: 1,
		sortable: true,
		dataIndex: 'brand_id',
		renderer: function(val) {
			var model = this.storages['brandsStore'].getById(val);
			if(null===model) {return ''};
			return model.get('title');
		}
	}, {
		header: 'Тип авто',
		flex: 1,
		sortable: true,
		dataIndex: 'car_type_id',
		renderer: function(val) {
			var model = this.storages['carTypesStore'].getById(val);
			if(null===model) {return ''};
			return model.get('title');
		}
	}, {
		header: 'Тип пального',
		flex: 1,
		sortable: true,
		dataIndex: 'fuel_type_id',
		renderer: function(val) {
			var model = this.storages['fuelTypesStore'].getById(val);
			if(null===model) {return ''};
			return model.get('title');
		}
	}, {
		header: 'Клас Авто',
		flex: 1,
		sortable: true,
		dataIndex: 'car_class_id',
		renderer: function(val) {
			var model = this.storages['carClassStore'].getById(val);
			if(null===model) {return ''};
			return model.get('title');
		}
	}, {
		header: 'Комплектація',
		flex: 1,
		sortable: true,
		dataIndex: 'car_compl_id',
		renderer: function(val) {
			var model = this.storages['carComplStore'].getById(val);
			if(null===model) {return ''};
			return model.get('title');
		}
	}, {
		header: 'Рік випуску',
		flex: 1,
		sortable: true,
		dataIndex: 'model_year',
		renderer: Ext.util.Format.dateRenderer('Y')
	}, {
		header: 'Трансмісія',
		flex: 1,
		sortable: true,
		dataIndex: 'transmission_id',
		renderer: function(val) {
			var model = this.storages['carTransmissionsStore'].getById(val);
			if(null===model) {return ''};
			return model.get('title');
		}
	}, {
		header: 'Кількість дверей',
		flex: 1,
		sortable: true,
		dataIndex: 'doors'
	}, {
		header: 'Об\'єм двигуна',
		flex: 1,
		sortable: true,
		dataIndex: 'engine_capacity'
	}/*, {
		header: 'Климат контроль',
		flex: 1,
		sortable: true,
		dataIndex: 'climate_control_id',
		renderer: function(val) {
			var model = this.climateControlsStore.getById(val);
			if(null===model) {return ''};
			return model.get('title');
		}
	}*/]
});


