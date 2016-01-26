class SidebarController {

	constructor($scope) {
		'ngInject';
		$scope.brands = [
			{
				id: 1,
				title: 'Kia'
			}, {
				id: 2,
				title: 'Opel'
			}, {
				id: 3,
				title: 'BMW'
			}
		];

		$scope.carCategories = [
			{
				id: 1,
				title: 'Седан',
				iconCls: 'sedan'
			}, {
				id: 3,
				title: 'Пикап',
				iconCls: 'pickup'
			}, {
				id: 4,
				title: 'Кабриолет / родстер',
				iconCls: 'cabriolet'
			}, {
				id: 8,
				title: 'Спортивный',
				iconCls: 'sport'
			}, {
				id: 2,
				title: 'Малолитражный ',
				iconCls: 'mini'
			}, {
				id: 5,
				title: 'Универсал ',
				iconCls: 'universal'
			}, {
				id: 6,
				title: 'Минивэн',
				iconCls: 'miniven'
			}, {
				id: 7,
				title: 'Микроавтобус',
				iconCls: 'microbus'
			}
		];

		$scope.data = {
			group3 : 'avatar-1'
		};
		$scope.avatarData = [{
			id: "avatars:svg-1",
			title: 'avatar 1',
			value: 'avatar-1'
		},{
			id: "avatars:svg-2",
			title: 'avatar 2',
			value: 'avatar-2'
		},{
			id: "avatars:svg-3",
			title: 'avatar 3',
			value: 'avatar-3'
		}];
		$scope.radioData = [
			{ label: '1', value: 1 },
			{ label: '2', value: 2 },
			{ label: '3', value: '3', isDisabled: true },
			{ label: '4', value: '4' }
		];

	}

}

export default SidebarController;
