import config from './index.config';
import routerConfig from './index.route';
import runBlock from './index.run';

import MainController from './main/main.controller';

//import FilterBuilder from './components/services/FilterBuilder.js';

import FileRead from './components/directives/fileread.js';

angular.module('angular', [
	'ngAnimate', 'ngCookies', 'ngTouch', 'ngSanitize', 'ngResource',
	'ui.router', 'ngMaterial', 'ngMdIcons', 'ui-rangeSlider'
])
	.config(config)
	.config(routerConfig)

	.directive('fileread', () => new FileRead())

	.run(runBlock)

	.controller('MainController', MainController);
