<?php
namespace MyApp\Helper;


class Session {

    private $cookieTime;

    public function __construct() {
        session_cache_limiter(false);
        session_start();
        $this->cookieTime = strtotime('+30 days');
    }

    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value) {
        $_SESSION[$name] = $value;
    }

    /**
     * @param $base
     * @param $key
     * @param $value
     */
    public function setMulti($base, $key, $value) {
        $_SESSION[$base][$key] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name) {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return $_SESSION[$name];
    }

    /**
     * @param $base
     * @param $key
     * @return mixed
     */
    public function getMulti($base, $key) {
        if (isset($_SESSION[$base][$key])) {
            return $_SESSION[$base][$key];
        }
        return $_SESSION[$base][$key];
    }

    /**
     * @param $name
     */
    public function kill($name) {
        unset($_SESSION[$name]);
    }

    /**
     * Destroy session
     */
    public function killAll() {
        session_destroy();
    }

    /**
     * @param $name
     * @param $value
     */
    public function setCookie($name, $value) {
        setcookie($name, $value, $this->cookieTime);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getCookie($name) {
        return $_COOKIE[$name];
    }

    /**
     * @param $name
     */
    public function killCookie($name) {
        setcookie($name, null);
    }
}