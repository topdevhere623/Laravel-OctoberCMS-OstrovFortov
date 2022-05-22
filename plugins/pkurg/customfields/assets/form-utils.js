 $( document ).ready(function() {

    $('#Form-field-CustomFields-type').on('change', function() {

        if(this.value=="CMS Page") {

            $( "div[data-field-name='inspector_check']" ).show()

        } else {

            $( "div[data-field-name='inspector_check']" ).hide()
        }

        $( "input[id$='-inspector_check']" ).each(function( index ) {

            if($( this ).prop('checked')) {
                $( this ).click();
            }

        });


    });

});

 setInterval(function(){


    if($('#Form-field-CustomFields-type').val() == 'CMS Page') {

        $( "div[data-field-name='inspector_check']" ).show();

    } else {

        $( "div[data-field-name='inspector_check']" ).hide();

    }


    

    for (var i = $('#Repeater-formCustomFields-items-custom_fields .field-repeater-item').length - 1; i >= 0; i--) {

        
                        
        if ($("#Form-formCustomFieldsForm" + i + "-field-CustomFields-custom_fields-" + i + "-inspector_check").is(':checked')) {

                         
            $("#Form-formCustomFieldsForm" + i + "-field-CustomFields-custom_fields-" + i + "-yaml-group").hide();

        } else {

            $("#Form-formCustomFieldsForm" + i + "-field-CustomFields-custom_fields-" + i + "-yaml-group").show();
        }


        id = "Form-formCustomFieldsForm" + i + "-field-CustomFields-custom_fields-" + i + "-type";

        
        
        if ($('#' + id).val()==='yaml') {

            $("#Form-formCustomFieldsForm" +i+ "-field-CustomFields-custom_fields-" +i+ "-name-group").hide();
            $("#Form-formCustomFieldsForm" +i+ "-field-CustomFields-custom_fields-" +i+ "-caption-group").hide();
            $("#Form-formCustomFieldsForm" +i+ "-field-CustomFields-custom_fields-" +i+ "-comment-group").hide();
            $("#Form-formCustomFieldsForm" +i+ "-field-CustomFields-custom_fields-" +i+ "-default-group").hide();

        } else {

            $("#Form-formCustomFieldsForm" +i+ "-field-CustomFields-custom_fields-" +i+ "-name-group").show();
            $("#Form-formCustomFieldsForm" +i+ "-field-CustomFields-custom_fields-" +i+ "-caption-group").show();
            $("#Form-formCustomFieldsForm" +i+ "-field-CustomFields-custom_fields-" +i+ "-comment-group").show();
            $("#Form-formCustomFieldsForm" +i+ "-field-CustomFields-custom_fields-" +i+ "-default-group").show();

        }

        


    }

}, 500);








// $( "input[id$='-inspector_check']" ).click();    


// if($("#Form-formCustomFieldsForm0-field-CustomFields-custom_fields-0-inspector_check").prop('checked')){
//     $( "#Form-formCustomFieldsForm0-field-CustomFields-custom_fields-0-inspector_check" ).click();    
// }



// $( "input[id$='-inspector_check']" ).click();    

