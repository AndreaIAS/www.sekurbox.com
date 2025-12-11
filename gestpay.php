<?php
	/*
 * GestPayCrypt e GestPayCryptHS 2.0.1
 * Copyright (C) 2001-2004 Alessandro Astarita <aleast@capri.it>
 *
 * http://gestpaycryptphp.sourceforge.net/
 *
 * GestPayCrypt-PHP is an implementation in PHP of GestPayCrypt e
 * GestPayCryptHS italian bank Banca Sella java classes. It allows to
 * connect to online credit card payment GestPay.
 *
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public License
 * version 2.1 as published by the Free Software Foundation.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details at 
 * http://www.gnu.org/copyleft/lgpl.html
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */
 
 // Path curl 
define("GESTPAYCRYPT_CURL_BIN", "/usr/bin/curl");

define("debug",true);

class GestPayCrypt
{
    private $shopLogin;
    private $currency;
    private $amount;
    private $shopTransactionId;
    private $cardNumber;
    private $expMonth;
    private $expYear;
    private $buyerName;
    private $buyerEmail;
    private $language;
    private $customInfo;
    private $authorizationCode;
    private $errorCode;
    private $errorDescription;
    private $bankTransactionId;
    private $alertCode;
    private $alertDescription;
    private $encryptedString;
    private $decrypted;
    private $transactionResult;
    private $transport;
    private $domainName;
    private $testDomainName;
    private $paymentUrl;
    private $port;
    private $separator;
    private $min;
    private $cvv;
    private $country;
    private $vbv;
    private $vbvRisp;
    private $threeDLevel;
    private $scriptEncrypt;
    private $scriptDecrypt;
    private $testEnv;

    public function __construct()
    {
        $this->shopLogin = "";
        $this->currency = "";
        $this->amount = "";
        $this->shopTransactionId = "";
        $this->cardNumber = "";
        $this->expMonth = "";
        $this->expYear = "";
        $this->buyerName = "";
        $this->buyerEmail = "";
        $this->language = "";
        $this->customInfo = "";
        $this->authorizationCode = "";
        $this->errorCode = "0";
        $this->errorDescription = "";
        $this->bankTransactionId = "";
        $this->alertCode = "";
        $this->alertDescription = "";
        $this->encryptedString = "";
        $this->decrypted = "";
        $this->transport = "tcp";
        $this->domainName = "ecomm.sella.it";
        $this->testDomainName = "testecomm.sella.it";
        $this->paymentUrl = "/pagam/pagam.aspx";
        $this->port = "80";
        $this->scriptEncrypt = "/CryptHTTP/Encrypt.asp";
        $this->scriptDecrypt = "/CryptHTTP/Decrypt.asp";
        $this->separator = "*P1*";
        $this->min = "";
        $this->cvv = "";
        $this->country = "";
        $this->vbv = "";
        $this->vbvRisp = "";
        $this->threeDLevel = "";
        $this->testEnv = false;
    }

    /**
     * @param bool $enable
     * @return GestPayCrypt
     */
    public function setTestEnv($enable)
    {
        $this->testEnv = $enable;

        return $this;
    }

    /**
     * @return bool
     */
    public function getTestEnv()
    {
        return $this->testEnv;
    }

    /**
     * @param string $val
     *
     * @return GestPayCrypt
     */
    public function setShopLogin($val)
    {
        $this->shopLogin = $val;

        return $this;
    }

    /**
     * @return string
     */
    public function getShopLogin()
    {
        return $this->shopLogin;
    }

    /**
     * @param string $val
     *
     * @return GestPayCrypt
     */
    public function setCurrency($val)
    {
        $this->currency = $val;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $val
     *
     * @return GestPayCrypt
     */
    public function setAmount($val)
    {
        $this->amount = $val;

        return $this;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string $val
     *
     * @return GestPayCrypt
     */
    public function setShopTransactionID($val)
    {
        $this->shopTransactionId = urlencode(trim($val));

        return $this;
    }

    /**
     * @return string
     */
    public function getShopTransactionID()
    {
        return urldecode($this->shopTransactionId);
    }

    /**
     * @param string $val
     *
     * @return GestPayCrypt
     */
    public function setCardNumber($val)
    {
        $this->cardNumber = $val;

        return $this;
    }

    /**
     * @param string $val
     *
     * @return GestPayCrypt
     */
    public function setExpMonth($val)
    {
        $this->expMonth = $val;

        return $this;
    }

    /**
     * @param string $val
     *
     * @return GestPayCrypt
     */
    public function setExpYear($val)
    {
        $this->expYear = $val;

        return $this;
    }

    /**
     * @param string $val
     *
     * @return GestPayCrypt
     */
    public function setMin($val)
    {
        $this->min = $val;

        return $this;
    }

    /**
     * @param string $val
     *
     * @return GestPayCrypt
     */
    public function setCvv($val)
    {
        $this->cvv = $val;

        return $this;
    }

    /**
     * @param string $val
     *
     * @return GestPayCrypt
     */
    public function setBuyerName($val)
    {
        $this->buyerName = urlencode(trim($val));

        return $this;
    }

    /**
     * @param string $val
     *
     * @return GestPayCrypt
     */
    public function setBuyerEmail($val)
    {
        $this->buyerEmail = trim($val);

        return $this;
    }

    /**
     * @param string $val
     *
     * @return GestPayCrypt
     */
    public function setLanguage($val)
    {
        $this->language = trim($val);

        return $this;
    }

    /**
     * @param string $val
     *
     * @return GestPayCrypt
     */
    public function setCustomInfo($val)
    {
        $this->customInfo = urlencode(trim($val));

        return $this;
    }

    /**
     * @param array $arrval
     * @return GestPayCrypt|bool
     */
    public function setCustomInfoFromArray(array $arrval)
    {
        if (!is_array($arrval)) {
            return false;
        }
        //check string validity
        foreach ($arrval as $key => $val) {
            if (strlen($val) > 300) {
                $val = substr($val, 0, 300);
            }
            $arrval[$key] = urlencode($val);
        }

        $this->customInfo = http_build_query($arrval, '', $this->separator);

        return $this;
    }

    public function getCustomInfoToArray()
    {
        $allinfo = explode($this->separator, $this->customInfo);
        $customInfoArray = array();
        foreach ($allinfo as $singleInfo) {
            $tagval = explode("=", $singleInfo);
            $customInfoArray[$tagval[0]] = urldecode($tagval[1]);
        }

        return $customInfoArray;
    }

    /**
     * @return string
     */
    public function getCustomInfo()
    {
        return urldecode($this->customInfo);
    }

    /**
     * @param string $val
     *
     * @return GestPayCrypt
     */
    public function setEncryptedString($val)
    {
        $this->encryptedString = $val;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getVbv()
    {
        return $this->vbv;
    }

    /**
     * @return string
     */
    public function getVbvRisp()
    {
        return $this->vbvRisp;
    }

    /**
     * @return string
     */
    public function get3dLevel()
    {
        return $this->threeDLevel;
    }

    /**
     * @return string
     */
    public function getBuyerName()
    {
        return urldecode($this->buyerName);
    }

    /**
     * @return string
     */
    public function getBuyerEmail()
    {
        return $this->buyerEmail;
    }

    /**
     * @return string
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return string
     */
    public function getErrorDescription()
    {
        return $this->errorDescription;
    }

    /**
     * @return string
     */
    public function getBankTransactionID()
    {
        return $this->bankTransactionId;
    }

    /**
     * @return string
     */
    public function getTransactionResult()
    {
        return $this->transactionResult;
    }

    /**
     * @return string
     */
    public function getAlertCode()
    {
        return $this->alertCode;
    }

    /**
     * @return string
     */
    public function getAlertDescription()
    {
        return $this->alertDescription;
    }

    /**
     * @return string
     */
    public function getEncryptedString()
    {
        return $this->encryptedString;
    }

    /**
     * @param string $type
     *
     * @return GestPayCrypt
     */
    public function setTransport($type)
    {
        $this->transport = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @param string $domain_name
     *
     * @return GestPayCrypt
     */
    public function setDomainName($domain_name)
    {
        $this->domainName = $domain_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDomainName()
    {
        if ($this->testEnv === true) {
            return $this->testDomainName;
        }

        return $this->domainName;
    }

    /**
     * @param string $port
     *
     * @return GestPayCrypt
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param string $script
     *
     * @return GestPayCrypt
     */
    public function setScriptEncrypt($script)
    {
        $this->scriptEncrypt = $script;

        return $this;
    }

    /**
     * @param string $script
     *
     * @return GestPayCrypt
     */
    public function setScriptDecrypt($script)
    {
        $this->scriptDecrypt = $script;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentUrl()
    {
        return $this->paymentUrl;
    }

    /**
     * @param $url
     * @return GestPayCrypt
     */
    public function setPaymentUrl($url)
    {
        $this->paymentUrl = $url;

        return $this;
    }

    public function getRedirectUrl()
    {
        return 'https://' . $this->getDomainName() . $this->getPaymentUrl() .
               '?a=' . $this->getShopLogin() .
               '&b=' . $this->getEncryptedString();
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getScriptType($type)
    {
        if ($type == "crypt") {
            return $this->scriptEncrypt;
        } else {
            return $this->scriptDecrypt;
        }
    }

    /**
     * @return bool
     */
    public function encrypt()
    {
        $this->setError('0', '');

        if (empty($this->shopLogin)) {
            $this->setError('546', 'IDshop not valid');
            return false;
        }

        if (empty($this->currency)) {
            $this->setError('552', 'Currency not valid');
            return false;
        }

        if (empty($this->amount)) {
            $this->setError('553', 'Amount not valid');
            return false;
        }

        if (empty($this->shopTransactionId)) {
            $this->setError('551', 'Shop Transaction ID not valid');
            return false;
        }

        $response = $this->_httpGetResponse("crypt", $this->shopLogin, $this->_getParsedEncryptArguments());

        if ($response == -1) {
            return false;
        }

        $this->encryptedString = $this->_parseResponse("crypt", $response);

        if ($this->encryptedString == -1) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    private function _getParsedEncryptArguments()
    {
        $args = "";

        $vars = array(
            "PAY1_CVV" => $this->cvv,
            "PAY1_MIN" => $this->min,
            "PAY1_UICCODE" => $this->currency,
            "PAY1_AMOUNT" => $this->amount,
            "PAY1_SHOPTRANSACTIONID" => $this->shopTransactionId,
            "PAY1_CARDNUMBER" => $this->cardNumber,
            "PAY1_EXPMONTH" => $this->expMonth,
            "PAY1_EXPYEAR" => $this->expYear,
            "PAY1_CHNAME" => $this->buyerName,
            "PAY1_CHEMAIL" => $this->buyerEmail,
            "PAY1_IDLANGUAGE" => $this->language
        );

        foreach ($vars as $name => $value) {
            if (!empty($value)) {
                $args .= $name . "=" . $value . $this->separator;
            }
        }

        $args = substr($args, 0, -strlen($this->separator));

        if (strlen($this->customInfo) > 0) {
            $args .= $this->separator . $this->getCustomInfo();
        }

        $args = str_replace(" ", chr(167), $args);

        return $args;
    }

    /**
     * @return bool
     */
    public function decrypt()
    {
        $this->setError('0', '');

        if (empty($this->shopLogin)) {
            $this->setError('546', 'IDshop not valid');
            return false;
        }

        if (empty($this->encryptedString)) {
            $this->setError('1009', 'String to Decrypt not valid');
            return false;
        }

        $response = $this->_httpGetResponse("decrypt", $this->shopLogin, $this->encryptedString);

        if ($response == -1) {
            false;
        }

        $this->decrypted = $this->_parseResponse("decrypt", $response);

        if ($this->decrypted == -1) {
            return false;
        } elseif (empty($this->decrypted)) {
            $this->setError('9999', 'Empty decrypted string');
            return false;
        }

        $this->decrypted = str_replace(chr(167), " ", $this->decrypted);

        $this->_parseDecryptedData();

        return true;
    }

    /**
     * @param string $type
     * @param string $a
     * @param string $b
     *
     * @return string
     */
    protected function _httpGetResponse($type, $a, $b)
    {
        $errno = "";
        $errstr = "";

        $socket = fsockopen(
            $this->getTransport() . "://" . $this->getDomainName(),
            $this->getPort(),
            $errno,
            $errstr,
            60
        );

        if (!$socket) {
            $this->setError(
                '9999',
                "Impossible to connect to: " .
                $this->getTransport() . "://" . $this->getDomainName() . ':' . $this->getPort()
            );
            return -1;
        }

        $uri = $this->getScriptType($type) . "?a=" . $a . "&b=" . $b;

        fputs($socket, "GET " . $uri . " HTTP/1.0\r\n\r\n");

        while (fgets($socket, 4096) != "\r\n") {
            ;
        }

        $line = fgets($socket, 4096);

        fclose($socket);

        return $line;
    }

    /**
     * @param string $type
     * @param string $response
     *
     * @return string
     */
    private function _parseResponse($type, $response)
    {
        $matches = array();

        if (preg_match("/#" . $type . "string#([\w\W]*)#\/" . $type . "string#/", $response, $matches)) {
            $parsed = trim($matches[1]);
        } elseif (preg_match("/#error#([\w\W]*)#\/error#/", $response, $matches)) {
            $err = explode("-", $matches[1]);

            if (empty($err[0]) && empty($err[1])) {
                $this->setError('9999', 'Unknown error');
            } else {
                $this->setError(trim($err[0]), trim($err[1]));
            }

            return -1;
        } else {
            $this->setError('9999', 'Response from server not valid');

            return -1;
        }

        return $parsed;
    }

    private function _parseDecryptedData()
    {
        $keyval = explode($this->separator, $this->decrypted);

        foreach ($keyval as $tagPAY1) {
            $tagPAY1val = explode("=", $tagPAY1);

            if (preg_match("/^PAY1_UICCODE/", $tagPAY1)) {
                $this->currency = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_AMOUNT/", $tagPAY1)) {
                $this->amount = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_SHOPTRANSACTIONID/", $tagPAY1)) {
                $this->shopTransactionId = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_CHNAME/", $tagPAY1)) {
                $this->buyerName = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_CHEMAIL/", $tagPAY1)) {
                $this->buyerEmail = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_AUTHORIZATIONCODE/", $tagPAY1)) {
                $this->authorizationCode = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_ERRORCODE/", $tagPAY1)) {
                $this->errorCode = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_ERRORDESCRIPTION/", $tagPAY1)) {
                $this->errorDescription = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_BANKTRANSACTIONID/", $tagPAY1)) {
                $this->bankTransactionId = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_ALERTCODE/", $tagPAY1)) {
                $this->alertCode = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_ALERTDESCRIPTION/", $tagPAY1)) {
                $this->alertDescription = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_CARDNUMBER/", $tagPAY1)) {
                $this->cardNumber = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_EXPMONTH/", $tagPAY1)) {
                $this->expMonth = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_EXPYEAR/", $tagPAY1)) {
                $this->expYear = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_COUNTRY/", $tagPAY1)) {
                $this->country = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_VBVRISP/", $tagPAY1)) {
                $this->vbvRisp = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_VBV/", $tagPAY1)) {
                $this->vbv = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_IDLANGUAGE/", $tagPAY1)) {
                $this->language = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_TRANSACTIONRESULT/", $tagPAY1)) {
                $this->transactionResult = $tagPAY1val[1];
            } elseif (preg_match("/^PAY1_3DLEVEL/", $tagPAY1)) {
                $this->threeDLevel = $tagPAY1val[1];
            } else {
                $this->customInfo .= $tagPAY1 . $this->separator;
            }
        }

        $this->customInfo = substr($this->customInfo, 0, -strlen($this->separator));
    }

    /**
     * @param string $errorCode
     * @param string $errorDescription
     * @return GestPayCrypt
     */
    protected function setError($errorCode, $errorDescription)
    {
        $this->errorCode = $errorCode;
        $this->errorDescription = $errorDescription;

        return $this;
    }
}
 
class GestPayCryptWS extends GestPayCrypt
{
    private $context;
    private $shopLogin;
    private $currency;
    private $amount;
    private $shopTransactionId;
    private $cardNumber;
    private $expMonth;
    private $expYear;
    private $buyerName;
    private $buyerEmail;
    private $language;
    private $customInfo;
    private $authorizationCode;
    private $errorCode;
    private $errorDescription;
    private $bankTransactionId;
    private $alertCode;
    private $alertDescription;
    private $encryptedString;
    private $decrypted;
    private $transactionResult;
    private $transport;
    private $domainName;
    private $domainNameS2S;
    private $testDomainName;
    private $paymentUrl;
    private $separator;
    private $min;
    private $cvv;
    private $country;
    private $vbv;
    private $vbvRisp;
    private $threeDLevel;
    private $testEnv;

    public function __construct()
    {
        $this->shopLogin = "";
        $this->currency = "";
        $this->amount = "";
        $this->shopTransactionId = "";

        $this->testEnv = false;
        $this->domainName = "ecomm.sella.it";
        $this->domainNameS2S = "ecommS2S.sella.it";
        $this->testDomainName = "testecomm.sella.it";
        $this->paymentUrl = "/pagam/pagam.aspx";
        $this->separator = "*P1*";

        $this->setContext();
    }

    public function setTestEnv($enable)
    {
        $this->testEnv = $enable;
        return $this;
    }

    public function getTestEnv()
    {
        return $this->testEnv;
    }

    public function setShopLogin($val)
    {
        $this->shopLogin = $val;
        return $this;
    }

    public function getShopLogin()
    {
        return $this->shopLogin;
    }

    public function setCurrency($val)
    {
        $this->currency = $val;
        return $this;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setAmount($val)
    {
        $this->amount = $val;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setShopTransactionID($val)
    {
        $this->shopTransactionId = urlencode(trim($val));
        return $this;
    }

    public function getShopTransactionID()
    {
        return urldecode($this->shopTransactionId);
    }

    public function setCardNumber($val)
    {
        $this->cardNumber = $val;
        return $this;
    }

    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    public function setExpMonth($val)
    {
        $this->expMonth = $val;
        return $this;
    }

    public function getExpMonth()
    {
        return $this->expMonth;
    }

    public function setExpYear($val)
    {
        $this->expYear = $val;
        return $this;
    }

    public function getExpYear()
    {
        return $this->expYear;
    }

    public function setMin($val)
    {
        $this->min = $val;
        return $this;
    }

    public function getMin()
    {
        return $this->min;
    }

    public function setCvv($val)
    {
        $this->cvv = $val;
        return $this;
    }

    public function getCvv()
    {
        return $this->cvv;
    }

    public function setBuyerName($val)
    {
        $this->buyerName = urlencode(trim($val));
        return $this;
    }

    public function getBuyerName()
    {
        return urldecode($this->buyerName);
    }

    public function setBuyerEmail($val)
    {
        $this->buyerEmail = trim($val);
        return $this;
    }

    public function getBuyerEmail()
    {
        return $this->buyerEmail;
    }

    public function setLanguage($val)
    {
        $this->language = trim($val);
        return $this;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setCustomInfo($val)
    {
        $this->customInfo = urlencode(trim($val));
        return $this;
    }

    public function getCustomInfo()
    {
        return urldecode($this->customInfo);
    }

    /**
     * @param array $arrval
     * @return GestPayCryptWS|bool
     */
    public function setCustomInfoFromArray(array $arrval)
    {
        if (!is_array($arrval)) {
            return false;
        }

        //check string validity
        foreach ($arrval as $key => $val) {
            if (strlen($val) > 300) {
                $val = substr($val, 0, 300);
            }

            $arrval[$key] = urlencode($val);
        }

        $this->customInfo = http_build_query($arrval, '', $this->separator);

        return $this;
    }

    public function getCustomInfoToArray()
    {
        $allinfo = explode($this->separator, $this->customInfo);
        $customInfoArray = array();

        foreach ($allinfo as $singleInfo) {
            $tagval = explode("=", $singleInfo);
            $customInfoArray[$tagval[0]] = urldecode($tagval[1]);
        }

        return $customInfoArray;
    }

    public function setEncryptedString($val)
    {
        $this->encryptedString = $val;
        return $this;
    }

    public function getEncryptedString()
    {
        return $this->encryptedString;
    }

    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setVbv($vbv)
    {
        $this->vbv = $vbv;
        return $this;
    }

    public function getVbv()
    {
        return $this->vbv;
    }

    public function setVbvRisp($vbvRisp)
    {
        $this->vbvRisp = $vbvRisp;
        return $this;
    }

    public function getVbvRisp()
    {
        return $this->vbvRisp;
    }

    public function set3dLevel($val)
    {
        $this->threeDLevel = $val;
        return $this;
    }

    public function get3dLevel()
    {
        return $this->threeDLevel;
    }

    public function setAuthorizationCode($val)
    {
        $this->authorizationCode = $val;
        return $this;
    }

    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @param string $errorCode
     * @param string $errorDescription
     * @return GestPayCryptWS
     */
    protected function setError($errorCode, $errorDescription)
    {
        $this->errorCode = $errorCode;
        $this->errorDescription = $errorDescription;
        return $this;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function getErrorDescription()
    {
        return $this->errorDescription;
    }

    public function setBankTransactionID($val)
    {
        $this->bankTransactionId = urlencode(trim($val));
        return $this;
    }

    public function getBankTransactionID()
    {
        return $this->bankTransactionId;
    }

    public function setTransactionResult($val)
    {
        $this->transactionResult = $val;
        return $this;
    }

    public function getTransactionResult()
    {
        return $this->transactionResult;
    }

    public function setAlertCode($alertCode)
    {
        $this->alertCode = $alertCode;
        return $this;
    }

    public function getAlertCode()
    {
        return $this->alertCode;
    }

    public function setAlertDescription($alertDescription)
    {
        $this->alertDescription = $alertDescription;
        return true;
    }

    public function getAlertDescription()
    {
        return $this->alertDescription;
    }

    public function setTransport($type)
    {
        $this->transport = $type;
        return $this;
    }

    public function getTransport()
    {
        return $this->transport;
    }

    public function getDomainName()
    {
        if ($this->testEnv === true) {
            return $this->testDomainName;
        }

        return $this->domainName;
    }
		
	public function getDomainNameS2S()
    {
        if ($this->testEnv === true) {
            return $this->testDomainName;
        }
        return $this->domainNameS2S;
    }

    public function getPaymentUrl()
    {
        return $this->paymentUrl;
    }

    public function setPaymentUrl($url)
    {
        $this->paymentUrl = $url;
        return $this;
    }

    public function setSeparator($separator)
    {
        $this->separator = $separator;
        return $this;
    }

    public function getSeparator()
    {
        return $this->separator;
    }

    public function setDecrypted($decrypted)
    {
        $this->decrypted = $decrypted;
        return $this;
    }

    public function getDecrypted()
    {
        return $this->decrypted;
    }

    /**
     * @param string $ciphers allowed chipers
     * @return GestPayCryptWS
     */
    public function setContext($ciphers = 'DHE-RSA-AES256-SHA:DHE-DSS-AES256-SHA:AES256-SHA:KRB5-DES-CBC3-MD5:KRB5-DES-CBC3-SHA:EDH-RSA-DES-CBC3-SHA:EDH-DSS-DES-CBC3-SHA:DES-CBC3-SHA:DES-CBC3-MD5:DHE-RSA-AES128-SHA:DHE-DSS-AES128-SHA:AES128-SHA:RC2-CBC-MD5:KRB5-RC4-MD5:KRB5-RC4-SHA:RC4-SHA:RC4-MD5:RC4-MD5:KRB5-DES-CBC-MD5:KRB5-DES-CBC-SHA:EDH-RSA-DES-CBC-SHA:EDH-DSS-DES-CBC-SHA:DES-CBC-SHA:DES-CBC-MD5:EXP-KRB5-RC2-CBC-MD5:EXP-KRB5-DES-CBC-MD5:EXP-KRB5-RC2-CBC-SHA:EXP-KRB5-DES-CBC-SHA:EXP-EDH-RSA-DES-CBC-SHA:EXP-EDH-DSS-DES-CBC-SHA:EXP-DES-CBC-SHA:EXP-RC2-CBC-MD5:EXP-RC2-CBC-MD5:EXP-KRB5-RC4-MD5:EXP-KRB5-RC4-SHA:EXP-RC4-MD5:EXP-RC4-MD5')
    {
        $this->context = stream_context_create(array(
            'ssl' => array(
                'ciphers' => $ciphers
            )
        ));

        return $this;
    }

    /**
     * @return A stream context resource.
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return 'https://' . $this->getDomainName() . $this->getPaymentUrl() .
            '?a=' . $this->getShopLogin() .
            '&b=' . $this->getEncryptedString();
    }

    /**
     * Genera la URL del WSDL
     * @return string
     */
    private function getWsdl()
    {
        return 'https://' . $this->getDomainNameS2S() .
            '/gestpay/gestpayws/WSCryptDecrypt.asmx?WSDL';
    }

    /**
     * Genera l'array dei parametri per l'encrypt
     * @return array
     */
    private function getEncParams()
    {
        // Parametri obbligatori
        $params = array(
            'shopLogin' => $this->getShopLogin(),
            'uicCode' => $this->getCurrency(),
            'amount' => $this->getAmount(),
            'shopTransactionId' => $this->getShopTransactionID(),
        );

        return array_merge($params, $this->getOptParams());
    }

    /**
     * Genera l'array dei parametri per il decrypt
     * @return array
     */
    private function getDecParams()
    {
        // Parametri obbligatori
        $params = array(
            'shopLogin' => $this->getShopLogin(),
            'CryptedString' => $this->getEncryptedString(),
        );

        return array_merge($params, $this->getOptParams());
    }

    /**
     * Parametri opzionali
     * @todo Gestire parametri opzionali
     * @return array
     */
    private function getOptParams()
    {
        $params = array();

        // Parametri opzionali
        if (isset($this->buyerName)) {
            $params['buyerName'] = $this->getBuyerName();
        }
        if (isset($this->buyerEmail)) {
            $params['buyerEmail'] = $this->getBuyerEmail();
        }
		if (isset($this->language)) {
            $params['languageId'] = $this->getLanguage();
        }
        if (isset($this->customInfo)) {
            $params['customInfo'] = $this->getCustomInfo();
        }
        return $params;
    }

    /**
     * @return bool
     */
    public function encrypt()
    {
        $retVal = false;
        $this->setError('0', '');

        if (empty($this->shopLogin)) {
            $this->setError('546', 'IDshop not valid');
            return false;
        }

        if (empty($this->currency)) {
            $this->setError('552', 'Currency not valid');
            return false;
        }

        if (empty($this->amount)) {
            $this->setError('553', 'Amount not valid');
            return false;
        }

        if (empty($this->shopTransactionId)) {
            $this->setError('551', 'Shop Transaction ID not valid');
            return false;
        }

        // Creo il SoapClient
        $client = new SoapClient($this->getWsdl(), array('stream_context' => $this->context));
        // Chiamo la funzione
        $objectresult = $client->__soapCall("Encrypt", array($this->getEncParams()));

        // Leggo l'output
        $res = new SimpleXMLElement($objectresult->EncryptResult->any);

        if ($res !== false) {
            // Parso i contenuti della risposta
            $TransactionType = (string) $res->TransactionType;
            $TransactionResult = (string) $res->TransactionResult;
            $EncryptedString = (string) $res->CryptDecryptString;
            $ErrorCode = (string) $res->ErrorCode;
            $ErrorDescription = (string) $res->ErrorDescription;

            // Gestione degli errori
            $this->setError($ErrorCode, $ErrorDescription);
            $this->setTransactionResult($TransactionResult);

            if ($ErrorCode == 0) {
                // Imposto la stringa criptata
                $this->setEncryptedString($EncryptedString);
                $retVal = true;
            }
        }

        return $retVal;
    }

    /**
     * @return bool
     */
    public function decrypt()
    {
        $retVal = false;
        $this->setError('0', '');

        if (empty($this->shopLogin)) {
            $this->setError('546', 'IDshop not valid');
            return false;
        }

        if (empty($this->encryptedString)) {
            $this->setError('1009', 'String to Decrypt not valid');
            return false;
        }

        // Creo il SoapClient
        $client = new SoapClient($this->getWsdl(), array('stream_context' => $this->context));
        // Chiamo la funzione
        $objectresult = $client->__soapCall("Decrypt", array($this->getDecParams()));

        // Leggo l'output
        $res = new SimpleXMLElement($objectresult->DecryptResult->any);				
        if ($res !== false) {
            // Parso i contenuti della risposta
            $TransactionType = (string) $res->TransactionType;
            $TransactionResult = (string) $res->TransactionResult;
            $ErrorCode = (string) $res->ErrorCode;
            $ErrorDescription = (string) $res->ErrorDescription;

            // Gestione degli errori
            $this->setError($ErrorCode, $ErrorDescription);
            $this->setTransactionResult($TransactionResult);
						
            $this->setShopTransactionID((string) $res->ShopTransactionID);
            $this->setBankTransactionID((string) $res->BankTransactionID);
            $this->setAuthorizationCode((string) $res->AuthorizationCode);
            $this->setCurrency((int) $res->Currency);
            $this->setAmount((float) $res->Amount);
            $this->setCustomInfo((string) $res->CustomInfo);
            $this->setDecrypted((string) $res->asXML());

            if ($ErrorCode == 0) {
                // Decrypted
                $retVal = true;
            }
        }

        return $retVal;
    }
} 
 
?>