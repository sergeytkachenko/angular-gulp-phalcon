class ImportController {
	/*@ngInject*/
	constructor($scope, $element, $http, $mdDialog) {
		$scope.parsedEntities = [];
		$scope.uploadInput = 'uploadInput';
		$scope.fileName = null;
		$scope.clearFile = function () {
			$element.find('#' + $scope.uploadInput)[0].value = '';
		};
		$scope.openFileDialog = function (fileInputId) {
			$element.find('#' + fileInputId)[0].click();
		}
		$scope.upload = function (data) {
			$scope.clearFile();
			if (data.indexOf('.sheet') === -1) {
				$scope.alert('Помилка файлу', 'Не вірний формат шаблону. Можливо ви завантажили старий формат шаблону?');
				return;
			}
			$mdDialog.show({
				templateUrl: '/app/components/wait.html'
			});
			$http.post('/api/import/parse', {
				data: data
			}).then(function (res) {
				$mdDialog.hide();
				if (res.data.success === true) {
					$scope.parsedEntities = res.data.data;
					$scope.fileName = res.data.fileName;
					return;
				}
				$scope.parsedEntities = [];
				$scope.alert('Помилка файлу', res.data.msg);
			});
		}
		$scope.cancelImport = function () {
			$scope.parsedEntities = [];
		}
		$scope.saveImport = function () {
			$mdDialog.show({
				templateUrl: '/app/components/wait.html'
			});
			$http.get('/api/import/save?filename=' + $scope.fileName)
				.then(function (res) {
					$mdDialog.hide();
					if (res.data.success === true) {
						$scope.parsedEntities = [];
						if (res.data.msg) {
							$scope.alert('', res.data.msg);
						}
						return;
					}
					$scope.alert('Помилка файлу', res.data.msg);
				});
		}

		$scope.alert = function (title, msg) {
			var alert = $mdDialog.alert()
				.title(title)
				.content(msg)
				.ok('Закрити');
			$mdDialog
				.show(alert)
				.finally(function () {
					alert = undefined;
				});
		}
	}
}

export default ImportController;
