<?php

$filename = '../../raw/12th_president_vote.csv';
$fp = fopen($filename,'r');


$data = array();
$data['候選人'][] = array('總統'=>'陳水扁','副總統'=>'呂秀蓮');
$data['候選人'][] = array('總統'=>'連戰','副總統'=>'宋楚瑜');




//Jump the first line
fgets($fp);




while(!feof($fp))
{
	$line = fgets($fp);
	$cols = explode(",",$line);
	$size = count($cols);
	

	//echo $line."\n";

	$data['投票狀況'][$cols[0]][$cols[1]][$cols[2]][] = array(
		'票所'=>$cols[3],
		'得票數'=>array(intval($cols[4]),intval($cols[6])),
		'得票率'=>array(floatval($cols[5]),floatval($cols[7])),
		'有效票'=>intval($cols[8]),
		'無效票'=>intval($cols[9]),
		'投票'=>intval($cols[10]),
		'已領未投投票'=>intval($cols[11]),
		'選舉人數'=>intval($cols[12]),
		'投票率'=>floatval($cols[13]));
}

$json = json_encode($data);

fclose($fp);

$fp = fopen('../../12_president.json','w+');
fprintf($fp,"%s",$json);
fclose($fp);





?>