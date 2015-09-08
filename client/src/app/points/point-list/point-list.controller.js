(function () {
  'use strict';

  angular
    .module('app.points')
    .controller('PointsController', PointsController);

  PointsController.$inject = ['$mdDialog', 'Points', 'PointDialogSrv'];

  /* @ngInject */
  function PointsController($mdDialog, Points, PointDialogSrv) {
    /* jshint validthis: true */
    var vm = this;

    vm = angular.extend(vm, {
      points: Points,
      addNew: addNew,
      edit: edit,
      deleteItem: deleteItem
    });

    ////////////////

    function addNew() {
      PointDialogSrv.open().then(function (point) {
        vm.points.post(point).then(function (createdPoint) {
          vm.points.push(createdPoint);
        });
      });
    }

    function edit(point) {
      PointDialogSrv.open(point.clone()).then(function (updatedPoint) {
        updatedPoint.save().then(function () {
          var index = vm.points.indexOf(point);
          if (index > -1) {
            vm.points.splice(index, 1, updatedPoint);
          }
        });
      });
    }

    function deleteItem(point) {
      var confirm = $mdDialog.confirm()
        .title('Attention')
        .content('Are you sure you want to delete \'' + point.name + '\' item?')
        .ok('Ok')
        .cancel('Cancel');

      $mdDialog.show(confirm).then(function () {
        point.remove().then(function () {
          var index = vm.points.indexOf(point);
          if (index > -1) {
            vm.points.splice(index, 1);
          }
        });
      });
    }
  }
})();
