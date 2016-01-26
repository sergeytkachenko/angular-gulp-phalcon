Ext.define('Ucar.store.Cars', {
	extend: 'Ext.data.Store',
	require: [
		'Ucar.model.Cars'
	],
	mixins: [
		'Ucar.mixin.Promise'
	],
	model: 'Ucar.model.Cars',
	autoLoad: true,
	remoteSort: true,
	proxy: {
		actionMethods : {
			read   : 'POST'
		},
		type: 'ajax',
		url: '/api/rest/cars/findAll',
		reader: {
			type: 'json',
			rootProperty: 'data'
		}
	}
});