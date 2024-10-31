"use strict";

class CountdownWidgetHandlerClass extends elementorModules.frontend.handlers.Base {
  getDefaultSettings() {
    return {
      selectors: {
        mainWrapper: '.pae-countdown',
        countdownContent: '.countdown-content'
      }
    };
  }
  getDefaultElements() {
    const selectors = this.getSettings('selectors');
    return {
      $mainWrapper: this.$element.find(selectors.mainWrapper),
      $countdownContent: this.$element.find(selectors.countdownContent)
    };
  }
  bindEvents() {
    const filter = this.elements.$mainWrapper.data('filter');
    const expiredNotice = this.elements.$mainWrapper.data('expired-notice');
    const $target = this.elements.$countdownContent;
    $target.countdown(filter).on('update.countdown', function (event) {
      let format = '%H:%M:%S';
      if (event.offset.totalDays > 0) {
        format = '%-d day%!d ' + format;
      }
      if (event.offset.weeks > 0) {
        format = '%-w week%!w ' + format;
      }
      $target.html(event.strftime(format));
    }).on('finish.countdown', function () {
      $target.html(expiredNotice).parent().addClass('disabled');
    });
  }
}
jQuery(window).on('elementor/frontend/init', () => {
  const addCountdownWidgetHandler = $element => {
    elementorFrontend.elementsHandler.addHandler(CountdownWidgetHandlerClass, {
      $element
    });
  };
  elementorFrontend.hooks.addAction('frontend/element_ready/pae-countdown.default', addCountdownWidgetHandler);
});