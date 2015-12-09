@extends('layout')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">广西大学 <span class="text-danger">(已关闭)</span></h1>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-user"> 基本信息</i>
            </div>
            <div class="panel panel-body">
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <td style="width: 20%;">客户名称</td>
                        <td class="edit" colspan="2" tabindex="1">广西大学</td>
                    </tr>
                    <tr>
                        <td>项目名称</td>
                        <td class="edit" colspan="2" tabindex="2">广西大学大型仪器共享管理系统</td>
                    </tr>
                    <tr>
                        <td>产品类型</td>
                        <td class="edit" colspan="2" tabindex="3">CF-LIMS</td>
                    </tr>
                    <tr>
                        <td>版本</td>
                        <td class="edit" colspan="2" tabindex="4">CF-2.0</td>
                    </tr>
                    <tr>
                        <td>客户类型</td>
                        <td class="edit" colspan="2" tabindex="5">高校</td>
                    </tr>
                    <tr>
                        <td>所在区域</td>
                        <td class="edit" colspan="2" tabindex="6">西南</td>
                    </tr>
                    <tr>
                        <td>联系人</td>
                        <td class="edit" colspan="2" tabindex="7">覃戟</td>
                    </tr>
                    <tr>
                        <td>联系电话</td>
                        <td class="edit" colspan="2" tabindex="8">18978909016</td>
                    </tr>
                    <tr>
                        <td>邮箱</td>
                        <td class="edit" colspan="2" tabindex="9">27131884@qq.com</td>
                    </tr>
                    <tr>
                        <td>IP 地址(内网) web 访问</td>
                        <td class="edit" colspan="2" tabindex="10">http://172.18.194.2/lims</td>
                    </tr>
                    <tr>
                        <td>IP 地址(内网) 仪器连接</td>
                        <td class="edit" colspan="2" tabindex="11">172.18.194.2</td>
                    </tr>
                    <tr>
                        <td>IP 地址(外网) web 访问</td>
                        <td class="edit" colspan="2" tabindex="12">http://210.36.22.87/lims</td>
                    </tr>
                    <tr>
                        <td>IP 地址(外网) 前台访问</td>
                        <td class="edit" colspan="2" tabindex="13">http://gxpt.gxu.edu.cn/</td>
                    </tr>
                    <tr>
                        <td rowspan="2">软件保修期限</td>
                        <td>默认模块</td>
                        <td tabindex="15">2015-7-2签合同，2015-11-05正式验收，验收后维保一年</td>
                    </tr>
                    <tr>
                        <td>增加模块</td>
                        <td class="edit" tabindex="16">同上</td>
                    </tr>
                    <tr>
                        <td rowspan="4">硬件保修期限</td>
                        <td style="width: 15%;">电源控制器</td>
                        <td class="edit" tabindex="17">部署三套，2015-11-3部署</td>
                    </tr>
                    <tr>
                        <td>摄像头</td>
                        <td class="edit" tabindex="18">调试接入海康监控，不需要我们维保</td>
                    </tr>
                    <tr>
                        <td>门禁</td>
                        <td class="edit" tabindex="19">暂无</td>
                    </tr>
                    <tr>
                        <td>温度监控</td>
                        <td class="edit" tabindex="20">暂无</td>
                    </tr>
                    <tr>
                        <td>商务负责人</td>
                        <td class="edit" colspan="2" tabindex="21">马玥</td>
                    </tr>
                    <tr>
                        <td>工程师负责人</td>
                        <td class="edit" colspan="2" tabindex="22">陈晨</td>
                    </tr>
                    <tr>
                        <td>地址</td>
                        <td class="edit" colspan="2" tabindex="23">广西壮族自治区南宁市大学东路100号</td>
                    </tr>
                    <tr>
                        <td>乘车路线</td>
                        <td class="edit" colspan="2" tabindex="24">乘飞机至南宁吴圩机场，乘机场大巴1号线至火车站（维也纳酒店），下车往回走50米，在朝阳济南路口站，乘10/8路至广西大学站</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">
                            <button type="button" class="btn btn-primary">
                                <i class="fa fa-edit"></i> 提交修改
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-comment"> 备注信息</i>
            </div>
            <div class="panel panel-body">

                <div class="media">
                    <div class="media-left media-middle">
                        <img data-src="holder.js/64x64">
                    </div>

                    <div class="media-body">
                        <h4 class="media-heading">标题</h4>
                        内容
                    </div>
                </div>

                <div class="media">
                    <div class="media-left media-middle">
                        <img data-src="holder.js/64x64">
                    </div>

                    <div class="media-body">
                        <h4 class="media-heading">标题</h4>
                        内容
                    </div>
                </div>

                <hr />

                <div class="form-group">
                    <input type="text" placeholder="标题" class="form-control" />
                </div>

                <div class="form-group">
                    <textarea class="form-control" rows="3" placeholder="内容"></textarea>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-warning">
                        <i class="fa fa-plus"></i> 备注追加
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-user"> 详细信息</i>
            </div>
            <div class="panel panel-body">


                <div id="myTabs">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#server" aria-controls="server" role="tab" data-toggle="tab">
                                <i class="fa fa-linux"></i> 服务器信息
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#info" aria-controls="info" role="tab" data-toggle="tab">
                                <i class="fa fa-info"></i> 信息变动
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#trello" aria-controls="trello" role="tab" data-toggle="tab">
                                <i class="fa fa-wrench"></i> 部署情况
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">

                        <!-- server -->
                        <div role="tabpanel" class="tab-pane active" id="server">
                            <div class="panel panel-body">
                                <table class="table table-hover table-bordered table-striped">
                                    <tr>
                                        <td colspan="2" class="text-left">
                                            <button type="button" class="btn btn-warning">
                                                <i class="fa fa-plus-circle"></i> 追加服务器
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">&#160;</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%">服务器提供方 (公司/自备)</td>
                                        <td>hell</td>
                                    </tr>

                                    <tr>
                                        <td>服务器条形码</td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>服务器条形码</td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>服务器序列号</td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>服务器 CPU</td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>服务器内存</td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>服务器硬盘</td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>服务器操作系统</td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>数据库</td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>FQDN</td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>VPN</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right">
                                            <button type="button" class="btn btn-primary">
                                                <i class="fa fa-edit"></i> 提交修改
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- server end -->

                        <!-- info -->
                        <div role="tabpanel" class="tab-pane" id="info">
                            <ul class="timeline">
                                <li>
                                    <div class="timeline-badge info"><i class="fa fa-flag"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">信息修改</h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> 11 hours ago via Rui Ma</small></p>
                                        </div>
                                        <div class="timeline-body">
                                            <p> 修改用户信息 <mark>「广东大学」</mark>-&gt;<mark>「广西大学」</mark></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-inverted">
                                    <div class="timeline-badge warning"><i class="fa fa-flag"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title"> 信息修改</h4>
                                            <p><small class="text-muted"><i class="fa fa-check-o"></i> 12 hours age via Rui Ma</small></p>
                                        </div>
                                        <div class="timeline-body">
                                            <p>创建新客户</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- info end-->

                        <!-- trello -->
                        <div role="tabpanel" class="tab-pane" id="trello">
                            对接 Trello
                        </div>
                        <!-- trello end-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {


    $('li[role=presentation] a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });


    $('*').delegate('.edit', 'click focus', function(e) {
        $this = $(this);
        $this.attr('contenteditable', true);

        $this.on('blur', function() {
            $this.attr('contenteditable', false);
        });

        e.preventDefault();
        return false;
    });
});
</script>

@endsection