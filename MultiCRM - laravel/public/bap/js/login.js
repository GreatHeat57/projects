BAP_Login = {

    init: function () {

        $('#userAdmin').on('click', function () {
            $('#name').val('admin@laravel-bap.com');
            $('#password').val('admin');
        });
        $('#userCompany1').on('click', function () {
            $('#name').val('norman@laravel-bap.com');
            $('#password').val('admin');
        });
        $('#userCompany2').on('click', function () {
            $('#name').val('wesker@laravel-bap.com');
            $('#password').val('admin');
        });

        $('#sign_up').on('submit', function(ev) {
            $('#signupModal').modal('show');
        });


    }

}

BAP_Login.init();

$(document).ready(function(){
    $('input').keydown(function(event){
        
    });

    function validationFunction(stepperForm, activeStepContent) {
        // You can use the 'stepperForm' to valide the whole form around the stepper:
        someValidationPlugin(stepperForm);
        // Or you can do something with just the activeStepContent
        someValidationPlugin(activeStepContent);
        // Return true or false to proceed or show an error
        return true;
    }

    function defaultValidationFunction(stepperForm, activeStepContent) {
        var inputs = activeStepContent.querySelectorAll('input, textarea, select');
        for (let i = 0; i < inputs.length; i++) if (!inputs[i].checkValidity()) return false;
        return true;
    }
    var stepper = document.querySelector('.stepper');
    var stepperInstace = new MStepper(stepper, {
        // Default active step.
        firstActive: 0,
        // Allow navigation by clicking on the next and previous steps on linear steppers.
        linearStepsNavigation: true,
        // Auto focus on first input of each step.
        autoFocusInput: false,
        // Set if a loading screen will appear while feedbacks functions are running.
        showFeedbackPreloader: true,
        // Auto generation of a form around the stepper.
        autoFormCreation: true,
        // Function to be called everytime a nextstep occurs. It receives 2 arguments, in this sequece: stepperForm, activeStepContent.
        validationFunction: defaultValidationFunction, // more about this default functions below
        // Enable or disable navigation by clicking on step-titles
        stepTitleNavigation: true,
        // Preloader used when step is waiting for feedback function. If not defined, Materializecss spinner-blue-only will be used.
        feedbackPreloader: '<div class="spinner-layer spinner-blue-only">...</div>'
    });
});