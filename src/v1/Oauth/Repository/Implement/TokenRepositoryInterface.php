<?php

namespace Src\v1\Oauth\Repository\Implement;

interface TokenRepositoryInterface
{
	public static function openTransaction();
	public static function rollbackTransaction();
	public static function commitTransaction();
    public static function getClient($client_id);
    public static function insertClientCredentials($data);
}