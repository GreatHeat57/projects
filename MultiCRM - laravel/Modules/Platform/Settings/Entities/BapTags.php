<?php
/**
 * Created by PhpStorm.
 * User: laravel-bap.com
 * Date: 29.12.18
 * Time: 11:14
 */

namespace Modules\Platform\Settings\Entities;


use HipsterJazzbo\Landlord\BelongsToTenants;
use Modules\Platform\Settings\Tags\Tag;

/**
 * Modules\Platform\Settings\Entities\BapTags
 *
 * @property int $id
 * @property string $name
 * @property string|null $type
 * @property int|null $order_column
 * @property int|null $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Settings\Tags\Tag containing($name)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Settings\Entities\BapTags newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Settings\Entities\BapTags newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Settings\Tags\Tag ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Settings\Entities\BapTags query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Settings\Entities\BapTags whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Settings\Entities\BapTags whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Settings\Entities\BapTags whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Settings\Entities\BapTags whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Settings\Entities\BapTags whereOrderColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Settings\Entities\BapTags whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Settings\Entities\BapTags whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Settings\Tags\Tag withType($type = null)
 * @mixin \Eloquent
 */
class BapTags extends Tag
{
    use BelongsToTenants;

    public $table = 'tags';
}