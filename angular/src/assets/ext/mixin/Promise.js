Ext.define('Ucar.mixin.Promise', {
	loadByPromise: function () {
		var self = this;
		return new Promise(function (next, reject) {
			self.on('load', next);
			self.load();
		});
	}
});