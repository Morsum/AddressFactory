<?php
namespace AddressFactory\GooglePlaces;
use AddressFactory\GooglePlaces\Factories\USAddressFactory;
Class AddressFactory{
	protected $street_number,
			$formattedAddress,
			$street,
			$apartment,
			$neigbourhood,
			$district,
			$city,
			$state,
			$stateCode,
			$postalCode,
			$lat,
			$lng,
			$countryCode,
			$country;
	protected $geocodeResult;
	function __construct($geocode=''){
        $this->geocodeResult = $geocode;
    }

	public static function getAddress($geocode){
		$classname = 'AddressFactory\\GooglePlaces\\Factories\\'.self::get($geocode);
		return new $classname($geocode);
	}

	public static function get($geocode){
		$countryCode = self::getGoogleApiCountry($geocode);
		if(class_exists($countryCode .'AddressFactory')){
			return $countryCode.'AddressFactory';
		}else{
			return 'DefaultAddressFactory';
		}
	}
	public static function getGoogleApiCountry($geocode){
		$key = array_search([0 => "country",1 => "political"], array_column($geocode['result']['address_components'], 'types'));
		return $geocode['result']['address_components'][$key]['short_name'];
	}

	function getStreetNumber(){
		return $this->street_number;
	}

	function setStreetNumber($var){
		$this->street_number = $var;
	}

	function getFormattedAddress(){
		return $this->formattedAddress;
	}

	function setFormattedAddress($var){
		$this->formattedAddress = $var;
	}

	function getStreet(){
		return $this->street;
	}

	function setStreet($var){
		$this->street= $var;
	}

	function getApartment(){
		return $this->apartment;
	}

	function setApartment($var){
		$this->apartment = $var;
	}

	function getNeigbourhood(){
		return $this->neigbourhood;
	}

	function setNeigbourhood($var){
		$this->neigbourhood = $var;
	}

	function getDistrict(){
		return $this->district;
	}

	function setDistrict($var){
		$this->district = $var;
	}

	function getCity(){
		return $this->city;
	}

	function setCity($var){
		$this->city = $var;
	}

	function getState(){
		return $this->state;
	}

	function setState($var){
		$this->state = $var;
	}

	function getStateCode(){
		return $this->stateCode;
	}

	function setStateCode($var){
		$this->stateCode = $var;
	}

	function getPostalCode(){
		return $this->postalCode;
	}
	function setPostalCode($var){
		$this->postalCode = $var;
	}

	function getLat(){
		return $this->lat;
	}

	function setLat($var){
		$this->lat = $var;
	}

	function getLng(){
		return $this->lng;
	}

	function setLng($var){
		$this->lng = $var;
	}

	function setCountry($var){
		$this->country = $var;
	}

	function getCountry(){
		return $this->country;
	}

	function setCountryCode($var){
		$this->countryCode = $var;
	}

	function getCountryCode(){
		return $this->countryCode;
	}
	
	
}