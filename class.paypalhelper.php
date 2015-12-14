<?php
	class PayPalHelper
	{
		// Private properties
		private $Mode;
		private $Endpoint;
		private $Version;
		private $Config;
		private $Success;

		// Public properties
		public $Result;

		// Construct
		public function __construct($Endpoint = "", $Version = "202")
		{
			$this->SetMode(0);
			$this->SetEndpoint($Endpoint);
			$this->SetVersion($Version);
			$this->SetConfig();
			$this->Success = false;
			$this->Result = array();
		}

		// Methods

		/*
			Config should be a "key" => "value" array with options that are perminently passed
			to the API call
		*/
		public function SetConfig($Array = array(), $Mode = 0)
		{
			$this->Config[$Mode] = $Array;
		}
		
		/*
			Appends to config
		*/
		public function AppendConfig($Key, $Value, $Mode = 0)
		{
			if(is_string($Key) && is_string($Value))
				return $this->Config[$Mode][$Key] = $Value;
			else
				return false;
		}

		/*
			Gets config by key, if no key passed entire config array is returned
		*/
		public function GetConfig($Key = null)
		{
			if(is_string($Key))
				return $this->Config[$this->Mode][$Key];
			else
				return $this->Config[$this->Mode];
		}

		/*
			Sets version
		*/
		public function SetVersion($Version)
		{
			if(is_string($Version))
				return $this->Version = $Version;
			else
				return false;
		}

		/*
			Gets version
		*/
		public function GetVersion()
		{
			return $this->Version;
		}

		/*
			Sets mode
		*/
		public function SetMode($Mode)
		{
			$this->Mode = $Mode;

			// Update endpoint if set in this config mode
			if(isset($this->Config[$this->Mode]["ENDPOINT"])
				&& is_string($this->Config[$this->Mode]["ENDPOINT"])
				&& strlen($this->Config[$this->Mode]["ENDPOINT"]) > 0)
			{
				$this->Endpoint = $this->Config[$this->Mode]["ENDPOINT"];
			}
		}

		/*
			Gets mode
		*/
		public function GetMode()
		{
			return $this->Mode;
		}

		/*
			Sets Endpoint
		*/
		public function SetEndpoint($Endpoint)
		{
			if(is_string($Endpoint))
				return $this->Endpoint = $Endpoint;
			else
				return false;
		}

		/*
			Gets endpoint
		*/
		public function GetEndpoint()
		{
			return $this->Endpoint;
		}
		
		/*
			Gets success
		*/
		public function Success()
		{
			return $this->Success;
		}

		/*
			Make a call to PayPal
			Param1: Array of options (key => value)
			Param2: (optional) Overrides endpoint
		*/
		public function DoCall()
		{
			// Get all parameters
			$Args = func_get_args();

			// Unset ENDPOINT in if set so it doesn't get passed as an option
			if(isset($this->Config[$this->Mode]["ENDPOINT"]))
			{
				$this->Endpoint = $this->Config[$this->Mode]["ENDPOINT"];
				unset($this->Config[$this->Mode]["ENDPOINT"]);
			}

			// Apply VERSION and current config array to RequestParams
			$RequestParams = array_merge(
				array("VERSION" => $this->Version),
				$this->Config[$this->Mode]
			);

			// Merge all arrays passed to RequestParams
			foreach($Args as $item)
				$RequestParams = array_merge($RequestParams, $item);

			// Build RequestParamsString
			$RequestParamsString = "";
			foreach($RequestParams as $k => $v)
				$RequestParamsString .= "&".$k."=".urlencode($v);
			$RequestParamsString = ltrim($RequestParamsString, "&");

			// Set Curl options
			$Curl = curl_init();
			curl_setopt($Curl, CURLOPT_VERBOSE, 1);
			curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($Curl, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($Curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($Curl, CURLOPT_URL, $this->Endpoint);
			curl_setopt($Curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($Curl, CURLOPT_POSTFIELDS, $RequestParamsString);

			// Get HTTP response and close Curl
			$httpResponse = curl_exec($Curl);
			curl_close($Curl);

			// Get array from response
			$httpResponseAr = explode("&", $httpResponse);

			$httpParsedResponseAr = array();
			foreach ($httpResponseAr as $i => $value) {
				$tmpAr = explode("=", $value);
				if(sizeof($tmpAr) > 1) {
					$httpParsedResponseAr[$tmpAr[0]] = urldecode($tmpAr[1]);
				}
			}

			$this->Result = $httpParsedResponseAr;

			if(strtoupper($this->Result["ACK"]) == "SUCCESS" || strtoupper($this->Result["ACK"]) == "SUCCESSWITHWARNING")
				$this->Success = true;
			else
				$this->Success = false;

			// Put ENDPOINT back into array
			if(isset($this->Endpoint))
				$this->Config[$this->Mode]["ENDPOINT"] = $this->Endpoint;

			return $this->Result;
		}
	}
