/**
 * @file
 * materialize-init.js
 *
 * Init materialize components.
 */

var Drupal = Drupal || {};

(function ($, Drupal, drupalSettings) {
  "use strict";

  Drupal.behaviors.initMobileMenu = {
    attach: function (context) {
      $('.button-collapse').once().sideNav();
    }
  };
  Drupal.behaviors.initDatePicker = {
    attach: function (context) {
      $('.datepicker').once().pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15 // Creates a dropdown of 15 years to control year
      });
    }
  };
  Drupal.behaviors.initSelectFields = {
    attach: function (context) {
      $('select').once().material_select();
    }
  };


})(jQuery, Drupal, drupalSettings);
