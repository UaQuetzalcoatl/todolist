(function() {
  'use strict';

  angular
    .module('app')
    .config(config)
    .config(restangularConfig);

  /** @ngInject */
  function config($logProvider) {
    // Enable log
    $logProvider.debugEnabled(true);
  }

  /** @ngInject */
  function restangularConfig(RestangularProvider, apiUrl, moment, lodash) {
    RestangularProvider.setBaseUrl(apiUrl);
    RestangularProvider.setRequestSuffix('.json');
    RestangularProvider.setRequestInterceptor(function(element) {
      return lodash.mapValues(element, function(property) {
        if (angular.isDate(property)) {
          return moment(property).format('YYYY-MM-DD');
        }

        return property;
      });
    });
  }
})();
