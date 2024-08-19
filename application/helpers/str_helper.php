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

if (!function_exists('toID')) {
    /**
     * Jadi format nomor telepon dengan kode negara Indonesia (62)
     * 
     * @param string $phone
     * 
     * @return string "08123456789" => "628123456789" or "   +628o<br>_.())21wwdw382dww90wdwada482    " => "6282138290482"
     */
    function toID($phone)
    {
        // Normalisasi inputan, hapus semua karakternya kecuali angka dari $phone
        $phone = normalize($phone);

        // Kalo prefix-nya 0 atau 62, hapus biar sama semua
        // Kalo prefix bukan 0 atau 62 gak perlu dicek
        if (startsWith($phone, '0')) {
            $phone = after($phone, '0');
        } elseif (startsWith($phone, '62')) {
            $phone = after($phone, '62');
        }

        // Semuanya nanti formatnya 8XXXXXXXXX, baru ditambah 62 di depan
        return '62' . $phone;
    }
}

if (!function_exists('wZeroLeading')) {
    /**
     * Jadi format nomor telepon dengan angka 0 di depan
     * 
     * @param string $phone
     * 
     * @return string "08123456789" => "08123456789" or "   +628o<br>_.())21wwdw382dww90wdwada482    " => "082138290482"
     */
    function wZeroLeading($phone)
    {
        // Normalisasi inputan, hapus semua karakternya kecuali angka dari $phone
        $phone = normalize($phone);

        // Kalo prefix-nya 0 atau 62, hapus biar sama semua
        // Kalo prefix bukan 0 atau 62 gak perlu dicek
        if (startsWith($phone, '0')) {
            $phone = after($phone, '0');
        } elseif (startsWith($phone, '62')) {
            $phone = after($phone, '62');
        }

        // Semuanya nanti formatnya 8XXXXXXXXX, baru ditambah 0 di depan
        return '0' . $phone;
    }
}

if (!function_exists('escape_query')) {
    /**
     * Kutip 1 jadi kutip 2
     * 
     * @param string $string
     * 
     * @return string
     */
    function escape_query($string)
    {
        return str_replace("'", "''", clean($string));
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

if (!function_exists('dateID')) {
    /**
     * @param string $tgl
     *  format yyyy-mm-dd
     *
     * @return string
     */
    function dateID($tgl)
    {
        $hari = gmdate($tgl, time() + 60 * 60 * 8);
        // memecah var hari jadi tahun, bulan dan tanggal
        list($tahun, $bulan, $tanggal) = explode('-', $hari);
        return $tanggal . ' ' . month($bulan) . ' ' . $tahun;
    }
}

if (!function_exists('dateTimeID')) {
    /**
     * @param string $tgl
     *  format yyyy-mm-dd hh:mm:ss
     *
     * @return string
     */
    function dateTimeID($tgl)
    {
        list($hari, $waktu) = explode(' ', $tgl);
        list($tahun, $bulan, $tanggal) = explode('-', $hari);

        return $tanggal . ' ' . month($bulan) . ' ' . $tahun . ' ' . date('H:i', strtotime($waktu));
    }
}

if (!function_exists('month')) {
    /**
     * @param int|string $bln
     *
     * @return string
     */
    function month($bln)
    {
        $arrBulan = arrMonth();

        // tambah 0 di depan sampai string berjumlah 2 digit
        // 2 -> 02 (string)
        $bln = str_pad($bln, 2, '0', STR_PAD_LEFT);

        // kalo key-nya gak ada di dalam array, return string kosong
        return isset($arrBulan[$bln]) ? $arrBulan[$bln] : '';
    }
}

if (!function_exists('arrMonth')) {
    /**
     * Array bulan bahasa indonesia
     * 
     * @param string $type
     * @return array
     */
    function arrMonth($type = '2d')
    {
        return $type === '2d' ?
        [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ] : [
            ['index' => '01', 'name' => 'Januari'],
            ['index' => '02', 'name' => 'Februari'],
            ['index' => '03', 'name' => 'Maret'],
            ['index' => '04', 'name' => 'April'],
            ['index' => '05', 'name' => 'Mei'],
            ['index' => '06', 'name' => 'Juni'],
            ['index' => '07', 'name' => 'Juli'],
            ['index' => '08', 'name' => 'Agustus'],
            ['index' => '09', 'name' => 'September'],
            ['index' => '10', 'name' => 'Oktober'],
            ['index' => '11', 'name' => 'November'],
            ['index' => '12', 'name' => 'Desember'],
        ];
    }
}

if (!function_exists('startsWith')) {
    /**
     * Determine if a given string starts with a given substring. Case sensitive.
     *
     * @param  string  $haystack
     * @param  string|string[]  $needles
     * @return bool
     */
    function startsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0) {
                return true;
            }
        }

        return false;
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

if (!function_exists('rupiah')) {
    /**
     * @param int|string $int
     * 
     * @return string Rp. 9.000.000
     */
    function rupiah($int)
    {
        return 'Rp. ' . thousand($int);
    }
}

if (!function_exists('thousand')) {
    /**
     * @param int|string $int
     * 
     * @return string 9.000.000
     */
    function thousand($int)
    {
        return number_format($int, 0, ',', '.');
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

if (!function_exists('dateTimeMicroSeconds')) {
    /**
     * @return string
     */
    function dateTimeMicroSeconds()
    {
        return date('Y-m-d H:i:s.', time()).gettimeofday()['usec'];
    }
}

if (!function_exists('isMenuActive')) {
    /**
     * Determine if the said endpoint is active
     * 
     * @param string $endpoint
     * @return string
     */
    function isMenuActive($endpoint) {
        return isActive($endpoint) ? 'active' : '';
    }
}

if (!function_exists('isActive')) {
    /**
     * Determine if the said endpoint is active
     * 
     * @param string $endpoint
     * @return bool
     */
    function isActive($endpoint) {
        $current_path = parse_url(current_url(), PHP_URL_PATH);
        $endpoint_path = parse_url($endpoint, PHP_URL_PATH);

        $res = strpos($current_path, $endpoint_path);
        return is_int($res) ? true : false;
    }
}
