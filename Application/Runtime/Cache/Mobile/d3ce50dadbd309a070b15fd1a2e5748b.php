<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="format-detection" content="telephone=no" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="applicable-device" content="mobile">
<title><?php echo ($tpshop_config['shop_info_store_title']); ?></title>
<meta http-equiv="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>" />
<link rel="stylesheet" href="/Template/mobile/new/Static/css/public.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/user.css">
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script src="/Public/js/global.js"></script>
<script src="/Public/js/mobile_common.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/modernizr.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
</head>
<body>
<header>
    <div class="tab_nav">
        <div class="header">
            <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
            <div class="h-mid">信息修改</div>
            <div class="h-right">
                <aside class="top_bar">
                    <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a
                            href="javascript:;"></a></div>
                </aside>
            </div>
        </div>
    </div>
</header>
<script type="text/javascript" src="/Template/mobile/new/Static/js/mobile.js" ></script>
<div class="goods_nav hid" id="menu">
      <div class="Triangle">
        <h2></h2>
      </div>
      <ul>
      <?php
 $md5_key = md5("SELECT * FROM `__PREFIX__wapnavigation` where is_show = 1 and lei=0 ORDER BY `sort` asc"); $result_name = $sql_result_v = S("sql_".$md5_key); if(empty($sql_result_v)) { $Model = new \Think\Model(); $result_name = $sql_result_v = $Model->query("SELECT * FROM `__PREFIX__wapnavigation` where is_show = 1 and lei=0 ORDER BY `sort` asc"); S("sql_".$md5_key,$sql_result_v,1); } foreach($sql_result_v as $k=>$v): ?><li>
				<a href="<?php echo ($v[url]); ?>"  <?php if($v["is_new"] == 1): ?>target="_blank"<?php endif; ?>><span class="menu1" style="background:url(<?php echo ($v[img]); ?>) no-repeat 50% 80%; background-size:auto 15px; margin-right:5px"></span><i><?php echo ($v[name]); ?></i></a>
			</li><?php endforeach; ?> 
   </ul>
 </div> 
<div id="tbh5v0">
    <div class="Personal">
        <div id="tbh5v0">
            <div class="innercontent1">
                <form method="post" action="" id="edit_profile" enctype="multipart/form-data" onSubmit="return checkinfo()">
                    <div class="name"><span>昵　 称</span>
                        <input type="text" name="nickname" id="nickname" value="<?php echo ($user["nickname"]); ?>" placeholder="*昵称"
                               class="c-f-text">
                    </div>                    
            <div class="name1"> <span>头像：</span>
            <ul>
            <a href="javascript:;" class="file">
                <div id="fileList0" style="width:40px;height:40px;"><img width="40" height="40" <?php if(!empty($user['head_pic'])): ?>src="<?php echo ($user["head_pic"]); ?>"<?php endif; ?>></div>  
                <input type="file" onChange="handleFiles(this,0)" name="comment_img_file[]" accept="image/*">
            </a><spna>点击图片，更换头像</span>
            </ul>
            </div>
                    <div class="name1"><span>性　 别</span>
                        <ul>
                            <li class="on">
                                <label for="sex0">
                                    <input type="radio" name="sex" value="0" tabindex="2" class="radio" id="sex0"
                                           checked=true/>
                                    保密</label>
                            </li>
                            <li>
                                <label for="sex1">
                                    <input type="radio" name="sex" value="1" tabindex="3" class="radio" id="sex1"/>
                                    男</label>
                            </li>
                            <li>
                                <label for="sex2">
                                    <input type="radio" name="sex" value="2" tabindex="4" class="radio" id="sex2"/>
                                    女</label>
                            </li>
                        </ul>
                    </div>

                    <div class="name">
                        <label for="email_ep"> <span>邮箱</span>
                            <input name="email" value="<?php echo ($user["email"]); ?>" id="email_ep" placeholder="*电子邮件地址" type="text"/>
                        </label>
                    </div>
                    <div class="field submit-btn">
                        <input type="submit" value="确认修改" class="btn_big1"/>
                    </div>
                </form>
            </div>

            <div class="innercontent1">
                <form method="post" action="" id="edit_mobile" onSubmit="return checkMobileForm()">
                    <div class="name">
                        <label for="email_ep"> <span>手机</span>
                            <input name="mobile" value="<?php echo ($user["mobile"]); ?>" id="mobile_ep" placeholder="*手机号码" type="text"/>
                        </label>
                    </div>
                    <?php if(tpCache('sms.regis_sms_enable') == 1): ?><div class="name">
                        <label for="email_ep"> <span>验证码</span>
                            <input type="text" id="mobile_code" name="mobile_code" placeholder="手机验证码"/>
                            <input id="zphone" type="button" rel="mobile" value="获取手机验证码 " onClick="sendcode(this)"
                                   class="zphone">
                        </label>
                    </div><?php endif; ?>
                    
                    <div class="field submit-btn">
                        <input type="submit" value="确认修改" class="btn_big1"/>
                    </div>
                </form>
            </div>

            <div class="innercontent11">
                <form name="formPassword" action="<?php echo U('User/password');?>" method="post" onSubmit="return editPassword()">
                    <h4 class="title">密码修改</h4>

                    <div class="field_pwd">
                        <label for="password">
                            <input type="password" name="old_password" id="password" class="c-f-text"
                                   placeholder="原密码"/>
                        </label>
                    </div>
                    <div class="field_pwd">
                        <label for="new_password">
                            <input type="password" name="new_password" id="new_password" class="c-f-text"
                                   placeholder="新密码"/>
                        </label>
                    </div>
                    <div class="field_pwd">
                        <label for="confirm_password">
                            <input type="password" name="confirm_password" id="confirm_password" class="c-f-text"
                                   placeholder="确认密码"/>
                        </label>
                    </div>
                    <div class="field submit-btn">
                        <input type="submit" value="确认修改" class="btn_big1"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('.name1 ul li').click(function () {
            $(this).find("input").attr("checked", "checked");
            $('.name1 ul li').removeClass("on");
            $(this).addClass("on");
        })
    </script>
</div>

<script language="javascript">
    $(function () {
        $('input[type=text],input[type=password]').bind({
            focus: function () {
                $(".global-nav").css("display", 'none');
            },
            blur: function () {
                $(".global-nav").css("display", 'flex');
            }
        });
    })

    var email_empty = "请输入您的电子邮件地址！";
    var email_error = "您输入的电子邮件地址格式不正确！";
    var old_password_empty = "请输入您的原密码！";
    var new_password_empty = "请输入您的新密码！";
    var confirm_password_empty = "请输入您的确认密码！";
    var both_password_error = "您现两次输入的密码不一致！";
    /* 会员修改密码 */
    function editPassword() {
        var frm = document.forms['formPassword'];
        var old_password = frm.elements['old_password'].value;
        var new_password = frm.elements['new_password'].value;
        var confirm_password = frm.elements['confirm_password'].value;

        var msg = '';
        var reg = null;

        if (old_password.length == 0) {
            msg += old_password_empty + '\n';
        }

        if (new_password.length == 0) {
            msg += new_password_empty + '\n';
        }

        if (confirm_password.length == 0) {
            msg += confirm_password_empty + '\n';
        }

        if (new_password.length > 0 && confirm_password.length > 0) {
            if (new_password != confirm_password) {
                msg += both_password_error + '\n';
            }
        }

        if (msg.length > 0) {
            alert(msg);
            return false;
        } else {
            return true;
        }
    }

    function checkinfo() {
        var nickname = $('#nickname').val();
        var email = $('#email_ep').val();
        if (nickname == '') {
            alert("昵称不能为空");
            return false;
        }

        if (!checkEmail(email)) {
            alert("邮箱格式不正确");
            return false;
        }
        return true;
    }


    function checkMobileForm() {
        var mobile = $('#mobile_ep').val();
        var mobile_code = $('#mobile_code').val();
        if (!checkMobile(mobile)) {
			layer.open({content:'手机格式不正确',time:2});
            return false;
        }
<?php if(tpCache('sms.regis_sms_enable') == 1): ?>if (mobile_code == '') {
			layer.open({content:'请填写手机验证码',time:2});
            return false;
        }
        if (!mobile_flag) {
			layer.open({content:'请先获取手机验证码',time:2});
            return false;
        }<?php endif; ?>
        return true;
    }

    var mobile_flag = false;
    //发送验证码
    function sendcode(o) {
        var mobile = $('#mobile_ep').val();
        if (!checkMobile(mobile)) {
			layer.open({content:'手机格式不正确',time:2});
        } else {
            $.ajax({
                url: '/index.php?m=Mobile&c=User&a=send_validate_code&t=' + Math.random(),
                type: 'post',
                dataType: 'json',
                data: {type: $(o).attr('rel'), send: $.trim($('#mobile_ep').val())},
                success: function (res) {
                    if (res.status == 1) {
						layer.open({content: res.msg, time: 2});
                        mobile_flag = true;
                        countdown(o);
                    } else {
                        mobile_flag = false;
                        layer.open({content: res.msg, time: 2});
                    }
                }
            });
        }
    }

    var wait = 150;
    function countdown(obj, msg) {
        obj = $(obj);
        if (wait == 0) {
            obj.removeAttr("disabled");
            obj.val(msg);
            wait = 150;
        } else {
            if (msg == undefined || msg == null) {
                msg = obj.val();
            }
            obj.attr("disabled", "disabled");
            obj.val(wait + "秒后重新获取");
            wait--;
            setTimeout(function () {
                countdown(obj, msg)
            }, 1000)
        }
    }
	
window.URL = window.URL || window.webkitURL;
function handleFiles(obj,id) {
	fileList = document.getElementById("fileList"+id);
		var files = obj.files;
		img = new Image();
		if(window.URL){	
			
			img.src = window.URL.createObjectURL(files[0]); //创建一个object URL，并不是你的本地路径
			img.width = 60;
	    	img.height = 60;
			img.onload = function(e) {
				window.URL.revokeObjectURL(this.src); //图片加载后，释放object URL
			}
		    if(fileList.firstElementChild){
		         fileList.removeChild(fileList.firstElementChild);
		    } 
			fileList.appendChild(img);
		}else if(window.FileReader){
			//opera不支持createObjectURL/revokeObjectURL方法。我们用FileReader对象来处理
			var reader = new FileReader();
			reader.readAsDataURL(files[0]);
			reader.onload = function(e){	
		            img.src = this.result;
		            img.width = 60;
		            img.height = 60;
		            fileList.appendChild(img);
			}
	    }else
	    {
			//ie
			obj.select();
			obj.blur();
			var nfile = document.selection.createRange().text;
			document.selection.empty();
			img.src = nfile;
			img.width = 60;
		    img.height = 60;
			img.onload=function(){
			  
		    }
			fileList.appendChild(img);
	    }

}
</script>
</body>
</html>