// Cacher les elements HTML des chargements
$('#add_css_item_loader').hide();
$('#del_css_item_loader').hide();
$('#add_data_item_loader').hide();
$('#del_data_item_loader').hide();
$('#add_template_item_loader').hide();
$('#del_template_item_loader').hide();
// Chargement des ressources (css,data,template) dans les selects
function reloadRessource() {
    var url = "/api/ressources?mustache=" + mustache_id;
    $.ajax({
        type: "GET",
        url: url,
        dataType: 'json',
        success: function (resp) {
            $("#select-css").html("");
            $.each(resp, function (key, val) {
                if (val.type === "css") {
                    $("#select-css").append(
                            `<option data-cs="${val.content}" value="${val.name}" data-id="${val.id}">${val.name}</option>`
                            );
                } else if (val.type === "data") {
                    $("#select-data").append(
                            `<option data-cs='${val.content}' value="${val.name}" data-id="${val.id}">${val.name}</option>`
                            );
                } else {
                    $("#select-template").append(
                            `<option data-cs="${val.content}" value="${val.name}" data-id="${val.id}">${val.name}</option>`
                            );
                }

            });
        }
    });
}
reloadRessource();
// Création de code mirror
var te_css = document.getElementById("code-css");
var te_html = document.getElementById("code-html");
var te_json = document.getElementById("code-json");
window.editor_css = CodeMirror.fromTextArea(te_css, {
    mode: "css",
    lineNumbers: true,
    lineWrapping: true,
    extraKeys: {"Ctrl-Space": "autocomplete"}
});
window.editor_json = CodeMirror.fromTextArea(te_json, {
    mode: {name: "javascript", json: true},
    lineNumbers: true,
    lineWrapping: true,
    extraKeys: {"Ctrl-Space": "autocomplete"}
});
window.editor_html = CodeMirror.fromTextArea(te_html, {
    mode: "htmlmixed",
    lineNumbers: true,
    lineWrapping: true,
    extraKeys: {"Ctrl-Space": "autocomplete"}
});
// Exécution de editeur
$("#btn-run").click(function (event) {
    event.preventDefault();
    var template = editor_html.getValue();
    var data = editor_json.getValue();
    var css = editor_css.getValue();
    rendered = Mustache.render(template, JSON.parse(data));
    $('#renderFrame').contents().find('body').html(rendered);
    $('#renderFrame').contents().find('head').html('<style>' + css + '</style>');
});
// Chargement des elements selectionnés
$("#select-css").on('click', function () {
    $("#name-css").val(this.value);
    editor_css.setValue($(this).find('option:selected').attr('data-cs'));
});
$("#select-data").on('click', function () {
    $("#name-data").val(this.value);
    editor_json.setValue($(this).find('option:selected').attr('data-cs'));
});
$("#select-template").on('click', function () {
    $("#name-template").val(this.value);
    editor_html.setValue($(this).find('option:selected').attr('data-cs'));
});
// Enregistrer les nouveaux elements
$("#save_css").click(function (event) {
    event.preventDefault();
    var name = $("#name-css").val();
    if (name == "") {
        $("#name-css").addClass("is-invalid");
    } else {
        var code = editor_css.getValue();
        $.ajax({
            type: "POST",
            beforeSend: function () {
                $('#add_css_item_loader').show();
                $('#save_css_icon').hide();
                $('#save_css').attr('disabled', true);
            },
            complete: function () {
                $('#add_css_item_loader').hide();
                $('#save_css_icon').show();
                $('#save_css').attr('disabled', false);
            },
            contentType: "application/json; charset=utf-8",
            url: "/api/ressources",
            data: '{"name":"' + name + '","type":"css","content":"' + code + '","mustache": "/api/mustaches/' + mustache_id + '"}',
            dataType: "json",
            success: function (resp) {
                $("#select-css").append(
                        `<option data-cs="${code}" value="${name}" data-id="${resp.id}">${name}</option>`
                        );
                $("#select-css").val(name);
                if ($("#name-css").hasClass("is-invalid")) {
                    $("#name-css").removeClass("is-invalid");
                }
            }
        });
    }
});
$("#save_data").click(function (event) {
    event.preventDefault();
    var name = $("#name-data").val();
    if (name == "") {
        $("#name-data").addClass("is-invalid");
    } else {
        var code = editor_json.getValue();
        $.ajax({
            type: "POST",
            beforeSend: function () {
                $('#add_data_item_loader').show();
                $('#save_data_icon').hide();
                $('#save_data').attr('disabled', true);
            },
            complete: function () {
                $('#add_data_item_loader').hide();
                $('#save_data_icon').show();
                $('#save_data').attr('disabled', false);
            },
            contentType: "application/json; charset=utf-8",
            url: "/api/ressources",
            data: '{"name":"' + name + '","type":"data","content":"' + code + '","mustache": "/api/mustaches/' + mustache_id + '"}',
            dataType: "json"
            , success: function (resp) {
                $("#select-data").append(
                        `<option data-cs="${code}" value="${name}" data-id="${resp.id}">${name}</option>`
                        );
                $("#select-data").val(name);
                if ($("#name-data").hasClass("is-invalid")) {
                    $("#name-data").removeClass("is-invalid")
                }
            }
        });
    }
});
$("#save_template").click(function (event) {
    event.preventDefault();
    var name = $("#name-template").val();
    if (name == "") {
        $("#name-template").addClass("is-invalid");
    } else {
        var code = editor_json.getValue();
        $.ajax({
            type: "POST",
            beforeSend: function () {
                $('#add_template_item_loader').show();
                $('#save_template_icon').hide();
                $('#save_template').attr('disabled', true);
            },
            complete: function () {
                $('#add_template_item_loader').hide();
                $('#save_template_icon').show();
                $('#save_template').attr('disabled', false);
            },
            contentType: "application/json; charset=utf-8",
            url: "/api/ressources",
            data: '{"name":"' + name + '","type":"template","content":"' + code + '","mustache": "/api/mustaches/' + mustache_id + '"}',
            dataType: "json"
            , success: function (resp) {
                $("#select-template").append(
                        `<option data-cs="${code}" value="${name}" data-id="${resp.id}">${name}</option>`
                        );
                $("#select-template").val(name);
                if ($("#name-template").hasClass("is-invalid")) {
                    $("#name-template").removeClass("is-invalid")
                }
            }
        });
    }
});
// Supprimmer les elements selectionnés
$("#del_css").click(function (event) {
    event.preventDefault();
    var id = $("#select-css").children(':selected').attr('data-id');
    $.ajax({
        type: "DELETE",
        beforeSend: function () {
            $('#del_css_item_loader').show();
            $('#del_css_icon').hide();
            $('#del_css').attr('disabled', true);
        },
        complete: function () {
            $('#del_css_item_loader').hide();
            $('#del_css_icon').show();
            $('#del_css').attr('disabled', false);
        },
        url: "/api/ressources/" + id,
        success: function () {
            var st = $(`#select-css option[data-id=${id}]`);
            st.remove();
            $("#name-css").val("");
            editor_css.setValue("");
        }
    });
});
$("#del_data").click(function (event) {
    event.preventDefault();
    var id = $("#select-data").children(':selected').attr('data-id');
    $.ajax({
        type: "DELETE",
        beforeSend: function () {
            $('#del_data_item_loader').show();
            $('#del_data_icon').hide();
            $('#del_data').attr('disabled', true);
        },
        complete: function () {
            $('#del_data_item_loader').hide();
            $('#del_data_icon').show();
            $('#del_data').attr('disabled', false);
        },
        url: "/api/ressources/" + id,
        success: function () {
            var st = $(`#select-data option[data-id=${id}]`);
            st.remove();
            $("#name-data").val("");
            editor_json.setValue("");
        }
    });
});
$("#del_template").click(function (event) {
    event.preventDefault();
    var id = $("#select-template").children(':selected').attr('data-id');
    $.ajax({
        type: "DELETE",
        beforeSend: function () {
            $('#del_template_item_loader').show();
            $('#del_template_icon').hide();
            $('#del_template').attr('disabled', true);
        },
        complete: function () {
            $('#del_template_item_loader').hide();
            $('#del_template_icon').show();
            $('#del_template').attr('disabled', false);
        },
        url: "/api/ressources/" + id,
        success: function () {
            var st = $(`#select-template option[data-id=${id}]`);
            st.remove();
            $("#name-template").val("");
            editor_html.setValue("");
        }
    });
});