<?php

namespace App\Http\Controllers;

use App\Hardware;
use Illuminate\Http\Request;
use App\SubProduct;
use App\Project;
use App\Client;
use App\Server;
use App\Module;
use App\Param;
use App\Clog;

class ProjectController extends Controller
{
    public function index()
    {
        $now = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        return view('projects/index', [
            'projects' => Project::orderByRaw(strtr("if (check_time > '%now', 1, 0)", ['%now'=> $now]))
                ->orderByRaw(strtr("if (service_end_time > '%now', 1, 0)", ['%now'=> $now]))
                ->orderBy('signed_status', 'asc')
                ->orderBy('service_end_time', 'asc')
                ->get()
        ]);
    }

    public function add(Request $request)
    {
        $user = \Session::get('user');
        if (!$user->can('项目签约')) {
            abort(401);
        }

        $sub = SubProduct::find($request->input('product_id'));
        $client = Client::find($request->input('client_id'));

        $project = new Project();
        $project->product()->associate($sub);
        $project->client()->associate($client);

        $project->vip = (bool) ($request->input('vip') == 'on');

        $project->signed_status = $request->input('signed_status');

        $project->ref_no = $request->input('ref_no');
        $project->name = $request->input('name');
        $project->seller = $request->input('seller');
        $project->contact_user = $request->input('contact_user');

        $signed_time = $request->input('signed_time');

        if (!$signed_time) {
            $signed_time = null;
        } else {
            $signed_time = \Carbon\Carbon::createFromFormat('Y/m/d', $signed_time)->format('Y-m-d H:i:s');
        }

        $project->signed_time = $signed_time;     // 签约时间

        $service_unit = $request->input('service_unit');
        $service_value = $request->input('service_value');

        # 维保时间
        $project->service_unit = $service_unit;
        $project->service_value = $service_value;

        $project->description = $request->input('description');

        if ($project->save()) {
            foreach ($sub->modules as $module) {
                $project->modules()->save($module);
            }

            foreach ($sub->params as $param) {
                $project->params()->save($param, [
                    'value' => $param->pivot->value,
                ]);
            }

            Clog::add($project, '签约项目');
            Clog::add($project->client, '签约项目', [
                $project->name,
            ], Clog::LEVEL_WARNING);

            \Log::notice(strtr('客户项目签约: 用户(%name[%id]) 签约了项目: (%project_name[%project_id]), 客户: (%client_name[%client_id], 子产品: (%product_name[%product_id])', [
                '%name' => $user->name,
                '%id' => $user->id,
                '%project_name' => $project->name,
                '%project_id' => $project->id,
                '%client_name' => $client->name,
                '%client_id' => $client->id,
                '%product_name' => $sub->name,
                '%product_id' => $sub->id,
            ]));

            return redirect(route('project.profile', ['id' => $project->id]))
                ->with('message_content', '签约成功!')
                ->with('message_type', 'info');
        }
    }

    public function edit(Request $request)
    {
        $user = \Session::get('user');
        if (!$user->can('项目信息管理')) {
            abort(401);
        }

        $project = Project::find($request->input('id'));
        $product = SubProduct::find($request->input('product_id'));

        $old_attributes = $project->attributesToArray();

        $project->ref_no = $request->input('ref_no');               // 项目编号
        $project->name = $request->input('name');                   // 项目名称

        $project->vip = (bool) ($request->input('vip') == 'on');

        $project->signed_status = $request->input('signed_status');

        $old_product_id = $project->product->id;
        $new_product_id = $product->id;

        $project->product()->associate($product);                   // 产品类型
        $project->contact_user = $request->input('contact_user');   // 联系人
        $project->contact_phone = $request->input('contact_phone'); // 联系电话
        $project->contact_email = $request->input('contact_email'); // 联系邮箱

        $project->login_url = $request->input('login_url');     //登录地址

        $signed_time = $request->input('signed_time');

        if (!$signed_time) {
            $signed_time = null;
        } else {
            $signed_time = \Carbon\Carbon::createFromFormat('Y/m/d', $signed_time)->format('Y-m-d H:i:s');
        }     // 签约时间

        $project->signed_time = $signed_time;

        # 实际验收时间
        $check_time = $request->input('check_time');

        if (!$check_time) {
            $check_time = null;
        } else {
            $check_time = \Carbon\Carbon::createFromFormat('Y/m/d', $check_time)->format('Y-m-d H:i:s');
        }

        $project->check_time = $check_time;

        # 维保时间
        $project->service_unit = $request->input('service_unit');
        $project->service_value = $request->input('service_value');

        $project->seller = $request->input('seller');               // 销售人员
        $project->engineer = $request->input('engineer');           // 工程师
        $project->description = $request->input('description'); //
        $project->deploy_address = $request->input('deploy_address');
        $project->way = $request->input('way');

        $project->updateServiceEndTime();

        if ($project->save()) {

            //修改了签约类型
            if ($old_product_id != $new_product_id) {

                //清空所有的 module, 重新关联 module
                $connected_modules = $project->modules()->lists('id')->all();

                if (count($connected_modules)) {
                    $project->modules()->detach($connected_modules);
                }

                foreach ($product->modules as $module) {
                    $project->modules()->save($module);
                }

                //清空所有的 params, 重新关联 params
                $connected_params = $project->params()->lists('id')->all();

                if (count($connected_params)) {
                    $project->params()->detach($connected_params);
                }

                foreach ($product->params as $param) {
                    $project->params()->save($param, [
                        'value' => $param->pivot->value,
                    ]);
                }
            }

            $new_attributes = $project->attributesToArray();

            $change = [];
            $helper = [
                'ref_no' => '项目编号',
                'name' => '项目名称',
                'product_id' => '产品类型(编号显示)',
                'contact_user' => '联系人',
                'contact_phone' => '联系人电话',
                'contact_email' => '联系人邮箱',
                'engineer' => '工程师负责人',
                'deploy_address' => '客户地址',
                'seller' => '销售负责人',
                'description' => '备注',
                'way' => '乘车路线',
                'signed_time' => '签约时间',
                'check_time' => '实际验收时间',
                'vip' => '重点项目状态',
                'signed_status' => '正式/试用/售前支持状态',
                'login_url' => '登录地址',
                'service_unit' => '维保时长',
                'service_value' => '维保时长',
            ];

            foreach (array_diff_assoc($old_attributes, $new_attributes) as $key => $value) {
                $old_value = $old_attributes[$key];
                $new_value = $new_attributes[$key];

                switch ($key) {
                    case 'vip':

                        $new_value = ($new_value === true) ? '重点项目' : '普通项目';
                        $old_value = ($old_value === true) ? '重点项目' : '普通项目';

                        break;
                    case 'signed_status':

                        $new_value = \App\Project::$signed_status[$new_value];
                        $old_value = \App\Project::$signed_status[$old_value];

                        break;

                    case 'signed_time':

                        if ($new_value) {
                            $new_value = $new_value->format('Y/m/d');
                        }
                        if ($old_value) {
                            $old_value = $old_value->format('Y/m/d');
                        }

                        //时间需要特殊处理
                        if ($old_value == $new_value) {
                            continue 2;
                        }

                        break;
                    case 'check_time':

                        if ($new_value) {
                            $new_value = $new_value->format('Y/m/d');
                        }
                        if ($old_value) {
                            $old_value = $old_value->format('Y/m/d');
                        }

                        //时间需要特殊处理
                        if ($old_value == $new_value) {
                            continue 2;
                        }

                        break;
                    case 'service_unit':
                    case 'service_value':

                        $old_value = $old_attributes['service_value'].\App\Project::$service_units[$old_attributes['service_unit']];
                        $new_value = $new_attributes['service_value'].\App\Project::$service_units[$new_attributes['service_unit']];

                        $key = 'service_value';
                        break;
                    case 'service_end_time':
                        break 2;
                    default:
                        if ($old_value === null) {
                            $old_value = '空';
                        }
                        if ($new_value === null) {
                            $new_value = '空';
                        }
                }

                $change[$key] = [
                    'old' => $old_value,
                    'new' => $new_value,
                    'title' => $helper[$key],
                ];
            }

            if (count($change)) {
                Clog::add($project, '修改基本信息', $change);

                foreach ($change as $c) {
                    \Log::notice(strtr('项目基本信息修改: 用户(%name[%id]) 修改了项目 (%project_name[%project_id] 的基本信息(%title) %old_value -> %new_value', [
                        '%name' => $user->name,
                        '%id' => $user->id,
                        '%project_name' => $project->name,
                        '%project_id' => $project->id,
                        '%title' => $c['title'],
                        '%old_value' => $c['old'],
                        '%new_value' => $c['new'],
                    ]));
                }
            }

            return redirect(route('project.profile', ['id' => $project->id]))
                ->with('message_content', '修改成功!')
                ->with('message_type', 'info');
        }
    }

    public function profile($id)
    {
        if (!\Session::get('user')->can('项目查看')) {
            abort(401);
        }

        $project = Project::find($id);

        return view('/projects/profile', [
            'project' => $project,
        ]);
    }

    public function delete($id)
    {
        $user = \Session::get('user');
        if (!$user->can('项目信息管理')) {
            abort(401);
        }

        $project = Project::find($id);

        \Log::notice(strtr('项目解约: 用户(%name[%id]) 对项目(%project_name[%project_id]) 进行了解约', [
            '%name' => $user->name,
            '%id' => $user->id,
            '%project_name' => $project->name,
            '%project_id' => $project->id,
        ]));

        Clog::add($project, '解约项目', [], Clog::LEVEL_WARNING);

        $project->delete();

        return redirect(route('projects'))
            ->with('message_content', '已解约该项目!')
            ->with('message_type', 'danger');
    }

    public function servers($id, Request $request)
    {
        $user = \Session::get('user');

        if (!$user->can('项目服务器管理')) {
            abort(401);
        }

        $project = Project::find($id);

        $server = Server::find($request->input('server_id'));

        $deploy_time = $request->input('deploy_time');

        if (!$deploy_time) {
            $deploy_time = null;
        } else {
            $deploy_time = \Carbon\Carbon::createFromFormat('Y/m/d', $deploy_time)->format('Y-m-d H:i:s');
        }

        if (!$project->servers()->find($request->input('server_id'))) {
            $project->servers()->save($server, [
                'deploy_time' => $deploy_time,
            ]);

            Clog::add($project, '关联服务器', [
                $server->name,
            ], Clog::LEVEL_WARNING);

            \Log::notice(strtr('项目服务器关联: 用户(%name[%id]) 对项目(%project_name[%project_id]) 关联了服务器(%server_name[%server_id)], 部署时间(%time)', [
                '%name' => $user->name,
                '%id' => $user->id,
                '%project_name' => $project->name,
                '%project_id' => $project->id,
                '%server_name' => $server->name,
                '%server_id' => $server->id,
                '%time' => $deploy_time,
            ]));

            return redirect(route('project.profile', ['id' => $project->id]))
                ->with('message_content', '关联成功!')
                ->with('message_type', 'info')
                ->with('tab', 'servers');
        }

        return redirect(route('project.profile', ['id' => $project->id]))
            ->with('message_content', '已关联服务器, 无法再次关联')
            ->with('message_type', 'danger')
            ->with('tab', 'servers');
    }

    public function server_disconnect($id, $server_id, Request $request)
    {
        $user = \Session::get('user');
        if (!$user->can('项目服务器管理')) {
            abort(401);
        }

        $project = Project::find($id);
        $server = Server::find($server_id);

        if ($project->servers()->find($server->id)) {
            $project->servers()->detach($server);

            Clog::add($project, '解除关联服务器', [
                $server->name,
            ], Clog::LEVEL_WARNING);

            \Log::notice(strtr('项目服务器解除关联: 用户(%name[%id]) 解除了项目(%project_name[%project_id]) 关联的服务器(%server_name[%server_id])', [
                '%name' => $user->name,
                '%id' => $user->id,
                '%project_name' => $project->name,
                '%project_id' => $project->id,
                '%server_name' => $server->name,
                '%server_id' => $server->id,
            ]));

            return redirect()->to(route('project.profile', ['id' => $project->id]))
                ->with('message_content', '解除关联成功')
                ->with('message_type', 'info')
                ->with('tab', 'servers');
        }
    }

    public function server_edit($id, Request $request)
    {
        $user = \Session::get('user');
        if (!$user->can('项目服务器管理')) {
            abort(401);
        }

        $project = Project::find($id);
        $server = Server::find($request->input('server_id'));

        if ($project->servers()->find($server->id)) {
            $deploy_time = $request->input('deploy_time');

            if (!$deploy_time) {
                $deploy_time = null;
            } else {
                $deploy_time = \Carbon\Carbon::createFromFormat('Y/m/d', $deploy_time);
            }

            $old_deploy_time = $project
                ->servers()
                ->where('server_id', $server->id)
                ->first()
                ->pivot
                ->deploy_time;

            $project->servers()->updateExistingPivot($server->id, [
                'deploy_time' => $deploy_time,
            ]);

            $old = $old_deploy_time->format('Y/m/d');
            $new = $deploy_time->format('Y/m/d');
            Clog::add($project, '修改服务器部署时间', [
                [
                    'old' => $old,
                    'new' => $new,
                    'title' => '部署时间',
                ],
            ]);

            \Log::notice(strtr('项目服务器部署时间修改: 用户(%name[%id]) 修改了项目(%project_name[%project_id]) 关联的服务器(%server_name[%server_id]) 的部署时间: %old -> %new', [
                '%name' => $user->name,
                '%id' => $user->id,
                '%project_name' => $project->name,
                '%project_id' => $project->id,
                '%server_name' => $server->name,
                '%server_id' => $server->id,
                '%old' => $old,
                '%new' => $new,
            ]));

            return redirect()->to(route('project.profile', ['id' => $project->id]))
                ->with('message_content', '修改成功')
                ->with('message_type', 'info')
                ->with('tab', 'servers');
        }
    }

    public function modules($id, Request $request)
    {
        $user = \Session::get('user');
        if (!$user->can('项目模块管理')) {
            abort(401);
        }

        $project = Project::find($id);

        $connected_modules = $project->modules()->where(
                'project_id',
                $project->id
            )->lists('id')->all();

        if (count($connected_modules)) {
            $project->modules()->detach($connected_modules);
        }

        $new_modules = $request->input('modules', []);

        foreach ($new_modules as $module_id) {
            $module = Module::find($module_id);

            $project->modules()->save($module);
        }

        $d1 = array_diff($new_modules, $connected_modules);
        $d2 = array_diff($connected_modules, $new_modules);

        if (count($d1)) {
            //新加的模块
            Clog::add($project, '添加模块', [
                implode(',', \App\Module::whereIn('id', $d1)->lists('name')->all()),
            ], Clog::LEVEL_WARNING);

            foreach ($d1 as $m) {
                $module = Module::find($m);
                \Log::notice(strtr('项目模块增加: 用户(%name[%id] 添加了项目(%project_name[%project_id] 的模块 (%module_name[%module_id])', [
                    '%name' => $user->name,
                    '%id' => $user->id,
                    '%project_name' => $project->name,
                    '%project_id' => $project->id,
                    '%module_name' => $module->name,
                    '%module_id' => $module->id,
                ]));
            }
        }

        if (count($d2)) {
            //删除的模块
            Clog::add($project, '删除模块', [
                implode(',', \App\Module::whereIn('id', $d2)->lists('name')->all()),
            ], Clog::LEVEL_WARNING);

            foreach ($d2 as $m) {
                $module = Module::find($m);

                \Log::notice(strtr('项目模块删除: 用户(%name[%id] 删除了项目(%project_name[%project_id] 的模块 (%module_name[%module_id])', [
                    '%name' => $user->name,
                    '%id' => $user->id,
                    '%project_name' => $project->name,
                    '%project_id' => $project->id,
                    '%module_name' => $module->name,
                    '%module_id' => $module->id,
                ]));
            }
        }

        return redirect()->back()
            ->with('message_content', '模块设置成功!')
            ->with('message_type', 'info')
            ->with('tab', 'softwares');
    }

    public function param_edit($id, Request $request)
    {
        $user = \Session::get('user');
        if (!$user->can('项目参数管理')) {
            abort(401);
        }

        $param_id = $request->input('param_id');

        $param = Param::find($param_id);

        $project = Project::find($id);

        $old_value = $project->params()->where('param_id', $param->id)->first()->pivot->value;

        //如果设定了需要重置,
        if ($request->input('reset') == 'on') {
            $new_value = $project->product->params()->where('param_id', $param->id)->first()->pivot->value;

            $project->params()->detach($param_id);

            $project->params()->save($param, [
                'value' => $new_value,
            ]);

            Clog::add($project, '重置参数', [
                [
                    'old' => $old_value,
                    'new' => $new_value,
                    'title' => $param->name,
                ],
            ], Clog::LEVEL_WARNING);
        } else {
            $project->params()->detach($param_id);

            $new_value = $request->input('value');

            $project->params()->save($param, [
                'value' => $new_value,
                'manual' => true,
            ]);

            Clog::add($project, '更新参数', [
                [
                    'old' => $old_value,
                    'new' => $new_value,
                    'title' => $param->name,
                ],
            ], Clog::LEVEL_WARNING);
        }

        \Log::notice(strtr('项目参数修改: 用户(%name[%id]) 修改了项目(%project_name[%project_id]) 的参数 (%param_name[%param_id]): %old -> %new', [
            '%name' => $user->name,
            '%id' => $user->id,
            '%project_name' => $project->name,
            '%project_id' => $project->id,
            '%param_name' => $param->name,
            '%param_id' => $param->id,
            '%old' => $old_value,
            '%new' => $new_value,
        ]));

        return redirect()->back()
            ->with('message_content', '参数修改成功!')
            ->with('message_type', 'info')
            ->with('tab', 'softwares');
    }

    public function hardwares($id, Request $request)
    {
        $user = \Session::get('user');
        if (!$user->can('项目硬件管理')) {
            abort(401);
        }

        $project = Project::find($id);

        $data = $project->hardwares()->lists('id')->all();

        //$data 为已关联的

        $hardwares = $request->input('hardwares');

        //拆分算法如下

        //1. 获取 $data 和 $params 的交集
        //2. 获取 $data 和 1.中交集的差集
        //3. 对差集进行 detach 即可
        //4. 获取 $param 和 1.中交集的差集, 进行 save

        //1. 获取 $data 和 $params 的交集
        $intersect = array_intersect($data, (array) $hardwares);

        //2. 获取 $data 和 1.中交集的差集

        $detach = array_diff($data, $intersect);

        //3. detach
        if (count($detach)) {
            foreach ($detach as $id) {
                $hardware = Hardware::find($id);

                \Log::notice(strtr('项目硬件取消关联: 用户(%name[%id]) 取消关联了项目(%project_name[%project_id]) 中的硬件 (%hardware_name[%hardware_id])', [
                    '%name' => $user->name,
                    '%id' => $user->id,
                    '%project_name' => $project->name,
                    '%project_id' => $project->id,
                    '%hardware_name' => $hardware->name,
                    '%hardware_id' => $hardware->id,
                ]));
            }

            $project->hardwares()->detach($detach);

            Clog::add($project, '取消关联硬件', [
                implode(',', \App\Hardware::whereIn('id', $detach)->lists('name')->all()),
            ]);
        }

        //4. 获取 $param 和 1.中交集的差集, 进行 save
        $save = array_diff((array) $hardwares, $intersect);

        $counts = $request->input('count');

        if (count($save)) {
            $hsn = [];
            foreach ($save as $hardware_id) {
                $hardware = Hardware::find($hardware_id);

                $count = $counts[$hardware_id];

                $project->hardwares()->save($hardware, [
                    'count' => $count,
                ]);

                $hsn[] = $hardware->name;

                \Log::notice(strtr('项目硬件关联: 用户(%name[%id]) 关联了项目(%project_name[%project_id]) 中的硬件 (%hardware_name[%hardware_id]), 计划部署数量: %count', [
                    '%name' => $user->name,
                    '%id' => $user->id,
                    '%project_name' => $project->name,
                    '%project_id' => $project->id,
                    '%hardware_name' => $hardware->name,
                    '%hardware_id' => $hardware->id,
                    '%count' => $count,
                ]));

                Clog::add($project, '关联硬件', [
                    [
                        'title' => strtr('关联了硬件 %hardware_name, 计划部署数量: %count', [
                            '%hardware_name' => $hardware->name,
                            '%count' => $count,
                        ]),
                    ],
                ], CLog::LEVEL_WARNING);
            }
        }

        foreach ($project->hardwares as $h) {
            if (array_key_exists($h->id, $counts)) {
                if ($h->pivot->count != $counts[$h->id]) {
                    $project->hardwares()->updateExistingPivot($h->id, [
                        'count' => $counts[$h->id],
                    ]);

                    \Log::notice(strtr('项目硬件关联: 用户(%name[%id]) 设置了项目(%project_name[%project_id]) 中的硬件 (%hardware_name[%hardware_id]) 的计划部署数量: %old -> %new', [
                        '%name' => $user->name,
                        '%id' => $user->id,
                        '%project_name' => $project->name,
                        '%project_id' => $project->id,
                        '%hardware_name' => $h->name,
                        '%hardware_id' => $h->id,
                        '%old' => $h->pivot->count,
                        '%new' => $counts[$h->id],
                    ]));

                    Clog::add($project, '修改硬件部署数量', [
                        [
                            'title' => $h->name,
                            'old' => $h->pivot->count,
                            'new' => $counts[$h->id],
                        ],
                    ], Clog::LEVEL_NOTICE);
                }
            }
        }

        return redirect()->back()
            ->with('message_content', '硬件设置成功!')
            ->with('message_type', 'info')
            ->with('tab', 'hardwares');
    }

    public function hardware_edit($id, Request $request)
    {
        $user = \Session::get('user');
        if (!$user->can('项目硬件管理')) {
            abort(401);
        }

        $hardware_id = $request->input('hardware_id');

        $hardware = Hardware::find($hardware_id);

        $project = Project::find($id);

        $h = $project->hardwares()->where('hardware_id', $hardware_id)->first();

        $old = [
            'description' => $h->pivot->description,
            'count' => $h->pivot->count,
        ];

        $new = [
            'description' => $request->input('description'),
            'count' => $request->input('count'),
        ];

        $project->hardwares()->detach($hardware_id);

        $project->hardwares()->save($hardware, $new);

        $change = [];

        $diff_helper = [
            'description' => '描述',
            'count' => '计划部署数量',
        ];

        foreach (array_keys($diff_helper) as $item) {
            if ($old[$item] != $new[$item]) {
                $change[] = [
                    'old' => $old[$item],
                    'new' => $new[$item],
                    'title' => $diff_helper[$item],
                ];
            }
        }

        if (count($change)) {
            foreach ($change as $c) {
                \Log::notice(strtr('项目关联硬件信息修改: 用户(%name[%id]) 修改了项目(%project_name[%project_id]) 关联硬件的信息: %title  %old -> %new', [
                    '%name' => $user->name,
                    '%id' => $user->id,
                    '%project_name' => $project->name,
                    '%project_id' => $project->id,
                    '%title' => $c['title'],
                    '%old' => $c['old'],
                    '%new' => $c['new'],
                ]));
            }

            array_unshift($change, [
                'title' => strtr('项目硬件: %hardware_name', ['%hardware_name' => $hardware->name]),
            ]);

            Clog::add($project, '关联硬件基本信息修改', $change, Clog::LEVEL_WARNING);
        }

        return redirect()->back()
            ->with('message_content', '硬件修改成功!')
            ->with('message_type', 'info')
            ->with('tab', 'hardwares');
    }

    //profile 信息 start
    public function profile_item($id, Request $request)
    {
        if (!\Session::get('user')->can('项目查看')) {
            abort(401);
        }

        $project = Project::find($id);
        $type = $request->input('type');

        $method = strtr('_profile_{type}', ['{type}' => $type]);

        if (method_exists($this, $method)) {
            return call_user_func([$this, $method], $project);
        }
    }

    private function _profile_comments($project)
    {
        return view('projects/profile/comments', ['project' => $project]);
    }

    private function _profile_servers($project)
    {
        return view('projects/profile/servers', ['project' => $project]);
    }

    private function _profile_hardwares($project)
    {
        return view('projects/profile/hardwares', ['project' => $project]);
    }

    private function _profile_softwares($project)
    {
        return view('projects/profile/softwares', ['project' => $project]);
    }

    private function _profile_informations($project)
    {
        return view('projects/profile/informations', ['project' => $project]);
    }

    private function _profile_trello($project)
    {
        return view('projects/profile/trello', ['project' => $project]);
    }

    private function _profile_records($project)
    {
        return view('projects/profile/records', ['project' => $project]);
    }
    //profile 信息 end
}
