<?php
namespace App\Util;

use GuzzleHttp\Client;

class Job
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    // Get All
    public function all()
    {
        return $this->endpointRequest('/api/recruitment/positions.json');
    }

    // Detail
    public function detail($id)
    {
        return $this->endpointRequestDetail('/api/recruitment/positions.json', $id);
    }

    // Search
    public function search($params)
    {
        $des = $params['description'];
        $loc = $params['location'];
        $type = $params['type'] ?? NULL;

        if(!is_null($type)){
            // return $this->endpointRequest('/api/recruitment/positions.json?description='.$des.'&location='.$loc);
            return $this->endpointRequestSearch('/api/recruitment/positions.json?description='.$des.'&location='.$loc, $type);
        }else{
            return $this->endpointRequest('/api/recruitment/positions.json?description='.$des.'&location='.$loc);
        }

        
    }

    public function endpointRequestDetail($url, $id)
	{
		try {
			$response = $this->client->get($url);
		} catch (\Exception $e) {
            return [];
		}
		return $this->detail_handler($response->getBody(), $id);
	}

    public function endpointRequest($url)
	{
		try {
			$response = $this->client->get($url);
		} catch (\Exception $e) {
            return [];
		}
		return $this->response_handler($response->getBody());
	}

    public function endpointRequestSearch($url, $type)
	{
		try {
			$response = $this->client->get($url);
		} catch (\Exception $e) {
            return [];
		}
		return $this->search_handler($response->getBody(), $type);
	}

	public function response_handler($response)
	{
		if ($response) {
			return json_decode($response);
		}
		
		return [];
	}

    public function detail_handler($response, $id)
    {
        $data = json_decode($response);
        $len = count($data);
        for($i=0; $i<$len; $i++){
            if($data[$i]->id == $id){
                return $data[$i];
            }
        }
    }

    public function search_handler($response, $type)
    {
        $data = json_decode($response);
        $filter = [];
        $len = count($data);
        for($i=0; $i<$len; $i++){
            if($data[$i]->type == $type){
                $filter[] = $data[$i];
            }
            
        }
        return $filter;
    }

}