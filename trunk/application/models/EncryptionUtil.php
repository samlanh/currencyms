<?php

class Application_Model_EncryptionUtil
{
	
	private $_keygen_str = "sovann-currency-exchange-Webbase";
	
	private  function getKey(){
		# the key should be random binary, use scrypt, bcrypt or PBKDF2 to
		# convert a string into a key
		# key is specified using hexadecimal
		# show key size use either 16, 24 or 32 byte keys for AES-128, 192
		# and 256 respectively		
		$key = array("key" => $this->_keygen_str, "key_size"=>strlen($this->_keygen_str));
		
		# create a random IV to use with CBC encoding
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$key["iv_size"] = $iv_size;
		$key["iv"] = $iv;
		
		return $key;
	}

	public function encrypt($sourceStr) {		
		# --- ENCRYPTION ---
		# Get Key for encrypt
		$key = $this->getKey();
	    
	    # creates a cipher text compatible with AES (Rijndael block size = 128)
	    # to keep the text confidential 
	    # only suitable for encoded input that never ends with value 00h
	    # (because of default zero padding)
	    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key["key"],
	                                 $sourceStr, MCRYPT_MODE_CBC, $key["iv"]);
	
	    # prepend the IV for it to be available for decryption
	    $ciphertext = $key["iv"] . $ciphertext;
	    
	    # encode the resulting cipher text so it can be represented by a string
	    $ciphertext_base64 = base64_encode($ciphertext);
	
	    return $ciphertext_base64;
	}
	
	public function decrypt($sourceStr) {
		# --- DECRYPTION ---
		# Get Key for decrypt
		$key = $this->getKey();
	
	    $ciphertext_dec = base64_decode($sourceStr);
	    
	    # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
	    $iv_dec = substr($ciphertext_dec, 0, $key["iv_size"]);
	    
	    # retrieves the cipher text (everything except the $iv_size in the front)
	    $ciphertext_dec = substr($ciphertext_dec, $key["iv_size"]);
	
	    # may remove 00h valued characters from end of plain text
	    $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key["key"],
	                                    $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
	    return $plaintext_dec;
	}
}