Ext.define('Ucar.store.ClimateControls', {
	extend: 'Ext.data.Store',
	require: [
		'Ucar.model.ClimateControls'
	],
	mixins: [
		'Ucar.mixin.Promise'
	],
	model: 'Ucar.model.ClimateControls',
	autoLoad: true,
	remoteSort: true,
	proxy: {
		type: 'ajax',
		url: '/api/rest/climate-controls/findAll',
		reader: {
			type: 'json',
			rootProperty: 'data'
		}
	}
});