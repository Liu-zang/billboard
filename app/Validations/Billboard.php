<?php

namespace App\Validations;

class Billboard
{
    /**
     * create
     *
     * @param  Array $request
     * @return Array
     */
    public static function create($request = null)
    {
        return [
            'rule' => [
                'typeId' => 'required|integer',
                'title' => 'required|string|max:50',
            ]
        ];
    }
}
