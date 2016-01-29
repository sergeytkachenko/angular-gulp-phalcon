function routerConfig($stateProvider, $urlRouterProvider) {
	'ngInject';

	$stateProvider
		.state('root', {
			abstract: true,
			views: {
				'nav@': {
					templateUrl: ''
				}
			}
		});

	$urlRouterProvider.otherwise('/');
}

export default routerConfig;
