function checkName() {
    var name = $("#name").val();
    if (name.length > 0) {
        return true;
    } else {
        $("#name-error").html("Should contain only Characters");
        $("#name").css("border", "2px solid #F90A0A");
        return false;
    }
}

function checkEditName(tableRowElementName) {
    var name = tableRowElementName.find('.js-edit-tag').val();
    if (name.length > 0) {
        return true;
    } else {
        $(tableRowElementName.find("#edit-name-error")).html("Should contain only Characters");
        $(tableRowElementName.find(".js-edit-tag")).css("border", "2px solid #F90A0A");
        return false;
    }
}

function resetInputField() {
    $('form')[0].reset();
    $("input").css("border", "1px solid #ced4da");
    $(".error.help-block").html("");
    $("#edit-name-error").html("");
}

function form_to_json(selector) {
    var ary = $(selector).serializeArray();
    var obj = {};
    for (var a = 0; a < ary.length; a++) obj[ary[a].name] = ary[a].value;
    return obj;
}

function appendDataInTable(data) {
    data.forEach((element, index) => {
        if (typeof element !== undefined) {
            let html = '<tr>';
            html += `<td scope="row">
                        <span class="tag-name">` + element.name + `</span>
                        <input type="hidden" id="tag" name="name" class="form-control js-edit-tag" value="` + element.name + `" required>
                        <em id="edit-name-error" class="error help-block"></em>
                    </td>`;
            html += '<td class="action-elements">';
            html += `<button type="button" class="btn btn-warning js-edit-btn btn-sm mr-1" data-id="` + element.id + `">
                <i data-feather="edit" class="mr-2 icon-xs">
                </i><span>Edit</span>
            </button>`;
            html += `<button type="button" class="btn btn-danger btn-sm ml-1 js-delete-btn" data-id="` + element.id + `">
                <i data-feather="trash-2" class="mr-2 icon-xs">
                </i><span>Delete</span>
            </button>`;
            html += ` </td>
            </tr>`;
            $('.tag-table-body').prepend(html)
        }
    });
}

function showAlltag() {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        url: "../api/tag/read.php",
        type: "GET",
        data: {
            action: "view"
        },
        success: function (response) {
            appendDataInTable(response.data);
            $('form')[0].reset();
            feather.replace();
        }
    });
}

function getLastRecord() {
    $.ajax({
        contentType: "application/json; charset=utf-8",
        url: "../api/tag/read.php",
        type: "GET",
        data: {
            action: "viewLastRecord"
        },
        success: function (response) {
            appendDataInTable(response.data);
            $('form')[0].reset();
            feather.replace();
        }
    });
}

$(document).ready(function () {
    showAlltag();

    $('.js-submit-tag').click(function (e) {
        e.preventDefault();
        if (checkName()) {
            const form_data = form_to_json('form');
            $.ajax({
                type: 'POST',
                contentType: "application/json; charset=utf-8",
                url: '../api/tag/create.php',
                data: JSON.stringify(form_data),
                dataType: 'json',
                success: function (data) {
                    resetInputField();
                    getLastRecord();
                    $('.alert-grp .alert-success .alert-msg-body').text(data.message);
                    $('.alert-success').addClass('alert-show')
                    setTimeout(function () {
                        $('.alert-success').removeClass('alert-show');
                    }, 4000);
                },
                error: function (data) {
                    console.log('fail');
                    console.log(data);
                },
            })
        }
    });

    $("body").on("click", ".js-delete-btn", function (e) {
        e.preventDefault();
        const dataId = {
            id: $(this).data('id')
        };
        const tableRowElement = $(this).parents("tr");
        const deleteConfirmation = confirm("Are you sure to delete this item?");
        if (deleteConfirmation) {
            $.ajax({
                type: 'DELETE',
                contentType: "application/json; charset=utf-8",
                dataType: 'json',
                url: '../api/tag/delete.php',
                data: JSON.stringify(dataId),
                success: function (data) {
                    tableRowElement.remove();
                    $('.alert-grp .alert-success .alert-msg-body').text(data.message);
                    $('.alert-success').addClass('alert-show')
                    setTimeout(function () {
                        $('.alert-success').removeClass('alert-show');
                    }, 4000);
                    feather.replace();
                },
                error: function (data) {
                    console.log('fail');
                    console.log(data);
                },
            });
        }
    });

    $("body").on("click", ".js-cancle-btn", function (e) {
        e.preventDefault();
        const id = $(this).data('id');
        let html = '<td class="action-elements">';
        html += `<button type="button" class="btn btn-warning js-edit-btn btn-sm mr-1" data-id="` + id + `">
                    <i data-feather="edit" class="mr-2 icon-xs">
                    </i><span>Edit</span>
                </button>`;
        html += `<button type="button" class="btn btn-danger btn-sm ml-1 js-delete-btn" data-id="` + id + `">
                    <i data-feather="trash-2" class="mr-2 icon-xs">
                    </i><span>Delete</span>
                </button>`;
        html += ` </td>`;
        const tableRowElement = $(this).parents("tr");
        $(tableRowElement.find(".tag-name")).show();
        $(tableRowElement.find(".js-edit-tag")).attr('type', 'hidden');
        $(tableRowElement.find('.action-elements').replaceWith(html));
        feather.replace();
    });

    $("body").on("click", ".js-edit-btn", function (e) {
        e.preventDefault();
        const id = $(this).data('id');
        let html = '<td class="action-elements">';
        html += `<button type="button" class="btn btn-warning js-update-btn btn-sm mr-1" data-id="` + id + `">
                    <i data-feather="send" class="mr-2 icon-xs">
                    </i><span>Update</span>
                </button>`;
        html += `<button type="button" class="btn btn-danger btn-sm ml-1 js-cancle-btn">
                    <i data-feather="x-circle" class="mr-2 icon-xs">
                    </i><span>Cancel</span>
                </button>`;
        html += ` </td>`;
        const tableRowElement = $(this).parents("tr");
        $(tableRowElement.find(".tag-name")).hide();
        $(tableRowElement.find(".js-edit-tag")).attr('type', 'text');
        $(tableRowElement.find('.action-elements').replaceWith(html));
        feather.replace();
    });

    $("body").on("click", ".js-update-btn", function (e) {
        e.preventDefault();
        const id = $(this).data('id');
        const tableRowElement = $(this).parents("tr");
        if (checkEditName(tableRowElement)) {
            const tableRowElement = $(this).parents("tr");
            const updatedData = {
                id: id,
                name: tableRowElement.find('.js-edit-tag').val(),
            };
            let html = '<tr>';
            html += `<td scope="row">
                        <span class="tag-name">` + updatedData.name + `</span>
                        <input type="hidden" id="tag" name="name" class="form-control js-edit-tag" value="` + updatedData.name + `" required>
                    </td>`;
            html += '<td class="action-elements">';
            html += `<button type="button" class="btn btn-warning js-edit-btn btn-sm mr-1" data-id="` + updatedData.id + `">
                <i data-feather="edit" class="mr-2 icon-xs">
                </i><span>Edit</span>
            </button>`;
            html += `<button type="button" class="btn btn-danger btn-sm ml-1 js-delete-btn" data-id="` + updatedData.id + `">
                <i data-feather="trash-2" class="mr-2 icon-xs">
                </i><span>Delete</span>
            </button>`;
            html += ` </td>
            </tr>`;
            $.ajax({
                type: 'PUT',
                contentType: "application/json; charset=utf-8",
                dataType: 'json',
                url: '../api/tag/update.php',
                data: JSON.stringify(updatedData),
                success: function (data) {
                    resetInputField();
                    $(tableRowElement).replaceWith(html);
                    $('.alert-grp .alert-success .alert-msg-body').text(data.message);
                    $('.alert-success').addClass('alert-show')
                    setTimeout(function () {
                        $('.alert-success').removeClass('alert-show');
                    }, 4000);
                    feather.replace();
                },
                error: function (data) {
                    console.log('fail');
                    console.log(data);
                },
            })
        }
    });
});