(function () {
  'use strict';

  angular
    .module('app.points')
    .controller('PointsController', PointsController);

  PointsController.$inject = ['Points'];

  /* @ngInject */
  function PointsController(Points) {
    /* jshint validthis: true */
    var vm = this;

    vm = angular.extend(vm, {
      points: Points,
      addNew: addNew
    });


    ////////////////

    function addNew() {
      console.log('add new');
    }


  }
})();
