<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/27
 * Time: 9:04
 */

use think\Request;


trait Upload
{

    private $imgSize = 1048576;//1M

    /**
     * 上传
     * Upload constructor.
     * @param Request $request
     */
    public function upload(Request $request)
    {
        $file = $request->file('image');
        if (!$file) {
            $this->result['msg'] = $file == null ? '参数错误' : $file->getError();
            $this->output();
            return;
        }
        $info = $file->validate(['size' => $this->imgSize])->move(ROOT_PATH . 'public' . DS . 'uploads');
        if (!$info) {
            $this->result['msg'] = $file->getError();
            $this->output();
            return;
        }
        $this->result['error_code'] = 2000;
        $this->result['data'] = [
            'img' => $info->getSaveName()
        ];
        $this->output();
    }

    /**
     * 处理BASE64上传图片
     * @param Request $request
     * @return mixed|string
     */
    public function uploadBase64(Request $request)
    {
        if(!$request->has('image')){
            return '参数错误';
        }
        $img = trim($request->param('image'));
        $result = null;
        if(!preg_match('/^(data:\s*image\/(\w+);base64,)/', $img,$result)){//判断是否为base64
            if($request->has('api')){
                $data = [
                    'code'=>400,
                    'msg'=>'base64图片格式错误',
                ];
                return json($data)->send();//返回JSON
            }else{
                return 'base64图片格式错误';
            }

        }
        if (!in_array($result[2], array('pjpeg', 'jpeg', 'jpg', 'gif', 'bmp', 'png'))) {//判断格式是否在预设值中
            if($request->has('api')){
                $data = [
                    'code'=>400,
                    'msg'=>'base64图片格式错误'
                ];
                return json($data)->send();//返回JSON
            }else{
                return '图片上传类型错误';
            }
        }
        $type = $result[2];//图片类型
        $dir = date('Ymd');//文件名
        $up_dir = ROOT_PATH . 'public' . DS . 'uploads'.DS.$dir.DS;//存放在当前目录的upload文件夹下
        $this->imgPathChmode($up_dir);//设置文件夹和权限
        $imgName = md5(NOW_TIME."_dangqun_".rand(0,10000)).".".$type;//文件名
        $newFile = $up_dir . $imgName;//组合成完整路径
        $this->isImgSize($img);exit;
        $base64Img = str_replace($result[1], '', $img);
        if (file_put_contents($newFile, base64_decode($base64Img))) {
            $img_path = Request::instance()->domain()."/public/uploads/".$dir.'/'.$imgName;
            if($request->has('api')){//api参数存在，则返回JSON数据
                $data = [
                    'code'=>200,
                    'msg'=>'请求成功',
                    'data'=>$img_path
                ];
                return json($data)->send();//返回JSON
            }else{
                return $img_path;//返回图片路径
            }
        } else {
            if($request->has('api')){
                $data = [
                    'code'=>400,
                    'msg'=>'图片上传失败'
                ];
                return json($data)->send();//返回JSON
            }else{
                return '图片上传失败';
            }
        }
    }

    /**
     * 判断base64大小
     */
    private function isImgSize($str){
        /* 判断base64图片数据大小不超过50M */
        $base64 = str_replace('data:image/jpeg;base64,', '', $str);
        $base64 = str_replace('=', '', $base64);
        $img_len = strlen($base64);
        $file_size = $img_len - ($img_len / 8) * 2;
        $file_size = number_format(($file_size / 1024), 2).'kb';
        if ($file_size > $this->imgSize) {
//            echo "image size: ".$file_size."<br/>";
//            echo "image is too large";
//            exit();
            return false;
        }
        return true;
//        echo "Image size: ".$file_size."<br/>";
    }

    /**
     * 设置目录和权限
     * @param $path
     * @return bool
     */
    private function imgPathChmode($path){
        if(empty($path)){
            return false;
        }
        if (!is_dir($path)) {
            @mkdir($path);
            @chmod($path, 0777);
        }
    }

}