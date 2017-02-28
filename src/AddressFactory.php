<?php
namespace AddressFactory\GooglePlaces;
use AddressFactory\GooglePlaces\Exceptions\GooglePlacesApiException;
use AddressFactory\GooglePlaces\Factories\USAddressFactory;
use AddressFactory\GooglePlaces\Factories\DefaultAddressFactory;
use AddressFactory\GooglePlaces\PlacesApi as GooglePlaces;
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
    public static function getAddress($string,$flagCount =0){
        if(empty($string) || $flagCount == 10){
            return new DefaultAddressFactory();
        }
//        $googlePlaces = new GooglePlaces(env('GOOGLE_MAPS_API_KEY'));
        $googlePlaces = new GooglePlaces('AIzaSyDZ-9Dz5vWYXqoogGVV7-Pa73jJh-4IvCc');
        try{
            $response = $googlePlaces->textSearch($string);
            $geocodingAddress = $googlePlaces->placeDetails($response['results'][0]['place_id']);
        }catch (GooglePlacesApiException $e){
            return new DefaultAddressFactory();
            die();
        }catch (Exception $e){
            return new DefaultAddressFactory();
            die();
        }




        $tmpKey =array_search(["street_number"], array_column($geocodingAddress['result']['address_components'], 'types'));
        $streetNumber =$geocodingAddress['result']['address_components'][$tmpKey]['short_name'];
        $tmpKey = array_search(["route"], array_column($geocodingAddress['result']['address_components'], 'types'));
        $streetName = $geocodingAddress['result']['address_components'][$tmpKey]['short_name'];
        if(empty($streetNumber) || empty($streetName)){
            return self::getAddress($geocodingAddress['result']['formatted_address'],$flagCount++);
        }
        if(empty($response['results'][0]['formatted_address'])){
            throw new Exception('Invalid address sent');

        }

        $classname = 'AddressFactory\\GooglePlaces\\Factories\\'.self::get($geocodingAddress);
        return new $classname($geocodingAddress);

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