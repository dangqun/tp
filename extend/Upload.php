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
    public function upload(\think\Request $request)
    {
        $file = $request->file('image');
        if (!$file) {
            $this->result['msg'] = $file->getError();
            $this->output();
            return;
        }
        $info = $file->validate(['size' => 204800])->move(ROOT_PATH . 'public' . DS . 'uploads');
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
     */
    protected function uploadBase64()
    {
        // $file = base64_decode(request()->file('image'));//图片
        $param = input('param.');
        $up_dir = ROOT_PATH . 'public' . DS . 'uploads / ';//存放在当前目录的upload文件夹下
        $base64_img = trim($param['image']);
        if (preg_match(' /^(data:\s * image\/(\w +);base64,)/', $base64_img, $result)){
            $type = $result[2];
            if (in_array($type, array('pjpeg', 'jpeg', 'jpg', 'gif', 'bmp', 'png'))) {
                $new_file = $up_dir . time() . ' . ' . $type;
                if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img)))) {
                    $img_path = str_replace(' ../../..', '', $new_file);
                    return $img_path;
                } else {
                    return '图片上传失败';
                }
            } else {
                //文件类型错误
                return '图片上传类型错误';
            }
        }
    }

}