'use strict';

describe('The main view', function () {
  var page, apiUrl;

  beforeEach(function () {
    browser.get('/');
    page = require('./main.po');
  });

  it('should include buttons', function() {
    expect(page.homeButton.getText()).toBe('HOME');
    expect(page.pointButton.getText()).toBe('POINTS');
  });

  it('should have correct routes', function () {
    page.pointButton.click().then(function () {
      expect(browser.getCurrentUrl()).toContain('/points');
    });

    page.homeButton.click().then(function () {
      expect(browser.getCurrentUrl()).not.toContain('/points');
    });
  });
});
