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
    
    public static function getMoreJobs(& $request)
    { //工作页的分页
      $jobs=Company::leftJoin('company_works','companies.id','company_works.company_id')->orderby('company_works.updated_at','desc')->paginate(16);
      $data = [];
      foreach ($jobs as $k=>$list) {
            $new='';$hot='';$fast='';
            if($list['new']==1){
                  $new='<span class="ico_new"><img src="images/new.gif" alt="最新" /></span>';
            }
            if($list['hot']==1){
                  $hot='<span class="ico_new"><img src="images/ico_hot.gif" alt="热门招聘" /></span>';
            }
            if($list['fast']==1){
                  $fast='<span class="ico_new"><img src="images/ji_05.gif" alt="急聘" /></span>';
            }      
            $tmp_html = '<article>
                              <div class="post-box">
                              <h2 class="entry-title">
                                    <a href="/job/detail/'.$list["id"].'">'.$list["job_name"].'</a>
                                    '.$new.$hot.$fast.'
                              </h2>
                              <p><a href="/job/detail/'.$list["id"].'" target="_blank">'.$list["company_name"].'</a></p>
                              </div>
                        </article>';
      $data[] = $tmp_html;
      }
      // dd($data);
      return $data;
    }
    

    /*public static function getSearchJobs(& $request)
    { //工作搜索页的分页
      
      $keywords=$request->get('keywords');
      $category=$request->get('jobcategory');
      
      //职位走这里
      if($category == 1 && $keywords != ''){
            $jobslist =Company::leftjoin('company_works','company_works.company_id','=','companies.id')->where('job_name', 'like', "%$keywords%")->paginate(16);       
            $data = [];
            foreach ($jobs as $k=>$list) {
                  $jobs[$k]['cate']=1;
                  $new='';$hot='';$fast='';
                  if($list['new']==1){
                        $new='<span class="ico_new"><img src="images/new.gif" alt="最新" /></span>';
                  }
                  if($list['hot']==1){
                        $hot='<span class="ico_new"><img src="images/ico_hot.gif" alt="热门招聘" /></span>';
                  }
                  if($list['fast']==1){
                        $fast='<span class="ico_new"><img src="images/ji_05.gif" alt="急聘" /></span>';
                  }      
                  $tmp_html = '<article>
                                    <div class="post-box">
                                    <h2 class="entry-title">
                                          <a href="/job/detail/'.$list["id"].'">'.$list["job_name"].'</a>
                                          '.$new.$hot.$fast.'
                                    </h2>
                                    <p><a href="/job/detail/'.$list["id"].'" target="_blank">'.$list["company_name"].'</a></p>
                                    </div>
                              </article>';
                  $data[] = $tmp_html;
            }
            dd($data);
            return $data;

      }elseif($category == 2 && $keywords != ''){
      //公司走这里
            $jobslist =Company::where('company_name', 'like', "%$keywords%")->paginate(16);
            foreach($jobslist as $k=>$jobslists){
                  $jobslist[$k]['cate']=2;
            }
      }else{
            $jobslist='';
      }
        



      $data = [];
      foreach ($jobs as $k=>$list) {
            $new='';$hot='';$fast='';
            if($list['new']==1){
                  $new='<span class="ico_new"><img src="images/new.gif" alt="最新" /></span>';
            }
            if($list['hot']==1){
                  $hot='<span class="ico_new"><img src="images/ico_hot.gif" alt="热门招聘" /></span>';
            }
            if($list['fast']==1){
                  $fast='<span class="ico_new"><img src="images/ji_05.gif" alt="急聘" /></span>';
            }      
            $tmp_html = '<article>
                              <div class="post-box">
                              <h2 class="entry-title">
                                    <a href="/job/detail/'.$list["id"].'">'.$list["job_name"].'</a>
                                    '.$new.$hot.$fast.'
                              </h2>
                              <p><a href="/job/detail/'.$list["id"].'" target="_blank">'.$list["company_name"].'</a></p>
                              </div>
                        </article>';
      $data[] = $tmp_html;
      }
      // dd($data);
      return $data;
    }*/






    public function jobsearch($keywords='')
    {	
            
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
