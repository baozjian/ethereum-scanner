<?php
	$f=@fopen($argv[1],"r");
	if(!$f)
	{
		echo "failed to open $argv[1]\n";
		exit;
	}
	//$obj_cluster = new RedisCluster(NULL, ['10.19.56.77:6529', '10.19.56.70:6529', '10.19.56.76:6529', '10.19.56.68:6529', '10.19.56.69:6529']);
	$obj_cluster = new Redis();
	$obj_cluster->connect('127.0.0.1', 6379);
	$obj_cluster->select(1);
	$num=0;

	while(!feof($f))
	{
		$line=fgets($f);
		$line=substr($line,0,-1);
		$arr=explode("~",$line);
		//txn.hash}~${txn.blockHash}~${txn.blockNumber}~${block.timestamp}~${txn.value}~${txn.from}~${txn.to}
		if(count($arr)<7)continue;
		$hash=$arr[0];
		$bhash=$arr[1];
		$bnum=$arr[2];
		$ts=$arr[3];
		$value=$arr[4];
		$from=$arr[5];
		$to=$arr[6];
		
		$num++;
		print $num;		
		print_r($arr);	
        	//$obj_cluster = new RedisCluster(NULL, ['10.19.56.77:6529', '10.19.56.70:6529', '10.19.56.76:6529', '10.19.56.68:6529', '10.19.56.69:6529']);
        	//$address=$obj_cluster->get($uid);
		$obj_cluster->hMSet($hash,array('bhash'=>$bhash,'bnum'=>$bnum,'ts'=>$ts,'value'=>$value,'from'=>$from,'to'=>$to));
		$obj_cluster->zAdd($from,intval($ts),$hash);
		$obj_cluster->zAdd($to,intval($ts),$hash);
	}
	fclose($f);
?>
