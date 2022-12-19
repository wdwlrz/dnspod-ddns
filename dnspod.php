<?php
require_once 'vendor/autoload.php';

use TencentCloud\Common\Credential;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Dnspod\V20210323\DnspodClient;
use TencentCloud\Dnspod\V20210323\Models\DescribeRecordListRequest;
use TencentCloud\Dnspod\V20210323\Models\ModifyDynamicDNSRequest;

class dnspod
{

    public $secretId='AK*********ab';
    public $secretKey='lT*********cd';

    public function updateDns($params){
        try {
            // 实例化一个认证对象，入参需要传入腾讯云账户secretId，secretKey,此处还需注意密钥对的保密
            // 密钥可前往https://console.cloud.tencent.com/cam/capi网站进行获取
            $cred = new Credential($this->secretId,$this->secretKey);
            // 实例化一个http选项，可选的，没有特殊需求可以跳过
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint("dnspod.tencentcloudapi.com");

            // 实例化一个client选项，可选的，没有特殊需求可以跳过
            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);
            // 实例化要请求产品的client对象,clientProfile是可选的
            $client = new DnspodClient($cred, "", $clientProfile);

            // 实例化一个请求对象,每个接口都会对应一个request对象
            $req = new ModifyDynamicDNSRequest();

            $params = array(
                "Domain" => $params['domain'],
                "SubDomain" => $params['subDomain'],
                "RecordId" => $params['recordId'],
                "RecordLine" => "默认",
                "Value" => $params['ip']
            );
            $req->fromJsonString(json_encode($params));

            // 返回的resp是一个ModifyDynamicDNSResponse的实例，与请求对象对应
            $resp = $client->ModifyDynamicDNS($req);

            // 输出json格式的字符串回包
            // print_r($resp->toJsonString());
            // var_dump($resp);
            return $resp;
        }catch(TencentCloudSDKException $e) {
            echo $e;
        }
    }





    public function getInfo($params){
        try {
            // 实例化一个认证对象，入参需要传入腾讯云账户secretId，secretKey,此处还需注意密钥对的保密
            // 密钥可前往https://console.cloud.tencent.com/cam/capi网站进行获取
            $cred = new Credential($this->secretId,$this->secretKey);
            // 实例化一个http选项，可选的，没有特殊需求可以跳过
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint("dnspod.tencentcloudapi.com");

            // 实例化一个client选项，可选的，没有特殊需求可以跳过
            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);
            // 实例化要请求产品的client对象,clientProfile是可选的
            $client = new DnspodClient($cred, "", $clientProfile);

            // 实例化一个请求对象,每个接口都会对应一个request对象
            $req = new DescribeRecordListRequest();

            $params = array(
                "Domain" => $params['domain'],
                "Subdomain" => $params['subDomain'],
                "RecordType" => $params['recordType']
            );
            $req->fromJsonString(json_encode($params));

            // 返回的resp是一个DescribeRecordListResponse的实例，与请求对象对应
            $resp = $client->DescribeRecordList($req);

            // 输出json格式的字符串回包
            // print_r($resp->toJsonString());
            return $resp->RecordList;
        }catch(TencentCloudSDKException $e) {
            echo $e;
        }
    }
}



function get_onlineip() {
    try{
        $ch = curl_init('http://only-72244-222-188-46-25.nstool.netease.com/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $a = curl_exec($ch);
        preg_match('/\d+\.\d+\.\d+\.\d+/', $a, $ip);
        return $ip[0];
    }catch (\Exception $e){
        return '';
    }
}