(function($){
    $('.dg-activation .act-btn').click(function(e){
        e.preventDefault();
        var $this = $(this);
        var $data = $this.data();
        var parent = $this.parent();

        var apikey = $('.dg-activation #'+ $data.licenseKey +'').val();
        var action = $(this).find(".text").text().toLowerCase();
        var status = $('#'+ $data.effectedKey +'');
        var status_field_value = {
            activate: 'active',
            deactivate : 'deactive'
        };
        var button_action = {
            activate: 'Deactivate',
            deactivate : 'Activate'
        };
        var error_text = {
            "OK" : {
                'activate':"License key activated",
                'deactivate': "License key deactivated"
            },
            "ERROR:MAX" : "Maximum number of activation reached",
            "ERROR:INVALID_LICENSE_KEY" : "Invalid license key",
            "OTHERS"    : "An error has occurred, please retry"
        }

        var data = {
            "action" : action,
            "request" : {
                "apikey"  : apikey,
            }
        }

        if(apikey !== '') {
            $this.addClass('loading');
            $.ajax({
                url: dg_act_options.api_url,
                type:'POST',
                data: data,
                cache: false,
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                crossDomain:true,
                error: function( xhr,status,error ){
                    console.log("From Error: ", xhr);
                    console.log("From Error: ", status);
                    console.log("From Error: ", error);
                    $this.removeClass('loading');
                    if( status == 'error' ) {
                        parent.find('p.error').text('Something went wrong. Please Try Again.');
                    }
                },
                success: function( response ){

                    $this.removeClass('loading');
    
                    if ( response == 'OK' ) {
                        var object = {
                            "action" : "update_license",
                            "data" : {
                                "apikey"    : apikey,
                                "license_field" : $data.licenseKey,
                                "status_field_key"  : $data.effectedKey,
                                "status_field_value"  : status_field_value[action],
                            }
                        }
                        // console.log("From Success: ", response );
        
                        jQuery.post(ajaxurl, object).error(function(xhr,status,error){
                            // jQuery('p.message').html('Something went wrong');
                        }).success(function(res) {
                            
                            // manipulate html
                            parent.find('p.error').text(error_text[response][action]);
                            $this.find('.text').text(button_action[action]);
                            status.val(status_field_value[action]);
                            status.removeClass('active');
                            status.removeClass('deactive');
                            status.addClass(status_field_value[action]);
                        })
                    } else {
                        parent.find('p.error').text(error_text[response]);
                    }
                    
                }
            })
        } else {
            // console.log("Please input a license key");
            parent.find('p.error').text("Please input a license key");
        }
        
    });
})(jQuery)