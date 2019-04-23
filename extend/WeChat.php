<?php

/**
 * 微信类
 * Trait wechat
 */
trait WeChat
{

    protected $appId = "";
    /**
     * 微信授权类
     */
    public function weLogin(){
        if(!$this->request->has('code')){
            $url = $this->request->url(true);
            $this->redirect("{$url}?code=bin");
        }
        $code = $this->request->param('code');
//        echo "code:".$code;
//        echo "<br/>\r\n";
        //TODO 这里写授权逻辑
        return true;
    }

}