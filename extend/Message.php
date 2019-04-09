<?php


use think\Db;
use think\Log;
class Message
{

    /**
     * 发信人，0为系统
     * @var int
     */
    protected $uid = 0;

    /**
     * 收信人
     * @var int
     */
    protected $from;
    /**
     * 消息类型
     * 1：文本
     * 2：图片
     * 3：单图文
     * 4：多图文
     * @var
     */
    protected $type = 1;

    /**
     * 消息标题
     * @var
     */
    protected $title = '';

    /**
     * 图片数组
     * @var array
     */
    protected $img = [];


    /**
     * 消息时间戳
     * @var
     */
    protected $time;

    /**
     * 消息链接
     * @var
     */
    protected $url;

    protected function setFrom($id = 0){
        $this->from = $id;
        return $this;
    }

    protected function setFroms($from = []){
        $this->from = $from;
        return $this;
    }

    protected function setUid($id = 0){
        $this->uid = $id;
        return $this;
    }

    protected function setType($type = 1){
        $this->type = $type;
        return $this;
    }

    protected function setTitle($title = ''){
        $this->title = $title;
        return $this;
    }


    protected function setTime($time = NOW_TIME){
        $this->time = $time;
        return $this;
    }


    protected function setImg($img){
        if(!empty($img)){
            $this->img[] = $img;
        }
        return $this;
    }

    protected function setImgs($imgs = []){
        if(!empty($imgs)){
            $this->img = $imgs;
        }
        return $this;
    }

    protected function setUrl($url = ''){
        if(!empty($url)){
            $this->url = $url;
        }
        return $this;
    }

    /**
     * 发送消息
     */
    protected function send(){
        if(empty($this->from)){
            Log::record('收信人必填');
            return false;
        }
        Db::startTrans();
        $data = $this->setData();
        $result = Db::name('message')->insert($data);
        if(empty($result)){
            Db::rollback();
            return false;
        }
        $this->log($data);
        Db::commit();
        return true;
    }

    /**
     * 批量发送
     */
    protected function sendAll(){
        if(empty($this->from) && !is_array($this->from)){
            Log::record('收信人必填');
            return false;
        }
        $data = $this->setDataAll();
        if($data == false){
            return false;
        }
        Db::startTrans();
        $result = Db::name('message')->insertAll($data);
        if(empty($result)){
            Db::rollback();
            return false;
        }
        Db::commit();
        $this->log($data);
    }

    private function setDataAll(){
        if(!is_array($this->from)){
            return false;
        }
        $data = [];
        foreach($this->from as $k=>$v){
            $arr = [];
            $arr['uid'] = $this->uid;
            $arr['from'] = $v;
            $arr['type'] = $this->type;
            if(!empty($this->title)){
                $arr['title'] = $this->title;
            }
            $arr['type'] = $this->type;
            $arr['time'] = $this->time;
            if(!empty($this->img)){
                if(count($this->img) == 1){
                    $arr['img'] = $this->img[0];
                }else{
                    $arr['img'] = $this->img;
                }
            }
            if(!empty($this->url)){
                $arr['url'] = $this->url;
            }
            $data[] = $arr;
        }
        return $data;
    }

    private function setData(){
        $data = [];
        $data['uid'] = $this->uid;
        $data['from'] = $this->from;
        $data['type'] = $this->type;
        if(!empty($this->title)){
            $data['title'] = $this->title;
        }
        $data['type'] = $this->type;
        $data['time'] = $this->time;
        if(!empty($this->img)){
            if(count($this->img) == 1){
                $data['img'] = $this->img[0];
            }else{
                $data['img'] = $this->img;
            }
        }
        if(!empty($this->url)){
            $data['url'] = $this->url;
        }
        return $data;
    }

    /**
     * 消息日志
     */
    private function log($data = []){
        $log = [
            'uid'=>$data['uid'],
            'create_time'=>$data['time'],
            'content'=>json_encode($data)
        ];
        $result = Db::name('message_log')->insert($log);
        return $result;
    }

    /**
     * 消息日志
     */
    private function logAll($data = []){
        $logs = [];
        foreach($data as $k=>$v){
            $log = [
                'uid'=>$v['uid'],
                'from'=>$v['from'],
                'create_time'=>NOW_TIME,
                'content'=>json_encode($v)
            ];
            $logs[] = $log;
        }
        $result = Db::name('message_log')->insertAll($logs);
        return $result;
    }

}