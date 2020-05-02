<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\GroupTask
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|GroupTask newModelQuery()
 * @method static Builder|GroupTask newQuery()
 * @method static Builder|GroupTask query()
 * @method static Builder|GroupTask whereCreatedAt($value)
 * @method static Builder|GroupTask whereId($value)
 * @method static Builder|GroupTask whereName($value)
 * @method static Builder|GroupTask whereUpdatedAt($value)
 * @method static truncate()
 * @method static create(array $array)
 * @mixin Eloquent
 */
class GroupTask extends Model
{
    protected $table = 'groups';
    protected $guarded = [];
}
