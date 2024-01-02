<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('sumArrValues')) {
	/**
	 * Jumlahkan nilai dalam array per row
	 * 
	 * @param array<array-key, T> $array
	 *
	 * @return array
	 */
	function sumArrValues(...$array)
	{
		$result = array_map(function(...$arr) {
			return array_sum($arr);
		}, ...$array);

		return $result;
	}
}

if (!function_exists('parseChildren')) {
	/**
	 * Parse parent-children relationship
	 * 
	 * @param array      $array
	 * @param string     $head_key      Primary key, id kepala untuk kepalanya. Kalo paling atas harusnya value $parent_id_val = null.
	 * @param string     $parent_id_val Foreign Key, id kepala untuk bawahannya. Kalo paling atas harusnya value ini null.
	 * @param string     $children_val  Nama value children-nya
	 * @param string|int $parentId
	 *
	 * @return array
	 */
	function parseChildren($array, $head_key = 'id', $parent_id_val = 'parent_id', $children_val = 'childrens', $parentId = 0)
	{
		$result = [];

		if (count($array) === 0) return $result;

		foreach ($array as $key => $value) {
			if ($value[$parent_id_val] == $parentId) {
				$children = parseChildren($array, $head_key, $parent_id_val, $children_val, $value[$head_key]);

				$value[$children_val] = $children ? $children : [];

				$result[] = $value;
			}
		}

		return $result;
	}
}

if (!function_exists('parseChildrenAlt')) {
	/**
	 * Parse parent-children relationship
	 * 
	 * @param array  $array
	 * @param string $head_key      Primary key, id kepala untuk kepalanya. Kalo paling atas harusnya value $parent_id_val = null.
	 * @param string $parent_id_val Foreign Key, id kepalanya untuk bawahannya. Kalo paling atas harusnya value ini null.
	 * @param string $children_val  Nama value children-nya
	 *
	 * @return array
	 */
	function parseChildrenAlt($array, $head_key = 'id', $parent_id_val = 'parent_id', $children_val = 'childrens')
	{
		$result = [];
		if (count($array) === 0) return $result;

		$array = array_column($array, null, 'id');

		$tree = [];
		foreach($array as &$value) {
			if ($parent = isset($value[$parent_id_val]) ? $value[$parent_id_val] : NULL) {
				$array[$parent][$children_val][] = &$value;
			} else {
				$tree[] = &$value;
			}
		}

		unset($value);
		$array = $tree;
		unset($tree);

		$result = [];
		for($j = 0; $j < count($array); $j++) {
			if (isset($array[$j][$children_val]) && !isset($array[$j][$head_key])) {
				$result = array_merge($result, $array[$j][$children_val]);
			} else {
				$result[] = $array[$j];
			}
		}

		array_multisort(array_column($result, $parent_id_val), array_column($result, $head_key), SORT_ASC, $result);
		return $result;
	}
}

if (!function_exists('arrSort')) {
	/**
	 * @param array $arr
	 * @param string $column
	 * @param $direction
	 *
	 * @return array
	 */
	function arrSort(&$arr, $column = '', $direction = SORT_ASC)
	{
		$arr = (array) $arr;
		if (!arrIsMultidimensional($arr)) {
			if ($direction === SORT_ASC) {
				sort($arr, SORT_STRING);
			} else {
				rsort($arr, SORT_STRING);
			}

			return $arr;
		}

		array_multisort(array_column($arr, $column), $direction, $arr);
		return $arr;
	}
}

if (!function_exists('arrIsMultidimensional')) {
	/**
	 * @param array $array
	 *
	 * @return bool
	 */
	function arrIsMultidimensional(&$array)
	{
		rsort($array);
		return isset($array[0]) && is_array($array[0]);
		// $keys = array_keys($array);
		// return array_keys($keys) !== $keys;
	}
}

if (!function_exists('flatten')) {
	/**
	 * @param array $arr
	 *
	 * @return array
	 */
	function flatten($arr)
	{
		$return = [];
		array_walk_recursive($arr, function($a) use (&$return) {
			$return[] = $a;
		});
		return array_values(array_filter(array_unique($return), 'strlen'));
	}
}

if (!function_exists('arr_unique_multidimensional')) {
	/**
	 * @param array $arr
	 *
	 * @return array
	 */
	function arr_unique_multidimensional($input)
	{
		$serialized = array_map('serialize', $input);
		$unique = array_unique($serialized);
		return array_values(array_intersect_key($input, $unique));
	}
}

if (!function_exists('keyBy')) {
	/**
	 * @param array        $array
	 * @param string|array $arrayKeys
	 * @param bool         $isArray
	 * @param string       $separator
	 *
	 * @return array
	 */
	function keyBy($array, $arrayKeys, $isArray = false, $separator = '|')
	{
		$tmp = [];
		if (count((array) $array) === 0) {
			return $tmp;
		}

		// Jadiin semuanya array
		$array = json_decode(json_encode((array) $array), TRUE);
		foreach ($array as $ar) {
			$key = NULL;

			// Ambil key-nya, masukin ke array
			$keyTemp = [];
			foreach ((array) $arrayKeys as $k) {
				$keyTemp[] = $ar[$k];
			}

			// Array key-nya digabung jadi string
			$key = join($separator, $keyTemp);
			if ($isArray) {
				$tmp[$key][] = $ar;
			} else {
				$tmp[$key] = $ar;
			}
		}

        // if ($array) {
        //     foreach ($array as $ar) {
        //         $key = NULL;
        //         $r = (array)$ar;
        //         if (is_array($arrayKeys)) {
        //             for ($i=0; $i < count($arrayKeys); $i++) { 
        //                 $k = $arrayKeys[$i];
        //                 $garis = '|';
        //                 $count = count($arrayKeys) - 1;
        //                 if ($i >= $count) {
        //                     $garis = NULL;
        //                 }
        //                 $key .= $r[$k].$garis;
        //             }
        //         } else {
        //             $key .= $r[$arrayKeys];
        //         }
        //         if ($isArray) {
        //             $tmp[$key][] = $ar;
        //         } else {
        //             $tmp[$key] = $ar;
        //         }
        //     }
        // }
        return $tmp;
	}
}