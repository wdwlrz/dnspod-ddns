<?php
require_once 'dnspod.php';
$dnspod=new dnspod(); // 在dnspod.php中修改一下密钥
$domain='abc.com';
$subDomain='www2'; // www2.abc.com

try{
	// 获取域名当前信息
	$info=$dnspod->getInfo([
		'domain'=>$domain,
		'subDomain'=>$subDomain,
		'recordType'=>'A',
	]);

	$RecordId=$info[0]->RecordId;
	$lastIp=$info[0]->Value;

	// 检查本地域名是否变动
	while(true){
		try{
			$ip=get_onlineip();
			if ($ip!=''){
				if ($ip!=$lastIp){
					echo '['.date('Y-m-d H:i:s')."] {$subDomain}.{$domain} , {$lastIp} => {$ip} ... ";
					$ret=$dnspod->updateDns([
						'domain'=>$domain,
						'subDomain'=>$subDomain,
						'recordId'=>$RecordId,
						'ip'=>$ip
					]);
					if ($ret->RecordId>0){
						echo 'ok'."\n";
						$lastIp=$ip;
					}else{
						echo 'error'."\n";
					}
				}
			}
			sleep(5*60*1000);// 5分钟检查一次
		}catch(\Exception $e){
			echo $e->getMessage()."\n";
		}
	}
}catch(\Exception $e){
	echo $e->getMessage()."\n";
}