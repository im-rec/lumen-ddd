<?php

namespace Src\v1\Auth\Repository;

use  Src\v1\Auth\Repository\Implement\LoginRepositoryInterface;

use Illuminate\Database\Eloquent\Model;

use DB;

class LoginRepository extends Model implements LoginRepositoryInterface {
	public static function openTransaction() {
		DB::connection('write')->beginTransaction();
	}

	public static function rollbackTransaction() {
		DB::connection('write')->rollBack();
	}

	public static function commitTransaction() {
		DB::connection('write')->commit();
	}

	public static function getDataUser($email){
		return DB::table('user')
				->select(DB::raw('id_user, email, password, name'))
				->where('email', '=', $email)
				->first();
	}
}