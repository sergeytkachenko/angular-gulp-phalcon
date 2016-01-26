Ext.define('Ucar.store.CarClass', {
	extend: 'Ext.data.Store',
	require: [
		'Ucar.model.CarClass'
	],
	mixins: [
		'Ucar.mixin.Promise'
	],
	model: 'Ucar.model.CarClass',
	autoLoad: true,
	remoteSort: true,
	proxy: {
		type: 'ajax',
		url: '/api/rest/car-class/findAll',
		reader: {
			type: 'json',
			rootProperty: 'data'
		}
	}
});