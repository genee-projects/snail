@extends('layout')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"></h1>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-plus"> 添加新客户</i>
            </div>
            <div class="panel panel-body">
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <td style="width: 20%;">客户名称</td>
                        <td class="edit" colspan="2" tabindex="1">&#160;</td>
                    </tr>
                    <tr>
                        <td>项目名称</td>
                        <td class="edit" colspan="2" tabindex="2">&#160;</td>
                    </tr>
                    <tr>
                        <td>产品类型</td>
                        <td class="edit" colspan="2" tabindex="3">&#160;</td>
                    </tr>
                    <tr>
                        <td>版本</td>
                        <td class="edit" colspan="2" tabindex="4">&#160;</td>
                    </tr>
                    <tr>
                        <td>客户类型</td>
                        <td class="edit" colspan="2" tabindex="5">&#160;</td>
                    </tr>
                    <tr>
                        <td>所在区域</td>
                        <td class="edit" colspan="2" tabindex="6">&#160;</td>
                    </tr>
                    <tr>
                        <td>联系人</td>
                        <td class="edit" colspan="2" tabindex="7">&#160;</td>
                    </tr>
                    <tr>
                        <td>联系电话</td>
                        <td class="edit" colspan="2" tabindex="8">&#160;</td>
                    </tr>
                    <tr>
                        <td>邮箱</td>
                        <td class="edit" colspan="2" tabindex="9">&#160;</td>
                    </tr>
                    <tr>
                        <td>IP 地址(内网) web 访问</td>
                        <td class="edit" colspan="2" tabindex="10">&#160;</td>
                    </tr>
                    <tr>
                        <td>IP 地址(内网) 仪器连接</td>
                        <td class="edit" colspan="2" tabindex="11">&#160;</td>
                    </tr>
                    <tr>
                        <td>IP 地址(外网) web 访问</td>
                        <td class="edit" colspan="2" tabindex="12">&#160;</td>
                    </tr>
                    <tr>
                        <td>IP 地址(外网) 前台访问</td>
                        <td class="edit" colspan="2" tabindex="13">&#160;</td>
                    </tr>
                    <tr>
                        <td rowspan="2">软件保修期限</td>
                        <td>默认模块</td>
                        <td tabindex="15">&#160;</td>
                    </tr>
                    <tr>
                        <td>增加模块</td>
                        <td class="edit" tabindex="16">&#160;</td>
                    </tr>
                    <tr>
                        <td rowspan="4">硬件保修期限</td>
                        <td style="width: 15%;">电源控制器</td>
                        <td class="edit" tabindex="17">&#160;</td>
                    </tr>
                    <tr>
                        <td>摄像头</td>
                        <td class="edit" tabindex="18">&#160;</td>
                    </tr>
                    <tr>
                        <td>门禁</td>
                        <td class="edit" tabindex="19">&#160;</td>
                    </tr>
                    <tr>
                        <td>温度监控</td>
                        <td class="edit" tabindex="20">&#160;</td>
                    </tr>
                    <tr>
                        <td>商务负责人</td>
                        <td class="edit" colspan="2" tabindex="21"></td>
                    </tr>
                    <tr>
                        <td>工程师负责人</td>
                        <td class="edit" colspan="2" tabindex="22"></td>
                    </tr>
                    <tr>
                        <td>地址</td>
                        <td class="edit" colspan="2" tabindex="23"></td>
                    </tr>
                    <tr>
                        <td>乘车路线</td>
                        <td class="edit" colspan="2" tabindex="24"></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">
                            <button type="button" class="btn btn-primary">
                                <i class="fa fa-plus"></i> 确认添加
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('table').delegate('td.edit', 'click focus', function(e) {
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