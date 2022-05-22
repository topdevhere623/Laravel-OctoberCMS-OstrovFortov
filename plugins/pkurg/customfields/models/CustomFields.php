<?php namespace Pkurg\Customfields\Models;

use Cms\Classes\Page as Pg;
use Cms\Classes\Theme;
use Model;
use pkurg\Customfields\Models\TabOrder;
use pkurg\Customfields\Models\UserTabOrder;
use pkurg\Customfields\Models\UserValuesData;
use pkurg\Customfields\Models\ValuesData;

/**
 * Model
 */
class CustomFields extends Model
{

    use \October\Rain\Database\Traits\Validation;

    public $befovalidate = true;

    //use \October\Rain\Database\Traits\SoftDelete;

    //protected $dates = ['deleted_at'];

    protected $jsonable = ['custom_fields', 'page'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'pkurg_customfields_fields';

    public $messages = [
        'maxtabcounts' => 'The :attribute field is required.',

    ];

    /**
     * @var array Validation rules
     */

    public $rules = [

        'name' => 'required|alpha|regex:/^[a-z]+$/u|max:25|regex:/^\S*$/u | not_in:content,title,url,layout,is_hidden,code|unique:pkurg_customfields_fields',

        'caption' => 'required|unique:pkurg_customfields_fields',

        'type' => 'required|maxtabcounts:type',

    ];

    // public function filterFields($fields, $context = null)
    // {

    //     if (property_exists($fields, 'custom_fields')) {

    //         $fields->custom_fields->hidden = true;
    //         //dd();
    //         // $fields->custom_fields->config['form']['fields']['inspector_check']['hidden'] = true;
    //         // dd($fields->custom_fields->config['form']['fields']['inspector_check']);

    //         // if ($fields->type == 'CMS Page') {
    //         //     dd($fields);
    //         // }

    //     }

    //     //if ($fields->type->value == 'CMS Page') {
    //     //if ($this->type == 'CMS Page') {

    //     // if (property_exists($fields, 'inspector_check')) {

    //     //     //dd($fields);
    //     //     //dump($fields->type);
    //     //     //dump($fields->inspector_check);
    //     //     //$fields->inspector_check->hidden = true;

    //     //     //dump(property_exists($fields, 'inspector_check'));
    //     // }

    //     //dd($fields->custom_fields->value);

    //     // foreach ($fields->custom_fields as $item) {

    //     //     dd($item->inspector_check);
    //     //     $item->inspector_check->hidden = false;
    //     // }

    //     //}

    // }

    public function getTableName()
    {
        return $this->table;

    }

    public function getPageOptions()
    {

        $pageslist = array();

        $theme = Theme::getEditTheme();
        $pages = Pg::listInTheme($theme, true);

        foreach ($pages as $item) {

            $pageslist[$item->fileName] = $item->fileName;

        }

        return $pageslist;

    }

    public function afterSave()
    {

        if ($this->type == 'User') {

            $tabscout = CustomFields::where('type', 'User')->count();
            $ordercount = UserTabOrder::get()->count();

            if ($tabscout > $ordercount) {

                $TabOrder = new UserTabOrder;
                $TabOrder->tabname = $this->id;
                $TabOrder->save();

            } else {

                if (!(UserTabOrder::where('tabname', $this->id)->first())) {

                    $TabOrder = UserTabOrder::where('tabname', '')->first();
                    $TabOrder->tabname = $this->id;
                    $TabOrder->save();

                }

            }
        }

        if ($this->type == 'Blog') {

            $tabscout = CustomFields::where('type', 'Blog')->count();

            $ordercount = TabOrder::get()->count();

            if ($tabscout > $ordercount) {

                $TabOrder = new TabOrder;
                $TabOrder->tabname = $this->id;
                $TabOrder->save();

            } else {

                if (!(TabOrder::where('tabname', $this->id)->first())) {

                    $TabOrder = TabOrder::where('tabname', '')->first();
                    $TabOrder->tabname = $this->id;
                    $TabOrder->save();

                }

            }
        }

        if ($this->type == 'CMS Page') {

            $columnValue = TabOrder::where('tabname', $this->id)->pluck('id');

            foreach ($columnValue as $value) {

                $TabOrder = TabOrder::find($value);
                $TabOrder->tabname = '';
                $TabOrder->save();

            }

        }

    }

    public function afterDelete()
    {

        if ($this->type == 'User') {
            $TabOrder = UserTabOrder::where('tabname', $this->id)->first();
            $TabOrder->tabname = '';
            $TabOrder->save();

            $columnValue = UserValuesData::all()->pluck('id');

            foreach ($columnValue as $value) {

                $ValuesData = UserValuesData::find($value);
                $val = 'value' . $TabOrder->id;
                $ValuesData->$val = '';
                $ValuesData->save();

            }
        }

        if ($this->type == 'Blog') {
            $TabOrder = TabOrder::where('tabname', $this->id)->first();
            $TabOrder->tabname = '';
            $TabOrder->save();

            $columnValue = ValuesData::all()->pluck('id');

            foreach ($columnValue as $value) {

                $ValuesData = ValuesData::find($value);
                $val = 'value' . $TabOrder->id;
                $ValuesData->$val = '';
                $ValuesData->save();

            }
        }

    }

    public function beforeValidate()
    {

        // if ($this->befovalidate) {

        $this->rules['custom_fields'] = 'required';

        foreach ($this->custom_fields as $index => $custom_fieldsItem) {

            //if yaml field type
            if ($custom_fieldsItem['type'] != 'yaml') {

                $this->rules['custom_fields.' . $index . '.name'] = 'required|alpha|regex:/^[a-z]+$/u|max:25|regex:/^\S*$/u | not_in:content,title,url,layout,is_hidden,code'; //varname

            }

        }
        //}

    }
}
