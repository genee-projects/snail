# CRM

## 项目说明

Genee 的 CRM

# 部署文档

* 本地安装 make 命令: `apt-get install -y build-essential`
* 进行容器构建: `sudo make build`
* 进行依赖安装: `sudo make init`
* 部署容器: `sudo make up`
* 进行宿主机 **dnsmasq** 安装: `sudo apt-get install -y dnsmasq`
* 宿主机 **dnsmasq** 增加 **gapper.in** 配置: `echo 'address=/gapper.in/123.59.70.173' > /etc/dnsmasq.d/common`


注意:

* 宿主机进行 **gapper.in** 地址增加, 需要使用 `root` 用户执行, 如果有其他 **DNS** 服务, 请参照该 **DNS** 服务配置文档增加 **gapper.in** 地址

* 如有需要, 进行 API 文档生成: `sudo make docs`


# 权限设计

## 人员类型分类

* 销售
* 售后
* 产品（包含技术）

## 操作

* 客户管理
	* 客户信息管理
* 产品管理
	* 产品信息管理
	* 产品类别管理
	* 产品模块管理
	* 产品参数管理
	* 产品硬件管理
* 项目管理
	* 项目签约
	* 项目信息管理
	* 项目模块管理
	* 项目参数管理
	* 项目硬件管理
	* 项目服务器管理
* 服务器管理
   * 服务器信息管理

## 权限规划

<table>
	<tr>
		<td>权限/角色</td>
		<td>销售</td>
		<td>售后</td>
		<td>产品(包含技术)</td>
	</tr>
	<tr>
		<td colspan="4"><strong>客户管理</strong></td>
	</tr>
	<tr>
		<td>客户信息管理</td>
		<td>√</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="4"><strong>产品管理</strong></td>
	</tr>
	<tr>
		<td>产品信息管理</td>
		<td></td>
		<td></td>
		<td>√</td>
	</tr>
	<tr>
		<td>产品类别管理</td>
		<td></td>
		<td></td>
		<td>√</td>
	</tr>
	<tr>
		<td>产品模块管理</td>
		<td></td>
		<td></td>
		<td>√</td>
	</tr>
	<tr>
		<td>产品参数管理</td>
		<td></td>
		<td></td>
		<td>√</td>
	</tr>
	<tr>
		<td colspan="4"><strong>项目管理</strong></td>
	</tr>
	<tr>
		<td>项目签约</td>
		<td>√</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td>项目信息管理</td>
		<td>√</td>
		<td>√</td>
		<td></td>
	</tr>
	<tr>
		<td>项目模块管理</td>
		<td>√</td>
		<td>√</td>
		<td></td>
	</tr>
	<tr>
		<td>项目参数管理</td>
		<td>√</td>
		<td>√</td>
		<td></td>
	</tr>
	<tr>
		<td>项目硬件管理</td>
		<td>√</td>
		<td>√</td>
		<td></td>
	</tr>
	<tr>
		<td>项目服务器管理</td>
		<td>√</td>
		<td>√</td>
		<td></td>
	</tr>
	<tr>
		<td>项目文件管理</td>
		<td></td>
		<td>√</td>
		<td></td>
	</tr>
	<tr>
		<td colspan="4"><strong>服务器管理</strong></td>
	</tr>
	<tr>
		<td>服务器信息管理</td>
		<td></td>
		<td>√</td>
		<td>√</td>
	</tr>
</table>

针对于 **硬件**、**用户**、**角色**, 均由超级管理员维护
