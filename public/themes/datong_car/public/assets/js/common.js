/*头部导航*/
$('.nav_item ').hover(function() {
	$(this).addClass('active1');
	$(this).find('.nav_second_item').show();
}, function() {
	$(this).removeClass('active1');
	$(this).find('.nav_second_item').hide();
});
	// 手机目录点击事件
	$('.open-panel').click(function(e){
		if($('body').hasClass('with-panel-left-cover')){
           $('body').removeClass('with-panel-left-cover');
           $('.panel-cover').removeClass('active').hide()
		}else{
			$('body').addClass('with-panel-left-cover');
			$('.panel-cover').show()
		    $('.panel-cover').addClass('active');
		}
		e.stopPropagation()
	})

	$('.list-block .item-content').on('clcik',function(e){
		e.stopPropagation();
	})
	$('.list-block .item-content').on('touchend',function(e){

		e.stopPropagation();
	})

	$('.accordion-item>a.item-link').on('click',function(e){


		e.stopPropagation()
	})
	$('.accordion-item>a.item-link').on('touchend',function(e){
		if($(this).parent().hasClass('accordion-item-expanded')){

			$(this).parent().removeClass('accordion-item-expanded')
		}else{

			$(this).parent().addClass('accordion-item-expanded')
		}
		e.stopPropagation()
	})

	$(document).on('click',function(){
		_closeAction();
	})
	$("body:not('.accordion-item')").on('touchend',function(){
		_closeAction();
	})

	function _closeAction(){
		$('.panel-cover').hide();
		$('.accordion-item>').removeClass('accordion-item-expanded');
		$('body').removeClass('with-panel-left-cover')
	}

	// 结束手机目录点击事件

/*首页*/
$(document).ready(function() {
	var $div_ul = $('.vehicle_con>ul')
	$('.vehicle_tit li').click(function() {
		var $t = $(this).index();
		$(this).addClass('active').siblings().removeClass('active');
		$div_ul.eq($t).show(600).siblings().hide(600);
	});

	/**预约看车*/
	var $car_li = $('.car_process .car_process_list ');
	$('.car_process_tit_item').click(function() {
		/**其他*/
		$('.car_process_tit_item').each(function() {
			var $d = $(this).index();
			var img_src = $(this).find('img').attr('src').split(".");
			var img_ = $(this).find('img').attr('src').split(".")[0];
			var img__ = img_.split('_01')[0];

			if (img_.indexOf('_01') > -1) {
				$(this).find('img').attr('src', img__ + "." + img_src[1]);
			}
		})

		var $d = $(this).index();
		var $this_siblings = $(this).siblings();
		var img_src = $(this).find('img').attr('src').split(".");
		var img_ = $(this).find('img').attr('src').split(".")[0];
		var img__ = img_.split('_01')[0];

		if (img_.indexOf('_01') > -1) {
			$(this).find('img').attr('src', img__ + "." + img_src[1]);
		} else {
			$(this).find('img').attr('src', img_src[0] + "_01." + img_src[1]);
		}

		$(this).addClass('active').siblings().removeClass('active');
		$car_li.eq($d).show(600).siblings().hide(600);
	})
})


// 首页 移动端车辆买卖
$('.vehicle_ul .tit').on('click',function(){
	$(this).siblings('.vehicle_con_detail').toggle(600)
})


/*个人中心*/
// 个人中心卖家中心查看详情
// 弹窗
$(document).delegate('.detail_see', 'click', function() {
	var onlyChoseAlert = simpleAlert({
		"imgshow": 1,
		"list1_txt": "金大地",
		"list2_txt": "18356082312",
		"list3_txt": "付过定金，已认证",
		"list4_txt": "合肥市蜀山区佛子岭路66号",
		"buttons": {
			"确定": function() {
				onlyChoseAlert.close();
			}
		}
	});
});

// 个人中心卖家中心取消
$(document).delegate('.order_cancel_btn', 'click', function() {
	$(this).parent().parent().prev().find('a').text('已取消')
})

// 个人中心卖家中心删除
$(document).delegate('.order_err_btn', 'click', function() {
	$(this).parent().parent().parent().parent().parent().remove()
})

/**车辆买卖*/
$(document).delegate('.analogy_tit', 'click', function(e) {
	$('.analogy_con').each(function() {
		$(this).hide();
	})

	$(this).siblings('.analogy_con').show();
	var _this = $(this);
	var _this_siblings = $(this).siblings('.analogy_con');
	var _parrent = $(this).parent().parent();
	var _this_siblings_li = $(this).siblings('.analogy_con').children('li');

	$(document).one('click', function() {
		_this_siblings.hide();
	})
	e.stopPropagation();

	_this_siblings_li.on('click', function() {
		var txt = $(this).children('input').val();
		_this.children('input').val(txt);
		_this_siblings.hide();
	})
})

// 个人中心在线充值
// 支付方式切换
window.onload = function() {
	var $pay_li = $('.pay_tab_list_item');
	var $pay_con = $('.pay_tab_con_list_item')

	$('.pay_tab_list_item').on('click', function() {
		var $this = $(this);
		var $index = $this.index();
		var $length = $(this).parent().children().length - 1;
		$pay_li.siblings('.pay_tab_list_item').hide();
		$pay_li.show();
		$this.addClass('select').siblings().removeClass('select')
		$pay_con.css('display', 'none');
		$pay_con.eq($index).css('display', 'block');
		var price = $(this).find('.icon').not(".other").text();
		$(this).parent().siblings('.payment_amount ').find('input').val("￥" + powAmount(price, 2));
		if ($index == $length) {
			$(this).parent().siblings('.custom_amount ').show();
		}
	})

	$('.custom_amount input').change(function() {

		var changeVal = $(this).val();
		$(this).parent().parent().siblings('.payment_amount ').find('input').val("￥" + powAmount(changeVal, 2))
	})
}

function powAmount(amount, _pow_) {
	var amount_bak = amount;
	var base = 10;
	if (isNaN(amount)) {
		return "0.00";
	} else if (amount < 0) {
		return "0.00"
	}
	amount = Math.round((amount - Math.floor(amount)) * Math.pow(base, _pow_));
	amount = amount < 10 ? '.0' + amount : '.' + amount
	amount = Math.floor(amount_bak) + amount;
	return amount;
}
//结束 个人中心在线充值

// 验证手机号
function isPhoneNo(phone) {
	var pattern = /^1[34578]\d{9}$/;
	return pattern.test(phone);
}

// $('input[name="tel"]').blur(function(){
// 	if(isPhoneNo($.trim($(this).val())) == false ){
// 			$(this).parent().css('height','auto')
// 			$(this).parent().siblings('i').show()
// 		}else{
// 			$(this).parent().css('height','35px')
// 			$(this).parent().siblings('i').hide()
// 		}
// })

$('.yuyue_guang').hover(function() {
	$(this).children('.yuyueguang').show();
}, function() {
	$(this).children('.yuyueguang').hide();
})

if (screen.width > 768) {
	// alert(123)
	$('.yuyue_guang a').click(function() {
		$(this).html('400-2263-6547')
	})
}

$(document).delegate('.cycle_icon li', 'click', function() {
	$(this).addClass('active').siblings().removeClass('active');
	var t = $(this).index();
	$(this).parent().parent().siblings().find('ul').animate({
		'margin-left': -t * 100 + "%"
	}, 600);
	// $('.simila_recommendation_list ').animate({'margin-left':-t*100+"%"},600);
})

// carousel_pic();
// // setInterval('carousel_pic()',3000);
// function  carousel_pic(){
// 	$('.cycle_icon li').each(function(){
// 		var p=$(this).parent().children().length-1;
// 		var t=$(this).index();
// 		console.log(t,p)
// 		$(this).addClass('active').siblings().removeClass('active').animate(1500);
// 		if(t>=p ){
// 			$(this).parent().parent().siblings().find('ul').animate({'margin-left':-t*100+"%"},1500);
// 			return t=0;
// 		}else{
// 			$(this).parent().parent().siblings().find('ul').animate({'margin-left':-t*100+"%"},1500);
// 		}
// 	})
// }





// 车辆信息
$(".car_message_nav_list").click(function() {
	$(".car_message_nav").css({
		"position": "fixed",
		"top": "0",
		"z-index": "1"
	});
	$(this).addClass('active').siblings().removeClass('active');
	var id = $(this).children('a').attr('href');

	$("html, body").animate({
		scrollTop: $(id).offset().top - 50
	}, {
		duration: 500,
		easing: "swing"
	});

})

function calcLi(lix) {
	var x = $('.simila_recommendation_list_con').width() / lix;
	$('.simila_recommendation_list .vehicle_con_detail_items ').css('width', x)
	var liLength = $('.simila_recommendation_list>li').length;
	if ($('.cycle_icon li').length < liLength / lix) {

		var num = Math.ceil(liLength / lix) - $('.cycle_icon li').length;
		for (var i = 0; i < num; i++) {
			$('.cycle_icon').append('<li><a></a></li>')
		}
	}
}

function lunpic() {
	if (screen.width > 767 && screen.width < 1200) {
		calcLi(3)
	}
	if (screen.width > 414 && screen.width < 768) {

		calcLi(2)
	}
	if (screen.width > 319 && screen.width < 415) {
		calcLi(1)
	}
}

function scroll() {
	var subNav_active = $('.car_message_nav .active');

	function subNav_scroll(tar) {
		subNav_active.removeClass('active');
		tar.parent().addClass('active');
		subNav_active = tar.parent();
	};

	$('.car_message_nav a').click(function() {
		var _this = $(this);
		subNav_scroll(_this);
		var target = _this.attr('href');
		var targetScroll = $(target).offset().top - 50;
		$('html,body').animate({
			scrollTop: targetScroll
		}, 300);
		return false;
	});

	if (window.location.hash) {
		var targetScroll = $(window.location.hash).offset().top;
		$('html,body').animate({
			scrollTop: targetScroll
		}, 300);
	}
	var divTop = $('.car_message_con').offset().top;

	$(window).scroll(function() {
		var $this = $(this);
		var targetTop = $(this).scrollTop();
		var footerTop = $('footer').offset().top;
		var height = $(window).height();

		if (targetTop > divTop) {
			// alert(1)
			$('.car_message_nav ').addClass('fixed_nav');
			// $('.empty-placeholder').removeClass('empty_hidden');
		} else {
			// alert(2)
			$('.car_message_nav ').removeClass('fixed_nav');
			// $('.empty-placeholder').addClass('empty_hidden');
		}

		$('.car_message_con_item').each(function() {
			var that = $(this)
			var liTop = that.offset().top - 57;
			var liHeight = that.height();
			var divHeight = liTop + liHeight;

			if (divHeight > targetTop && targetTop > liTop) {
				var liId = that.prop('id');
				$('.car_message_nav_list a').each(function() {

					if ($(this).attr('href') == "#" + liId) {
						subNav_scroll($(this))
					}
				})
			}
		})
	})
}

/*预约看车*/
function car_mess_btn_submit() {
	if ($.trim($('input[name="tel"]').val()) == "" || $.trim($('input[name="tel"]').val()) == "请输入电话号码" || isPhoneNo($.trim($('input[name="tel"]').val())) == false) {
		alert('请填写正确手机号')
		$('input[name="tel"]').siblings('i').css('display', 'inline-block')
		return false;
	} else if ($.trim($('input[name="yanzhengma"]').val()) == "" || $.trim($('input[name="yanzhengma"]').val()) == "请输入验证码") {
		alert('输入验证码')
		$('input[name="yanzhengma"]').siblings('i').css('display', 'inne-block')
		return false;
	}
}
// $('.yuyue_guang_mess_list input').blur(function(){
// 	if($.trim($('input[name="tel"]').val()) == "" || $.trim($('input[name="tel"]').val()) == "请输入电话号码" || isPhoneNo($.trim($('input[name="tel"]').val())) == false){
// 		$(this).siblings('i').css('display','inline-block');
// 	}else{
// 		$(this).siblings('i').css('display','none');
// 	}
// })

/*车辆买卖信息*/
/*表单验证*/
function check() {
	if ($('input[name="brand"]').val() == "请选择品牌") {
		// $('input[name="brand"]').parent().parent().parent().css('height','auto')
		// $('input[name="brand"]').parent().parent().siblings('i').show();
		alert('请选择品牌')
		return false;
	} else if ($('input[name="motorcycle"]').val() == "请选择车系") {
		// $('input[name="motorcycle"]').parent().parent().parent().css('height','auto')
		// $('input[name="motorcycle"]').parent().parent().siblings('i').show();
		alert('请选择车系')
		return false;
	} else if ($('input[name="tel"]').val() == "") {
		// $('input[name="tel"]').parent().parent().parent().css('height','auto')
		// $('input[name="tel"]').parent().parent().siblings('i').show();
		alert('请填写手机号')
		return false;
	}
}

$('.vehiTrad_tit_item .more').on('click', function() {
	if ($(this).hasClass('on')) {
		$(this).removeClass('on');
		$(this).parent().parent().css('height', '50px');
	} else {
		$(this).addClass('on');
		$(this).parent().parent().css('height', 'auto');
	}
})

$('.vehiTrad_tit_item_other_list p').on('click', function(e) {
	var _this = $(this);
	var _this_siblings = $(this).siblings('ul');
	var _this_siblings_li = $(this).siblings('ul').children('li');

	_this_siblings.show();
	$(document).one('click', function() {
		_this_siblings.hide();
	})
	e.stopPropagation();

	_this_siblings_li.on('click', function() {
		var txt = $(this).children('a').text();
		_this.html(txt)
		_this_siblings.hide();
	})
})





/**车险服务 --投保流程*/
$('.claim_guidance_guide li .circle').click(function() {
	var _parent = $(this).parent();
	var _t = _parent.index();
	var _div = $('.claim_guidance_guide_con_list');
	console.log(_t)
	_parent.addClass('active').siblings().removeClass('active');
	_div.eq(_t).show().siblings().hide(600);
})

// 电话验证
function isPhoneNo(phone) {
	var pattern = /(^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$)|(^0{0,1}1[3|4|5|6|7|8|9][0-9]{9}$)/;
	return pattern.test(phone)
}

// 车辆号牌
function car_num(num) {
	var pattern = /^[京津沪渝冀豫云辽黑湘皖鲁新苏浙赣鄂桂甘晋蒙陕吉闽贵粤青藏川宁琼使领A-Z]{1}[A-Z]{1}[A-Z_0-9]{5}$/;
	return pattern.test(num)
}

/*strat**险种选择，资料填写*/
function is_submit(value) {
	console.log($('input[name="sfz"]'))

	var form1 = $("#data_filling");
	// 在线投保
	if ($.trim($('input[name="user_name"]').val()).length == 0) {
		alert('请填写正确用户名')
		$('input[name="user_name"]').siblings('b').css('display', 'block')
		return false;
	} else if ($.trim($('input[name="tel"]').val()).length == 0 || isPhoneNo($.trim($('input[name="tel"]').val())) == false) {
		alert('请填写正确手机号')
		$('input[name="tel"]').siblings('b').css('display', 'block')
		return false;
	} else if ($.trim($('input[name="plateNo"]').val()).length == 0 || car_num($.trim($('input[name="plateNo"]').val())) == false) {
		alert('请填写车牌号')
		$('input[name="plateNo"]').siblings('b').css('display', 'block')
		return false;
	} else if ($.trim($('input[name="xcz"]').val()).length == 0) {
		alert('请上传行车本照片')
		$('input[name="xcz"]').parent().parent().siblings('b').css('display', 'block')
		return false;
	} else if ($('input[name="sfz"]') && $.trim($('input[name="sfz"]').val()) == "") {
		alert('请上传身份证正面照片')
		$('input[name="sfz"]').parent().parent().siblings('b').css('display', 'block')
		return false;
	} else {
		if (value == 1) {
			var id = $("#id").val();
			form1.action = "/Test/querrybyid?id=" + id;
			$("#form1").attr("action", form1.action);
			form1.submit();
		}
		// 线上投保
		if (value == 2) {
			var title = $("#title").val();
			form1.action = "/Test/querrybyname?title=" + title;
			$("#form1").attr("action", form1.action);
			form1.submit();
		}
	}
}

// $('.data_filling_list  .right input').blur(function(){
// 	if($.trim($(this).val()) == ""){
// 		$(this).siblings('b').css('display','block');
// 		if($(this).attr('type') == 'file'){
// 			$(this).parent().parent().siblings('b').hide();
// 		}
// 	}else if($(this).attr('name') == 'tel' && isPhoneNo($.trim($('input[name="tel"]').val())) == false){
// 		$(this).siblings('b').css('display','block');


// 	}else if($(this).attr('name') == 'car_num' && car_num($.trim($('input[name="car_num"]').val())) == false){
// 		$(this).siblings('b').css('display','block');
// 	}else{
// 		$(this).siblings('b').css('display','none');
// 		if($(this).attr('type') == 'file'){
// 			$(this).parent().parent().siblings('b').show();
// 		}
// 	}
// })
/*end**险种选择，资料填写*/

/*车险选择签合同 */
$(".contract_p .check_span input").click(function() {
	if ($(this).prop('checked')) {
		$(this).siblings('label').attr('tid', '1')
	} else {
		$(this).siblings('label').attr('tid', '0')
	}
})

function contract(e) {
	if ($(".contract_p .check_span>label").attr('tid') != 1) {
		alert("您未同意服务条款")
		return false;
	}
	e.preventDefault();
}

/*同意服务*/
$('.auto_login input').click(function() {
	if ($(this).prop('checked')) {
		$(this).parent('label').attr('tid', '1')
	} else {
		$(this).parent('label').attr('tid', '0')
	}
})

/****登录按钮**/
function loginLayoutValidate() {
	if ($.trim($('input[name="tel"]').val()).length == 0 || isPhoneNo($.trim($('input[name="tel"]').val())) == false) {
		alert('请填写正确手机号')
		$('input[name="tel"]').siblings('b').css('display', 'block')
		return false;
	} else if ($.trim($('input[name="password"]').val()).length == 0) {
		alert('请填写密码')
		$('input[name="password"]').siblings('b').css('display', 'block');
		return false;
	} else if ($.trim($('input[name="yanzheng"]').val()).length == 0) {
		alert('请填写验证码')
		$('input[name="yanzheng"]').siblings('b').css('display', 'block');
		return false;
	} else {
		if ($(".register_form .auto_login label").attr('tid') != 1) {
			alert("您未同意服务条款");
			return false;
		}
	}
}

// $('.user_login_input input').blur(function(){
// 	if($.trim($(this).val())==""){
// 		$(this).siblings('b').show();
// 	}else{
// 		if($(this).attr('name')=="tel" && isPhoneNo($.trim($('input[name="tel"]').val())) == false){
// 			$(this).siblings('b').show();
// 		}else{
// 			$(this).siblings('b').hide();
// 		}
// 	}
// })





// 模拟placeholder
var funPlaceholder = function(element) {
	//检测是否需要模拟placeholder
	var placeholder = '';
	if (element && !("placeholder" in document.createElement("input")) && (placeholder = element.getAttribute("placeholder"))) {
		//当前文本控件是否有id, 没有则创建
		var idLabel = element.id;
		if (!idLabel) {
			idLabel = "placeholder_" + new Date().getTime();
			element.id = idLabel;
		}
		//创建label元素
		var eleLabel = document.createElement("label");
		eleLabel.htmlFor = idLabel;
		eleLabel.style.position = "absolute";
		//根据文本框实际尺寸修改这里的margin值
		eleLabel.style.margin = "1px 0 0 5px";
		eleLabel.style.color = "#999";
		eleLabel.style.cursor = "text";
		eleLabel.style.fontSize = "14px";
		//插入创建的label元素节点
		element.parentNode.insertBefore(eleLabel, element);
		//事件
		element.onfocus = function() {
			eleLabel.innerHTML = "";
		};
		element.onblur = function() {
			if (this.value === "") {
				eleLabel.innerHTML = placeholder;
			}
		};
		//样式初始化
		if (element.value === "") {
			eleLabel.innerHTML = placeholder;
		}
	}
};
$('.placeholder').each(function(i, ind) {
	// console.log($(this))
	funPlaceholder(ind)
});



// 预加载
$(function () {

	// 图片预览
	$('input[type="file"]').change(function() {
		var x = $(this).attr('id');
		var y = $(this).parent().parent().siblings().find('.show_img');
		$(this).parent().parent().siblings('.img_div').show();
		$(this).parent().parent().siblings('b').hide();
		var f = document.getElementById(x).files[0];
		var src = window.URL.createObjectURL(f);

		$(this).parent().parent().siblings().find('.show_img').attr('src', src);
	});
});


/*方法 function*/

// 地区 省份获取城市
function select_province(o,url) {
	if (!o) { var o ='#input-province'; }
	if (!url) { var url = '/usual/ajax/getcitys.html'; }

    // $(o).change(function() {
        var Id = $(o).val();

        $.ajax({
            url: url,
            type: 'POST',
            // dataType: 'json',
            data: {parentId: Id},
        })
        .done(function(data) {
            // console.log("success");
            if (data) {$('#input-city').html(data);}
        })
        .fail(function() {
            // console.log("error");
        })
        .always(function() {
            // console.log("complete");
        });

		// $.ajax({
		//     url: url,
		//     type: 'POST',
		//     // dataType: 'json',
		//     data: {parentId: Id},
		//     success:function(data){
		//         console.log(data);
		//         if (data) { $('#input-city').html(data); }
		//     }
		// });
    // });
}



/* 没有form表单 \public\themes\simpleboot3\user\profile\avatar.html
<style type="text/css">
    .uploaded_photo_area {
        margin-top: 20px;
    }
    .uploaded_photo_btns {
        margin-top: 20px;
    }
    .uploaded_photo_area .uploaded_photo_btns {
        display: none;
    }
</style>
<div class="tab-pane active" id="one">
    <br>
    <if condition="empty($photo)">
        <img src="__TMPL__/public/assets/images/headicon_128.png" class="headicon" width="128"/>
    <else/>
        <img src="{:cmf_get_user_avatar_url($photo)}?t={:time()}" class="headicon" width="128"/>
    </if>
    <input type="file" onchange="photo_upload(this,"{:url('Profile/avatarUpload')}")" id="photo_uploder" name="file"/>
    <div class="uploaded_photo_area">
        <div class="uploaded_photo_btns">
            <a class="btn btn-primary confirm_photo_btn" onclick="update_photo(.uploaded_photo_area img,"{:url('Profile/avatarUpdate')}")">确定</a>
            <a class="btn" onclick="reloadPage()">取消</a>
        </div>
    </div>
    <p class="help-block">头像支持jpg,png,jpeg格式,文件大小最大不能超过1M</p>
</div>
 */
/*点击上传按钮
var obj = this;
var url = '{:url('Profile/avatarUpload')}';
*/
function photo_upload(obj,url) {
    var $fileinput = $(obj);
    /* $(obj)
     .show()
     .ajaxComplete(function(){
     $(this).hide();
     }); */
    Wind.css("jcrop");
    Wind.use("ajaxfileupload", "jcrop", "noty", function () {
        $.ajaxFileUpload({
            url: "",
            secureuri: false,
            fileElementId: "photo_uploder",
            dataType: 'json',
            data: {},
            success: function (data, status) {
                if (data.code == 1) {
                    $("#photo_uploder").hide();
                    var $uploaded_area = $(".uploaded_photo_area");
                    $uploaded_area.find("img").remove();
                    var src  = "__ROOT__/upload/" + data.data.file;
                    var $img = $("<img/>").attr("src", src);
                    $img.prependTo($uploaded_area);
                    $(".uploaded_photo_btns").show();
                    var img = new Image();
                    img.src = src;

                    var callback = function () {
                        console.log(img.width);
                        $img.Jcrop({
                            aspectRatio: 1,
                            trueSize: [img.width, img.height],
                            setSelect: [0, 0, 100, 100],
                            onSelect: function (c) {
                                $img.data("area", c);
                            }
                        });
                    }
                    if (img.complete) {
                        callback();
                    } else {
                        img.onload = callback;
                    }
                } else {
                    noty({
                        text: data.msg,
                        type: 'error',
                        layout: 'center',
                        callback: {
                            afterClose: function () {
                                reloadPage(window);
                            }
                        }
                    });
                }
            },
            error: function (data, status, e) {
            }
        });
    });

    return false;
}

/*确认上传
var o = '.uploaded_photo_area img';
var url = '{:url('Profile/avatarUpdate')}';
*/
function update_photo(o,url) {
    var area = $(o).data("area");
    $.post(url, area, function (data) {
        if (data.code == 1) {
            reloadPage(window);
        }
    }, "json");
}


// 弹窗 引用个人中心的
function msgDialog(data) {
	// for (var i = 0; i < Things.length; i++) {
	// 	Things[i]
	// }
	var onlyChoseAlert = simpleAlert({
		"imgshow": 1,
		"list1_txt": "金大地",
		"list2_txt": "popup-Dialog",
		"list3_txt": "付过定金，已认证",
		"list4_txt": "合肥市蜀山区佛子岭路66号",
		"buttons": {
			"确定": function() {
				onlyChoseAlert.close();
			}
		}
	});
}



