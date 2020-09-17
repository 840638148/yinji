<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loupan extends Model
{
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'name','name_en', 'intro','intro_en','lpavg','tel','address','address_en','email','fax','url','area','area_en','dc_id','cover','logoimg','view_num','release_time','jz_dcarticle_id','yl_dcarticle_id','gq_dcarticle_id','yxzx_dcarticle_id','ybf_dcarticle_id','designer_id','jz_display','yl_display','yxzx_display','gq_display','ybf_display','hxt_display','hxtimg',
    ];


    //将字段修改为json类型，数据库存的时候格式为json格式["qwe","asda"],修改器
    public function setDesignerIdAttribute($value)
    {
        $this->attributes['designer_id'] =  ',' . implode(',', $value) . ',';
    }
    
    // 访问器
    public function getDesignerIdAttribute($value)
    {   
        $value = trim($value, ',');
        return explode(',', $value);
    }


    public function getJzDcArticleIdAttribute($value)
    {
        $value = trim($value, ',');
        return explode(',', $value);
    }

    public function setJzDcArticleIdAttribute($value)
    {
        $this->attributes['jz_dcarticle_id'] =  ',' . implode(',', $value) . ',';
    }

    public function getYlDcArticleIdAttribute($value)
    {
        $value = trim($value, ',');
        return explode(',', $value);
    }

    public function setYlDcArticleIdAttribute($value)
    {
        $this->attributes['yl_dcarticle_id'] =  ',' . implode(',', $value) . ',';
    }
    
    public function getGqDcArticleIdAttribute($value)
    {
        $value = trim($value, ',');
        return explode(',', $value);
    }

    public function setGqDcArticleIdAttribute($value)
    {
        $this->attributes['gq_dcarticle_id'] =  ',' . implode(',', $value) . ',';
    }

    public function getYxzxDcArticleIdAttribute($value)
    {
        $value = trim($value, ',');
        return explode(',', $value);
    }

    public function setYxzxDcArticleIdAttribute($value)
    {
        $this->attributes['yxzx_dcarticle_id'] =  ',' . implode(',', $value) . ',';
    }

    public function getYbfDcArticleIdAttribute($value)
    {
        $value = trim($value, ',');
        return explode(',', $value);
    }

    public function setYbfDcArticleIdAttribute($value)
    {
        $this->attributes['ybf_dcarticle_id'] =  ',' . implode(',', $value) . ',';
    }

    public function setHxtimgAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['hxtimg'] = ',' . implode(',', $value) . ',';
        }
    }
    
    public function getHxtimgAttribute($value)
    {
        $value = trim($value, ',');
        return explode(',', $value);
    }

}
