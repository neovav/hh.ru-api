<?php
namespace HHruApi;

use ReflectionClass;

/**
 * Class utils for convert properties classes to string
 */
class Utils
{
    /**
     * Getting public properties form class and convert to uri queries
     *
     * @param object $class
     *
     * @return string
     *
     * @throws
     */
    public static function convertClassToUriQuery($class): string
    {
        if (!is_object($class)) {
            throw new \Exception('Parameter is not class');
        }

        $queries = [];

        $reflect = new ReflectionClass($class);

        $props   = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($props as $prop) {
            $name = $prop->getName();
            $value = $class->$name;
            if (!empty($value)) {
                if (is_array($value)) {
                    foreach ($value as $val) {
                        $queries[] = $name . '=' . urlencode($val);
                    }
                } else {
                    $queries[] = $name . '=' . urlencode($value);
                }
            }
        }

        $result = '';

        if (!empty($queries)) {
            $result = implode('&', $queries);
        }

        return $result;
    }

    /**
     * Getting public properties form class and convert to json
     *
     * @param object $class
     *
     * @return string
     *
     * @throws
     */
    public static function convertClassToJson($class): string
    {
        if (!is_object($class)) {
            throw new \Exception('Parameter is not class');
        }

        $query = [];

        $reflect = new ReflectionClass($class);

        $props   = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($props as $prop) {
            $name = $prop->getName();
            $value = $class->$name;
            if (!empty($value)) {
                $query[$name] = $value;
            }
        }

        if (empty($query)) {
            throw new \Exception('Empty data for public vacancy');
        }

        return json_encode($query);
    }
}