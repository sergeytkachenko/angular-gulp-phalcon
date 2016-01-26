Ext.define('Ucar.store.FuelTypes', {
	extend: 'Ext.data.Store',
	require: [
		'Ucar.model.FuelTypes'
	],
	mixins: [
		'Ucar.mixin.Promise'
	],
	model: 'Ucar.model.FuelTypes',
	autoLoad: true,
	remoteSort: true,
	proxy: {
		type: 'ajax',
		url: '/api/rest/fuel-types/findAll',
		reader: {
			type: 'json',
			rootProperty: 'data'
		}
	}
});