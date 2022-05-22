<?php namespace Pkurg\Customfields\Controllers;

use Backend\Classes\Controller;
use Config;
use Input;
use Pkurg\Customfields\Models\CustomFields as FieldsModel;
use pkurg\Customfields\Models\TabOrder;
use pkurg\Customfields\Models\ValuesData as BlogModel;
use RainLab\Blog\Models\Post;
use Response;
use View;

class BlogFieldsImport extends Controller
{
    public $implement = [];

    public $pageTitle = 'Import Blog Custom Fields with Data';

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $backendURL = Config::get('cms.backendUri');

        $this->addCSS('/plugins/pkurg/customfields/assets/dropzone.css');

        return View::make('pkurg.customfields::importfields', ['this' => $this, 'id' => uniqid(), 'backendURL' => $backendURL]);

    }

    public function uploadFiles($id)
    {

        $input = Input::all();

        $file = Input::file('file');

        if (!Input::hasFile('file')) {

            return Response::json(array('message' => 'no file'), 401);
        }

        if (!(Input::file('file')->isValid())) {

            return Response::json(array('message' => 'Invalid file'), 401);

        }

        $data = file_get_contents($file->getRealPath());

        $jsonData = json_decode($data);
        if (!$jsonData) {
            return Response::json(array('message' => 'Invalid file'), 401);
        }

        $q = $this->generateRandomString();
        $un = uniqid();

        $ids = array();

        foreach ($jsonData->fields as $value) {

            $field = new FieldsModel;
            $field->befovalidate = false;
            $field->custom_fields = json_decode($value->custom_fields);
            $field->type = $value->type;
            $field->name = $value->name . $q;
            $field->caption = $value->caption . ' imported-' . $un;
            $field->maxitems = $value->maxitems;
            $field->save();

            $ids[$value->id] = $field->id;

        }

        foreach ($jsonData->data as $key => $value) {

            //get new post id
            foreach ($jsonData->posts as $postkey => $postvalue) {

                $slug = null;
                if ($postvalue->id == $value->post_id) {

                    $slug = $postvalue->slug;
                    break;

                }

            }

            $newpost = Post::where('slug', $slug)->first();

            if (!$newpost) {
                $post_id = null;
            } else {

                $post_id = $newpost->id;
            }

            $v = BlogModel::where('post_id', $post_id)->first();

            if (!$v) {
                $v = new BlogModel;
            }

            //get old value number
            foreach ($ids as $kk => $vv) {

                foreach ($jsonData->tabdata as $tabkey => $tabvalue) {

                    if ($tabvalue->tabname == $kk) {

                        $oldvalueNumber = $tabvalue->id;
                        break;

                    }

                }

                //get new value number

                $tabdata = TabOrder::get();

                foreach ($tabdata as $tabkey => $tabvalue) {

                    if ($tabvalue->tabname == $vv) {

                        $newvalueNumber = $tabvalue->id;
                        break;

                    }

                }

                $old = 'value' . $oldvalueNumber;
                $newvalue = 'value' . $newvalueNumber;

                $v->$newvalue = json_decode($value->$old);

            }

            //get new post id
            foreach ($jsonData->posts as $postkey => $postvalue) {

                $slug = null;
                if ($postvalue->id == $value->post_id) {

                    $slug = $postvalue->slug;
                    break;

                }

            }

            $newpost = Post::where('slug', $slug)->first();

            if (!$newpost) {
                $v->post_id = null;
            } else {

                $v->post_id = $newpost->id;
            }

            $v->save();

        }

    }

    public function generateRandomString($length = 5)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
