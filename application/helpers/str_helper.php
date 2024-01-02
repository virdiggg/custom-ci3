<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('randomHex')) {
    /**
     * Generate random Hex color.
     * 
     * @return string
     */
    function randomHex()
    {
        return '#' . strtoupper(str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT));
    }
}

if (!function_exists('back')) 
{
	/**
	 * @return http response
	 */
    function back()
    {
        $ci =& get_instance();
        $ci->load->library('user_agent');
        return redirect($ci->agent->referrer());
    }
}

if (!function_exists('convert')) 
{
	/**
     * Convert byte
     * 
     * @param int|float $size
     * 
	 * @return string
	 */
    function convert($size) {
        $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }
}

if (!function_exists('isJson')) {
    /**
     * Determine if a given string is valid JSON.
     *
     * @param  string  $value
     * @return bool
     */
    function isJson($value)
    {
        if (!is_string($value)) {
            return false;
        }

        try {
            json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}

if (!function_exists('pretty_print_json')) {
    /**
     * Pretty JSON
     * 
     * @param string $json_data
     * 
     * @return string
     */
    function pretty_print_json($json_data) {
        // Initialize variable for adding space
        $space = 0;
        $flag = false;
        // Using <pre> tag to format alignment and font
        $tmp = "<pre>";
        // loop for iterating the full json data
        for ($counter = 0; $counter < strlen($json_data); $counter++) {
            // Checking ending second and third brackets
            if ($json_data[$counter] == '}' || $json_data[$counter] == ']') {
                $space--;
                $tmp .= "\n";
                $tmp .= str_repeat(' ', ($space * 2));
            }

            // Checking for double quote(“) and comma (,)
            if ($json_data[$counter] == '"' && ($json_data[$counter - 1] == ',' || $json_data[$counter - 2] == ',')) {
                $tmp .= "\n";
                $tmp .= str_repeat(' ', ($space * 2));
            }

            if ($json_data[$counter] == '"' && !$flag) {
                if ($json_data[$counter - 1] == ':' || $json_data[$counter - 2] == ':')

                    // Add formatting for question and answer
                    $tmp .= '<span style="color: #9ed839;">';
                else
                    // Add formatting for answer options
                    $tmp .= '<span style="color: #ff4444;">';
            }

            $tmp .= $json_data[$counter];
            // Checking conditions for adding closing span tag  
            if ($json_data[$counter] == '"' && $flag)
                $tmp .= '</span>';
            if ($json_data[$counter] == '"')
                $flag = !$flag;
            // Checking starting second and third brackets
            if ($json_data[$counter] == '{' || $json_data[$counter] == '[') {
                $space++;
                $tmp .= "\n";
                $tmp .= str_repeat(' ', ($space * 2));
            }
        }

        $tmp .= "</pre>";
        return $tmp;
    }
}

if (!function_exists('normalize')) {
    /**
     * Hapus semua kecuali angka
     * 
     * @param string $phone
     * 
     * @return string
     */
    function normalize($phone)
    {
        return preg_replace('/[^0-9]++/', '', $phone);
    }
}

if (!function_exists('clean')) {
    /**
     * Trim whitespace, hapus tag php/html, hapus unicode NO-BREAK SPACE/nbsp (U+00a0),
     * convert special character jadi karakter biasa
     * 
     * @param string $string
     * 
     * @return string
     */
    function clean($string)
    {
        return htmlspecialchars(strip_tags(trim(preg_replace('/\xc2\xa0/', '', $string))));
    }
}

if (!function_exists('after')) {
    /**
     * Return the remainder of a string after the first occurrence of a given value.
     *
     * @param  string  $subject
     * @param  string  $search
     * @return string
     */
    function after($subject, $search)
    {
        return $search === '' ? $subject : array_reverse(explode($search, $subject, 2))[0];
    }
}

if (!function_exists('before')) {
    /**
     * Get the portion of a string before the first occurrence of a given value.
     *
     * @param  string  $subject
     * @param  string  $search
     * @return string
     */
    function before($subject, $search)
    {
        if ($search === '') {
            return $subject;
        }

        $result = strstr($subject, (string) $search, true);

        return $result === false ? $subject : $result;
    }
}

if (!function_exists('beforeLast')) {
    /**
     * Get the portion of a string before the last occurrence of a given value.
     *
     * @param  string  $subject
     * @param  string  $search
     * @return string
     */
    function beforeLast($subject, $search)
    {
        if ($search === '') {
            return $subject;
        }

        $pos = mb_strrpos($subject, $search);

        if ($pos === false) {
            return $subject;
        }

        return substr($subject, 0, $pos);
    }
}

if (!function_exists('parameter')) {
    /**
     * @param array $data
     * @param bool $urlencode
     *
     * @return string|null
     */
    function parameter($data, $urlencode = false)
    {
        if (empty($data)) return null;

        $res = [];
        foreach ($data as $key => $value) {
            $val = $urlencode ? urlencode($value) : $value;
            // masing-masing val query dimasukin ke array
            $res[] = $key . '=' . $val;
        }

        return join('&', $res);
    }
}

if (!function_exists('specialCharToWhiteSpace')) {
    /**
     * Sisain alphanumeric, sama whitespace aja.
     * 
     * @param string $str
     * 
     * @return string
     */
    function specialCharToWhiteSpace($str)
    {
        return preg_replace("/[^a-zA-Z0-9\s]/", ' ', $str);
    }
}