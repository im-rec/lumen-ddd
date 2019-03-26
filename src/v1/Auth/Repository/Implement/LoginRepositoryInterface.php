<?php

namespace Src\v1\Auth\Repository\Implement;

interface LoginRepositoryInterface
{
	public static function openTransaction();
	public static function rollbackTransaction();
	public static function commitTransaction();
    public static function getDataUser($email);
}