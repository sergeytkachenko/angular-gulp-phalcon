Ext.define('Ucar.store.CarTypes', {
	extend: 'Ext.data.Store',
	require: [
		'Ucar.model.CarTypes'
	],
	mixins: [
		'Ucar.mixin.Promise'
	],
	model: 'Ucar.model.CarTypes',
	autoLoad: true,
	remoteSort: true,
	proxy: {
		type: 'ajax',
		url: '/api/rest/car-types/findAll',
		reader: {
			type: 'json',
			rootProperty: 'data'
		}
	}
});