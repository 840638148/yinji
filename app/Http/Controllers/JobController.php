<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Error;
use App\Http\Output;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Models\CompanyWork;
use App\Models\CompanyProject;
use App\Models\Company;
use App\Models\Companyhot;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';

    	//使用model来获取所有列表，分页    获取company_work表的数据
    	$joblist=Company::leftJoin('company_works','companies.id','company_works.company_id')->orderby('company_works.updated_at','desc')->paginate(16);

    	$company=Company::orderby('sort','desc')->get();//获取companies表的数据
		
		//连表查询 并用company_id进行分组
		$companyall=Company::leftJoin('company_works','companies.id','company_works.company_id')->orderby('companies.sort','desc')->orderby('company_works.updated_at','desc')->get()->groupby('company_id');
		
		$company_all_n = [];
		foreach ($companyall as $company) {
		    $company_all_n[] = $company->take(4)->all();
        }

		//热词查询
		$hotword=Companyhot::all()->toArray();
		
    	$data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'joblist'=>$joblist,
            'hotword'=>$hotword,
            'company_all_n'=>$company_all_n,
        ];

        return view('job.lists', $data);
    }
        
    
    //job关键字查询   
    public function searchjob(Request $request)
    {   
        // dd($request->all());
    	$lang = $request->session()->get('language') ?? 'zh-CN';
		//获取表单提交的数据
    	$keywords=$request->get('keywords');
    	$category=$request->get('jobcategory');
    	$page=CompanyWork::paginate(10);//使用model来获取所有列表，分页    获取company_work表的数据
    	//连表查询 并用company_id进行分组
		$companyall=Company::leftJoin('company_works','companies.id','company_works.company_id')->orderby('companies.sort','desc')->orderby('company_works.updated_at','desc')->get()->groupby('company_id');
		
		$company_all_n = [];
		foreach ($companyall as $company) {
		    $company_all_n[] = $company->take(4)->all();
        }
        
		//热词查询
		$hotword=Companyhot::all()->toArray();

        // $jobslist = (new CompanyWork)->jobsearch($keywords)->toArray();
        //  dd($request->all());

        //职位走这里
        if($category == 1 && $keywords != ''){
            $jobslist =Company::leftjoin('company_works','company_works.company_id','=','companies.id')->where('job_name', 'like', "%$keywords%")->get()->toArray();       

            foreach($jobslist as $k=>$jobslists){
                $jobslist[$k]['cate']=1;
            }
           
        }elseif($category == 2 && $keywords != ''){
            //公司走这里
            $jobslist =Company::where('company_name', 'like', "%$keywords%")->get()->toArray();
            foreach($jobslist as $k=>$jobslists){
                $jobslist[$k]['cate']=2;
            }
        }else{
            $jobslist='';
        }
        

    	$data = [
    	   'lang' => $lang,
    	   'user' => $this->getUserInfo(),
           'jobslist'=>$jobslist,
           'hotword'=>$hotword,
           'company_all_n'=>$company_all_n,
        ];

        return view('job.searchjob',$data);
    }   
       
       
    
/*    public function detail(Request $request, $company_id)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        
    	$companyde=Db::table('companies')->where('id',$company_id)->get();
        
        $jobdetail=CompanyWork::where('id',$company_id)->get();//获取招聘详情
        $jobproject=CompanyProject::all();//获取所有项目

        $data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'jobdetail' => $jobdetail,
            'jobproject' => $jobproject,
            'companyde' => $companyde,
        ];
        
        return view('job.detail', $data);
    }*/
    
    public function detail(Request $request,$id)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        
      
        //企业ID
        $company_id=CompanyWork::where('id',$id)->first()->company_id;
        //所有有关相同企业ID的数据
    	$companyde=Db::table('companies')->where('id',$company_id)->get();

		//连表查询 并用company_id进行分组
		$companyall=Company::leftJoin('company_works','companies.id','company_works.company_id')->orderby('companies.sort','desc')->orderby('company_works.updated_at','desc')->get()->groupby('company_id');
        
        //右边招聘显示最新的4个职位
		$company_all_n = [];
		foreach ($companyall as $company) {
		    $company_all_n[] = $company->take(4)->all();
		}

    	$arr1=[];
    	$arr2=CompanyWork::where('company_id',$company_id)->get();//获取所有公司职位
    	
    	$first_display = $arr2->firstWhere('id', $id)->toArray();
    	$lists = $arr2->reject(function ($value) use ($id) {
		  return $value->id == $id;
		});
		$lists=$lists->toArray();


        $jobproject=CompanyProject::where('company_id',$company_id)->get()->toArray();//获取所有项目
        // dd($company_id);
		
        $data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'jobproject' => $jobproject,
            'companyde' => $companyde,
            'first_display' => $first_display,
            'arr2' => $arr2,
            'companyall' => $companyall,
            'lists' => $lists,
            'company_all_n' => $company_all_n,
        ];
        
        return view('job.detail', $data);
    }
    
    
    public function apply(Request $request)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        

        $data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
        ];
        
        return view('job.apply', $data);
    }
}
