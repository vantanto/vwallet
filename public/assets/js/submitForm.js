function mainFormSubmit(
    pMainForm = null, 
    pMainFormData = null, 
    pMainFormBtn = null, 
    pBeforeSend = null, 
    pSuccess = null, 
    pError = null, 
    pComplete = null) {
    
    const mainForm = pMainForm ?? $('#mainForm');
    mainForm.submit(function(e) {
        e.preventDefault();
        const mainFormData = pMainFormData ?? new FormData(mainForm.get(0));
        const mainFormBtn = pMainFormBtn ?? $("#mainFormBtn");
        return submitForm(mainForm, mainFormData, mainFormBtn, pBeforeSend, pSuccess, pError, pComplete);
    })
};

function submitForm(
    mainForm, 
    mainFormData, 
    mainFormBtn, 
    pBeforeSend = null, 
    pSuccess = null, 
    pError = null, 
    pComplete = null) {
    
    const mainFormBtnHtml = mainFormBtn.html();
    mainFormBtn.prop('disabled', true);
    mainFormBtn.html(mainFormBtn.attr('data-loading') ?? "Uploading . . .");

    $('#' + mainForm.attr('id') + ' input[data-type="thousand"]').each(function() {
        var inputName = $(this).attr('name');
        var decimal = $(this).data('decimal') ?? 2;
        mainFormData.set(inputName, numberNoCommas(mainFormData.get(inputName), decimal));
    });

    return $.ajax({
        method: "post",
        url: mainForm.prop('action'),
        data: mainFormData,
        processData: false,
        contentType: false,
        beforeSend: pBeforeSend ?? function(data) {
            $("#alert_error").hide();
            $("#alert_error_msg").html("");
            $("#alert_error_list").html("");
        },
        success: pSuccess ??function(data, textStatus, jqXHR) {
            if (data.status == "success") {
                swalAlert('success', data.msg).then(() => {
                    window.location.href = data.href ?? $('meta[name="url-current"]').attr('content')
                });
            }
        },
        error: pError ?? function(data, textStatus, jqXHR) {
            if (typeof data.responseJSON !== 'undefined' && typeof data.responseJSON.status !== 'undefined') {
                if (data.responseJSON.status == 'validator') {
                    var alert_error_list = '';
                    $.each(data.responseJSON.msg, function(index, value) {
                        mainForm.find("[name='" + index + "']").addClass("is-invalid")
                        mainForm.find("[name='" + index + "']").siblings(".invalid-feedback").text(value[0])
                        alert_error_list += `<li class="text-md font-bold text-red-500 text-sm">${value[0]}</li>`;
                    });
                    swalAlert('error', 'Input Error!');
                    $("#alert_error").show();
                    $("#alert_error_list").html(alert_error_list);
                } else {
                    $("#alert_error").show();
                    $("#alert_error_msg").html(data.responseJSON.msg);
                    swalAlert('error', data.responseJSON.msg);
                }
            } else
                swalAlert('error', 'Error!');
        },
        complete: pComplete ?? function(data, textStatus) {
            mainFormBtn.prop('disabled', false)
            mainFormBtn.html(mainFormBtnHtml)
        }
    });
}