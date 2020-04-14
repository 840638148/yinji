<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyWork extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    
    
    public function company()
    {
          return $this->belongsTo(Company::class, 'company_id', 'id');
          
    }
    
    public function getjob()
    {
          return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    
    public function jobname()
    {
          return $this->belongsTo(Jobname::class, 'company_id', 'id');
    }
    
    public function jobsearch($keywords='')
    {	
            // dd($keywords);
    	// 获取搜索查询的数据
    	// $jobslist =CompanyWork::query()
	// 	->whereHas('company', function ($query) use ($keywords){
	// 	  $query->where('company_name', 'like', "%$keywords%");
	// 	})
	// 	->orwhere('job_name', 'like', "%$keywords%")
	// 	->orWhere('addr', 'like', "%$keywords%")
	// 	->orWhere('content', 'like', "%$keywords%")
	// 	->orWhere('skills', 'like', "%$keywords%")
      // 	->get();
            
            //职位走这里
            if($_GET['jobcategory']==1 && $keywords !== ''){
                  $jobslist =CompanyWork::where('job_name', 'like', "%$keywords%")->get();
                  return $jobslist;

            }else{
                  $jobslist='没有数据';
                  return $jobslist;
            }

            //公司走这里
            if($_GET['jobcategory']==2 && $keywords != ''){
                  $jobslist =Company::where('company_name', 'like', "%$keywords%")->get();
                  return $jobslist;
            }else{
                  $jobslist='没有数据';
                  return $jobslist;
            }
		
         
    }
    
    
}
