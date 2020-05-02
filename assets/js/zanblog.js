/**
 * Functionality specific to Zanblog.
 *
 * Provides helper functions to enhance the theme experience.
 *
 * Website: www.yeahzan.com
 */

jQuery(function () {
  zan.init();
});

var zan = {

  //初始化函数
  init: function () {
    this.topFixed();
    this.goTop();
    this.dropDown();
    this.panelToggle();
    this.panelClose();
  },

  // 回到顶端
  goTop: function () {
    jQuery(window).scroll(function () {
      jQuery(this).scrollTop() > 200 ? jQuery("#zan-gotop").css({
        bottom: "20px"
      }) : jQuery("#zan-gotop").css({
        bottom: "-40px"
      });
    });

    jQuery("#zan-gotop").click(function () {
      return jQuery("body,html").animate({
        scrollTop: 0
      }, 500), !1
    });
  },

  // 头部固定
  topFixed: function () {

    var zanHeader = jQuery('#zan-header');
    var body = jQuery('body');
    var ifFixed = zanHeader.find('input[type="checkbox"]');
    var storage = window.localStorage;

    storage.setItem('ifFixed', 'fixed');
    // 将这行代码注释去掉可以实现网站头部默认钉住。

    if (!storage.getItem('ifFixed')) {

      storage.setItem('ifFixed', 'float');
    } else {
      if (storage.getItem('ifFixed') == 'fixed') {

        zanHeader.addClass('navbar-fixed-top');
        body.addClass('nav-fixed');
        ifFixed.prop("checked", true);
      } else {

        zanHeader.removeClass('navbar-fixed-top');
        body.removeClass('nav-fixed');
        ifFixed.prop("checked", false);
      }
    }

    ifFixed.on('change', function () {
      if (jQuery(this).is(':checked')) {
        zanHeader.addClass('navbar-fixed-top');
        body.addClass('nav-fixed');
        storage.setItem('ifFixed', 'fixed');
      } else {
        zanHeader.removeClass('navbar-fixed-top');
        body.removeClass('nav-fixed');
        storage.setItem('ifFixed', 'float');
      }
    });
  },

  // 菜单下拉
  dropDown: function () {
    var dropDownLi = jQuery('.nav.navbar-nav li');

    dropDownLi.mouseover(function () {
      jQuery(this).addClass('open');
    }).mouseout(function () {
      jQuery(this).removeClass('open');
    });
  },

  // 小工具显示/隐藏
  panelToggle: function () {
    jQuery('.panel-btn-toggle')
      .data('toggle', true)
      .click(function () {
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
      });
  },

  // 小工具删除
  panelClose: function () {
    jQuery('.panel-btn-remove').click(function () {
      jQuery(this).parents('.panel').first().toggle(300);
    });
  },
}