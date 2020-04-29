/**
 * Functionality specific to Zanblog.
 *
 * Provides helper functions to enhance the theme experience.
 *
 * Website: www.yeahzan.com
 */

jQuery(function() {
	zan.init();
});

var zan = {

	//初始化函数
	init: function() {
		this.topFixed();
		this.goTop();
		this.dropDown();
		this.panelToggle();
		this.panelClose();
		this.btnLoading();
		this.setImgHeight();
		this.archivesNum();
		// this.lazyload();
		this.commentValidate();
		this.ajaxCommentsReply();
		this.ajaxCommentsPage();
	},

	// 回到顶端
	goTop: function() {
		jQuery(window).scroll(function() {
			jQuery(this).scrollTop() > 200 ? jQuery("#zan-gotop").css({
				bottom: "20px"
			}) : jQuery("#zan-gotop").css({
				bottom: "-40px"
			});
		});

		jQuery("#zan-gotop").click(function() {
			return jQuery("body,html").animate({
				scrollTop: 0
			}, 500), !1
		});
	},

	// 头部固定
	topFixed: function() {

    	var zanHeader = jQuery('#zan-header');
    	var body = jQuery('body');
    	var ifFixed = zanHeader.find('input[type="checkbox"]');
    	var storage = window.localStorage;

  		storage.setItem('ifFixed', 'fixed');  
  		// 将这行代码注释去掉可以实现网站头部默认钉住。

    	if(!storage.getItem('ifFixed')) {

    		storage.setItem('ifFixed', 'float');
    	} else {
    		if(storage.getItem('ifFixed') == 'fixed') {

		  		zanHeader.addClass('navbar-fixed-top');
		  		body.addClass('nav-fixed');
		  		ifFixed.iCheck('check');
    		} else {

    			zanHeader.removeClass('navbar-fixed-top');
		  		body.removeClass('nav-fixed');
		  		ifFixed.iCheck('uncheck');
    		}
    	}

	    ifFixed.iCheck({
	    	checkboxClass: 'icheckbox_flat-red'
	  	});

	  	ifFixed.on('ifChecked', function(event){
		  	zanHeader.addClass('navbar-fixed-top');
		  	body.addClass('nav-fixed');
		  	storage.setItem('ifFixed', 'fixed');

		}).on('ifUnchecked', function(event) {
			zanHeader.removeClass('navbar-fixed-top');
		  	body.removeClass('nav-fixed');
		  	storage.setItem('ifFixed', 'float');
		});
	},
	
	// 菜单下拉
	dropDown: function() {
		var dropDownLi = jQuery('.nav.navbar-nav li');

		dropDownLi.mouseover(function() {
			jQuery(this).addClass('open');
		}).mouseout(function() {
			jQuery(this).removeClass('open');
		});
	},

	// 小工具显示/隐藏
	panelToggle: function() {

		var toggleBtn = jQuery('.panel-toggle');

		toggleBtn.data('toggle', true);

		toggleBtn.click(function() {

			var btn = jQuery(this);

			if(btn.data('toggle')) {

				btn.removeClass('fa-chevron-circle-up').addClass('fa-chevron-circle-down');
				btn.parents('div.panel').addClass('toggled');
				btn.data('toggle', false);
			} else {

				btn.removeClass('fa-chevron-circle-down').addClass('fa-chevron-circle-up');
				btn.parents('div.panel').removeClass('toggled');
				btn.data('toggle', true);
			}

		});
	},

    // 小工具删除
	panelClose: function() {

		var closeBtn = jQuery('.panel-remove');

		closeBtn.click(function() {

			var btn = jQuery(this);

			btn.parents('.panel').toggle(300);
			
		});
	},

	btnLoading:	function() {

		var loadBtn = jQuery('#load-more');
		var loadData = loadBtn.attr('load-data');

		loadBtn.click(function() {

			loadBtn.addClass('disabled');
			loadBtn.find('i').addClass('fa fa-spinner fa-spin');
			loadBtn.find('attr').text(loadData);
		})
	},

	// 设置图片高度
	setImgHeight: function() {

		var img = jQuery(".content-article p").find("img");

		img.each(function() {

			var $this = jQuery(this);
			var attrWidth = $this.attr('width');
			var attrHeight = $this.attr('height');
			var width = $this.width();

			var scale = width / attrWidth;
			var height = scale * attrHeight;

			$this.css('height', height);

		});
	},

	// 文章存档添加字段
	archivesNum: function() {

		jQuery('#archives .panel-body').each(function() {

			var num = jQuery(this).find('p').size();
			var archiveA = jQuery(this).parent().siblings().find("a");
			var text = archiveA.text();

			archiveA.html(text + ' <small>(' + num + '篇文章)</small>');
		});
 	},

 	// 延时加载图片功能
	lazyload: function() {
		jQuery("#sidebar img.lazy").lazyload({ threshold : 800});
		jQuery("#smilelink img.lazy").lazyload({ threshold : 800});
		jQuery("img.lazy").lazyload({ effect : "fadeIn" ,threshold : 800,skip_invisible : false});

	},

	// 评论验证
	commentValidate: function() {
	  jQuery( '#commentform' ).validate( {
	    rules: {
	      author: {
	        required: true
	      },
	      email: {
	        required: true,
	        email: true
	      },
	      url: {
	        url:true
	      },
	      comment: {
	        required: true
	      }
	    },
	    messages: {
	      author: {
	        required: "用户名不能为空！"
	      },
	      email: {
	        required: "邮箱不能为空！",
	        email: "邮箱格式不正确！"
	      },
	      url: {
	        url: "输入的网址不正确！"
	      },
	      comment: {
	        required: "留言内容不能为空！"
	      }
	    }
	  } );
	},

	// ajax评论回复
	ajaxCommentsReply :function() {
		var $ = jQuery.noConflict();

		var $commentform = $('#commentform'),
		    txt1 = '<div id="loading"><i class="fa fa-spinner fa-spin"></i> 正在提交, 请稍候...</div>',
		    txt2 = '<div id="error">#</div>',
				cancel_edit = '取消编辑',
				num = 1,
				$comments = $('#comments-title'),
				$cancel = $('#cancel-comment-reply-link'),
				cancel_text = $cancel.text(),
				$submit = $('#commentform #submit');

				$submit.attr('disabled', false),
				$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body'),
				comm_array = [];
				comm_array.push('');
				
        $('#comment').after(txt1 + txt2);
				$('#loading').hide();
				$('#error').hide();

		$(document).on("submit", "#commentform",
		  function() {
				$submit.attr('disabled', true).fadeTo('slow', 0.5);
				$('#loading').slideDown();

				$.ajax({
					url: $("#comments").attr("data-url"),
					data: $(this).serialize() + "&action=ajax_comment",
					type: $(this).attr('method'),
					error: function(request) {
						$('#loading').hide();
						$("#error").slideDown().html(request.responseText);
						setTimeout(function() {
							$submit.attr('disabled', false).fadeTo('slow', 1);
							$('#error').slideUp();
						},
						3000);
					},
					success: function(data) {
						$('#loading').hide();
						comm_array.push($('#comment').val());
						$('textarea').each(function() {
							this.value = ''
						});

						var t = addComment,
						cancel = t.I('cancel-comment-reply-link'),
						temp = t.I('wp-temp-form-div'),
						respond = t.I(t.respondId);
						post = t.I('comment_post_ID').value,
						parent = t.I('comment_parent').value;

						if ($comments.length) {
							n = parseInt($comments.text().match(/\d+/));
							$comments.text($comments.text().replace(n, n + 1));
						}

						new_htm = '" id="new-comm-' + num + '"></';
						new_htm = (parent == '0') ? ('\n<ol class="commentlist' + new_htm + 'ol>') : ('\n<ol class="children' + new_htm + 'ol>');
						div_ = (document.body.innerHTML.indexOf('div-comment-') == -1) ? '': ((document.body.innerHTML.indexOf('li-comment-') == -1) ? 'div-': '');
						
						$('#respond').before(new_htm);
						$('#new-comm-' + num).append(data);

						zan.lazyload();
						
						$body.animate({
							scrollTop: $('#new-comm-' + num).offset().top - 65
						}, 800);
						
						countdown();
						num++;
						cancel.style.display = 'none';
						cancel.onclick = null;
						t.I('comment_parent').value = '0';

						if (temp && respond) {
							temp.parentNode.insertBefore(respond, temp);
							temp.parentNode.removeChild(temp)
						}
					}
				});
				return false;
			}
		);
		addComment = {
			moveForm: function(commId, parentId, respondId, postId, num) {
				var t = this,
				div,
				comm = t.I(commId),
				respond = t.I(respondId),
				cancel = t.I('cancel-comment-reply-link'),
				parent = t.I('comment_parent'),
				post = t.I('comment_post_ID');

				num ? (
					t.I('comment').value = comm_array[num], 
					$new_sucs = $('#success_' + num), 
					$new_sucs.hide(), $new_comm = $('#new-comm-' + num), 
					$cancel.text(cancel_edit)
				) : $cancel.text(cancel_text);

				t.respondId = respondId;
				postId = postId || false;

				zan.lazyload();

				if (!t.I('wp-temp-form-div')) {
					div = document.createElement('div');
					div.id = 'wp-temp-form-div';
					div.style.display = 'none';
					respond.parentNode.insertBefore(div, respond)
				} 

				!comm ? (
					temp = t.I('wp-temp-form-div'), 
					t.I('comment_parent').value = '0', 
					temp.parentNode.insertBefore(respond, temp), 
					temp.parentNode.removeChild(temp)
				) : comm.parentNode.insertBefore(respond, comm.nextSibling);

				$body.animate( {
					scrollTop: $('#respond').offset().top - 200
				}, 400 );

				if (post && postId) post.value = postId;

				parent.value = parentId;
				cancel.style.display = '';

				cancel.onclick = function() {
					var t = addComment,
					temp = t.I('wp-temp-form-div'),
					respond = t.I(t.respondId);
					t.I('comment_parent').value = '0';

					if (temp && respond) {
						temp.parentNode.insertBefore(respond, temp);
						temp.parentNode.removeChild(temp);
					}
					this.style.display = 'none';
					this.onclick = null;
					return false;
				};

				try {
					t.I('comment').focus();
				}
				catch(e) {}
				return false;
			},

			I: function(e) {
				return document.getElementById(e);
			}
		};

		var wait = 10,
		submit_val = $submit.val();

		function countdown() {
			if (wait > 0) {
				$submit.val(wait);
				wait--;
				setTimeout(countdown, 1000);
			} else {
				$submit.val(submit_val).attr('disabled', false).fadeTo('slow', 1);
				wait = 10;
			}
		};
	},

		// ajax评论分页
	ajaxCommentsPage: function() {
		var $ = jQuery.noConflict();

		$body=(window.opera)?(document.compatMode=="CSS1Compat"?$('html'):$('body')):$('html,body');
		// 点击分页导航链接时触发分页
		$('#comment-nav a').live('click', function(e) {
		    e.preventDefault();
		    $.ajax({
		        type: "GET",
		        url: $(this).attr('href'),
		        beforeSend: function(){
		            $('#comment-nav').remove();
		            $('.commentlist').remove();
		            $('#loading-comments').slideDown();
		            $body.animate({scrollTop: $('#comments-title').offset().top - 65 }, 800 );
		        },
		        dataType: "html",
		        success: function(out){
		            result = $(out).find('.commentlist');
		            nextlink = $(out).find('#comment-nav');

		            $('#loading-comments').slideUp('fast');
		            $('#loading-comments').after(result.fadeIn(500));
		            $('.commentlist').after(nextlink);
		            zan.ajaxCommentsReply();
		        }
		    });
		    return false;
		});
	},

}