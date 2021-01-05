<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'app_name', 'sub_name', 'url', 'logo', 'page_banner', 'favicon','email', 'address', 'phone_number1', 'phone_number2', 'business_time', 'map'
    ];

    public static function getName()
    {
        $setting = \App\Models\Setting::find(1);
        if(isset($setting->app_name)){
            return $setting->app_name;
        }
        return '';
    }
    public static function getSubName()
    {
        $setting = \App\Models\Setting::find(1);
        if(isset($setting->sub_name)){
            return $setting->sub_name;
        }
        return '';
    }
    public static function getLogo()
    {
    	$setting = \App\Models\Setting::find(1);
    	if(isset($setting->logo)){
    		return $setting->logo;
    	}
    	return '';
    }
    public static function getPageBanner()
    {
        $setting = \App\Models\Setting::find(1);
        if(isset($setting->page_banner)){
            return $setting->page_banner;
        }
        return '';
    }
    public static function getFavicon()
    {
    	$setting = \App\Models\Setting::find(1);
    	if(isset($setting->favicon)){
    		return $setting->favicon;
    	}
    	return '';
    }
    public static function getEmail()
    {
        $setting = \App\Models\Setting::find(1);
        if(isset($setting->email)){
            return $setting->email;
        }
        return '';
    }
    public static function getAddress()
    {
        $setting = \App\Models\Setting::find(1);
        if(isset($setting->address)){
            return $setting->address;
        }
        return '';
    }
    public static function getMap()
    {
        $setting = \App\Models\Setting::find(1);
        if(isset($setting->map)){
            return $setting->map;
        }
        return '';
    }
    public static function getBusinessTime()
    {
        $setting = \App\Models\Setting::find(1);
        if(isset($setting->business_time)){
            return $setting->business_time;
        }
        return '';
    }
    public static function getPhone()
    {
        $setting = \App\Models\Setting::find(1);
        if(isset($setting->phone_number1)){
            return $setting->phone_number1.'-'.$setting->phone_number2;
        }
        return '';
    }
    public static function getMainPhone()
    {
        $setting = \App\Models\Setting::find(1);
        if(isset($setting->phone_number1)){
            return $setting->phone_number1;
        }
        return '';
    }

}
