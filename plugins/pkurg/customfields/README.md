##Rainlab Blog Custom Fields
####Video manual
!![640x360](//player.vimeo.com/video/341159021)

###Creating group fields

Go to Custom Fields
Create group our cusom field
Set Tab caption and target type page 

![](https://i.ibb.co/L0WRKnM/1-New-Custom-Fields-October-CMS.png)

Adding new fields.

![](https://i.ibb.co/D8bbY8x/2-Edit-Custom-Fields-October-CMS-1.png)

Go to the blog post page and make sure that our fields are available.

![](https://i.ibb.co/Qcg60hX/3-Edit-Blog-post-October-CMS-1.png)


##Using  fields 


**post.getField($name)**  - get field by name


    {{ post.getField('name')}} 
    {{ post.getField('customcolor')}} 
    {{ post.getField('image') | media }} 
    <img src="{{ post.getField('image') | media }}" />


**post.getRepeatField** - get repeated field by name

    {% for item in post.getRepeatField('items') %}
                                      
        <p>{{ item }}</p>
            
    {% endfor %}


##Cms Page
####Video manual
!![640x360](//player.vimeo.com/video/341494401)
###Creating group fields

- Go to Custom Fields.
- Create group our cusom field.
- Set Tab caption and target type page.
- Adding new fields.
- Go to the CMS page and make sure that our fields are available.

![](https://i.ibb.co/svLQK8v/4abc-CMS-October-CMS.png)

##Using  fields 

Simple {{ viewBag.group_fields_name[0].field_name }} where "firstfields" name of field

    {{ viewBag.data[0].richtext | raw  }}
    {{ viewBag.data[0].myitem | raw }}
    <img src="{{ viewBag.data[0].image | media }} " >


    {% for items in viewBag.items %}
                                       
        <p style="color:{{ items.itemcolor }}; font-weight: bold;" >{{ items.item }}</p>
                    
    {% endfor %}


##User custom fields
####Video manual
!![640x360](//player.vimeo.com/video/361549484)
###Creating group fields

- Go to Custom Fields.
- Create group our cusom field.
- Set Tab caption and target type page.
- Adding new fields.

![](https://i.ibb.co/889H7MZ/Edit-Custom-Fields-October-CMS.png)

##Using user custom fields 


    {{ user.getField('first') }}
    {{ user.getField('second') }}


    $user->setField('usercustomfields', [[
            "first" => input('first'),
            "second" => input('second'),
            "photo" => input('photo'),
        ]]
        );



##Example user cabinet  **user.htm**

    title = "user"
    url = "/user"
    layout = "default"
    is_hidden = 0
    robot_index = "index"
    robot_follow = "follow"

    [session]
    security = "all"
    ==
    <?php
    use RainLab\User\Models\User as UserModel;

    function onSave()
    {

        $user = UserModel::where('id', input('id'))->first();
        $user->name = input('name');
        $user->email = input('email');
        $user->password = input('password');
        $user->password_confirmation = input('password_confirmation');
        $user->setField('usercustomfields', [[
            "first" => input('first'),
            "second" => input('second'),
            "photo" => input('photo'),
        ]]
        );

        $user->save();

        Flash::success('Successfully saved!');

    }
    ?>
    ==
    <section id="demo" class="section demos bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center section-title">
                    <br>


                    {% if user %}



                    <form class="" data-request="onSave" data-request-flash >


                       <input name="id" type="text" class="form-control" id="accountName" value="{{ user.id }}" hidden>

                       <div class="form-group">
                        <label for="accountName">Full Name</label>
                        <input name="name" type="text" class="form-control" id="accountName" value="{{ user.name }}">
                    </div>

                    <div class="form-group">
                        <label for="accountEmail">Email</label>
                        <input name="email" type="email" class="form-control" id="accountEmail" value="{{ user.email }}">
                    </div>

                    <div class="form-group">
                        <label for="accountPassword">New Password</label>
                        <input name="password" type="password" class="form-control" id="accountPassword">
                    </div>

                    <div class="form-group">
                        <label for="accountPasswordConfirm">Confirm New Password</label>
                        <input name="password_confirmation" type="password" class="form-control" id="accountPasswordConfirm">
                    </div>


                    <div class="form-group">
                        <label for="accountName">First test field</label>
                        <input name="first" type="text" class="form-control" id="accountName" value="{{ user.getField('first') }}">
                    </div>

                    <div class="form-group">
                        <label for="accountName">Second test field</label>
                        <input name="second" type="text" class="form-control" id="accountName" value="{{ user.getField('second') }}">
                    </div>

                    <div class="form-group">
                        <label for="accountName">Photo</label>

                        <input name="photo" type="text" class="form-control" id="accountName" value="{{ user.getField('photo') }}">

                        <img style="width: 200px" class="form-control" src="{{ user.getField('photo') | media }}">

                    </div>


                    <button type="submit" class="btn btn-default">Save</button>
                </form>

                <p>Hello {{ user.name }}</p>


                {% else %}
                <p>Nobody is logged in</p>
                {% endif %}


            </div>
        </div>
    </div>
    </section>





###API
####Get API key
**Settings->Custom Fields->API KEY**

####List of field groups

GET|HEAD  | api/v1/fields/list 

URL: GET http://oct.pkurg.ru/api/v1/fields/list?key=5d37221eed8a7

Response:

    [
      {
        "id": 3,
        "type": "Blog",
        "name": "wwwwww",
        "custom_fields": [
          {
            "name": "ww",
            "type": "text",
            "caption": "ww",
            "comment": "wwww"
          }
        ],
        "caption": "New Tabwww",
        "created_at": "2019-07-23 06:19:23",
        "updated_at": "2019-07-23 06:19:23"
      },
      {
        "id": 6,
        "type": "Blog",
    .................. and more



###Show by field group id

GET|HEAD  | api/v1/fields/{field}  

URL: GET http://oct.pkurg.ru/api/v1/fields/5?key=5d37221eed8a7

Response:

    {
      "id": 5,
      "type": "Blog",
      "name": "files",
      "custom_fields": [
        {
          "name": "mark",
          "type": "markdown",
          "caption": "My mark",
          "comment": "comment"
        }
      ],
      "caption": "Test New Tab",
      "created_at": "2019-07-23 07:47:48",
      "updated_at": "2019-07-23 07:47:48"
    }



###Create new fields group

POST | api/v1/fields  

URL: POST http://oct.pkurg.ru/api/v1/fields?key=5d37221eed8a7

Payload:

    {  
      "type": "Blog",
      "name": "filwesqqq",
      "custom_fields": [
        {
          "name": "mark",
          "type": "markdown",
          "caption": "My mark",
          "comment": "comment"
        }
      ],
      "caption": "Test New Tab 2"
    }

Response:

    'ok saved'


####Delete fields group

DELETE | api/v1/fields/{field}  

URL: DELETE http://oct.pkurg.ru/api/v1/fields/2?key=5d37221eed8a7

Response:

    'ok deleted'