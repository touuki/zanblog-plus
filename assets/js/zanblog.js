/**
 * Functionality specific to Zanblog.
 *
 * Provides helper functions to enhance the theme experience.
 *
 */

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

    jQuery('.comment-switch-html').click(this.changeCommentEditorToHtml);
    jQuery('.comment-switch-tmce').click(this.changeCommentEditorToTmce);
    if (jQuery('textarea#comment').hasClass('comment-textarea')) {
      jQuery('.comment-form .submit').click(function () {
        if (jQuery('.comment-editor-wrap').hasClass('comment-tmce-active')) {
          zan.syncTmceToTextarea();
        }
      });
    }

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

  syncTmceToTextarea: function () {
    jQuery('.comment-textarea').val(wp.editor.removep(tinymce.get('comment-tinymce').getContent()));
  },

  syncTextareaToTmce: function () {
    tinymce.get('comment-tinymce').setContent(wp.editor.autop(jQuery('.comment-textarea').val()));
  },

  changeCommentEditorToHtml: function () {
    var wrap = jQuery('.comment-editor-wrap');
    if (wrap.hasClass('comment-html-active')) {
      return;
    }
    zan.syncTmceToTextarea();
    wrap.removeClass('comment-tmce-active').addClass('comment-html-active');
    jQuery('.mce-floatpanel').css('display', 'none');
    jQuery('.comment-tinymce').css('display', 'none');
    jQuery('.comment-textarea').css('display', '');
  },

  changeCommentEditorToTmce: function () {
    var wrap = jQuery('.comment-editor-wrap');
    if (wrap.hasClass('comment-tmce-active')) {
      return;
    }
    zan.syncTextareaToTmce();
    wrap.removeClass('comment-html-active').addClass('comment-tmce-active');
    jQuery('.comment-textarea').css('display', 'none');
    jQuery('.comment-tinymce').css('display', '');
  },

  openMenu: function () {
    var menu = jQuery(this);
    menu.addClass('open');
  },

  closeMenu: function () {
    var menu = jQuery(this);
    menu.removeClass('open');
  },

  showNavbarAccordingly: function (currentScrollPos, prevScrollpos) {
    var width = jQuery(window).width();
    if (jQuery('#top-menu').hasClass('in') && width < 768) {
      return;
    }
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
    jQuery('.body-padding-top').css('height', jQuery('.navbar-fixed-top').height() + 'px');
  },
};

setTimeout(function () { zan.init(); });
