<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * This is the model class for collection "configs".
 *
 * @property string $id
 * @property string $key
 * @property string $value
 * @property string $type
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class Config extends Model
{
    use HasFactory;

    /**
     * Name of model's table.
     *
     * @var array
     */
    protected $table = "configs";

    /**
     * The attributes that not assigned a value.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * sanitize key before save.
     */
    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = strip_tags($value);
    }

    /**
     * sanitize value before save.
     */
    public function setValueAttribute($value)
    {
        switch ($this->type) {
            case 'boolean':
                $value = ($value == 'false' || $value == '0') ? false : $value;
                $value = ($value == 'true' || $value == '1') ? true : $value;
                break;
            case 'integer':
                $value = intval($value);
                break;
            case 'string':
                $value = strip_tags($value);
                break;
            case 'array':
                $value = json_encode($value, JSON_UNESCAPED_SLASHES);
                break;
        }
        $this->attributes['value'] = $value;
    }

    /**
     * change value response base type.
     */
    public function getValueAttribute($value)
    {
        switch ($this->type) {
            case 'boolean':
                $value = ($value == 'true' || 1) ? true : $value;
                $value = ($value == 'false' || 0) ? false : $value;
                break;
            case 'integer':
                $value = intval($value);
                break;
            case 'string':
                $value = htmlentities($value);
                break;
            case 'array':
                $value = preg_replace('/\n|""/', "", json_decode($value));
                break;
        }
        return $value;
    }

}
