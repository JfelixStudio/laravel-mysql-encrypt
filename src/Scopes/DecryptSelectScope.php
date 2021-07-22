<?php

namespace JfelixStudio\MysqlEncrypt\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;

class DecryptSelectScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $encryptable = $model->encryptable();

        $columns = DB::connection($model->getConnection()->getConfig()["name"])->getSchemaBuilder()->getColumnListing($model->getTable());

        if (empty($columns)) {
            return $builder->addSelect(...$columns);
        }

        $select = collect($columns)->map(function ($column) use ($encryptable) {
            return (in_array($column, $encryptable)) ? db_decrypt($column) : $column;
        });

        return $builder->addSelect(...$select);
    }
}
