<?php

class ChatweeV2_Session
{
	private static function getCookieKey() {
		if(ChatweeV2_Configuration::isConfigurationSet() === false) {
			throw new Exception("The client credentials are not set");
		}
		return "chatwee-SID-" . ChatweeV2_Configuration::getChatId();
	}

    public static function getSessionId() {
    	$cookieKey = self::getCookieKey();

    	return isSet($_COOKIE[$cookieKey]) ? $_COOKIE[$cookieKey] : null;
    }

    public static function setSessionId($sessionId) {
		$hostChunks = explode(".", $_SERVER["HTTP_HOST"]);

		$hostChunks = array_slice($hostChunks, -2);

		$cookieDomain = "." . implode(".", $hostChunks);

		setcookie(self::getCookieKey(), $sessionId, time() + 2592000, "/", $cookieDomain);
    }

    public static function clearSessionId() {
		$hostChunks = explode(".", $_SERVER["HTTP_HOST"]);

		$hostChunks = array_slice($hostChunks, -2);

		$domain = "." . implode(".", $hostChunks);

		setcookie(self::getCookieKey(), "", time() - 1, "/", $domain);
    }

    public static function isSessionSet() {
		return ChatweeV2_Session::getSessionId() !== null;
    }
}
