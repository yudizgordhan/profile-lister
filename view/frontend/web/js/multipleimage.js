define([
    "jquery",
    'mage/translate'
], function ($, $t) {
    $('.freelancer-form-title .delete-button').on('click', function(e){
        var self=this;
        e.preventDefault();
        var url = $(self).attr('href');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: url,
            data: {},
            beforeSend: function() {
                $('body').trigger("processStart");
            },
            success: function (response) {
                $('body').trigger("processStop");
                $(self).closest('.remove-tag').remove();
            },
            error: function (response) {
                $('body').trigger("processStop");
            }
        })
    })
});