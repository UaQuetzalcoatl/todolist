(function() {
  'use strict';

  describe('point list controller', function () {
    var
      vm,
      $httpBackend,
      PointModel,
      $mdDialog,
      $rootScope;

    beforeEach(function () {
      module('app');
      module('app.points');
    });

    beforeEach(inject(function ($controller, _$rootScope_, _$httpBackend_, _PointModel_, _$mdDialog_, PointDialogSrv) {
      var resolvedPoints;

      $httpBackend = _$httpBackend_;
      PointModel = _PointModel_;
      $mdDialog = _$mdDialog_;
      $rootScope = _$rootScope_;
      $httpBackend.expectGET(/points\.json$/).respond('[{"id": "a", "name": "name1", "dueDate": "1983-10-04"}, {"id": "b", "name": "name2", "dueDate": "2015-10-04"}]');

      PointModel.getList().then(function (response) {
        resolvedPoints = response;
      });

      $httpBackend.flush();
      $rootScope.$apply();

      vm = $controller('PointsController', {
        '$mdDialog': $mdDialog,
        PointDialogSrv: PointDialogSrv,
        Points: resolvedPoints
      });
    }));

    afterEach(function () {
      $httpBackend.verifyNoOutstandingExpectation();
      $httpBackend.verifyNoOutstandingRequest();
    });

    it('should have 2 point models', function () {
      expect(vm.points.length === 2).toBeTruthy();
    });

    it('DueDate should be Date object', function () {
      expect(vm.points[0].dueDate instanceof Date).toBeTruthy();
    });

    describe('should have CRUD functionality', function () {
      var modalInstance;

      beforeEach(function () {
        spyOn($mdDialog, 'confirm').and.callThrough();
        spyOn($mdDialog, 'show').and.callFake(function () {
          var callbacks = {};

          modalInstance = {
            then: function(confirmCallback, cancelCallback) {
              callbacks.confirmCallBack = confirmCallback || angular.noop;
              callbacks.cancelCallback = cancelCallback || angular.noop;
            },
            hide: function(item) {
              callbacks.confirmCallBack(item);
            },
            cancel: function(type) {
              callbacks.cancelCallback(type);
            }
          };

          return modalInstance;
        });
      });

      afterEach(function () {
        modalInstance = undefined;
      });

      it('should open confirm dialog on delete', function () {
        vm.deleteItem(vm.points[0]);

        expect($mdDialog.confirm).toHaveBeenCalled();
        expect($mdDialog.show).toHaveBeenCalled();
      });

      it('should do nothing when deletion canceled', function () {
        vm.deleteItem(vm.points[0]);
        modalInstance.cancel();

        expect(vm.points.length).toEqual(2);
      });

      it('should delete point from the list', function () {
        $httpBackend.expectDELETE(/points\/a\.json/).respond(201);
        vm.deleteItem(vm.points[0]);
        modalInstance.hide();
        $httpBackend.flush();

        expect(vm.points.length).toEqual(1);
        expect(vm.points[0].id).toEqual('b');
      });

      it('should add point to the list', function () {
        var newItem = '{"id": "c", "name": "name3", "dueDate": "1983-10-04"}';
        $httpBackend.expectPOST(/points\.json/).respond(newItem);
        vm.addNew();
        modalInstance.hide(newItem);
        $httpBackend.flush();

        expect($mdDialog.show).toHaveBeenCalled();
        expect(vm.points.length).toEqual(3);
        expect(vm.points[2].id).toEqual('c');
      });

      it('should update point data in the list', function () {
        var
          point = '{"id": "a", "name": "name_edited", "dueDate": "1983-10-04"}',
          editedPoint = vm.points[0].clone();
        $httpBackend.expectPUT(/points\/a\.json/).respond(point);
        vm.edit(vm.points[0]);
        editedPoint.name = 'name_edited';
        modalInstance.hide(editedPoint);
        $httpBackend.flush();

        expect($mdDialog.show).toHaveBeenCalled();
        expect(vm.points.length).toEqual(2);
        expect(vm.points[0].name).toEqual('name_edited');
      });
    });
  });
})();
