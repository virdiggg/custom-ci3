<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Usage:
 * 
 * $this->load->helper('encrypt');
 * $str = 'coba doang buat encrypt';
 * $enc = encrypt($str); 656E6372797074
 * $dec = decrypt($enc); 64656372797074
 * 
 * echo $str.'<br>'.$enc.'<br>'.$dec.'<br>';
 */

if (!function_exists('hexa')) 
{
    /**
     * Decrypt hexa
     *
     * @param string
     */
    function hexa($str) {
        $r = "";
        $len = (strlen($str) - 1);
        for ($i = 0; $i < $len; $i += 2) {
            $r .= chr(hexdec($str[$i].$str[$i + 1]));
        }
        return $r;
    }
}

if (!function_exists('conf')) 
{
    /**
     * Ambil config CI 3 (636F6E66)
     *
     * @param string
     */
    function conf($str) {
        $ci =& get_instance();
        return $ci->config->item($str);
    }
}

if (!function_exists('sess')) 
{
    /**
     * Ambil session CI 3 (73657373)
     *
     * @param string
     */
    function sess($str) {
        $ci =& get_instance();
        return $ci->session->userdata($str);
    }
}

if (!function_exists('headers')) 
{
    /**
	 * Load HTTP Headers
	 * 
	 * @param bool $standard
	 * @param bool $extra
	 * 
     * @param void
     */
    function headers($standard = false, $extra = false) {
        header("X-Frame-Options: SAMEORIGIN", TRUE);
        header("X-Content-Type-Options: nosniff", TRUE);
        header("Referrer-Policy: no-referrer", TRUE);

		if ($standard) {
			header('Cross-Origin-Opener-Policy: same-origin', TRUE);
			header('Cross-Origin-Resource-Policy: same-origin', TRUE);
			header('Cross-Origin-Embedder-Policy: require-corp', TRUE);
			header('X-DNS-Prefetch-Control: off', TRUE);
			header('X-Download-Options: noopen', TRUE);
			header('X-Permitted-Cross-Domain-Policies: none', TRUE);
			header('Origin-Agent-Cluster: ?1', TRUE);
			header("Content-Security-Policy: default-src 'self' 'unsafe-inline'", TRUE);
			if (ENVIRONMENT === 'production') {
				header('Strict-Transport-Security: max-age=15552000; includeSubDomains', TRUE);
			}
		}

		if ($extra) {
			header("Permissions-Policy: fullscreen=(self), geolocation=(self), camera=(self)", TRUE);
			header('Clear-Site-Data: "cache"', TRUE);
		}
    }
}

if (!function_exists('encrypt')) 
{
    /**
     * The algorithm used for encryption.
     *
     * @param string
     */
    function secret_key()
    {
        return hexa(conf('encryption_key'));
    }

    /**
     * The algorithm used for encryption.
     *
     * @param string
     */
    function chiper()
    {
        return conf('encrypt_method');
    }

    /**
     * The supported cipher algorithms and their properties.
     *
     * @param array
     */
    function supportedCiphers()
    {
        return [
            'aes-128-cbc' => ['size' => 16, 'aead' => false],
            'aes-256-cbc' => ['size' => 32, 'aead' => false],
            'aes-128-gcm' => ['size' => 16, 'aead' => true],
            'aes-256-gcm' => ['size' => 32, 'aead' => true],
        ];
    }

    /**
     * Determine if the given key and cipher combination is valid.
     *
     * @param  string  $key
     * @param  string  $cipher
     * @return bool
     */
    function supported($key, $cipher)
    {
        $supportedCiphers = supportedCiphers();
        if (! isset($supportedCiphers[strtolower($cipher)])) {
            return false;
        }

        return mb_strlen($key, '8bit') === $supportedCiphers[strtolower($cipher)]['size'];
    }

    /**
     * Encrypt the given value.
     *
     * @param  mixed  $value
     * @param  bool  $serialize
     * @return string
     *
     * @throws \Exception
     */
    function encrypt($value, $serialize = true)
    {
        $cipher = chiper();
        $supportedCiphers = supportedCiphers();
        $key = secret_key();

        // if (! supported($key, $cipher)) {
        //     $ciphers = join(', ', array_keys($supportedCiphers));
        //     $size = $supportedCiphers[strtolower($cipher)]['size'];

        //     throw new \Exception("Unsupported cipher or incorrect key length. Supported ciphers are: {$ciphers}. Key must be $size character long.");
        // }

        $iv = random_bytes(openssl_cipher_iv_length(strtolower($cipher)));

        $tag = '';

        $ci =& get_instance();

        $value = $supportedCiphers[strtolower($cipher)]['aead']
            ? \openssl_encrypt(
                $serialize ? serialize($value) : $value,
                strtolower($cipher), $key, 0, $iv, $tag
            )
            : \openssl_encrypt(
                $serialize ? serialize($value) : $value,
                strtolower($cipher), $key, 0, $iv
            );

        if ($value === false) {
            throw new \Exception('Could not encrypt the data.');
        }

        $iv = base64_encode($iv);
        $tag = base64_encode($tag);

        $mac = $supportedCiphers[strtolower($cipher)]['aead']
            ? '' // For AEAD-algoritms, the tag / MAC is returned by openssl_encrypt...
            : hashed($iv, $value);

        $json = json_encode(compact('iv', 'value', 'mac', 'tag'), JSON_UNESCAPED_SLASHES);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Could not encrypt the data.');
        }

        return base64_encode($json);
    }

    /**
     * Create a MAC for the given value.
     *
     * @param  string  $iv
     * @param  mixed  $value
     * @return string
     */
    function hashed($iv, $value)
    {
        return hash_hmac('sha256', $iv.$value, secret_key());
    }

    /**
     * Decrypt the given value.
     *
     * @param  string  $payload
     * @param  bool  $unserialize
     * @return mixed
     *
     * @throws \Exception
     */
    function decrypt($payload, $unserialize = true)
    {
        $payload = getJsonPayload($payload);

        $iv = base64_decode($payload['iv']);

        ensureTagIsValid(
            $tag = empty($payload['tag']) ? null : base64_decode($payload['tag'])
        );

        // Here we will decrypt the value. If we are able to successfully decrypt it
        // we will then unserialize it and return it out to the caller. If we are
        // unable to decrypt this value we will throw out an exception message.
        $decrypted = \openssl_decrypt(
            $payload['value'], strtolower(chiper()), secret_key(), 0, $iv, $tag ?? ''
        );

        if ($decrypted === false) {
            throw new \Exception('Could not decrypt the data.');
        }

        return $unserialize ? unserialize($decrypted) : $decrypted;
    }

    /**
     * Ensure the given tag is a valid tag given the selected cipher.
     *
     * @param  string  $tag
     * @return void
     */
    function ensureTagIsValid($tag)
    {
        $supportedCiphers = supportedCiphers();
        if ($supportedCiphers[strtolower(chiper())]['aead'] && strlen($tag) !== 16) {
            throw new \Exception('Could not decrypt the data.');
        }

        if (! $supportedCiphers[strtolower(chiper())]['aead'] && is_string($tag)) {
            throw new \Exception('Unable to use tag because the cipher algorithm does not support AEAD.');
        }
    }

    /**
     * Get the JSON array from the given payload.
     *
     * @param  string  $payload
     * @return array
     *
     * @throws \Exception
     */
    function getJsonPayload($payload)
    {
        $payload = json_decode(base64_decode($payload), true);

        $supportedCiphers = supportedCiphers();

        // If the payload is not valid JSON or does not have the proper keys set we will
        // assume it is invalid and bail out of the routine since we will not be able
        // to decrypt the given value. We'll also check the MAC for this encryption.
        if (! validPayload($payload)) {
            // log_message('error', json_encode(['HTTP_REFERER' => $_SERVER['HTTP_REFERER'],'HTTP_ORIGIN' => $_SERVER['HTTP_ORIGIN']]));
            throw new \Exception('The payload is invalid.');
        }

        if (! $supportedCiphers[strtolower(chiper())]['aead'] && ! validMac($payload)) {
            throw new \Exception('The MAC is invalid.');
        }

        return $payload;
    }

    /**
     * Determine if the MAC for the given payload is valid.
     *
     * @param  array  $payload
     * @return bool
     */
    function validMac(array $payload)
    {
        return hash_equals(
            hashed($payload['iv'], $payload['value']), $payload['mac']
        );
    }

    /**
     * Verify that the encryption payload is valid.
     *
     * @param  mixed  $payload
     * @return bool
     */
    function validPayload($payload)
    {
        return is_array($payload) && isset($payload['iv'], $payload['value'], $payload['mac']) &&
            strlen(base64_decode($payload['iv'], true)) === openssl_cipher_iv_length(strtolower(chiper()));
    }
}