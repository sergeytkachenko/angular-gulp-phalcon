import config from './index.config';
import routerConfig from './index.route';
import runBlock from './index.run';

import MainController from './main/main.controller';
import ImportController from './import/import.controller';
import FilterController from './main/filter/filter.controller';
import SidebarController from './components/sidebar/sidebar.controller';

import FilterBuilder from './components/services/FilterBuilder.js';

import FileRead from './components/directives/fileread.js';
import ButtonsFilter from './components/directives/buttons-filter/buttonsFilter.js';
import QuickFilter from './components/directives/quick-filter/quickFilter.js';

angular.module('angular', ['ngAnimate', 'ngCookies', 'ngTouch', 'ngSanitize', 'ngResource', 'ui.router', 'ngMaterial', 'ngMdIcons', 'ui-rangeSlider'])
	.config(config)
	.config(routerConfig)

	.directive('fileread', () => new FileRead())
	.directive('buttonsFilter', () => new ButtonsFilter())
	.directive('quickFilter', () => new QuickFilter())

	.service('filterBuilder', FilterBuilder)

	.run(runBlock)

	.controller('MainController', MainController)
	.controller('ImportController', ImportController)
	.controller('FilterController', FilterController)
	.controller('SidebarController', SidebarController);
