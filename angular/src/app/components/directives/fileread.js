class FileRead {
	/*@ngInject*/
	constructor() {
		this.scope =  {
			fileread: '='
		};
	}

	link(scope, element) {
		element.bind('change', function (changeEvent) {
			var reader = new FileReader();
			reader.onload = function (loadEvent) {
				scope.$apply(function () {
					scope.fileread(loadEvent.target.result);
				});
			};
			reader.readAsDataURL(changeEvent.target.files[0]);
		});
	}
}

export default FileRead;