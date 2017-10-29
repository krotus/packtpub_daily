<?php

namespace PacktpubDaily\libraries;


class Config
{
    const DELIMITER = '.';

    public static function get($key)
    {
        self::_checkConfig();
        $value = null;
        try {
            $settings = include(CONFIG);
            $exploded = explode(self::DELIMITER, $key);
            $limit = sizeof($exploded);
            $search = end($exploded);
            $value = self::_searchArrayValueByKey($settings, $search, $limit);
        } catch (\Exception $e) {
            throw new \Exception('Something was wrong getting the key value of config:' . $e->getMessage() . PHP_EOL );
        }
        return $value;
    }


    private function _checkConfig()
    {
        // Load the config file
        if (!file_exists(CONFIG)) {
            throw new \Exception('The config file does not exist, required: ' . CONFIG . PHP_EOL );
        }
    }

    /**
     * @param $array
     * @param $search
     * @param $length
     * @return mixed|null
     */
    private function _searchArrayValueByKey($array, $search, $length) {
        $recursive = new \RecursiveArrayIterator($array);
        $iterator = new \RecursiveIteratorIterator($recursive, \RecursiveIteratorIterator::SELF_FIRST);
        foreach ($iterator as $key => $value) {
            $depth = $iterator->getDepth();
            $childDepth = $depth + 1;
            if ($search === $key && $childDepth == $length) {
                return $value;
            }
        }
        return null;
    }
}