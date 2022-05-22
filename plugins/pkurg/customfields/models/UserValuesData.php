<?php namespace Pkurg\Customfields\Models;

use Model;

/**
 * Model
 */
class UserValuesData extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    protected $fillable = ['value', 'value1', 'value2', 'value3', 'value4', 'value5', 'value6', 'value7', 'value8', 'value9', 'value10', 'value11', 'value12', 'value13', 'value14', 'value1', 'value16', 'value17', 'value18', 'value19', 'value20', 'value21', 'value22', 'value23', 'value24', 'value25', 'value26', 'value27', 'value28', 'value29', 'value30', 'value31', 'value32'];

    protected $jsonable = ['value', 'value1', 'value2', 'value3', 'value4', 'value5', 'value6', 'value7', 'value8', 'value9', 'value10', 'value11', 'value12', 'value13', 'value14', 'value1', 'value16', 'value17', 'value18', 'value19', 'value20', 'value21', 'value22', 'value23', 'value24', 'value25', 'value26', 'value27', 'value28', 'value29', 'value30', 'value31', 'value32'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'pkurg_customfields_users_data';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

  public $belongsTo = [
      
         'user' => ['RainLab\User\Models\User'],

    ];

public static function getFromUser($post)
    {
        if ($post->user) {
            return $post->user;
        }

        $blog = new static();

        $blog->user = $post;

        $blog->save();
        $post->user = $blog;

        return $blog;
    }


}
