<?php

$filename = '../raw/9th_president_vote.csv';
$fp = fopen($filename,'r');


$data = array();
$data['候選人'][] = array('總統'=>'陳履安','副總統'=>'王淸峰');
$data['候選人'][] = array('總統'=>'李登輝','副總統'=>'連戰');
$data['候選人'][] = array('總統'=>'彭明敏','副總統'=>'謝長廷');
$data['候選人'][] = array('總統'=>'林洋港','副總統'=>'郝伯村');

while(!feof($fp))
{
	$line = fgets($fp);
	//printf("%s",$line);
	$cols = explode(",",$line);
	$size = count($cols);
	

		//echo $cols[$i]."\n";

	$data['投票狀況'][$cols[0]][$cols[1]][$cols[2]][] = array(
		'票所'=>$cols[3],
		'得票數'=>array($cols[4],$cols[6],$cols[8],$cols[10]),
		'得票率'=>array($cols[5],$cols[7],$cols[9],$cols[11]),
		'有效票'=>$cols[12],
		'無效票'=>$cols[13],
		'投票'=>$cols[14],
		'已領未投投票'=>$cols[15],
		'選舉人數'=>$cols[16],
		'投票率'=>$cols[17]);
}

echo count($data['投票結果']);

$json = json_encode($data);

fclose($fp);

$fp = fopen('../9_president.json','w+');
fprintf($fp,"%s",$json);
fclose($fp);





?>