<?php namespace Pkurg\Customfields\Models;

use Model;

/**
 * Model
 */
class UserTabOrder extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'pkurg_customfields_usertabvalueorder';

    /**
     * @var array Validation rules
     */

    public $rules = [

        'id' => 'max:32',

    ];

    public $messages = [
        'id.max:32' => 'The maximum number of tabs is 32',

    ];
}
