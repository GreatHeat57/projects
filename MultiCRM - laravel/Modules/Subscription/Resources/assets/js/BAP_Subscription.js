var BAP_Subscription = {

    _plan_name: '',
    _plan_description: '',
    _plan_currency: '',
    _plan_gateway: '',

    init: function () {

    },

    setupPaymentForm: function (btnElement) {

        BAP_Subscription._plan_name = $(btnElement).attr('data-name');
        BAP_Subscription._plan_description = $(btnElement).attr('data-desc');
        BAP_Subscription._plan_currency = $(btnElement).attr('data-currency');
        BAP_Subscription._plan_gateway = $(btnElement).attr('data-gateway');


        $('#payment_form_name').val(BAP_Subscription._plan_name);
        $('#payment_form_desc').val(BAP_Subscription._plan_description);
        $('#payment_form_currency').val(BAP_Subscription._plan_currency);
        $('#payment_form_gateway').val(BAP_Subscription._plan_gateway);
    },

    brainTreeSetup: function (token) {

        braintree.setup(token, 'dropin', {
            container: 'dropin-container',
            onReady: function () {

            },

        });

        $('.change-plan').click(function (e) {

            $('#payment-form').show();

            var btnElement = $(this);

            BAP_Subscription.setupPaymentForm(btnElement);

            e.preventDefault();

        });

    },

    stripeSetup: function (stripeKey, email) {

        var handler = StripeCheckout.configure({
            key: stripeKey,
            locale: 'auto',
            token: function (token) {
                var form = $('#payment-form');

                $(form).prop('disabled', true);

                $('<input>').attr({
                    type: 'hidden',
                    name: 'token',
                    value: token.id
                }).appendTo(form);

                form.submit();
            }
        });

        $('.change-plan').click(function (e) {

            var btnElement = $(this);

            BAP_Subscription.setupPaymentForm(btnElement);

            handler.open({
                name: BAP_Subscription._plan_name,
                description: BAP_Subscription._plan_description,
                currency: BAP_Subscription._plan_currency,
                key: stripeKey,
                email: email
            });

            e.preventDefault();

        });

    },


};

BAP_Subscription.init();
