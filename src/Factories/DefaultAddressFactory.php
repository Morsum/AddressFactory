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
        $this->setStreet("");
        $this->setCity("");
        $this->setPostalCode("");
        $this->setCountryCode("");
        $this->setCountry("");
        $this->setFormattedAddress($geocode['result']['formatted_address']);


    }

}