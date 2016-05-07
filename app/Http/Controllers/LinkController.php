<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LinkController extends Controller
{
    /**
     * 展示首页模版
     */
    public function getLink()
    {
        return view('index');
    }

    /**
     * 进行URL存储
     * @param Request $request
     * @return 返回链接信息（已存在、未存在）
     */
    public function postLink(Request $request)
    {
        // 自动验证
        $this->validate($request,[
            'link' => "required|regex:/^(http[s]{0,1}:\\/\\/)?[a-zA-Z0-9\\.\\-]+\.([a-zA-Z]{2,4})(:\\d+)?(\\/[a-zA-Z0-9\\.\\-~!@#$%^&*+?:_\\/=<>]*)?$/",
        ], [
            'required' => '必须填写要缩短的URL！',
            'regex'    => '请检查网址是否合规矩！',
        ]);

        // 处理传入的URL
        $url = $request->input('link');
        if(preg_match("/^(http[s]?)/", $url) !== 1) {
            $url = 'http://' . $url;
        }

        // 如果数据库中已经存在该URL则为null
        $link = Link::where('url', $url)->first();
        if(is_null($link)) {
            // 生成随机码作为hash
            do {
                $hash = str_random(6);
            } while(Link::where('hash', $hash)->count() != 0);

            // 创建新数据
            $row = new Link();
            $row->url = $url;
            $row->hash = $hash;

            // 插入新数据
            if($row->save()) {
                return redirect(action('LinkController@getLink'))
                    ->withInput()
                    ->with('link', $row->hash);
            } else {
                return redirect(action('LinkController@getLink'))
                    ->withInput()
                    ->with('message', '数据更新异常！');
            }
        } else {
            // 数据库中已经存在，返回此url的hash
            return redirect(action('LinkController@getLink'))
                ->withInput()
                ->with('link', $link->hash);
        }
    }

    /**
     * 依据用户传入的hash值，执行跳转需求
     * @param $hash
     * @return 有效则跳转，失效在首页显示错误信息
     */
    public function shortener($hash)
    {
        // hash值格式验证
        if(preg_match('/^[0-9a-zA-Z]{6}$/', $hash) !== 1) {
            return redirect(action('LinkController@getLink'))
                ->with('message', '无效的链接！');
        }

        // 从数据库中查找URL
        $url = Link::where('hash', $hash)
            ->select('url')
            ->first();

        // 找不到记录则为null
        if(!is_null($url)) {
            return redirect($url->url);
        } else {
            return redirect(action('LinkController@getLink'))
                ->with('message', '失效的链接！');
        }
    }
}
