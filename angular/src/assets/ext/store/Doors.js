Ext.define('Ucar.store.Doors', {
	extend: 'Ext.data.Store',
	mixins: [
		'Ucar.mixin.Promise'
	],
	model: 'Ucar.model.Doors',
	autoLoad: true,
	remoteSort: true,
	proxy: {
		type: 'ajax',
		url: '/api/rest/helper/findDoorsAll',
		reader: {
			type: 'json',
			rootProperty: 'data'
		}
	}
});