Ext.define('Ucar.store.Brands', {
	extend: 'Ext.data.Store',
	require: [
		'Ucar.model.Brands'
	],
	mixins: [
		'Ucar.mixin.Promise'
	],
	model: 'Ucar.model.Brands',
	autoLoad: true,
	remoteSort: true,
	proxy: {
		type: 'ajax',
		url: '/api/rest/brands/findAll',
		reader: {
			type: 'json',
			rootProperty: 'data'
		}
	}
});