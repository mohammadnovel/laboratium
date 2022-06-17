var popupValidator = {};
var main = {
    'init': function () {
        // $(".number").number( true );
        // $(".price-us").number( true, 2 );
        // $(".digit").limitkeypress({ rexp: /^[0-9]*$/ });
    }
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

var tForm = null;

function readURL(input, callback) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            callback(e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    main.init();
    $("body").delegate('.item-detail', 'click', function (e) {
        e.preventDefault();
        swal({
            title: $(this).data("title"),
            text: $(this).data("description"),
            imageUrl: $(this).data('image'),
            showConfirmButton: false,
            showCloseButton: true,
            footer: '<a href="' + $(this).data('url') + '" target="_blank">Go to website</a>'
        });
    });

    $("body").delegate('select[data-target]', 'change', function (e) {
        e.preventDefault();
        var target = $(this).data('target');
        if ($(target).length) {
            var url = $(this).data('url');
            $.ajax({
                type: $(this).data('method') || 'GET',
                url: url,
                data: { id: $(this).val() },
                dataType: "json",
                success: function (response) {
                    if (response.data) {
                        $(target).empty();
                        response.data.forEach(element => {
                            selected = '';
                            if ($(target).data('selected') == element.id) selected = ' selected="selected"';
                            $(target).append('<option value="' + element.id + '"' + selected + '>' + element.label + '</option>')
                        });
                        $(target).trigger('change');
                    }
                }
            });
        }
    });

    $("body").delegate('[data-info]', 'click', function (e) {
        e.preventDefault();
        tForm = $(this);
        conf = {
            title: '<strong>' + $(this).data('label') + '</strong>',
            type: 'info',
            html: $(this).find('.hide').html(),
            showCancelButton: true,
            customClass: $(this).data('info'),
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !swal.isLoading()
        };
        if (tForm.data('button') == false) {
            conf.showCancelButton = false;
            conf.showConfirmButton = false;
        }
        if (tForm.data('title') == false) {
            conf.title = false;
            conf.type = false;
        }
        Swal.fire(conf);
    });
    $("body").delegate('[data-confirm]', 'click', function (e) {
        e.preventDefault();
        tForm = $(this);
        Swal.fire({
            title: '<strong>' + $(this).data('label') + ' <u>Action</u></strong>',
            type: 'info',
            html: $(this).data('confirm') + ' ' + $(this).find('.hide').html(),
            showCancelButton: true,
            customClass: 'swal2-overflow',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Decline',
            showLoaderOnConfirm: true,
            onOpen: function () {
                main.init();
                // var notesField = '<div class="form-group">'+
                //                     '<label class="control-label">Notes</label>'+
                //                     '<textarea class="form-control" rows="5" name="notes" cols="50" id="notes"></textarea>'+
                //                 '</div>';
                // if (!$('.swal2-container.swal2-shown #notes').length){
                //     if ($('.swal2-container.swal2-shown .form-container').length) {
                //         $('.swal2-container.swal2-shown .form-container').append(notesField);
                //     } else {
                //         $('.swal2-container.swal2-shown #swal2-content').append('<form class="form-container" id="popupForm">'+notesField+'</form>');
                //     }
                // }
                $('.swal2-container.swal2-shown .form-container label').removeAttr('for');
                $(".popup-script").remove();

                $.each($('.swal2-container .datetimepicker-input'), function (index, value) {
                    var id = $(this).attr('id');
                    $(this).attr({
                        id: id + '_modal',
                        target: id + '_modal'
                    });
                });
                $('.swal2-container .datetimepicker-input').datetimepicker({});
                $("body").append('<script class="popup-script">' + tForm.find('.hide script').html() + '</script>');
            },
            preConfirm: () => {
                var data = '';
                if ($('.swal2-container.swal2-shown').find('.form-container').length) {
                    if (!$(".swal2-container.swal2-shown .form-container").valid()) {
                        return false;
                    }
                    data = new FormData($('.swal2-container.swal2-shown').find('.form-container')[0]);
                }
                return $.ajax({
                    type: tForm.data('method'),
                    url: tForm.data('action'),
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log(response);
                        if (response.redirect !== undefined) {
                            if (response.target !== undefined) {
                                window.open(response.redirect, response.target);
                            } else {
                                window.location.href = response.redirect;
                            }

                        }
                    }
                }).then(response => {
                    dataTable.ajax.reload();
                    return response;
                }).catch(error => {
                    if (error.responseJSON !== undefined) {
                        var errorMessage = error.responseJSON.message;
                        $.each(error.responseJSON.errors, function (indexInArray, valueOfElement) {
                            if ($(".swal2-container.swal2-shown .form-container [name='" + indexInArray + "']").length) {
                                $(".swal2-container.swal2-shown .form-container").validate().showErrors({
                                    [indexInArray]: valueOfElement[0]
                                });
                            }
                            errorMessage = valueOfElement[0];
                        });
                        swal.showValidationError(errorMessage)
                    }
                })
            },
            allowOutsideClick: () => !swal.isLoading()
        }).then((result) => {
            if (result.value != undefined) {
                var type = (result.value.type === undefined) ? 'success' : result.value.type;
                Toast.fire({
                    type: type,
                    title: result.value.message
                })
            }
        })
    });

    $("body").delegate('.photo-file', 'change', function () {
        var target = $(this).data('target');
        readURL(this, function (result) {
            $(target).append('<div class="col-md-3 list"><img src="' + result + '" style="max-width:100%"><input type="hidden" value="' + result + '" name="images[]"><span>x</span></div>');
        });
    })

    $("body").delegate("#image-view .list span", "click", function (e) {
        e.preventDefault();
        $(this).parent().remove();
    });

    var form = $(".form-validate");

    form.submit(function (e) {
        e.preventDefault();
        var t = $(this);
        t.find("[type='submit']").append(' <i class="fa fa-spinner fa-spin"></i>');

        t.find("[type='submit']").attr('disabled', 'disabled');
        validateForm = $(this).validate({
            errorPlacement: function (error, element) {
                if (element.parents(".grouping").length) {
                    error.insertAfter(element.parents(".grouping"));
                } else if (element.parent().is(".input-group")) {
                    error.insertAfter(element.parent(".input-group"));
                } else if (element.parent().is(".form-group")) {
                    element.parent(".form-group").append(error);
                } else {
                    error.insertAfter(element);
                }
            }
        });
        if ($(this).valid()) {
            if ($(this).attr("validateonly") == "true") {
                return false;
            }
            if ($(this).attr("noajax") != "true") {
                $(this).ajaxSubmit({
                    url: $(this).attr('action'),
                    dataType: 'json',
                    success: function (responseText, statusText, xhr, $form) {
                        t.find("[type='submit']").removeAttr('disabled');
                        t.find("[type='submit'] i").remove();
                        responseText.status = 200;
                        if (customMessage(responseText, validateForm)) {

                        }
                    },
                    error: function (argument) {
                        t.find("[type='submit']").removeAttr('disabled');
                        t.find("[type='submit'] i").remove();
                    }
                });
            } else {
                window.location.href = $(this).attr("action") + "?" + $(this).serialize();
                t.find("[type='submit']").removeAttr('disabled');
                t.find("[type='submit'] i").remove();
            }

        } else {
            t.find("[type='submit']").removeAttr('disabled');
            t.find("[type='submit'] i").remove();
        }
    });

});

function customMessage(data, validateForm) {
    var autoCloseTime = (data.autoClose != undefined) ? data.autoClose : null;
    var confirmButton = (data.autoClose != undefined) ? false : true;
    if (data.script != undefined) {
        eval(data.script);
    };
    if (!data.status) {
        if (data.errors != undefined) {
            validateForm.showErrors(data.errors);
        }
        if (data.message != undefined) {
            subject = (data.subject == undefined) ? "Error" : data.subject;
            swal({
                title: subject,
                html: true,
                text: data.message,
                type: "error",
                timer: autoCloseTime,
                showConfirmButton: confirmButton
            },
                function (isConfirm) {
                    if (isConfirm) {
                        if (data.scriptConfirmation != undefined) {
                            eval(data.scriptConfirmation);
                        };
                    }
                });
        }
        return false;
    } else if (data.status == 401) {
        subject = (data.subject == undefined) ? "Error" : data.subject;
        swal({
            title: subject,
            html: true,
            text: data.message,
            type: "error",
            timer: autoCloseTime,
            showConfirmButton: false
        });
        redirectDelay(loginURL + "?redirect=" + window.location.href);
        return false;
    } else if (data.status == 403) {
        subject = (data.subject == undefined) ? "Error" : data.subject;
        swal({
            title: subject,
            html: true,
            text: data.message,
            type: "error"
        });
        return false;
    } else if (data.status == 1 || data.status == 200) {
        if (data.noalert == undefined || data.noalert != true) {
            subject = (data.subject == undefined) ? "Success" : data.subject;
            swal({
                title: subject,
                html: true,
                text: data.message,
                type: "success",
                timer: autoCloseTime,
                showConfirmButton: (data.confirmButton != undefined) ? data.confirmButton : false
            });
            if (data.redirect != undefined) {
                redirectDelay(data.redirect);
            };
        };
        return true;
    } else {
        return false;
    }
}

function redirectDelay(url, time) {
    var time = (time === undefined) ? 300 : time;
    setInterval(() => {
        window.location.href = url;
    }, time);
}
