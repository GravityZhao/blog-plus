<?php


namespace app\admin\validate;


use think\Validate;

class Upload extends Validate
{
    protected $rule = [
        'file' => 'file',
        'name|文件名' => 'require',

    ];

    protected $message =[
        'name.require' => '文件名为必填'
    ]
    public function sceneFileUnique(){
        return $this->only(['file_hash'])->append('file_hash')
}

}