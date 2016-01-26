Ext.define('Ucar.store.ModelYear', {
	extend: 'Ext.data.Store',
	mixins: [
		'Ucar.mixin.Promise'
	],
	model: 'Ucar.model.ModelYear',
	autoLoad: true,
	remoteSort: true,
	proxy: {
		type: 'ajax',
		url: '/api/rest/helper/findModelYearAll',
		reader: {
			type: 'json',
			rootProperty: 'data'
		}
	}
});