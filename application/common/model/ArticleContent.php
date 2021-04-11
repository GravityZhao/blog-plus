<?php

namespace app\common\model;

use think\Model;

class ArticleContent extends Model
{
    public function article()
    {
        return $this->hasOne('Article', 'a_id', 'id');
    }
}
