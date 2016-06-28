<?php

namespace Api\Server\Services;
use App\Models\ApiCredential;
use App\Models\AccessToken;
class OAuthService {
	/**
	 * Create a new oauth service instance.
	 */
	public function __construct() {
		$this->apiCredential = new ApiCredential();
		$this->accessToken = new AccessToken();
	}

	public function authorize($request)
	{		
		$inputs = $request->all();
		if(!isset($inputs['api_key']) || $inputs['api_key'] == ""){
			return 'API key is required';
		}else if(!isset($inputs['api_secret']) || $inputs['api_key'] == ""){
			return 'API secret is required';	
		}else{
			$api_key    = $inputs['api_key'];
			$api_secret = $inputs['api_secret'];
			$origin     = $request->ip();
			if(!$creds = $this->checkApiKeyAndSecret($api_key ,$api_secret, $request->ip())){
				return 'Invalid API key or secret';
			}else{
				$access_token = str_random(25);
				$refresh_token = str_random(25);
				if( null!= $access_tokens  = $this->accessToken->create([
					'api_key_id'    => $creds->id,
					'accessToken'  => $access_token,
					'refresh_token' => $refresh_token,
					'expire_at'     => \Carbon\Carbon::now()->addDays(10),
					'origin'        => $origin
				])){
					return $access_tokens;
				}
			}			
		}
	}

	public function refreshToken($request)
	{				
		$inputs = $request->all();
		if(!isset($inputs['api_key']) || $inputs['api_key'] == ""){
			return 'API key is required';
		}else if(!isset($inputs['api_secret']) || $inputs['api_key'] == ""){
			return 'API secret is required';
		}else if(!isset($inputs['refresh_token']) || $inputs['refresh_token'] == ""){
			return 'Refresh token is required';
		}else{
			$api_key       = $inputs['api_key'];
			$api_secret    = $inputs['api_secret'];
			$refresh_token = $inputs['refresh_token'];
			if(!$creds = $this->checkApiKeyAndSecret($api_key ,$api_secret, $request->ip())){
				return 'Invalid API key or secret';
			}else{
				if(!$access_tokens = $this->checkRefreshToken($creds->id, $refresh_token)){
					return 'Invalid refresh token';
				}else{
					$access_token = str_random(25);
					$refresh_token = str_random(25);
					$expire_at = \Carbon\Carbon::now()->addDays(10);
					$origin    = $request->ip();
					$access_tokens = $access_tokens->update([
						'api_key_id'    => $creds->id,
						'accessToken'  => $access_token,
						'refresh_token' => $refresh_token,
						'expire_at'     => $expire_at,
						'origin'        => $origin
					]);
					if($access_tokens){
						return [
							'access_token'  => $access_token,
							'refresh_token' => $refresh_token,
							'expire_at'     => $expire_at
						];
					}
				}
			}			
		}
	}

	public function passOauth($request)
	{		
		$inputs = $request->all();
		if($request->isMethod('get')){
			$access_token = $request->header('access_token');
			dd($request->header());
		}else{
			$access_token = isset($inputs['access_token']) ? $inputs['access_token'] : null;
		}
		$response = [];
		// if(!isset($inputs['api_key'])){
		// 	$response['errors'] = 'api_key is required';
		// 	return $response;
		// }else if(!isset($inputs['api_secret'])){
		// 	$response['errors'] = 'api_secret is required';
		// 	return $response;			
		// }else 
		if(!isset($access_token)){
			$response['errors'] = 'access_token is required';
			return $response;
		}else{
			// $api_key       = $inputs['api_key'];
			// $api_secret    = $inputs['api_secret'];
			$access_token  = $access_token;
			// if(!$creds = $this->checkApiKeyAndSecret($api_key ,$api_secret, $request->ip())){
			// 	$response['errors'] = 'Invalid api_key or api_secret';
			// 	return $response;				
			// }else{
			if(!$access_tokens = $this->checkAccessToken($request->ip(), $access_token)){
				$response['errors'] = 'Invalid access token';
				return $response;					
			}else{
				$expire_at = \Carbon\Carbon::parse($access_tokens->expire_at);
				if($expire_at->isPast()){
					$response['expire'] = 'Your access token has been expired please refresh it';
					return $response;
				}
			}
		}		
	}
	
	private function checkAccessToken($origin, $access_token)
	{		
		$access_tokens = $this->accessToken
		->where('access_token' , $access_token)
		// ->where('origin', $origin)
		->first();
		return null!= $access_tokens ? $access_tokens : false;
	}

	private function checkApiKeyAndSecret($api_key, $api_secret, $ip)
	{		
		$creds = $this->apiCredential->where(['api_key' => $api_key, 'api_secret' => $api_secret])->first();		
		return null != $creds ? $creds : false;
	}

	private function checkRefreshToken($api_key_id, $refresh_token)
	{
		$access_tokens = $this->accessToken->where(['api_key_id' => $api_key_id, 'refresh_token' => $refresh_token ])->first();
		return null!= $access_tokens ? $access_tokens : false;
	}

}