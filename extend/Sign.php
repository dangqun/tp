<?php

/**
 * 签到签退
 * Trait Sign
 */
trait Sign
{
    use Assessment;

    public function sign(){
        $this->typeStr = 'activity';
        $this->uid = 1049;
        $result = $this->add();
        if($result === true){
            $this->result['code'] = 200;
            $this->output();
            return;
        }else if($result === false){
            $this->result['error_code'] = 400;
            $this->output();
        }
        $this->result['msg'] = $result;
        $this->output();
    }

}