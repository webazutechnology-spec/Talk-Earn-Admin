<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cookie;

use App\Models\Configuration;
use App\Models\State;
use App\Models\Citie;
use App\Models\Wallet;
use App\Models\User;




class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    
    public function activateThemeMode()
    {
        $current = Cookie::get('theme_style', config('custom.admin.theme_style'));
        $newTheme = $current == 'light-theme' ? 'dark-theme' : 'light-theme';
        Cookie::queue('theme_style', $newTheme, 10000000);
        return back();
    }



    public function GenerateConfig()
    {
        $host_name = request()->getHost();
        $config = Configuration::pluck('value', 'name')->toArray();
        if (!empty($config)) {
            config($config);
        }
    }

    public function getStates($country_id)
    {
        $states = State::where(['country_id' => $country_id])->orderBy('name', 'asc')->get();
        return response()->json($states);
    }

    public function getCities($state_id)
    {
        $cities = Citie::where(['state_id' => $state_id])->orderBy('name', 'asc')->get();
        return response()->json($cities);
    }

    
    public function find_user_name()
    {
        $data =  User::where('code', request()->phone)->orWhere('phone_number', request()->phone)->first();

        if($data)
        {   
            $walletData = Wallet::where('user_id', $data->id)->first();

            return json_encode([
                    'status' => 'success', 
                    'msg' => 'referral code.', 
                    'user' => $data,
                    'wallet' => $walletData
                ]);
        }

        return ([
            'status' => 'error', 
            'msg' => 'invalid referral code.', 
            'user' => '',
            'wallet' => ''
        ]);
    }
}
