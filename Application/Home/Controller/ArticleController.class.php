<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * ============================================================================
 * $Author: IT宇宙人 2015-08-10 $
 */ 
namespace Home\Controller;
use Home\Logic\ArticleLogic;

class ArticleController extends BaseController {
    
    public function index(){       
        $article_id = I('article_id',38);
    	$article = D('article')->where("article_id=$article_id")->find();
    	$this->assign('article',$article);
        $this->display();
    }
 
    /**
     * 文章内列表页
     */
    public function articleList(){
        $article_cat = M('ArticleCat')->where("parent_id  = 0")->select();
        $this->assign('article_cat',$article_cat);        
        $this->display();
    }    
    /**
     * 文章内容页
     */
    public function detail(){
    	$article_id = I('article_id',1);
    	$article = D('article')->where("article_id=$article_id")->find();
    	if($article){
    		$parent = D('article_cat')->where("cat_id=".$article['cat_id'])->find();
    		$this->assign('cat_name',$parent['cat_name']);
    		$this->assign('article',$article);
    	}
        $this->display();
    } 
   
}