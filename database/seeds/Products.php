<?php

use Illuminate\Database\Seeder;
use App\Product;

class Products extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            'LIMS-CF' => 'LIMS-CF 是一款专门面向科研实验室公共仪器的智能化管理系统。本系统将公共仪器平台的各项必要工作流程整合在一起，显著提高仪器设备的管理和使用效率。',
            'LIMS' => 'LIMS 以实验室为中心，结合应用软件与互联网技术，根据科研人员的工作需要，将多个影响实验室运作的必要因素有机地结合起来，从而大幅度提高实验室管理效率和自动化水平，为您的实验室实现简易便捷的无纸化管理环境。',
            'Billing' => 'Billing 是基理科技设计的独立支付结算平台，能为拥有多个需要进行充值支付系统的用户提供更灵活的机构内充值分配结算的解决方案。',
            'Mall' => 'Mall 是基理科技自主研发的在线科研采购管理系统，系统全面整合产品查找、选购、付款、收货、报销结算等各个环节，通过线上平台为科研工作者提供丰富的试剂、耗材等实验室用品信息，用户随时能够以透明实惠的价格买到最合适的产品，有效节省选购时间，缩短供货周期。',
            'Tender' => 'Tender 是基理科技结合高校采购流程，通过优化再造所研发的一款电子采购平台。通过信息发布，商家报价，网上定标及结果公布等流程实现全透明监管，有效防止物品采购过程中的暗箱操作。',
        ];

        foreach($products as $name => $description) {

            $product = new Product();

            $product->name = $name;
            $product->description = $description;
            $product->save();
        }
    }
}
