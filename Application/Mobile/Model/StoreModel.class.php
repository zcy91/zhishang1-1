<?php
/**
 * tpshop
 * 回复模型
 * @auther：dyr
 */ 
namespace Mobile\Model;
use Think\Model;


class StoreModel extends Model{
    /**
     * 店铺街
     * @author dyr
     * @param $sc_id 店铺分类ID，可不传，不传将检索所有分类
     * @param int $p 分页
     * @param int $item 每页多少条记录
     * @return mixed
     */
    public function getStreetList($sc_id,$p=1,$item=10,$key="")
    {
        $model = M('');;
        $store_where = array();
        $db_prefix = C('DB_PREFIX');
		
		$store_where['s.store_state'] = 1;
        if($sc_id>0){
            $store_where['s.sc_id'] = $sc_id;
        }elseif($sc_id=='0'){
            $store_where['s.store_recommend'] = 1;
        }elseif($sc_id=='-1'){
            $store_where['s.is_own_shop'] = 1;
        }
		if($key){
            $store_where['s.store_name'] =array('like','%'.$key.'%');
		}
        $store_list = $model
            ->table($db_prefix .'store s')
            ->field('s.store_id,s.store_phone,s.store_logo,s.store_name,s.store_desccredit,s.store_servicecredit,s.store_address,
						s.store_deliverycredit,r1.name as province_name,r2.name as city_name,r3.name as district_name,
						s.deleted as goods_array')
            ->join('LEFT JOIN '.$db_prefix . 'region As r1 ON r1.id = s.province_id')
            ->join('LEFT JOIN '.$db_prefix . 'region As r2 ON r2.id = s.city_id')
            ->join('LEFT JOIN '.$db_prefix . 'region As r3 ON r3.id = s.district')
            ->where($store_where)
            ->page($p,$item)
            ->cache(true,TPSHOP_CACHE_TIME)
            ->select();
		//echo $sc_id.'--->'.$model->getLastSql();	
        return $store_list;
    }

    /**
     * 附近商家 
     * @author dyr
     * @param $sc_id 店铺分类ID，可不传，不传将检索所有分类
     * @param int $p 分页
     * @param int $item 每页多少条记录
     * @return mixed
     */
    public function getStoreList($sc_id,$p=1,$item=10,$key="")
    {
        $model = M('');;
        $store_where = array();
        $db_prefix = C('DB_PREFIX');
		
		$store_where['s.store_state'] = 1;
        if($sc_id>0){
            $store_where['s.sc_id'] = $sc_id;
        }elseif($sc_id=='0'){
            $store_where['s.store_recommend'] = 1;
        }elseif($sc_id=='-1'){
            $store_where['s.is_own_shop'] = 1;
        }
		if($key){
            $store_where['s.store_name'] =array('like','%'.$key.'%');
		}

        $store_where['s.lng'] = array('exp','is not null');
		$lng_lat=session('lng_lat');
		$lng_lat=explode(",",$lng_lat);
        $slng =$lng_lat[0];
	    $slat =$lng_lat[1];
	    if(empty($slng))
	        $slng = 120.081613;
	    if(empty($slat))
	        $slat = 29.312187;
        $store_list = $model
            ->table($db_prefix .'store s')
            ->field('s.store_id,s.store_phone,s.store_logo,s.store_name,s.store_desccredit,s.store_servicecredit,s.store_address,
						s.store_deliverycredit,r1.name as province_name,r2.name as city_name,r3.name as district_name,
						s.deleted as goods_array,s.lng,s.lat,ROUND(6378.138*2*ASIN(SQRT(POW(SIN(('.$slat.'*PI()/180-s.lat*PI()/180)/2),2)+COS('.$slat.'*PI()/180)*COS(s.lat*PI()/180)*POW(SIN(('.$slng.'*PI()/180-s.lng*PI()/180)/2),2))),2) AS juli')
            ->join('LEFT JOIN '.$db_prefix . 'region As r1 ON r1.id = s.province_id')
            ->join('LEFT JOIN '.$db_prefix . 'region As r2 ON r2.id = s.city_id')
            ->join('LEFT JOIN '.$db_prefix . 'region As r3 ON r3.id = s.district')
            ->where($store_where)
			->order('juli asc')
            ->page($p,$item)
			
            ->cache(true,TPSHOP_CACHE_TIME)
            ->select();
		    // $model->getLastSql()."<br>";	

        return ($store_list);
    }




    /**
     * 获取店铺商品详细
     * @param $store_id
     * @param $limit
     * @return mixed
     */
    public function getStoreGoods($store_id,$limit)
    {
        $goods_model = M('goods');
        $goods_where = array(
            'is_on_sale'=>1,
//            'is_recommend'=>1,
//            'is_hot'=>1,
            'goods_state'=>1,
            'store_id'=>$store_id
        );
        $res['goods_list'] = $goods_model->field('goods_id,goods_name,shop_price')->where($goods_where)->limit($limit)->order('sort desc')->select();
        $count_where = array(
//            'goods_state'=>1,
            'store_id'=>$store_id
        );
        $res['goods_count'] = $goods_model->where($count_where)->count();
        return $res;
    }
}