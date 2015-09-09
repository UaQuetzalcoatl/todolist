(function () {
  'use strict';

  angular
    .module('app.points')
    .factory('PointDialogSrv', PointDialogSrv);

  PointDialogSrv.$inject = ['$mdDialog'];

  /* @ngInject */
  function PointDialogSrv($mdDialog) {
    var service = {
      open: open
    };

    return service;

    ////////////////

    function open(pointModel) {
      pointModel = pointModel || {name: null, due_date: null};

      return $mdDialog.show({
        controller: function ($scope, $mdDialog, point) {
          $scope.point = point;
          $scope.cancel = function () {
            $mdDialog.cancel();
          };
          $scope.save = function () {
            $mdDialog.hide(point);
          };
        },
        templateUrl: 'app/points/point-dialog/point-dialog.html',
        locals: {point: pointModel}
      });
    }
  }

})();
