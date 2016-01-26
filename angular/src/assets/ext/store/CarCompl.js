Ext.define('Ucar.store.CarCompl', {
	extend: 'Ext.data.Store',
	require: [
		'Ucar.model.CarCompl'
	],
	mixins: [
		'Ucar.mixin.Promise'
	],
	model: 'Ucar.model.CarCompl',
	autoLoad: true,
	remoteSort: true,
	proxy: {
		type: 'ajax',
		url: '/api/rest/car-compl/findAll',
		reader: {
			type: 'json',
			rootProperty: 'data'
		}
	}
});