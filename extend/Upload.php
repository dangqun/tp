<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/27
 * Time: 9:04
 */


trait Upload
{

    /**
     * 上传
     * Upload constructor.
     * @param \think\Request $request
     * @param $name
     */
    public function upload (\think\Request $request){
        $file = $request->file('image');
        if(!$file){
            $this->result['msg'] = $file->getError();
            $this->output();
            return;
        }
        $info = $file->validate(['size'=>204800])->move(ROOT_PATH.'public'. DS . 'uploads');
        if(!$info){
            $this->result['msg'] = $file->getError();
            $this->output();
            return;
        }
        $this->result['error_code'] = 2000;
        $this->result['data'] = [
            'img'=>$info->getSaveName()
        ];
        $this->output();
    }

}