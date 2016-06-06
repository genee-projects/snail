<?php

namespace App;

class NFS
{
    public static function delete($path)
    {
        //修正一下 Path
        $path = realpath($path);

        //目录
        $dirname = dirname($path);

        //文件
        $file = substr($path, strrpos($path, '/') + 1);

        //不进行删除, 增加 . 进行隐藏即可
        $new_path = strtr('%dirname/.%file', [
            '%dirname' => $dirname,
            '%file' => $file,
        ]);

        if (file_exists($new_path)) {
            $dirname = dirname($new_path).'/';

            $info = \App\NFS::pathinfo($new_path);
            $extension = $info['extension'] ? '.'.$info['extension'] : '';
            $name = substr($file, 0, strrpos($file, '.') ?: strlen($file));

            $suffix_count = 2;

            do {
                $file_name = $name.'('.$suffix_count.')'.$extension;
                $new_path = $dirname.'.'.$file_name;
                ++$suffix_count;
            } while (file_exists($new_path));
        }

        return rename($path, $new_path);
    }

    public static function rename($path, $old, $new)
    {
        $dirname = realpath($path);

        $old = strtr('%dirname/%old', [
            '%dirname' => $dirname,
            '%old' => $old,
        ]);

        $new = strtr('%dirname/%new', [
            '%dirname' => $dirname,
            '%new' => self::fix_name($new),
        ]);

        return rename($old, $new);
    }

    public static function path($project, $path, $type = '*')
    {

        //先进行目录过滤
        $path = self::fix_path($path);

        $full_path = self::full_path($project, $path);

        $directory = [];
        $file = [];
        foreach (scandir($full_path) as $f) {
            if ($f[0] == '.') {
                continue;
            }

            if (is_dir($full_path.'/'.$f)) {
                $directory[] = $f;
            } else {
                $file[] = $f;
            }
        }

        switch ($type) {
            case '*':
                $return = [
                    'directory' => $directory,
                    'file' => $file,
                ];
            break;
            case 'directory':
                $return = $directory;
            break;
            case 'file':
                $return = $file;
            break;
            default:
        }

        return $return;
    }

    //返回此路径的去除点，空格等后的合法路径$path
    public static function fix_path($path)
    {
        $path = preg_replace('/^[\/\s]+|[\/\s]+$/', '', $path);
        $path = preg_replace('/\.{1,2}\/{0,1}/', '', $path);

        return $path;
    }

    //修正文件名称
    public static function fix_name($name)
    {

        //文件或目录名称修改函数
        if (is_null($name) || trim($name) == '') {
            return;
        }

        //无论如何，都会清空前面的.，如果delete_slash为true，会继续清空前面的/
        $name = preg_replace('/^[.\s\/]+/', '', $name);
        $name = preg_replace('/\//', '_', $name); /* 删除斜线(/) */

        return $name;
    }

    public static function full_path($project, $path)
    {
        $root = config('app.nfs_root');

        return strtr('%root/project/%id/%path', [
            '%root' => $root,
            '%id' => $project->id,
            '%path' => $path,
        ]);
    }

    public static function nfs_init($project)
    {
        $root = config('app.nfs_root');

        $id = $project->id;

        $dirs = [
            '系统运行计划',
            '客户部署情况',
            '外出工作总结',
            '培训相关',
            '验收相关',
            '客服案例记录' => [
                '2016年',
                '2016年之前',
            ],
            '出差表单' => [
                '硬件交付单',
                '工程联系单',
                '巡访记录',
            ],
            '用户报告',
            '其他',
            '施工相关',
            '初始数据',
        ];

        foreach ($dirs as $key => $dir) {
            if (is_array($dir)) {
                $path = strtr('%root/project/%id/%path', [
                    '%root' => $root,
                    '%id' => $id,
                    '%path' => $key,
                ]);

                mkdir($path, 0775, true);

                foreach ($dir as $d) {
                    $path = strtr('%root/project/%id/%dir/%path', [
                        '%root' => $root,
                        '%id' => $id,
                        '%dir' => $key,
                        '%path' => $d,
                    ]);

                    mkdir($path, 0755, true);
                }
            } else {
                $path = strtr('%root/project/%id/%path', [
                    '%root' => $root,
                    '%id' => $id,
                    '%path' => $dir,
                ]);

                mkdir($path, 0755, true);
            }
        }
    }

    public static function pathinfo($path)
    {
        $pathinfo = [];

        $name = substr($path, strripos($path, '/') + 1, strripos($path, '.'));

        $dirname = substr($path, 0, strripos($path, '/'));

        preg_match("/(.*)\./ ", $name, $filename);

        preg_match("/((?<=\.)\w+)$/", $name, $exp);

        $pathinfo['dirname'] = $dirname;
        $pathinfo['basename'] = $name;

        if (isset($exp[1])) {
            $pathinfo['extension'] = $exp[1];
        } else {
            $pathinfo['extension'] = null;
        }
        if (isset($filename[1])) {
            $pathinfo['filename'] = $filename[1];
        } else {
            $pathinfo['filename'] = null;
        }

        return $pathinfo;
    }
}
