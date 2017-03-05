<?php

namespace App\Models;

trait SearchTrait
{
    function search($params, $handles = [])
    {
        $query = $this->getQuery();
        if (empty($handles)) {
            return $query;
        }
        $keys = array_keys($handles);
        $keys = array_filter($keys, function ($item) {
            return stripos('__', $item) === false;
        });
        $tmpData = array_fill_keys($keys, null);
        foreach($params as $key => $val){
            $tmpData[$key] = $val;
        }
        $params = $tmpData;
        foreach ($params as $key => $value) {
            if (empty($value)) {
                if (isset($handles["__{$key}__"])) {
                    $handles["__{$key}__"]($query, $value, $params);
                } else {
                    continue;
                }
            } elseif (is_callable($handles[$key])) {
                $handles[$key]($query, $value, $params);
            }
        }
        return $query;
    }
    function params($params, $handles = [])
    {
        $keys = array_keys($handles);
        $keys = array_filter($keys, function ($item) {
            return stripos($item, '__') === false;
        });
        $keys[] = 'pageSize';

        $tmpData = array_fill_keys($keys, null);
        foreach($params as $key => $val){
            $tmpData[$key] = $val;
        }
        return $tmpData;
    }

    function getQuery()
    {
        return self::query();
    }
}
