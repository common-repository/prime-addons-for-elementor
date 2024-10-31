"use strict";

const PAECarousel = function ($wrapper) {
  const swiperLoader = (swiperElement, swiperConfig) => {
    if ('undefined' === typeof Swiper) {
      const asyncSwiper = elementorFrontend.utils.swiper;
      return new asyncSwiper(swiperElement, swiperConfig).then(newSwiperInstance => {
        return newSwiperInstance;
      });
    }
    return swiperPromise(swiperElement, swiperConfig);
  };
  const swiperPromise = (swiperElement, swiperConfig) => {
    return new Promise(resolve => {
      const swiperInstance = new Swiper(swiperElement, swiperConfig);
      resolve(swiperInstance);
    });
  };
  const autoplay = $wrapper.data('autoplay');
  const columns = $wrapper.data('columns');
  const gap = $wrapper.data('gap');
  const responsiveGap = gap - 10;
  let columnsMd;
  if (columns > 1) {
    columnsMd = 2;
  } else {
    columnsMd = 1;
  }
  const swiperConfig = {
    slidesPerView: columns,
    spaceBetween: parseInt(gap),
    lazy: true,
    autoplayDisableOnInteraction: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    },
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    },
    breakpoints: {
      1920: {
        slidesPerView: columns
      },
      1024: {
        slidesPerView: columns,
        spaceBetween: responsiveGap
      },
      768: {
        slidesPerView: columnsMd,
        spaceBetween: responsiveGap
      },
      640: {
        slidesPerView: 1,
        spaceBetween: 0
      },
      320: {
        slidesPerView: 1,
        spaceBetween: 0
      }
    }
  };
  if ('yes' === autoplay) {
    swiperConfig.autoplay = {
      delay: 3000
    };
  }
  $wrapper.imagesLoaded(function () {
    $wrapper.fadeIn();
    swiperLoader($wrapper, swiperConfig);
  });
};
class CarouselWidgetHandlerClass extends elementorModules.frontend.handlers.Base {
  getDefaultSettings() {
    return {
      selectors: {
        mainWrapper: '.pae-carousel'
      }
    };
  }
  getDefaultElements() {
    const selectors = this.getSettings('selectors');
    return {
      $mainWrapper: this.$element.find(selectors.mainWrapper)
    };
  }
  bindEvents() {
    PAECarousel(this.elements.$mainWrapper);
  }
}
jQuery(window).on('elementor/frontend/init', () => {
  const addCarouselWidgetHandler = $element => {
    elementorFrontend.elementsHandler.addHandler(CarouselWidgetHandlerClass, {
      $element
    });
  };
  elementorFrontend.hooks.addAction('frontend/element_ready/pae-post-carousel.default', addCarouselWidgetHandler);
  elementorFrontend.hooks.addAction('frontend/element_ready/pae-woo-product-carousel.default', addCarouselWidgetHandler);
  elementorFrontend.hooks.addAction('frontend/element_ready/pae-lp-course-carousel.default', addCarouselWidgetHandler);
  elementorFrontend.hooks.addAction('frontend/element_ready/pae-edd-product-carousel.default', addCarouselWidgetHandler);
  elementorFrontend.hooks.addAction('frontend/element_ready/pae-testimonial-carousel.default', addCarouselWidgetHandler);
  elementorFrontend.hooks.addAction('frontend/element_ready/pae-picture-carousel.default', addCarouselWidgetHandler);
});