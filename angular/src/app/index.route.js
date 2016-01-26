function routerConfig($stateProvider, $urlRouterProvider) {
	'ngInject';

	$stateProvider
		.state('root', {
			abstract: true,
			views: {
				'nav@': {
					templateUrl: 'app/components/nav.html'
				},
				'filter@': {
					templateUrl: 'app/main/filter/filter.html',
					controller: 'FilterController'
				}
			}
		})

		.state('root.main', {
			url: '/',
			views: {
				'container@': {
					templateUrl: 'app/main/main.html',
					controller: 'MainController'
				}
			}
		})

		.state('root.import', {
			url: '/import',
			views: {
				'container@': {
					templateUrl: 'app/import/import.html',
					controller: 'ImportController'
				},
				'filter@': ''
			}
		})

		.state('root.import.accept', {
			url: '/accept',
			views: {
				'container@': {
					templateUrl: 'app/import/accept/accept.html',
					controller: 'ImportAcceptController'
				},
				'filter@': ''
			}
		});

	$urlRouterProvider.otherwise('/');
}

export default routerConfig;
