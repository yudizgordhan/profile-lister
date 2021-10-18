define([
    "jquery",
    'Magento_Ui/js/modal/confirm',
    'Magento_Ui/js/modal/alert',
    'mage/translate'
], function ($, confirmation, alert, $t) {
    $('.freelancers-box .detail-box .freelancers-box-actions .delete-button').on('click', function(e){
        var self=this;
        e.preventDefault();
        confirmation({
            title: $t('Delete?'),
            content: $t('Are you sure you want to delete your freelancer profile?'),
            actions: {
                confirm: function(){

                    //If confirmed
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
                            $(self).closest('.detail-box').remove();
                            $('.cover-image-slider').remove();
                            $('.profile').remove();
                            alert({
                                content: response.message,
                            });
                            location.reload();
                        },
                        error: function (response) {
                            $('body').trigger("processStop");
                            alert({
                                content: $t('Something went wrong.')
                            });
                        }
                    })
                    
                }
            }
        });
    })
});