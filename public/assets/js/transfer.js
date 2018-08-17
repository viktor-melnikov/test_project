import sendForm from './modules/_handleSubmit';
import Notify from './modules/_notify';

$(() => {

    $().alert();

    $.validator.setDefaults({
        errorElement: "div",
        errorPlacement: (error, element) => {
            error.addClass('invalid-feedback');
            element.attr('type') === 'checkbox' ? error.insertAfter(element.parent('label')) : element.parent('.form-group').append(error);
        },
        highlight: (element) => {
            $(element).addClass('is-invalid');
        },
        unhighlight: (element) => {
            $(element).removeClass('is-invalid');
        }
    });

    /**
     * ### Form Transfer Money
     */
    let transferForm = $('#transfer');
    let usersSelect  = $('#users');

    usersSelect.select2({
        ajax: {
            url: usersSelect.data('url'),
            dataType: 'json'
        },
        minimumInputLength: 1,
        language : "ru"
    });

    transferForm.validate({
        rules: {
            users: {
                required: true,
            },
            inn : {
                required: true
            },
            deposit : {
                required: true
            },
        },
        submitHandler: () => {
            sendForm(transferForm, (data) => {
                let notify = new Notify;
                usersSelect.val('').trigger('change');
                transferForm[0].reset();
                notify.show(data.message);
            });
            return false;
        }
    });

    /**
     * ### Form Add User with inn
     */
    let modal       = $('#addUser');
    let addUserForm = modal.find('form');

    modal.find('[name="inn"]').select2({
        tags: true
    });

    modal.on('show.bs.modal', () => {
        modal.find('.is-invalid').each(() => $(this).removeClass('is-invalid'));
        modal.find('.invalid-feedback').text('');
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
            inn : {
                required: true
            }
        },
        submitHandler: () => {
            sendForm(addUserForm, (data) => {
                let notify = new Notify;

                modal.modal('hide');
                notify.show(data.message);
            });
            return false;
        }
    });
});