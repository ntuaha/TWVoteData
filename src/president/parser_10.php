<?php

$filename = '../../raw/10th_president_vote.csv';
$fp = fopen($filename,'r');


$data = array();
$data['候選人'][] = array('總統'=>'宋楚瑜','副總統'=>'張昭雄');
$data['候選人'][] = array('總統'=>'連戰','副總統'=>'蕭萬長');
$data['候選人'][] = array('總統'=>'李敖','副總統'=>'馮滬祥');
$data['候選人'][] = array('總統'=>'許信良','副總統'=>'朱惠良');
$data['候選人'][] = array('總統'=>'陳水扁','副總統'=>'呂秀蓮');




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
		'得票數'=>array(intval($cols[10]),intval($cols[12]),intval($cols[14]),intval($cols[16]),intval($cols[18])),
		'得票率'=>array(floatval($cols[11]),floatval($cols[13]),floatval($cols[15]),floatval($cols[17]),floatval($cols[19])),
		'有效票'=>intval($cols[4]),
		'無效票'=>intval($cols[5]),
		'投票'=>intval($cols[6]),
		'已領未投投票'=>intval($cols[7]),
		'選舉人數'=>intval($cols[8]),
		'投票率'=>floatval($cols[9]));
}

$json = json_encode($data);

fclose($fp);

$fp = fopen('../../10_president.json','w+');
fprintf($fp,"%s",$json);
fclose($fp);





?>