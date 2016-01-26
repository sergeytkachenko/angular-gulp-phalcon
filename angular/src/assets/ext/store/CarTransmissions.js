Ext.define('Ucar.store.CarTransmissions', {
	extend: 'Ext.data.Store',
	require: [
		'Ucar.model.CarTransmissions'
	],
	mixins: [
		'Ucar.mixin.Promise'
	],
	model: 'Ucar.model.CarTransmissions',
	autoLoad: true,
	remoteSort: true,
	proxy: {
		type: 'ajax',
		url: '/api/rest/transmissions/findAll',
		reader: {
			type: 'json',
			rootProperty: 'data'
		}
	}
});