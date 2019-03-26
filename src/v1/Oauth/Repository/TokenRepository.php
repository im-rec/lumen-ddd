<?php

namespace Src\v1\Oauth\Repository;

use  Src\v1\Oauth\Repository\Implement\TokenRepositoryInterface;

use Illuminate\Database\Eloquent\Model;

use DB;

class TokenRepository extends Model implements TokenRepositoryInterface {
	
	public static function openTransaction() {
		DB::connection('write')->beginTransaction();
	}

	public static function rollbackTransaction() {
		DB::connection('write')->rollBack();
	}

	public static function commitTransaction() {
		DB::connection('write')->commit();
	}

	public static function getClient($client_id){
		return DB::table('oauth_client')
				->select(DB::raw('client_id, client_secret'))
				->where('client_id', '=', $client_id)
				->where('status', '=', GetReferential('oauth_client', 'status', 'ENABLED'))
				->first();
	}

	public static function insertClientCredentials($data){
		try {
			DB::connection('write')->table('oauth_client')->insert($data);
			return true;
		} catch (\Illuminate\Database\QueryException $e) {
		    return false;
		}
	}
}