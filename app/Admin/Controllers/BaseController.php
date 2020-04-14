<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class BaseController extends Controller
{

    public $strHeader = '';
    public $currentModel = '';
   

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header($this->strHeader)
            ->description(trans('admin::lang.list'))
            ->body($this->grid());
    }
    
    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header($this->strHeader)
            ->description('description')
            ->body($this->detail($id));
    }
    

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function getCreate(Content $content)
    {
        return $content
            ->header($this->strHeader)
            ->description('description')
            ->body($this->form());
    }


    /**
     * Create action.
     *
     * @return Content
     */
    public function postCreate(Request $request)
    {
        $validator = $this->valid($request);
    	if ($validator->fails()) {
    		return back()->withInput()->withErrors($validator);
    	}
        
    	return $this->form($request)->store();
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function getEdit($id, Content $content)
    {
        return $content
            ->header($this->strHeader)
            ->description('description')
            ->body($this->form()->edit($id));
    }
    
    /**
     * Edit action.
     *
     * @param $id
     * @return Content
     */
    public function putEdit(Request $request, $id)
    {
    	$validator = $this->valid($request);
    	if ($validator->fails()) {
    		return back()->withInput()->withErrors($validator);
    	}
    	return $this->form($request)->update($id);
    }
    
    
    /**
     * Delete action.
     *
     * @param $id
     * @return Content
     */
    public function remove($id)
    {
    	$ids = explode(',', $id);
    	
    	if ($this->currentModel::destroy(array_filter($ids))) {
    		return response()->json([
    				'status'  => true,
    				'message' => trans('admin::lang.delete_succeeded'),
    		]);
    	} else {
    		return response()->json([
    				'status'  => false,
    				'message' => trans('admin::lang.delete_failed'),
    		]);
    	}
    }
    
    public function option()
    {
        return $this->currentModel::select("id", "name_cn as text")->get();
    }
}
