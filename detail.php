<?php
	//$address=$_GET["address"];
	ini_set('memory_limit','500M');
	date_default_timezone_set('PRC');
	//print strtotime("2018-1-1");
	//print_r($_GET);

        if(array_key_exists('address',$_GET))
        {
                $address=$_GET["address"];
                //print_r($_GET);
                //print $uid;
        }
        else
        {
                $address=$argv[1];
        }

	if(array_key_exists('stime',$_GET))
        {
                $stime=$_GET["stime"];
		//print $stime;
		//$stime=strtotime($stime);
                //print_r($_GET);
                //print $stime;
        }
        else
        {
                $stime=$argv[2];
        }
	
	if(array_key_exists('etime',$_GET))
        {
                $etime=$_GET["etime"];
		//print $etime;
		//$etime=strtotime($etime);
                //print_r($_GET);
                //print $etime;
        }
        else
        {
                $etime=$argv[3];
        }

	if(array_key_exists('offset',$_GET))
        {
                $offset=$_GET["offset"];
        }
        else
        {
                $offset=$argv[4];
        }

 	if(array_key_exists('count',$_GET))
        {
                $count=$_GET["count"];
        }
        else
        {
                $count=$argv[5];
        }

	$stime=strtotime($stime);
	$etime=strtotime($etime);

	if(!$stime)$stime="-inf";
	if(!$etime)$etime="+inf";

	if($offset=="")$offset=0;
	if($count=="")$count=-1;
	//echo "stime:$stime etime:$etime\n";
	//echo "offset:$offset count:$count\n";

        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->select(1);

	//$ret=$redis->zRangeByScore($address, $stime, $etime, array('withscores' => TRUE));
	$ret=$redis->zRangeByScore($address, $stime, $etime, array('withscores' => TRUE, 'limit' => array($offset, $count)));
	//$ret=$redis->zRange($address, 0, -1, true);
	foreach($ret as $k=>&$v)
	{
		$v = $redis->hGetAll($k);
		$ts = $v["ts"];
		$v["ts"]= @date("Y-m-d H:i:s",$ts);
	}
	echo json_encode($ret)."\n";
	//print_r($ret);
/*
	$it = NULL;
	$redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);
	while($arr_matches = $redis->zScan($address, $it, '*pattern*')) {
    		foreach($arr_matches as $str_mem => $f_score) {
        	echo "Key: $str_mem, Score: $f_score\n";
    		}
	}
*/

?>
