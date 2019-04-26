<?php
namespace app\admin\controller;

class Activitys extends Base {

    public function activeList() {
        return $this->fetch('activeList');
    }

    public function actAdd() {
            return $this->fetch('act_add');
        }

}