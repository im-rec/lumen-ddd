<?php

namespace Lib;

use Illuminate\Support\Facades\Redis;

class RedisLib
{

    private $redis;

    /**
     * Untuk proses hash set redis
     *
     */
    public function set($key, $expiry, $index, $data)
    {
        // Set redis expired
        Redis::hSet($key, $index, json_encode($data));

        if (!empty($expiry)) {
            Redis::expire($key, intval($expiry));
        }

        return self::get($key);
    }

    /**
     * Untuk proses hash set multi redis
     *
     */
    public function setMulti($key, $expiry, $data)
    {
        // Set redis expired
        if (!empty($data)) {
            foreach ($data as $dkey => $dval) {
                Redis::hSet($key, $dkey, json_encode($dval));
            }
        }

        if (!empty($expiry)) {
            Redis::expire($key, intval($expiry));
        }

        return self::get($key);
    }

    /**
     * Untuk proses hash set extend redis
     *
     */
    public function setExtend($key, $index, $data)
    {
        // extend current key
        return Redis::hSet($key, $index, json_encode($data));
    }

    /**
     * Untuk proses set redis
     *
    */
    public function setSingle($key, $expiry, $data)
    {
        // Set redis expired
        Redis::set($key, json_encode($data));

        if (!empty($expiry)) {
            Redis::expire($key, intval($expiry));
        }

        return self::getSingle($key);
    }

    /**
     * Untuk get value redis by hash keys
     *
     */
    public function get($key, $convertArray = false)
    {
        $result     = Redis::hGetall($key);
        foreach ($result as $key => $value) {
            $result[$key] = $convertArray ? json_decode($value, true) : json_decode($value);
        }
        return $result;
    }

    /**
     * Untuk get value redis by hash keys per index
     *
     */
    public function getIndex($key, $index)
    {
        $indexValue = Redis::hGet($key, $index);
        return $indexValue ? json_decode($indexValue) : [];
    }

    /**
     * Untuk proses get redis
     *
     */
    public function getSingle($key)
    {
        return json_decode(Redis::get($key));
    }

    /**
     * Untuk proses delete redis by hash keys
     *
     */
    public function delete($key, $index)
    {
        Redis::hDel($key, $index);
        return self::get($key);
    }

    /**
     * Untuk proses delete redis by hash keys
     *
     */
    public function deleteMulti($key, $index)
    {
        if (!empty($index)) {
            foreach ($index as $value) {
                Redis::hDel($key, $value);
            }
        }
        return self::get($key);
    }

    /**
     * Untuk proses delete redis
     *
     */
    public function deleteAll($key)
    {
        return Redis::del($key);
    }

    /**
     * Untuk cek existing hash key redis
     *
     */
    public function exists($key, $index)
    {
        return Redis::hExists($key, $index);
    }

    /**
     * Untuk rename existing key
     *
     */
    public function rename($old_key, $new_key)
    {
        return Redis::rename($old_key, $new_key);
    }

    /**
     * Untuk proses set expire key redis
     *
     */
    public function expire($key, $expiry)
    {
        return Redis::expire($key, intval($expiry));
    }
}

