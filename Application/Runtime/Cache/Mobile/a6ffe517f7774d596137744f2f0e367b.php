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
    <div class="h-mid">完善资料</div>
    <div class="h-right">
      <aside class="top_bar">
        <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
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
                <form method="post" enctype="multipart/form-data" onSubmit="return validate_comment()">
                
                    <div class="name"><span>昵　&nbsp;&nbsp; 称</span>
                        <input type="text" name="nickname" id="nickname" value="<?php echo ($user["nickname"]); ?>" placeholder="*在平台里使用" class="c-f-text" style="width:65%">
                    </div>
                    <div class="name"><span>真实姓名</span>
                        <input type="text" name="name" id="name" value="<?php echo ($user["name"]); ?>" placeholder="*人工审核,通过后不可更改" class="c-f-text" style="width:65%">
                    </div>
                    <div class="name1" style="overflow:hidden"><span>性　&nbsp;&nbsp; 别</span>
                    <ul>
                     <li <?php if($user["sex"] == 0): ?>class="on"<?php endif; ?>><label for="sex0"><input type="radio" name="sex" value="0" tabindex="2" class="radio" id="sex0" <?php if($user["sex"] == 0): ?>checked=true<?php endif; ?>/>保密</label></li>
                     <li <?php if($user["sex"] == 1): ?>class="on"<?php endif; ?>><label for="sex1"><input type="radio" name="sex" value="1" tabindex="3" class="radio" id="sex1" <?php if($user["sex"] == 1): ?>checked=true<?php endif; ?>/>男</label></li>
                     <li <?php if($user["sex"] == 2): ?>class="on"<?php endif; ?>><label for="sex2"><input type="radio" name="sex" value="2" tabindex="4" class="radio" id="sex2" <?php if($user["sex"] == 2): ?>checked=true<?php endif; ?>/>女</label></li>
                    </ul>
                    </div>
                    <div class="name"><span>身份证号</span>
                        <input type="text" name="sfz" id="sfz" value="<?php echo ($user["sfz"]); ?>" placeholder="*人工审核,通过后不可更改" class="c-f-text"  style="width:45%">
                    </div>

                    <div class="name1" style="text-align:center">
                       <input name="is_sq" type="checkbox" id="level"  style="background: #eee;border: none;"  value="1" checked   readonly="readonly" onclick="return false;">
					   申请成为债务债权合伙人 <a href="/index.php?s=/Mobile/Article/index/article_id/24.html" style="color:#2fcafd;">《细则条例》</a>
                    </div>

<?php $all_img=unserialize($user['all_img']);?>
<section class="zyw-container" style="display:none">
            <div class="name1" style="text-align:center; color:#f00; font-size:16px">债务债权<small style="font-size:12px">(以下信息仅用作平台评估不会用作他途)</small></div>
<div class="p_main">
<ol>
<li>
<a href="javascript:;" class="file"><div id="fileList0" style="width:60px;height:60px;"><img width="60" height="60" <?php if(!empty($all_img[0])): ?>src="<?php echo ($all_img[0]); ?>"<?php endif; ?>></div><input type="file" onChange="handleFiles(this,0)" name="comment_img_file[]" accept="image/*"></a><br>
个人债务一
</li>
<li>
<a href="javascript:;" class="file"><div id="fileList1" style="width:60px;height:60px;"><img width="60" height="60" <?php if(!empty($all_img[1])): ?>src="<?php echo ($all_img[1]); ?>"<?php endif; ?>></div><input type="file" onChange="handleFiles(this,1)" name="comment_img_file[]" accept="image/*"></a><br>
个人债务二
</li>
<li>
<a href="javascript:;" class="file"><div id="fileList2" style="width:60px;height:60px;"><img width="60" height="60" <?php if(!empty($all_img[2])): ?>src="<?php echo ($all_img[2]); ?>"<?php endif; ?>></div><input type="file" onChange="handleFiles(this,2)" name="comment_img_file[]" accept="image/*"></a><br>
个人债务三
</li>
<li>
<a href="javascript:;" class="file"><div id="fileList3" style="width:60px;height:60px;"><img width="60" height="60" <?php if(!empty($all_img[3])): ?>src="<?php echo ($all_img[3]); ?>"<?php endif; ?>></div><input type="file" onChange="handleFiles(this,3)" name="comment_img_file[]" accept="image/*"></a><br>
个人债务四
</li>
</ol>
</div>
</section>
   <div class="field submit-btn">
   <?php if($user["is_sq"] == 0 && $user["level"] == 1): ?><input type="submit" value="确认提交" class="btn_big1" style="background:#eae01e; color:#333"/>
   <?php else: ?>
       <input name="按钮" type="button" class="btn_big1" style="background:#ccc; color:#333" value="不可修改"/><?php endif; ?>
   </div>
                </form>
            </div>

        </div>
    </div>

</div>

<script type="text/javascript">

$('.name1 ul li').click(function () {
            $(this).find("input").attr("checked", "checked");
            $('.name1 ul li').removeClass("on");
            $(this).addClass("on");
})

/*$('#level').each(function(i,elemt){
    $(this).change(function(){
            var ischecked = $(this).prop("checked");
			if(!ischecked){
				$('.zyw-container').hide();
			}else{
				$('.zyw-container').show();				
			}
            $(this).siblings('input').prop("checked",ischecked);
       });
})
*/
function validate_comment(){
	var nickname = $("#nickname").val();
	var name = $("#name").val();
	var sfz = $("#sfz").val();
	var mobile = $("#mobile").val();
	var error = [];
	var img_num = 0;
	var AllImgExt=".jpg|.jpeg|.gif|.bmp|.png|";//全部图片格式类型 
	//var title = document.getElementById("title").value;
	$(".file input").each(function(index){
		FileExt = this.value.substr(this.value.lastIndexOf(".")).toLowerCase(); 	
		if(this.value!=''){
		    img_num++;
			if(AllImgExt.indexOf(FileExt+"|")==-1){
			     error.push("第"+(index+1)+"张图片格式错误"); 
			}
		}    
	});

	 if(nickname == ''){
	    error.push('请输入您的昵称！');
	 }
	 if(name == ''){
	    error.push('请输入您的真实姓名！');
	 }
	 if(sfz == ''){
	    error.push('请输入您的身份证号码！');
	 }
	if(error.length>0){
	   layer.open({content:error,time:2});	
	   return false;
	}else{
	  return true;
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