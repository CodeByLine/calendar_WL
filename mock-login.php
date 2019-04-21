    <?php
/**
* User Login Class
*
* LICENSE:      (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2)
*
* COPYRIGHT:    Finley Designs
* CONTACT:      ffrinfo@yahoo.com
* DESIGNED BY:  Roy Finley
* VERSION:  1.0
* Password hashing with PBKDF2.
* This class uses the pdkdf2 functions designed by : havoc AT defuse.ca : www: https://defuse.ca/php-pbkdf2.htm
* 
*/
class PasswordProcessor
{
//CREATE HASH FROM USER PASSWORD FOR NEW USER OR LOST PASSWORD
public function create_hash($password)
{
    // format: algorithm:iterations:salt:hash
    $salt = base64_encode(mcrypt_create_iv(24, MCRYPT_DEV_URANDOM));
    return  "sha256:1000:" .  $salt . ":" . 
        base64_encode($this->pbkdf2(
            "sha256",
            $password,
            $salt,
            1000,
            24,
            true
        ));
}
//VALIDATE USER PASSWORD
public function validate_password($password, $good_hash)
{
    $params = explode(":", $good_hash);
    if(count($params) < 4)
       return false; 
    $pbkdf2 = base64_decode($params[3]);
    return $this->slow_equals(
        $pbkdf2,
        $this->pbkdf2(
            $params[0],
            $password,
            $params[2],
            (int)$params[1],
            strlen($pbkdf2),
            true
        )
    );
}

// COMPARE TWO STRINGS IN LENGTH-CONSTANT TIME.
private function slow_equals($a, $b)
{
    $diff = strlen($a) ^ strlen($b);
    for($i = 0; $i < strlen($a) && $i < strlen($b); $i++)
    {
        $diff |= ord($a[$i]) ^ ord($b[$i]);
    }
    return $diff === 0; 
}
//HASHING ALGORITHM
private function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
{
    $algorithm = strtolower($algorithm);
    if(!in_array($algorithm, hash_algos(), true))
        die('PBKDF2 ERROR: Invalid hash algorithm.');
    if($count <= 0 || $key_length <= 0)
        die('PBKDF2 ERROR: Invalid parameters.');

    $hash_length = strlen(hash($algorithm, "", true));
    $block_count = ceil($key_length / $hash_length);

    $output = "";
    for($i = 1; $i <= $block_count; $i++) {
        // $i encoded as 4 bytes, big endian.
        $last = $salt . pack("N", $i);
        // first iteration
        $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
        // perform the other $count - 1 iterations
        for ($j = 1; $j < $count; $j++) {
            $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
        }
        $output .= $xorsum;
    }

    if($raw_output)
        return substr($output, 0, $key_length);
    else
        return bin2hex(substr($output, 0, $key_length));
}
}//CLOSE PasswordProcessor CLASS
?>