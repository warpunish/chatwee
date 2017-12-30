<?php

class ChatweeV2_HttpClient
{
	const API_URL = "http://chatwee-api.com/v2/";

	private $response;

	private $responseStatus;

	private $responseObject;

    public function get($method, $parameters) {
		if(ChatweeV2_Configuration::isConfigurationSet() === false) {
			throw new Exception("The client credentials are not set");
		}

		$parameters["chatId"] = ChatweeV2_Configuration::getChatId();
		$parameters["clientKey"] = ChatweeV2_Configuration::getClientKey();

		$serializedParameters = self::_serializeParameters($parameters);
		$url = self::API_URL . $method . "?" . $serializedParameters;

		self::call("GET", $url);
    }

	private function call($method, $url) {
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_TIMEOUT, 60);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, Array (
			'Accept: application/xml',
			'Content-Type: application/xml',
			'User-Agent: ChatweeV2 PHP SDK 1.01'
		));

		$this->response = curl_exec($curl);
		$this->responseStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		$this->responseObject = $this->response ? json_decode($this->response) : null;
		if($this->responseStatus != 200) {
			$responseError = $this->responseObject ? $this->responseObject->errorMessage : "ChatweeV2 PHP SDK unknown error: " . $this->responseStatus;
			$responseError .= " (" . $url . ")";
			throw new Exception($responseError);
		}
    }

	private function _serializeParameters($parameters) {
		if(!is_array($parameters) || count($parameters) == 0) {
			return "";
		}

		$result = "";
		foreach($parameters as $key => $value) {
			$result .= ($key . "=" . ($value ? urlencode(htmlentities($value)) : $value) . '&');
		}

		$result = substr_replace($result, "", -1);
		return $result;
	}

	public function getResponse() {
		return $this->response;
	}

	public function getResponseObject() {
		return $this->responseObject;
	}

	public function getResponseStatus() {
		return $this->responseStatus;
	}
}
