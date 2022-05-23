<?php

class Encryption {
    
	protected $skey = 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO';

    public  function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
	
	public function decode($data) {
		return base64_decode($data);
	}
	
	public function encode($data) {
		return base64_encode($data);
	}

    /*public function decode($data) {
		$encryption_key = base64_decode($this->skey);
		list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 
		2),2,null);
		return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, 
		$iv);
  	}
	
	public function encode($data) {
		$encryption_key = base64_decode($this->skey);
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
		$encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, 
		$iv);
		return base64_encode($encrypted . '::' . $iv);
	}*/
}


?>