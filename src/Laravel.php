<?php

namespace fffaraz\Utils;

class Laravel
{
    // https://stackoverflow.com/questions/45582882/laravel-how-to-check-redis-availability
    public static function isDatabaseReady($connection = null)
    {
        $isReady = true;
        try {
            \Illuminate\Support\Facades\DB::connection($connection)->getPdo();
        } catch (\Exception $e) {
            $isReady = false;
        }
        return $isReady;
    }

    public static function isRedisReady($connection = null)
    {
        $isReady = true;
        try {
            $redis = \Illuminate\Support\Facades\Redis::connection($connection);
            $redis->connect();
            $redis->disconnect();
        } catch (\Exception $e) {
            $isReady = false;
        }
        return $isReady;
    }

    public static function getSQL($query) // Laravel Eloquent ORM to SQL
    {
        // $sql = \Illuminate\Support\Str::replaceArray('?', $query->getBindings(), $query->toSql());
        $sql = $query->toSql();
        foreach($query->getBindings() as $binding)
        {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        return $sql;
    }
}
