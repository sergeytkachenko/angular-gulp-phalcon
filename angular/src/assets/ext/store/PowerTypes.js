Ext.define('Ucar.store.PowerTypes', {
	extend: 'Ext.data.Store',
	require: [
		'Ucar.model.PowerTypes'
	],
	mixins: [
		'Ucar.mixin.Promise'
	],
	model: 'Ucar.model.PowerTypes',
	autoLoad: true,
	remoteSort: true,
	proxy: {
		type: 'ajax',
		url: '/api/rest/power-types/findAll',
		reader: {
			type: 'json',
			rootProperty: 'data'
		}
	}
});