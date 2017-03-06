<?php

namespace AddressFactory\GooglePlaces\Factories;
use AddressFactory\GooglePlaces\AddressFactory as AddressFactory;
Class DefaultAddressFactory extends AddressFactory{
    function __construct($geocode=''){
        $this->geocodeResult = $geocode;
        $this->init();
    }
    function init(){
        $geocode = $this->geocodeResult;
        if(!empty($geocode['result'])) {
            if (!empty($geocode['result']['formatted_address'])) {
                $this->setFormattedAddress($geocode['result']['formatted_address']);
            }

            $tmpKey = array_search(["street_number"], array_column($geocode['result']['address_components'], 'types'));
            if (!empty($geocode['result']['address_components'][$tmpKey]['short_name'] && is_numeric($geocode['result']['address_components'][$tmpKey]['short_name']))) {
                $this->setStreetNumber($geocode['result']['address_components'][$tmpKey]['short_name']);
            }


            $tmpKey = array_search(["route"], array_column($geocode['result']['address_components'], 'types'));
            if (!empty($geocode['result']['address_components'][$tmpKey]['long_name'])) {
                $this->setStreet($geocode['result']['address_components'][$tmpKey]['long_name']);
            } else {
                $this->setStreet("");
            }


            $tmpKey = array_search(["neighborhood", "political"], array_column($geocode['result']['address_components'], 'types'));
            if (!empty($geocode['result']['address_components'][$tmpKey]['long_name'])) {
                $this->setNeigbourhood($geocode['result']['address_components'][$tmpKey]['long_name']);
            }


            $tmpKey = array_search(["sublocality_level_1", "sublocality", "political"], array_column($geocode['result']['address_components'], 'types'));
            $borrowgh = $geocode['result']['address_components'][$tmpKey]['long_name'];
            if (!empty($borrowgh) && in_array($borrowgh, array('Manhattan', 'Brooklyn', 'Queens', 'Staten Island', 'Bronx'))) {
                $this->setCity('New York');
            }
            if (!empty($borrowgh)) {
                $this->setDistrict($borrowgh);
            }

            $tmpKey = array_search(["locality", "political"], array_column($geocode['result']['address_components'], 'types'));
            $city = $geocode['result']['address_components'][$tmpKey]['long_name'];
            if (!empty($city) && empty($this->getCity)) {
                $this->setCity($city);
            } else {
                $this->setCity("");
            }

            $tmpKey = array_search(["postal_code"], array_column($geocode['result']['address_components'], 'types'));
            if (!empty($geocode['result']['address_components'][$tmpKey]['long_name'])) {
                $this->setPostalCode(substr($geocode['result']['address_components'][$tmpKey]['long_name'],0,11));
            } else {
                $this->setPostalCode("");
            }


            $key = array_search(["country", "political"], array_column($geocode['result']['address_components'], 'types'));
            if (!empty($geocode['result']['address_components'][$key]['short_name'])) {
                $this->setCountryCode(substr($geocode['result']['address_components'][$key]['short_name'], 0, 2));
            } else {
                $this->setCountryCode("");
            }

            if (!empty($geocode['result']['address_components'][$key]['long_name'])) {
                $this->setCountry($geocode['result']['address_components'][$key]['long_name']);
            } else {
                $this->setCountry("");
            }


            $key = array_search(["administrative_area_level_1", "political"], array_column($geocode['result']['address_components'], 'types'));
            if (!empty($geocode['result']['address_components'][$key]['short_name'])) {
                $this->setStateCode(substr($geocode['result']['address_components'][$key]['short_name'], 0, 10));
            }

            if (!empty($geocode['result']['address_components'][$key]['long_name'])) {
                $this->setState($geocode['result']['address_components'][$key]['long_name']);
            }

            if (!empty($geocode['result']['geometry']['location']['lat'])) {
                $this->setLat($geocode['result']['geometry']['location']['lat']);
            }

            if (!empty($geocode['result']['geometry']['location']['lat'])) {
                $this->setLng($geocode['result']['geometry']['location']['lng']);
            }

            if(($this->getStreet() == $this->getCity()) && ($this->getCity() == $this->getState())){
                $this->setFormattedAddress('');
            }
        }

    }

}