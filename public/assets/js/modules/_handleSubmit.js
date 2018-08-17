import formJson from "./_formToJson";

function handleSubmit (form, success) {
    let button = form.find('[type="submit"]');

    button.attr('disabled', true);

    fetch(form.attr('action'), {
        method: 'POST',
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formJson(form))
    })
    .then(response => response.json())
    .then((data) => {
        button.removeAttr('disabled');

        if(data.error) {
            switch(data.error.status_code) {
                case 422:
                    $.each(data.error.validation, (k, v) => {
                        let field = form.find('[name="'+k+'"]').addClass('is-invalid');
                        ! field.parent('.form-group').find('.invalid-feedback').length ? field.parent('.form-group').append('<div class="invalid-feedback"></div>') : null;

                        field.parent('.form-group').find('.invalid-feedback').text(v);
                        field.parent('.form-group').find('.invalid-feedback').show();
                    });
                    break;
            }
        } else {
            success(data);
        }
    });
}

export default function submitForm(form, callback) {
    handleSubmit(form, (data) => callback(data));
}