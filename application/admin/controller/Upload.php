<?php


namespace app\admin\controller;

use think\Db;
use think\Controller;
use app\common\model\File;
use think\response\Download;

class Upload extends Controller
{

    public function index(){
        $this->fetch();
        $this->navsManager();
        return view('upload');
    }

    private function navsManager()  //将导航栏信息返回到view
    {
        $this->assign('navs', [
            '文章管理'  => [
                [
                    '文章列表'  => url('/admin/article_list'),
                    '添加文章'  => url('/admin/article_add'),
                ],
            ],
            '分类管理'  => [
                [
                    '文章分类'  => url('/admin/category_list'),
                    '增加分类'  => url('/admin/category_add'),
                ],
            ],
            '文件管理'  =>[
                [
                    '上传文件' => url('/admin/file_upload'),
                    '文件列表' => url('#'),
                ]
            ],
        ]);
    }

    public function upload()
    {
        if (!$_FILES["upload_file"]["error"] > 0) {
            if (isset($_POST['file_name'])) {
                $filename = $_POST['file_name'];
            } else {
                $filename = $_FILES["upload_file"]["name"];
            }
            $file_discription = $_POST['file_discription'];
            $allowedExts = array("apk", "exe");
            $temp = explode(".", $_FILES["upload_file"]["name"]);
            $extension = end($temp);
            $file_md5 = md5_file($_FILES['upload_file']['tmp_name']);
            $is_existed = Db::name('file')->where('file_hash', "$file_md5")->find();
            if (!$is_existed) {
                if ($_FILES["upload_file"]["size"] > 102400000) {
                    $this->error("文件大小不得超过100MB","/admin/upload");
//                    echo '<script>alert("文件大小不得超过100MB")</script>';
                } else {
                    if (!in_array($extension, $allowedExts)) {
                        $this->error("只能上传exe或apk文件","/admin/upload");
//                        echo '<script>alert("只能上传exe或apk文件")</script>';
                    } else {
                        if (file_exists("../public/upload_file/")) {
                            if ($extension == 'apk') {
                                move_uploaded_file($_FILES['upload_file']['tmp_name'], "../public/upload_file/apk_file/" . $_FILES["upload_file"]["name"]);
                                $file_path = "../public/upload_file/apk_file/" . $_FILES["upload_file"]["name"];
                            }
                            if ($extension == "exe") {
                                move_uploaded_file($_FILES['upload_file']['tmp_name'], "../public/upload_file/exe_file/" . $_FILES["upload_file"]["name"]);
                                $file_path = "../public/upload_file/exe_file/" . $_FILES["upload_file"]["name"];
                            }
                            //文件信息
                            $file_name = $filename;
                            $upload_time = time();
                            $upload_user = session('user.username');
                            $file_size = $_FILES["upload_file"]["size"];
                            $file_type = $extension;
                            $file_hash = $file_md5;
                            $path = $file_path;
                            //信息数组
                            $info = [
                                'file_name' => "$file_name",
                                'upload_time' => "$upload_time",
                                'upload_user' => "$upload_user",
                                'file_size' => "$file_size",
                                'file_type' => "$file_type",
                                'file_hash' => "$file_hash",
                                'path' => "$path",
                                'discription' => "$file_discription",
                            ];
                            Db::name('file')->insert($info);
                            //上传成功，页面跳转至上传页面
                            $this->success("文件上传成功", "/admin/upload");
                        } else {
//                            echo '<script>alert("上传路径不存在")</script>';
                            $this->error("上传路径不存在，请通知网站管理员","/admin/upload");
                        }
                    }
                }
            } else {
//                echo '<script>alert("文件已存在")</script>';
                $this->error("该文件已存在","/admin/upload");
            }
        }
    }

    public function download()
    {
        if(is_set($_POST['file_id'])){
            $file_name = File::where('id')->select('file_name');
            $file_type = File::where('id')->select('file_type');
            $file_hash = File::where('id')->select('file_hash');
            $download =  new \think\response\Download('image.jpg');
            return $download->name('/public/upload_file/'.$file_type.'_file/'."$file_name");
            // 或者使用助手函数完成相同的功能
            // download是系统封装的一个助手函数
            return download('$filename', "$file_hash".'.'."$file_type");
        } else {
            $this->error("非法请求");
        }
    }
}