$(() => {
    $.validator.setDefaults( {
        errorElement: "div",
        errorPlacement: ( error, element ) => {

            error.addClass('invalid-feedback');

            element.attr('type') === 'checkbox' ? error.insertAfter( element.parent('label') ) : element.parent('.form-group').append( error );
        },
        highlight: ( element, errorClass, validClass ) => {
            $( element ).addClass('is-invalid');
        },
        unhighlight: (element, errorClass, validClass) => {
            $( element ).removeClass('is-invalid');
        }
    } );

    let transferForm = $('#transfer');

    transferForm.validate({
        rules: {
            users: {
                required: true,
            },

            inn : {
                required: true
            }
        },

        submitHandler: () => {
            alert('done');
            return false;
        }
    });

    let modal       = $('#addUser');
    let addUserForm = modal.find('form');

    modal.find('[name="inn"]').select2({
        tags: true
    });

    modal.on('show.bs.modal', () => {
        modal.find('form')[0].reset();
    });

    addUserForm.validate({
        rules: {
            last_name: {
                required: true,
            },
            first_name: {
                required: true,
            },
            patronymic: {
                required: true,
            },
            balance: {
                required: true,
            },
            inn : {
                required: true
            }
        }
    });

    $('.done').on('click', (event) => {
        let button = $(event.currentTarget);

        button.closest('.modal-content').find('form').trigger('submit');
    });
});
