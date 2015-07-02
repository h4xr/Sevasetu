<?php
/**
 * Defines functions to  implement framework wide security
 * The implementation includes constants for generating hashes and validating
 * the data.
 *
 * @author Saurabh Badhwar
 */

    /**
     * EMAIL_REGEX
     * Defines the Regular expression used to validate the email address
     * @link http://www.regular-expressions.info/email.html
     */
    define("EMAIL_REGEX","\\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\\.[A-Z]{2,4}\\b");

    /**
     * REGEX_SENSITIVITY
     * Defines the case sensitivity of the regular expression matching
     */
    define("REGEX_SENSITIVITY",false);

    /**
     * SALT_STRING
     * The string from which the salt is generated
     */
    define("SALT_STRING","0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+");

    /**
     * SALT_LENGTH
     * The length of the salt string
     */
    define("SALT_LENGTH",8);

    /**
     * Generates the salt string for the security purpose
     *
     * @returns String
     */
    function generateSalt()
    {
        $characters=SALT_STRING;
        $randomString='';
        for($i=0;$i<SALT_LENGTH;$i++)
        {
            $randomString.=$characters[rand(0,strlen($characters))];
        }
        return $randomString;
    }

    /**
     * Generate the hash string
     *
     * @param String $str The string of which the hash needs to be generated
     *
     * @returns String
     */
    function generateHash($str)
    {
        return hash("sha256",$str);
    }

    /**
     * Validate the E-Mail ID
     * @param String $mail The mail id to be validated
     *
     * @returns true|false
     */
    function verifyEmail($mail)
    {
        if(REGEX_SENSITIVITY==true)
        {
            $regex=EMAIL_REGEX;
        }
        else
        {
            $regex=EMAIL_REGEX."/i";
        }

        if(preg_match($regex,$mail)===FALSE)
        {
            return false;
        }
        else
        {
            return true;
        }
    }