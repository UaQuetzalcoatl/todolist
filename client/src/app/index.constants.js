/* global malarkey:false, moment:false, _:false */
(function() {
  'use strict';

  angular
    .module('app')
    .constant('malarkey', malarkey)
    .constant('lodash', _)
    .constant('moment', moment)
    .constant('apiUrl', 'http://127.0.0.1:8000/app_dev.php/');

})();
