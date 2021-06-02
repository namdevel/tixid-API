<?php 
namespace Namdevel;
/*
@ Unofficial TIX ID PHP Class
@ Author : namdevel
@ Created at 03-06-2021 23:26
@ Last Modified at 03-06-2021 00:41
*/
class TixID
{
    const API_URL = 'https://api.tix.id';
    const API_VOUCHER_URL = 'https://api-voucher.tix.id';
    const API_CURATED_URL = 'https://curated.tix.id';
    const CLIENT_SECRET = '123456';
    const DEFAULT_CITY = '967969975509716992';
	
    private $authToken;
	
    public function __construct($token = false)
    {
        if ($token)
        {
            $this->authToken = $token;
        }
    }
	
    public function getPromoBanner()
    {
        return self::Request(self::API_URL . "/v1/content/promo/banner", false, self::buildHeaders());
    }
	
    public function Theaters($cityId = self::DEFAULT_CITY)
    {
        return self::Request(self::API_URL . "/v1/theaters?city_id={$cityId}", false, self::buildHeaders());
    }
	
    public function movieInfo($mid)
    {
        return self::Request(self::API_CURATED_URL . "/v1/app/movie/{$mid}", false, self::buildHeaders());
    }
	
    public function movieSchedule($cityId = self::DEFAULT_CITY, $date = '2021-06-02', $mid = '1394500495057440768', $page = 1)
    {
        return self::Request(self::API_URL . "/v3/schedule?city={$cityId}&date={$date}&lat=&lon=&merchant=&movie={$mid}&page={$page}&q=&sort=alfabetical&studio_type=", false, self::buildHeaders());
    }
	
    public function movieRate($mid)
    {
        return self::Request(self::API_URL . "/v1/movie/additional/{$mid}", false, self::buildHeaders());
    }
	
    public function getVoucher($limit = 10, $page = 1)
    {
        return self::Request(self::API_VOUCHER_URL . "/v1/vouchers?limit={$limit}&page={$page}", false, self::buildHeaders());
    }
	
    public function nowPlaying($cityId = self::DEFAULT_CITY, $total = 7)
    {
        return self::Request(self::API_URL . "/v1/movies/now_playing?city_id={$cityId}&tz={$total}", false, self::buildHeaders());
    }
	
    public function upComing($cityId = self::DEFAULT_CITY)
    {
        return self::Request(self::API_URL . "/v1/movies/upcoming?city_id={$cityId}", false, self::buildHeaders());
    }
	
    public function spotLights($page = 1, $total = 7)
    {
        return self::Request(self::API_CURATED_URL . "/v1.1/app/spotlights?page_number={$page}&tz={$total}", false, self::buildHeaders());
    }
	
    public function showspotLight($sid)
    {
        return self::Request(self::API_CURATED_URL . "/v2/app/spotlight/{$sid}?user_id=", false, self::buildHeaders());
    }
	
    public function relatedSpotlight($cid)
    {
        return self::Request(self::API_CURATED_URL . "/v2/app/contents/recommend?content_id={$cid}&recommend_name=article&tag_name=Spotlight&type=4", false, self::buildHeaders());
    }
	
    public function getCities()
    {
        return self::Request(self::API_URL . '/v1/cities', false, self::buildHeaders());
    }
	
    public function tixNow($cityId = self::DEFAULT_CITY, $page = 1, $total = 7)
    {
        return self::Request(self::API_CURATED_URL . "/v1/app/now/list?city_id={$cityId}&page={$page}&tz={$total}&user_id=", false, self::buildHeaders());
    }
	
    public function showTixNow($aid)
    {
        return self::Request(self::API_CURATED_URL . "/v2/app/article/{$aid}?user_id=", false, self::buildHeaders());
    }
	
    public function getAuthToken()
    {
        return self::Request(self::API_URL . '/v1/token', true, self::buildHeaders('Client-Secret: ' . self::CLIENT_SECRET));
    }
	
    protected function Request($url, $post = false, $headers = false)
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        ));
        if ($post)
        {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        }
        if ($headers)
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
	
    protected function buildHeaders($data = false)
    {
        $headers = array(
            'Content-Type: application/json',
            'Connection: keep-alive',
            'Accept: */*',
            'User-Agent: TIX%20ID/1 CFNetwork/1220.1 Darwin/20.3.0',
            'Accept-Language: id'
        );
        if ($data)
        {
            array_push($headers, $data);
        }
        if ($this->authToken)
        {
            array_push($headers, 'Authorization: Bearer ' . $this->authToken);
        }
        return $headers;
    }
}
