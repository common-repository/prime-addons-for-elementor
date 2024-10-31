"use strict";

class TypingWidgetHandlerClass extends elementorModules.frontend.handlers.Base {
  getDefaultSettings() {
    return {
      selectors: {
        mainWrapper: '.pae-typing',
        dynamicText: '.pae-typing-text'
      }
    };
  }
  getDefaultElements() {
    const selectors = this.getSettings('selectors');
    return {
      $mainWrapper: this.$element.find(selectors.mainWrapper),
      $dynamicText: this.$element.find(selectors.dynamicText)
    };
  }
  bindEvents() {
    const textsRaw = this.elements.$mainWrapper.data('texts');
    if (textsRaw) {
      const texts = textsRaw.split('||');
      const settings = {
        strings: texts,
        typeSpeed: 50,
        loop: true
      };
      new Typed(this.elements.$dynamicText[0], settings);
    }
  }
}
jQuery(window).on('elementor/frontend/init', () => {
  const addTypingWidgetHandler = $element => {
    elementorFrontend.elementsHandler.addHandler(TypingWidgetHandlerClass, {
      $element
    });
  };
  elementorFrontend.hooks.addAction('frontend/element_ready/pae-typing.default', addTypingWidgetHandler);
});