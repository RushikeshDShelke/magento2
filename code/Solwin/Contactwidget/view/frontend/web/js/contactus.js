require([
    'jquery', // jquery Library
    'jquery/ui', // Jquery UI Library
    'jquery/validate', // Jquery Validation Library
    'mage/translate', // Magento text translate (Validation message translte as per language)
    "Solwin_Contactwidget/js/contactus"
], function($){
//custom validations form mobile number, pincode...

$.validator.addMethod(
    'validate-mobile-number', function (value) {
        return value.length == 10 && value.match(/^\d*(?:\.\d{1,2})?$/);
    }, $.mage.__('Please enter a valid mobile number.'));

$.validator.addMethod(
    'validate-pincode', function (value) {
        return value.length == 6 && value.match(/^\d*(?:\.\d{1,2})?$/);
    }, $.mage.__('Please enter a valid pincode.'));


// hide/show fields based on contact type selection by user
jQuery(document).ready(function($) {
    //$('#general-subject-container').fadeOut('slow');
    //$('#order-subject-container').fadeOut('slow');
    $('#fldset-additional').fadeOut('slow');
    $("input[type='radio']").attr("checked", false);
    $("input[type='radio']").click(function(){
        $("#select-general-subject").val($("#select-general-subject option:first").val());
        $("#select-order-subject").val($("#select-order-subject option:first").val());
        var radioValue = $("input[name='contact-type']:checked").val();
        if(radioValue=='general-enquiry'){
            $('#fldset-additional').fadeOut('slow');
            $('#order-subject-container').fadeOut('slow');
            $('#general-subject-container').fadeIn('slow');
        }else if(radioValue=='order-related'){
            $('#fldset-additional').fadeOut('slow');
            $('#general-subject-container').fadeOut('slow');
            $('#order-subject-container').fadeIn('slow');
        }
    });

    $('#select-general-subject').change(function() {

        if($(this).find(":selected").val()) {

            $('#fldset-additional').fadeIn('slow');
            $('.field.name').fadeIn('slow');
            $('.field.email').fadeIn('slow');
            $('.field.mobile-number').fadeIn('slow');
            $('.field.comment').fadeIn('slow');

            switch ($(this).find(":selected").val()) {
                case 'Bulk Order Enquiry':
                    $('.field.location').fadeIn('slow');
                    $('.field.product-name').fadeIn('slow');
                    $('.field.product-quantity').fadeIn('slow');
                    $('.field.couponcode').fadeOut('slow');
                    $('.field.pincode').fadeOut('slow');
                    $('.field.order-number').fadeOut('slow');
                    $('.field.imageFile-container').fadeOut('slow');
                    break;
                case 'Dealer/Distributor Enquiry':
                    $('.field.location').fadeIn('slow');
                    $('.field.product-name').fadeIn('slow');
                    $('.field.product-quantity').fadeOut('slow');
                    $('.field.couponcode').fadeOut('slow');
                    $('.field.pincode').fadeOut('slow');
                    $('.field.order-number').fadeOut('slow');
                    $('.field.imageFile-container').fadeOut('slow');
                    break;
                case 'Information On Product':
                    $('.field.location').fadeOut('slow');
                    $('.field.product-name').fadeOut('slow');
                    $('.field.product-quantity').fadeOut('slow');
                    $('.field.couponcode').fadeOut('slow');
                    $('.field.pincode').fadeOut('slow');
                    $('.field.order-number').fadeOut('slow');
                    $('.field.imageFile-container').fadeOut('slow');
                    break;
                case 'Nearest Retail Store':
                    $('.field.location').fadeOut('slow');
                    $('.field.product-name').fadeOut('slow');
                    $('.field.product-quantity').fadeOut('slow');
                    $('.field.couponcode').fadeOut('slow');
                    $('.field.pincode').fadeOut('slow');
                    $('.field.order-number').fadeOut('slow');
                    $('.field.imageFile-container').fadeOut('slow');
                    break;
                case 'Brand Voucher Redemption Related':
                    $('.field.location').fadeOut('slow');
                    $('.field.product-name').fadeOut('slow');
                    $('.field.product-quantity').fadeOut('slow');
                    $('.field.couponcode').fadeOut('slow');
                    $('.field.pincode').fadeOut('slow');
                    $('.field.order-number').fadeOut('slow');
                    $('.field.imageFile-container').fadeOut('slow');
                    break;
                case 'Online Coupon Code Related':
                    $('.field.location').fadeOut('slow');
                    $('.field.product-name').fadeOut('slow');
                    $('.field.product-quantity').fadeOut('slow');
                    $('.field.couponcode').fadeIn('slow');
                    $('.field.pincode').fadeOut('slow');
                    $('.field.order-number').fadeOut('slow');
                    $('.field.imageFile-container').fadeOut('slow');
                    break;
                case 'Shipping Timeline':
                    $('.field.location').fadeIn('slow');
                    $('.field.product-name').fadeOut('slow');
                    $('.field.product-quantity').fadeOut('slow');
                    $('.field.couponcode').fadeOut('slow');
                    $('.field.pincode').fadeIn('slow');
                    $('.field.order-number').fadeOut('slow');
                    $('.field.imageFile-container').fadeOut('slow');
                    break;
                case 'Others':
                    $('.field.location').fadeOut('slow');
                    $('.field.product-name').fadeOut('slow');
                    $('.field.product-quantity').fadeOut('slow');
                    $('.field.couponcode').fadeOut('slow');
                    $('.field.pincode').fadeOut('slow');
                    $('.field.order-number').fadeOut('slow');
                    $('.field.imageFile-container').fadeOut('slow');
                    break;
            }
        }else{
            $('#fldset-additional').fadeOut('slow');
        }
    });

    $('#select-order-subject').change(function() {

        if($(this).find(":selected").val()) {

            $('#fldset-additional').fadeIn('slow');
            $('.field.name').fadeIn('slow');
            $('.field.email').fadeIn('slow');
            $('.field.mobile-number').fadeIn('slow');
            $('.field.comment').fadeIn('slow');

            switch ($(this).find(":selected").val()) {
                case 'Order Status':
                    $('.field.location').fadeOut('slow');
                    $('.field.product-name').fadeOut('slow');
                    $('.field.product-quantity').fadeOut('slow');
                    $('.field.couponcode').fadeOut('slow');
                    $('.field.pincode').fadeOut('slow');
                    $('.field.order-number').fadeIn('slow');
                    $('.field.imageFile-container').fadeOut('slow');
                    break;
                case 'Exchange Related':
                    $('.field.location').fadeOut('slow');
                    $('.field.product-name').fadeOut('slow');
                    $('.field.product-quantity').fadeOut('slow');
                    $('.field.couponcode').fadeOut('slow');
                    $('.field.pincode').fadeOut('slow');
                    $('.field.order-number').fadeIn('slow');
                    $('.field.imageFile-container').fadeIn('slow');
                    break;
                case 'Defective Product':
                    $('.field.location').fadeOut('slow');
                    $('.field.product-name').fadeIn('slow');
                    $('.field.product-quantity').fadeOut('slow');
                    $('.field.couponcode').fadeOut('slow');
                    $('.field.pincode').fadeOut('slow');
                    $('.field.order-number').fadeIn('slow');
                    $('.field.imageFile-container').fadeIn('slow');
                    break;
                case 'Invoice Request':
                    $('.field.location').fadeOut('slow');
                    $('.field.product-name').fadeOut('slow');
                    $('.field.product-quantity').fadeOut('slow');
                    $('.field.couponcode').fadeOut('slow');
                    $('.field.pincode').fadeOut('slow');
                    $('.field.order-number').fadeIn('slow');
                    $('.field.imageFile-container').fadeOut('slow');
                    break;             
                case 'Others':
                    $('.field.location').fadeOut('slow');
                    $('.field.product-name').fadeOut('slow');
                    $('.field.product-quantity').fadeOut('slow');
                    $('.field.couponcode').fadeOut('slow');
                    $('.field.pincode').fadeOut('slow');
                    $('.field.order-number').fadeOut('slow');
                    $('.field.imageFile-container').fadeOut('slow');
                    break;
            }
        }else{
            $('#fldset-additional').fadeOut('slow');
        }

    });
});
});
