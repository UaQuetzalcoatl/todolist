/* global malarkey:false, toastr:false, moment:false */
(function() {
  'use strict';

  angular
    .module('app')
    .constant('malarkey', malarkey)
    .constant('toastr', toastr)
    .constant('moment', moment)
    .constant('apiUrl', 'http://127.0.0.1:8000/app_dev.php/');

})();
