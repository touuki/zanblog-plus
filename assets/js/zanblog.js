/**
 * Functionality specific to Zanblog.
 *
 * Provides helper functions to enhance the theme experience.
 *
 */

jQuery(function () {
  zan.init();
});

var zan = {

  init: function () {
    // set default value
    var defaultState = jQuery('.if-navbar-fixed').attr('data-state');
    if (defaultState) {
      window.localStorage.setItem('ifNavbarFixed', defaultState);
    }

    var ifNavbarFixed = window.localStorage.getItem('ifNavbarFixed');
    if (ifNavbarFixed) {
      if (ifNavbarFixed === 'checked') {
        jQuery('.if-navbar-fixed').addClass("checked");
      } else {
        jQuery('.if-navbar-fixed').removeClass("checked");
      }
    }
    jQuery('.if-navbar-fixed').click(this.ifNavbarFixedClick);

    jQuery(".goto-top").click(this.gotoTop);

    jQuery('.nav.navbar-nav li').mouseover(this.openMenu).mouseout(this.closeMenu);

    jQuery('.panel-btn-toggle').data('toggle', true).click(this.panelToggle);
    jQuery('.panel-btn-remove').click(this.panelClose);

    this.bodyPaddingTop();
    this.showNavbarAccordingly(window.pageYOffset, zan.prevScrollpos);
    this.showGotoTopAccordingly();
    jQuery(window).resize(function () {
      zan.showNavbarAccordingly(window.pageYOffset, zan.prevScrollpos);
      zan.bodyPaddingTop();
    });

    jQuery(window).scroll(function () {
      zan.showNavbarAccordingly(window.pageYOffset, zan.prevScrollpos);
      zan.showGotoTopAccordingly();
      zan.prevScrollpos = window.pageYOffset;
    });
  },

  prevScrollpos: window.pageYOffset,

  openMenu: function () {
    var menu = jQuery(this);
    menu.addClass('open');
  },

  closeMenu: function () {
    var menu = jQuery(this);
    menu.removeClass('open');
  },

  showNavbarAccordingly: function (currentScrollPos, prevScrollpos) {
    if (jQuery('#top-menu').hasClass('in')) {
      return;
    }
    var width = jQuery(window).width();
    var height = jQuery('.navbar-fixed-top').height();
    var additionalHeight = jQuery('#wpadminbar').height() || 0;
    if (width <= 600 && additionalHeight > 0) {
      additionalHeight = currentScrollPos < additionalHeight ? additionalHeight - currentScrollPos : 0;
    }
    if (
      // screen is at the top
      currentScrollPos < height
      // scroll up
      || prevScrollpos >= currentScrollPos
      // fixed navbar
      || width >= 768 && jQuery('.if-navbar-fixed').hasClass('checked')
    ) {
      jQuery('.navbar-top').css('top', additionalHeight + 'px');
    } else {
      jQuery('.navbar-top').css('top', (additionalHeight - height) + 'px');
    }
  },

  showGotoTopAccordingly: function () {
    jQuery(window).scrollTop() > 200 ? jQuery(".goto-top").css({
      bottom: "20px"
    }) : jQuery(".goto-top").css({
      bottom: "-40px"
    });
  },

  gotoTop: function () {
    jQuery("body,html").animate({
      scrollTop: 0
    }, 500);
    return false;
  },

  ifNavbarFixedClick: function () {
    var btn = jQuery(this);
    if (btn.hasClass('checked')) {
      btn.removeClass('checked');
      window.localStorage.setItem('ifNavbarFixed', 'unchecked');
    } else {
      btn.addClass('checked');
      window.localStorage.setItem('ifNavbarFixed', 'checked');
    }
  },

  panelToggle: function () {
    var btn = jQuery(this);
    if (btn.data('toggle')) {
      btn
        .removeClass('fa-chevron-circle-up')
        .addClass('fa-chevron-circle-down')
        .data('toggle', false)
        .parents('.panel-heading').first()
        .nextAll()
        .slideToggle(300);
    } else {
      btn
        .removeClass('fa-chevron-circle-down')
        .addClass('fa-chevron-circle-up')
        .data('toggle', true)
        .parents('.panel-heading').first()
        .nextAll()
        .slideToggle(300);
    }
  },

  panelClose: function () {
    var btn = jQuery(this);
    btn.parents('.panel').first().toggle(300);
  },

  bodyPaddingTop: function () {
    jQuery('body').css('padding-top', jQuery('.navbar-fixed-top').height() + 'px');
  },
}