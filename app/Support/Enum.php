<?php

namespace App\Support;

use Illuminate\Support\Str;

trait Enum
{
    /**
     * Enum property getter
     *
     * @param string $field
     * @return mixed|false
     */
    public static function getEnum(string $field)
    {
        $instance = new static;

        if ($instance->hasEnumProperty($field)) {
            $property = $instance->getEnumProperty($field);

            return $instance->$property;
        }

        return false;
    }

    /**
     * Gets the expected enum property
     *
     * @param string $field
     * @return string
     */
    protected function getEnumProperty(string $field)
    {
        return 'enum' . Str::plural(Str::studly($field));
    }

    /**
     * Gets the enum value by key
     *
     * @param string $field
     * @param mixed $key
     * @return mixed
     */
    protected function getKeyedEnum(string $field, $key)
    {
        return static::getEnum($field)[$key];
    }

    /**
     * Is an enum property defined for the provided field
     *
     * @param string $field
     * @return boolean
     */
    protected function hasEnumProperty(string $field)
    {
        $property = $this->getEnumProperty($field);

        return isset($this->$property) && is_array($this->$property);
    }

    /**
     * Is the provided value a key in the enum
     *
     * @param string $field
     * @param mixed $key
     * @return bool
     */
    protected function isKeyedEnum(string $field, $key)
    {
        return in_array($key, array_keys(static::getEnum($field)), true);
    }

    /**
     * Is the value a valid enum in any way
     *
     * @param string $field
     * @param mixed $value
     * @return bool
     */
    protected function isValidEnum(string $field, $value)
    {
        return $this->isValueEnum($field, $value) ||
        $this->isKeyedEnum($field, $value);
    }

    /**
     * Is the provided value in the enum
     *
     * @param string $field
     * @param mixed $value
     * @return bool
     */
    protected function isValueEnum(string $field, $value)
    {
        return in_array($value, static::getEnum($field));
    }

    /**
     * Return an array with enum value and key.
     *
     * @param  String $field
     * @return void
     */
    public function getEnumJson(string $field)
    {
        if ($enum = $this->getEnum($field)) {
            return collect($enum)->map(function ($item, $key) {
                return [
                    'id' => $key + 1,
                    'name' => $item,
                ];
            });
        }

        return false;
    }
}