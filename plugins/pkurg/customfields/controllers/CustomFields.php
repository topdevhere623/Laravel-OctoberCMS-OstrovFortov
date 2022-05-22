<?php namespace Pkurg\Customfields\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use DB;
use Pkurg\Customfields\Models\CustomFields as FielsModel;
use Request;
use Response;

class CustomFields extends Controller
{
    //public $implement = ['Backend\Behaviors\ListController', 'Backend\Behaviors\FormController', 'Backend.Behaviors.RelationController'];

    public $implement = ['Backend\Behaviors\ListController', 'Backend\Behaviors\FormController'];

    //'Backend\Behaviors\ReorderController',

    public $requiredPermissions = ['pkurg.cardslider.manage_fields'];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    //public $reorderConfig = 'config_reorder.yaml';
    //public $relationConfig = 'config_relation.yaml';

    public function formExtendFieldsBefore(\Backend\Widgets\Form $host)
    {

        if (class_exists('\Editor\Controllers\Index')) {

            $configFile = __DIR__ . '/customfields/fields2.yaml';

            $config = \Yaml::parse(\File::get($configFile));

            $host->fields = $config['fields'];
        }

    }

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('pkurg.Customfields', 'main-menu-item');
        if (class_exists('\Editor\Controllers\Index')) {
            //$this->addjs("/plugins/pkurg/customfields/assets/form-utils.js", "Pkurg.Customfields");
            $this->addjs("/plugins/pkurg/customfields/assets/form-utils.js?" . uniqid());
        }

    }

    function list() {

        $res = FielsModel::get();

        return Response::json($res);
    }

    public function onExport()
    {

        $fields = DB::table('pkurg_customfields_fields')->where('type', 'Blog')->get();
        $data = DB::table('pkurg_customfields_value_data')->get();
        $tabdata = DB::table('pkurg_customfields_tabvalueorder')->get();
        $posts = DB::table('rainlab_blog_posts')
            ->select(['id', 'slug'])
            ->get();

        $export = array();

        $export['fields'] = $fields;
        $export['data'] = $data;
        $export['tabdata'] = $tabdata;
        $export['posts'] = $posts;

        $data = json_encode($export);

        return response($data)
            ->withHeaders([
                'Content-Type' => 'text/plain',
                'Cache-Control' => 'no-store, no-cache',
                'Content-Disposition' => 'attachment; filename="' . time() . '-export.txt',
            ]);

    }

    public function show($id)
    {

        $res = FielsModel::where('id', $id)->first();

        return Response::json($res);
    }

    public function destroy($id)
    {

        $CF = FielsModel::find($id);
        $CF->delete();
        return 'ok deleted';

    }

    public function store(Request $request)
    {

        $payLoad = json_decode(request()->getContent(), true);

        $payLoad['custom_fields'];

        $CF = new FielsModel;
        $CF->type = $payLoad['type'];
        $CF->custom_fields = $payLoad['custom_fields'];
        $CF->name = $payLoad['name'];
        $CF->caption = $payLoad['caption'];
        $CF->save();

        return 'ok saved';

    }

}
