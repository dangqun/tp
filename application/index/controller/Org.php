<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/29
 * Time: 17:06
 */

namespace app\index\controller;

use think\Loader;
class Org extends Base
{

    public function index(){
        return 1;
    }

    /************************************************ api分割线 *******************************************************/

    /**
     * 组织列表
     */
    public function apiGetList(){
        $model = Loader::model('Org');
        $list = $model->field('id,name,address,mobile,img')->with('volunteer')->where('status','=','1')->page($this->page)->limit($this->size)->select();
        if(empty($list)){
            $this->result['error_code'] = 3001;
            $this->output();
            return;
        }
        if(!empty($list)){
            $list = collection($list)->toArray();
            foreach($list as $k=>$v){
                $list[$k]['volunteer'] = count($v['volunteer']);
            }
        }
        $this->result['code'] = 200;
        $this->result['data'] = $list;
        $this->output();
    }

    /**
     * 组织详情
     */
    public function apiGetContent(){
        if(!$this->request->has('id')){
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        $model = Loader::model('Org');
        $id = $this->request->param('id');
        $content = $model->find($id);
        print_r($content->parents);
    }

}