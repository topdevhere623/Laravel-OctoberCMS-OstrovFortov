<?php namespace Pkurg\Customfields\Models;

use Model;

/**
 * Model
 */
class TabOrder extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'pkurg_customfields_tabvalueorder';

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
