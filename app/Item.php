<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'age',
        'sex',
        'memo'
    ];

    /**
     * 名前での絞り込み
     * ローカルスコープを定義する場合、その名前の先頭にはscopeを付けます。
     *
     * @param Builder $query
     * @param string|null $name
     * @return mixed
     */
    public function scopeNameFilter($query, string $name = null){

        if(!$name){
            return $query;
        }

        return $query->where('name', 'like', '%'.$name.'%');
    }

    /**
     * 性別での絞り込み
     *
     * @param Builder $query
     * @param string|null $sex
     * @return mixed
     */
    public function scopeSexFilter($query, string $sex = null){

        if(!$sex){
            return $query;
        }

        return $query->where('sex', $sex);
    }

    /**
     * 備考での絞り込み
     *
     * @param Builder $query
     * @param string|null $memo
     * @return mixed
     */
    public function scopeMemoFilter($query, string $memo = null){

        if(!$memo){
            return $query;
        }

        return $query->where('memo', 'like', '%'.$memo.'%');
    }
}
