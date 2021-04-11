<?php

namespace app\admin\model;

class ArticleContent extends \app\common\model\ArticleContent
{
    public function add(array $data)  //向数据库插入base64编码后的文章
    {
        $data['content'] = base64_encode($data['content']);
        return $this->insert($data);
    }

    public function edit($id, $content)  //向数据库中更新base64编码后的文章
    {
        return $this->where('id', $id)->update(['content' => base64_encode($content)]);
    }
}
