<?php

function conquer($arrA, $arrB) {
	$count = 0;
	$i = 0;
	$j = 0;
	$arr = [];
	while (($i + $j) < (sizeof($arrA) + sizeof($arrB))) {
		$a = PHP_INT_MAX;
		$b = PHP_INT_MAX;
		if ($i < sizeof($arrA)) {
			$a = $arrA[$i];
		}
		if ($j < sizeof($arrB)) {
			$b = $arrB[$j];
		}
		
		if ($a < $b) {
			$arr[] = $a;
			$i++;
		} else {
			$arr[] = $b;
			$j++;
			$count = $count + sizeof($arrA) - $i;
		}
	}
	return [$arr, $count];
}

function divide($arr) {
	$divideIndex = ceil(sizeof($arr) / 2);
	$arrA = array_slice($arr, 0, $divideIndex);
	$arrB = array_slice($arr, $divideIndex);
	return [$arrA, $arrB];
}

function deal($arr) {
	if (sizeof($arr) == 1) {
		return [$arr, 0];
	}
	
	list($arrA, $arrB) = divide($arr);
	list($dealedArrA, $arrACount) = deal($arrA);
	list($dealedArrB, $arrBCount) = deal($arrB);
	list($outputArr, $arrABCount) = conquer($dealedArrA, $dealedArrB);
	
//	var_dump($dealedArrA, $dealedArrB, $arrACount, $arrBCount, $arrABCount);
//	echo "\n";
	
	$count = $arrACount + $arrBCount + $arrABCount;
	return [$outputArr, $count];
}

// $input = [4, 80, 70, 23, 9, 60, 68, 27, 66, 78, 12, 40, 52, 53, 44, 8, 49, 28, 18, 46, 21, 39, 51, 7, 87, 99, 69, 62, 84, 6, 79, 67, 14, 98, 83, 0, 96, 5, 82, 10, 26, 48, 3, 2, 15, 92, 11, 55, 63, 97, 43, 45, 81, 42, 95, 20, 25, 74, 24, 72, 91, 35, 86, 19, 75, 58, 71, 47, 76, 59, 64, 93, 17, 50, 56, 94, 90, 89, 32, 37, 34, 65, 1, 73, 41, 36, 57, 77, 30, 22, 13, 29, 38, 16, 88, 61, 31, 85, 33, 54 ];

$filename = "IntegerArray.txt";
$file = fopen($filename, "r");

$inputArr = [];
while (true) {
	$number = (int) fgets($file);
	if (feof($file)) break;
	$inputArr[] = $number;
}

list($output, $count) = deal($inputArr);
var_dump($count);