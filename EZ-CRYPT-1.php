<?php
//#######################
//# EZ-CRYPT 1.0
//#######################

/* -----------------------------------------------  
@Author: Developped by Chr1s@EZScripts.net  
@Site: http://www.EZScripts.net/  
-----------------------------------------------  

How's the my encryption algorithm work:  

First it will generate an encryption key with the string you supply:  

Key 1 will be equal to the numerical value  
of each character in your crypt key.  

Key 2 will be equal to the length of your  
crypt key.  

For each character in the string you wish to encrypt, it will do the following mathematical calculations, where V is the final value of the encoded character and C is the value of the character currently encrypting:  

V = C * Key1  
V = V + Key2  

It will then separate each character in the original string with a character between 65 and 90 (cap. letters).  

To decrypt the string, it will do the opposite calculations, where V is the final value of the decrypted character and C is the value of the encrypted character:  

V = V / Key1  
V = C – Key2 */  

// ---------------------- ENCRYPTION START ----------------------
//Name: Encrypt()
//Args: $txt-> String to encrypt.
//Args: $CRYPT_KEY -> String used to generate a encryption key.
function encrypt($txt,$CRYPT_KEY){
    if (!$txt && $txt != "0"){
    return false;
    exit;
    }
    if (!$CRYPT_KEY){
    return false;
    exit;
    }
    $kv = keyvalue($CRYPT_KEY);
    $estr = "";
    $enc = "";
    for ($i=0; $i<strlen($txt); $i++) {
    $e = ord(substr($txt, $i, 1));
    $e = $e + $kv[1];
    $e = $e * $kv[2];
    (double)microtime()*1000000;
    $rstr = chr(rand(65, 90));
    $estr .= "$rstr$e";
    }
    return $estr;
}
// ---------------------- ENCRYPTION END ----------------------
// ---------------------- DECRYPTION START ----------------------
//Name: Decrypt()
//Args: $txt-> String to decrypt.
//Args: $CRYPT_KEY -> String used to encrypt the string.
function decrypt($txt, $CRYPT_KEY){
    if (!$txt && $txt != "0"){
    return false;
    exit;
    }
    if (!$CRYPT_KEY){
    return false;
    exit;
    }
    $kv = keyvalue($CRYPT_KEY);
    $estr = "";
    $tmp = "";
    for ($i=0; $i<strlen($txt); $i++) {
        if ( ord(substr($txt, $i, 1)) > 64 && ord(substr($txt, $i, 1)) < 91 ) {
            if ($tmp != "") {
            $tmp = $tmp / $kv[2];
            $tmp = $tmp - $kv[1];
            $estr .= chr($tmp);
            $tmp = "";
            }
        } else{
        $tmp .= substr($txt, $i, 1);
        }
    }
    $tmp = $tmp / $kv[2];
    $tmp = $tmp - $kv[1];
    $estr .= chr($tmp);
    return $estr;
}
// ---------------------- DECRYPTION START ----------------------
// ---------------------- KEYVALUE START ----------------------
//Name: keyvalue()  
//Args: $CRYPT_KEY -> String used to generate a encryption key.
//Returns: $keyvalue -> Array containing 2 encryption keys.
function keyvalue($CRYPT_KEY){
    $keyvalue = "";
    $keyvalue[1] = "0";
    $keyvalue[2] = "0";
    for ($i=0; $i<strlen($CRYPT_KEY); $i++) {
    $curchr = ord(substr($CRYPT_KEY, $i, 1));
    $keyvalue[1] = $keyvalue[1] + $curchr;
    $keyvalue[2] = strlen($CRYPT_KEY);
    }
    return $keyvalue;
}
// ---------------------- KEYVALUE END ----------------------

?>
