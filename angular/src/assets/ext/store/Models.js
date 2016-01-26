Ext.define('Ucar.store.Models', {
	extend: 'Ext.data.Store',
	require: [
		'Ucar.model.Models'
	],
	mixins: [
		'Ucar.mixin.Promise'
	],
	model: 'Ucar.model.Models',
	autoLoad: true,
	remoteSort: true,
	proxy: {
		type: 'ajax',
		url: '/api/rest/models/findAll',
		reader: {
			type: 'json',
			rootProperty: 'data'
		}
	}
});