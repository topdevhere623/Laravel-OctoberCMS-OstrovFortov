<?php

namespace Pkurg\Customfields;

use Cms\Classes\Theme;
use Event;
use Illuminate\Support\Facades\Schema;
use pkurg\Customfields\Models\CustomFields;
use Pkurg\Customfields\Models\Settings;
use pkurg\Customfields\Models\TabOrder;
use pkurg\Customfields\Models\UserTabOrder;
use pkurg\Customfields\Models\UserValuesData as UserDataModel;
use pkurg\Customfields\Models\ValuesData as BlogModel;
use RainLab\Blog\Controllers\Posts as PostsController;
use RainLab\Blog\Models\Post as PostModel;
use RainLab\User\Controllers\Users as UserController;
use RainLab\User\Models\User as UserModel;
use Symfony\Component\Yaml\Exception\ParseException;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use Validator;

class Plugin extends PluginBase
{
    public $reapeterb = array();
    public $reapeterp = array();
    public $reapeteru = array();

    public $maxBlogCustomTab = 32;

    public $reapeterIndex = 1;
    public $reapeterIndexPage = 1;
    public $reapeterIndexUser = 1;

    public $reapeterpname = array();

    public function registerPermissions()
    {
        return [
            'pkurg.cardslider.manage_fields' => [
                'tab' => 'Custom fields',
                'label' => 'Manage Custom fields',
            ],

        ];
    }

    public function registerSettings()
    {

        return [
            'settings' => [
                'label' => 'Custom Fields',
                'description' => 'Manage Custom Fields settings.',
                'category' => SettingsManager::CATEGORY_CMS,
                'icon' => 'icon-bars',
                'class' => 'Pkurg\Customfields\Models\Settings',
                'order' => 500,
                'permissions' => ['pkurg.cardslider.manage_fields'],

            ],
        ];
    }

    public function registerComponents()
    {
    }

    public function registerMarkupTags()
    {
    }

    public function genFields($field)
    {

        if (class_exists(UserModel::class)) {

            if ('User' == $field->type) {

                $tabOrderId = UserTabOrder::where('tabname', $field->id)->first();

                foreach ($field->custom_fields as $value) {
                    if ($value['type'] == 'yaml') {

                        $find = array("\t");
                        $replace = array('    ');
                        $s = str_replace($find, $replace, $value['yaml']);

                        try {

                            $config = \Yaml::parse($s);

                        } catch (ParseException $exception) {

                            $config = [
                                'ferr' => [
                                    'type' => 'section',
                                    'comment' => 'Field yaml parse error ' . $exception->getMessage(),
                                ],
                            ];
                        }

                        if ($config) {
                            foreach ($config as $key => &$i) {

                                $i['cssClass'] = 'repeater-control-pkurg';
                                $fieldData[$key] = $i;
                            }
                        }

                    } else {

                        $value['label'] = $value['caption'];

                        if ($value['type'] == 'mediafinder') {
                            $value['mode'] = 'image';
                        }
                        $value['cssClass'] = 'repeater-control-pkurg';
                        $fieldData[$value['name']] = $value;

                    }
                }

                $FormFieldsData['fields'] = $fieldData;
                $form['form'] = $FormFieldsData;
                $form['tab'] = $field->caption;
                $form['cssClass'] = 'repeater-pkurg';
                $form['type'] = 'repeater';
                $form['maxItems'] = $field->maxitems;

                $terb['user[value' . $tabOrderId->id . ']'] = $form;

                $this->reapeteru[$this->reapeterIndexUser] = $terb;

                $this->reapeterIndexUser++;

            }
        }

        if (class_exists(PostModel::class)) {

            if ('Blog' == $field->type) {

                $tabOrderId = TabOrder::where('tabname', $field->id)->first();

                foreach ($field->custom_fields as $value) {

                    if ($value['type'] == 'yaml') {

                        $find = array("\t");
                        $replace = array('    ');
                        $s = str_replace($find, $replace, $value['yaml']);

                        try {

                            $config = \Yaml::parse($s);

                        } catch (ParseException $exception) {

                            $config = [
                                'ferr' => [
                                    'type' => 'section',
                                    'comment' => 'Field yaml parse error ' . $exception->getMessage(),
                                ],
                            ];
                        }

                        if ($config) {
                            foreach ($config as $key => &$i) {

                                $i['cssClass'] = 'repeater-control-pkurg';
                                $fieldData[$key] = $i;
                            }
                        }

                    } else {

                        $value['label'] = $value['caption'];

                        if ($value['type'] == 'mediafinder') {
                            $value['mode'] = 'image';
                        }
                        $value['cssClass'] = 'repeater-control-pkurg';
                        $fieldData[$value['name']] = $value;

                    }
                }

                $FormFieldsData['fields'] = $fieldData;
                $form['form'] = $FormFieldsData;
                $form['tab'] = $field->caption;
                $form['cssClass'] = 'repeater-pkurg';
                $form['type'] = 'repeater';
                $form['maxItems'] = $field->maxitems;

                $terb['blog[value' . $tabOrderId->id . ']'] = $form;

                $this->reapeterb[$this->reapeterIndex] = $terb;

                $this->reapeterIndex++;

            }
        }

        if ('CMS Page' == $field->type) {
            foreach ($field->custom_fields as $value) {

                if (($value['type'] == 'yaml') and ($value['inspector_check']=="0")) {

                    $find = array("\t");
                    $replace = array('    ');
                    $s = str_replace($find, $replace, $value['yaml']);

                    try {

                        $config = \Yaml::parse($s);

                    } catch (ParseException $exception) {

                        $config = [
                            'ferr' => [
                                'type' => 'section',
                                'comment' => 'Field yaml parse error ' . $exception->getMessage(),
                            ],
                        ];
                    }

                    if ($config) {
                        foreach ($config as $key => &$i) {

                            $i['cssClass'] = 'repeater-control-pkurg';
                            $fieldData[$key] = $i;
                        }
                    }

                } else {

                    $value['label'] = $value['caption'];
                    if ($value['type'] == 'mediafinder') {
                        $value['mode'] = 'image';
                    }
                    $value['tab'] = $field->caption;
                    $value['containerAttributes'] = ['repit' => 'CMSPage'];

                    $value['cssClass'] = 'repeater-control-pkurg';
                    $fieldData[$value['name']] = $value;
                }
            }

            $FormFieldsData['fields'] = $fieldData;
            $form['form'] = $FormFieldsData;
            $form['tab'] = $field->caption;
            $form['cssClass'] = 'repeater-pkurg-page';
            $form['type'] = 'repeater';
            $form['maxItems'] = $field->maxitems;
            $terb['viewBag[' . $field->name . ']'] = $form;

            $this->reapeterp[$this->reapeterIndexPage] = $terb;

            $this->reapeterpname[$this->reapeterIndexPage] = $field->page;

            $this->reapeterIndexPage++;

        }
    }

    public function register()
    {
    }

    public function boot()
    {

        if (Settings::get('apikey') == '') {

            Settings::set('apikey', uniqid());

        }

//CustomFieldsController::extend(function($controller) {
        \Cms\Classes\CmsController::extend(function ($controller) {
            $controller->middleware('Pkurg\Customfields\Middleware\AuthMiddleware');
        });

        // $this->app['Illuminate\Contracts\Http\Kernel']
        // ->prependMiddleware('Pkurg\Customfields\Middleware\AuthMiddleware');

        Validator::extend('maxtabcounts', function ($attribute, $value, $parameters) {

            if ($value == 'CMS Page') {
                return true;
            }

            $tabs = CustomFields::where('type', 'Blog')->count();

            return $tabs < $this->maxBlogCustomTab;
        });

        Validator::replacer('maxtabcounts', function ($message, $attribute, $rule, $parameters) {
            return 'You can create only 16 tab for Blog post page type.';
        });

        Event::listen('backend.page.beforeDisplay', function ($controller, $action, $params) {
            $controller->addCSS('/plugins/pkurg/customfields/assets/main.css');
            $controller->addJS('/plugins/pkurg/customfields/assets/main.js');
        });

        //Extend User model
        if (class_exists(UserModel::class)) {
            UserModel::extend(function ($model) {
                $model->hasOne['user'] = ['Pkurg\Customfields\Models\UserValuesData', 'key' => 'user_id'];

            });

            UserModel::extend(function ($model) {

                $model->addDynamicMethod('getRepeatField', function ($name) use ($model) {

                    if ($model->user) {

                        $tabIndexs = UserTabOrder::where('tabname', '!=', '')->pluck('id');

                        foreach ($tabIndexs as $i) {

                            $index = 'value' . $i;

                            if ($model->user->$index) {
                                foreach ($model->user->$index as $key => $value) {
                                    if (array_key_exists($name, $value)) {
                                        return $model->user->$index;
                                    }
                                }
                            }

                        }

                    }

                });

                $model->addDynamicMethod('getField', function ($name) use ($model) {

                    if ($model->user) {

                        $tabIndexs = UserTabOrder::where('tabname', '!=', '')->pluck('id');

                        foreach ($tabIndexs as $i) {

                            $index = 'value' . $i;

                            if ($model->user->$index) {
                                foreach ($model->user->$index as $key => $value) {
                                    if (array_key_exists($name, $value)) {

                                        foreach ($model->user->$index as $key => $value) {
                                            if (array_key_exists($name, $value)) {
                                                return $value[$name];
                                            }
                                        }

                                    }
                                }
                            }

                        }

                    }

                });

                $model->addDynamicMethod('setField', function ($tabname, $data) use ($model) {

                    $vals = new UserDataModel;
                    $model->user()->save($vals);

                    if ($model->user) {

                        $tab = CustomFields::where('name', $tabname)->first();
                        if ($tab) {

                            $tabIndexs = UserTabOrder::where('tabname', $tab->id)->first();

                            $index = 'value' . $tabIndexs->id;

                            $model->user->$index = $data;
                            $model->user->save();

                        }

                    }

                });

            });

        }

        //Extend post model
        if (class_exists(PostModel::class)) {
            PostModel::extend(function ($model) {
                $model->hasOne['blog'] = ['Pkurg\Customfields\Models\ValuesData', 'key' => 'post_id'];

            });

            PostModel::extend(function ($model) {

                $model->addDynamicMethod('getRepeatField', function ($name) use ($model) {

                    if ($model->blog) {

                        $tabIndexs = TabOrder::where('tabname', '!=', '')->pluck('id');

                        foreach ($tabIndexs as $i) {

                            $index = 'value' . $i;

                            if ($model->blog->$index) {
                                foreach ($model->blog->$index as $key => $value) {
                                    if (array_key_exists($name, $value)) {
                                        return $model->blog->$index;
                                    }
                                }
                            }

                        }

                    }

                });

                $model->addDynamicMethod('getField', function ($name) use ($model) {

                    if ($model->blog) {

                        $tabIndexs = TabOrder::where('tabname', '!=', '')->pluck('id');

                        foreach ($tabIndexs as $i) {

                            $index = 'value' . $i;

                            if ($model->blog->$index) {
                                foreach ($model->blog->$index as $key => $value) {
                                    if (array_key_exists($name, $value)) {

                                        foreach ($model->blog->$index as $key => $value) {
                                            if (array_key_exists($name, $value)) {
                                                return $value[$name];
                                            }
                                        }

                                    }
                                }
                            }

                        }

                    }

                });
            });
        }

        $n = new CustomFields();

        if (!Schema::hasTable($n->getTableName())) {return;}

        $CF = CustomFields::get();

        foreach ($CF as $value) {
            $this->genFields($value);
        }

        //Extend User Controller
        foreach ($this->reapeteru as $value) {

            UserController::extendFormFields(function ($form, $model, $context) use ($value) {

                if (!$model instanceof UserModel) {
                    return;
                }

                if (!$model->exists) {
                    return;
                }

                UserDataModel::getFromUser($model);

                if ($form->isNested === false) {

                    $form->addTabFields($value);

                }

            });

        }

        //Extend Post Controller
        foreach ($this->reapeterb as $value) {

            PostsController::extendFormFields(function ($form, $model, $context) use ($value) {
                if (!$model instanceof PostModel) {
                    return;
                }

                if (!$model->exists) {
                    return;
                }

                BlogModel::getFromPost($model);

                if ($form->isNested === false) {
                    $form->addSecondaryTabFields($value);

                }

            });

        }

        $k = 1;
        foreach ($this->reapeterp as $value) {

            //October 2
            if (class_exists('\Editor\Controllers\Index')) {

                $v = array_values($value);

                Event::listen('cms.template.getTemplateToolbarSettingsButtons', function ($extension, $dataHolder) use ($v) {

                    if ($dataHolder->templateType === 'page') {

                        $p = [];
                        $i = [];
                        $properties = [];
                        foreach ($v[0]['form']['fields'] as $field) {

                            if (array_key_exists('inspector_check', $field)) {

                                //User Inspector Data schema configuration
                                if ($field['inspector_check'] == '1') {

                                    $data = json_decode($field['inspector_config'], true);

                                    if (!is_null($data)) {
                                        $p[] = $data;
                                    }

                                } else {

                                    $i['property'] = $field['name'];
                                    $i['title'] = (trim($field['caption']) == '') ? $field['name'] : $field['caption'];
                                    $i['type'] = $field['type'];
                                    $i['default'] = $field['default'];
                                    $p[] = $i;
                                }
                            }
                        }

                        $dataHolder->buttons[] = [
                            'button' => $v[0]['tab'],
                            'icon' => 'icon-bars',
                            'popupTitle' => $v[0]['tab'],
                            'useViewBag' => true,
                            'properties' => $p,

                        ];
                    }
                });

            }

            if (($this->reapeterpname[$k] == null) or ($this->reapeterpname[$k] == 0)) {

                //for all pages

                Event::listen('backend.form.extendFields', function ($widget) use ($value) {

                    if (!$widget->model instanceof \Cms\Classes\Page) {
                        return;
                    }

                    if (!($theme = Theme::getEditTheme())) {
                        throw new ApplicationException(Lang::get('cms::lang.theme.edit.not_found'));
                    }

                    if (false === $widget->isNested) {
                        $widget->addSecondaryTabFields($value);
                    }

                });

            } else {

                if (!$this->reapeterpname[$k] == 0) {

                    //for selected pages

                    Event::listen('backend.form.extendFields', function ($widget) use ($value, $k) {

                        if (!$widget->model instanceof \Cms\Classes\Page) {
                            return;
                        }

                        if ((in_array($widget->model->fileName, $this->reapeterpname[$k]))) {

                            if (!($theme = Theme::getEditTheme())) {
                                throw new ApplicationException(Lang::get('cms::lang.theme.edit.not_found'));
                            }

                            if (false === $widget->isNested) {
                                $widget->addSecondaryTabFields($value);
                            }

                        }

                    });

                }
            }

            $k = $k + 1;

        }

    }

}
