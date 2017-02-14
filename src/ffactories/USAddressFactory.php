<?php

namespace AddressFactory\GooglePlaces\Factories;
use AddressFactory\GooglePlaces\AddressFactory as AddressFactory;
Class USAddressFactory extends AddressFactory{
	function __construct($geocode=''){
		$this->geocodeResult = $geocode;
		$this->init();
	}
	function init(){
		$geocode = $this->geocodeResult;
		$tmpKey = array_search(["street_number"], array_column($geocode['result']['address_components'], 'types'));
		$this->setStreetNumber($geocode['result']['address_components'][$tmpKey]['short_name']);


		$tmpKey = array_search(["route"], array_column($geocode['result']['address_components'], 'types'));
		$this->setStreet($geocode['result']['address_components'][$tmpKey]['long_name']);
		
		$tmpKey = array_search(["neighborhood","political"], array_column($geocode['result']['address_components'], 'types'));
		$this->setNeigbourhood($geocode['result']['address_components'][$tmpKey]['long_name']);


		$tmpKey = array_search(["sublocality_level_1","sublocality","political"], array_column($geocode['result']['address_components'], 'types'));
		$borrowgh = $geocode['result']['address_components'][$tmpKey]['long_name'];
		if(in_array($borrowgh,array('Manhattan','Brooklyn','Queens','Staten Island','Bronx'))){
			$this->setCity('New York');
		}
		$this->setDistrict($borrowgh);

		$tmpKey = array_search(["locality","political"], array_column($geocode['result']['address_components'], 'types'));
		$city = $geocode['result']['address_components'][$tmpKey]['long_name'];
		if(empty($this->getCity)){
			$this->setCity($city);
		}

		$tmpKey = array_search(["postal_code"], array_column($geocode['result']['address_components'], 'types'));
		$this->setPostalCode($geocode['result']['address_components'][$tmpKey]['long_name']);

		$key = array_search(["country","political"], array_column($geocode['result']['address_components'], 'types'));
		$this->setCountryCode($geocode['result']['address_components'][$key]['short_name']);
		$this->setCountry($geocode['result']['address_components'][$key]['long_name']);

		$key = array_search(["administrative_area_level_1","political"], array_column($geocode['result']['address_components'], 'types'));
		$this->setStateCode($geocode['result']['address_components'][$key]['short_name']);
		$this->setState($geocode['result']['address_components'][$key]['long_name']);

		$this->setFormattedAddress($geocode['result']['formatted_address']);

		$this->setLat($geocode['result']['geometry']['location']['lat']);
		$this->setLng($geocode['result']['geometry']['location']['lng']);
		$this->setApartment(" ");
	}

}