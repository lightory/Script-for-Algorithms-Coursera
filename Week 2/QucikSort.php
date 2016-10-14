<?php

function arrayFromFile($filename) {
	$filename = $filename;
	$file = fopen($filename, "r");

	$arr = [];
	while (true) {
		$number = (int) fgets($file);
		if ($number == 0) break;
		$arr[] = $number;
		if (feof($file)) break;
	}
	
	return $arr;
}

function choosePivotIndex($arr) {
	// Strategy 1
	// return 0;
	
	// Strategy 2
	// return sizeof($arr) - 1;
	
	// Strategy 3
	$a = 0;
	$b = sizeof($arr) - 1;
	$c = floor((sizeof($arr) - 1) / 2);
	return findMiddleIndex($arr, $a, $b, $c);
}

function findMiddleIndex($arr, $a, $b, $c) {
	if ($arr[$a] < $arr[$c]) {
		if ($arr[$b] < $arr[$a]) return $a;
		if ($arr[$b] > $arr[$c]) return $c;
		return $b;
	} else {
		if ($arr[$b] > $arr[$a]) return $a;
		if ($arr[$b] < $arr[$c]) return $c;
		return $b; 
	}
}

function exchangeArrayElements(&$arr, $i, $j) {
	// echo "exchangeArrayElements: " . sizeof($arr) . " {$i} {$j} \n";
	if ($i == $j) return;
	$temp = $arr[$i];
	$arr[$i] = $arr[$j];
	$arr[$j] = $temp;
}

function sortAroundPivot($arr, $pivotIndex) {	
	exchangeArrayElements($arr, 0, $pivotIndex);
	$pivotElement = $arr[0];
	
	$i = 1;
	for ($j = 1; $j < sizeof($arr); $j++) {
		if ($arr[$j] < $pivotElement) {
			exchangeArrayElements($arr, $i, $j);
			$i = $i + 1;
		}
	}
	exchangeArrayElements($arr, $i - 1, 0);
	
	$leftArr = array_slice($arr, 0, $i - 1);
	$rightArr = array_slice($arr, $i);
	return [$leftArr, $rightArr];
}

$count = 0;
function partitionSort($arr) {
	if (sizeof($arr) <= 1) {
		return $arr;
	}

	$GLOBALS['count'] += (sizeof($arr) - 1);
	
	$pivotIndex = choosePivotIndex($arr);
	$pivotElement = $arr[$pivotIndex];
	list($leftArr, $rightArr) = sortAroundPivot($arr, $pivotIndex);
	
	$leftArr = partitionSort($leftArr);
	$rightArr = partitionSort($rightArr);
	$arr = array_merge($leftArr, [$pivotElement], $rightArr);
	
	return $arr;
}

$arr = arrayFromFile("QuickSort.txt");
var_dump($arr);
$arr = partitionSort($arr);
var_dump($arr);
var_dump($count);