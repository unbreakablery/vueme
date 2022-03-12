<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Country_all extends Model
{
    protected $table = 'country_all';

    public function get_all_countries(){

        $country_all = Country_all::orderBy('country','asc')->get();
        $us_index = $country_all->search(function($country) {
            return $country->code2 === 'US';
        });
        $us = $country_all->pull($us_index);
        return $country_all->prepend($us);
    }
 
}

