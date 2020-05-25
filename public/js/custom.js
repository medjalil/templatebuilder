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

            //$("#select-css").html("");
            $.each(resp, function (key, val) {
                if (val.type === "css") {
                    $("#select-css").append(
                            `<option data-cs="${val.content}" value="${val.name}" data-id="${val.id}">${val.name}</option>`
                            );
                } else if (val.type === "json") {
                    $("#select-data").append(
                            `<option data-cs='${val.content}' value="${val.name}" data-id="${val.id}">${val.name}</option>`
                            );
                } else {

                    $("#select-template").append(
                            `<option data-cs='${val.content}' value="${val.name}" data-id="${val.id}">${val.name}</option>`
                            );
                }

            });
        }
    });
}
reloadRessource();
// Création de code
require.config({paths: {'vs': 'https://unpkg.com/monaco-editor@latest/min/vs'}});
require(['vs/editor/editor.main'], function () {
//Editeur CSS
    var editor = monaco.editor.create(document.getElementById('code-css'), {
        value: [].join('\n'),
        language: 'css',
        theme: 'vs-dark'
    });
    $("#select-css").on('click', function () {
        $("#name-css").val(this.value);
        editor.setValue($(this).find('option:selected').attr('data-cs'));
    });
    $("#css_save").click(function (event) {
        event.preventDefault();
        var name = $("#name-css").val();
        if (name == "") {
            $("#name-css").addClass("is-invalid");
        } else {
            var name = $("#name-css").val();
            var code = JSON.stringify(editor.getValue());
            $.ajax({
                type: "POST",
                beforeSend: function () {
                    $('#add_css_item_loader').show();
                    $('#css_save_icon').hide();
                    $('#css_save').attr('disabled', true);
                },
                complete: function () {
                    $('#add_css_item_loader').hide();
                    $('#css_save_icon').show();
                    $('#css_save').attr('disabled', false);
                },
                contentType: "application/json",
                url: "/api/ressources",
                data: `{"name":"${name}","type":"css","content":${code},"mustache": "/api/mustaches/${mustache_id}"}`,
                dataType: "json",
                success: function (resp) {
                    var code2 = code.replace(/\\n/g, " ");
                    $("#select-css").append(
                            `<option data-cs=${code2} value="${name}" data-id="${resp.id}">${name}</option>`
                            );
                    $("#select-css").val(name);
                    if ($("#name-css").hasClass("is-invalid")) {
                        $("#name-css").removeClass("is-invalid");
                    }
                }
            });
        }
    });
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
                editor.setValue("");
            }
        });
    });
    //Editeur JSON
    var editor1 = monaco.editor.create(document.getElementById('code-data'), {
        value: [].join('\n'),
        language: 'json',
        theme: 'vs-dark'
    });
    $("#select-data").on('click', function () {
        $("#name-data").val(this.value);
        editor1.setValue($(this).find('option:selected').attr('data-cs'));
    });
    $("#save_data").click(function (event) {
        event.preventDefault();
        var name = $("#name-data").val();
        if (name == "") {
            $("#name-data").addClass("is-invalid");
        } else {
            var code = JSON.stringify(editor1.getValue());
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
                contentType: "application/json",
                url: "/api/ressources",
                data: `{"name":"${name}","type":"json","content":${code},"mustache": "/api/mustaches/${mustache_id}"}`,
                dataType: "json"
                , success: function (resp) {
                    var code2 = code.replace(/\\n/g, " ");
                    code2 = code2.substr(1, code2.length - 2);
                    code2 = code2.replace(/\\/g, "");

                    $("#select-data").append(
                            `<option data-cs='${code2}' value="${name}" data-id="${resp.id}">${name}</option>`
                            );
                    $("#select-data").val(name);
                    if ($("#name-data").hasClass("is-invalid")) {
                        $("#name-data").removeClass("is-invalid")
                    }
                }
            });
        }
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
                editor1.setValue("");
            }
        });
    });
    //Editeur HTML
    var editor2 = monaco.editor.create(document.getElementById('code-html'), {
        value: [].join('\n'),
        language: 'html',
        theme: 'vs-dark'
    });
    $("#select-template").on('click', function () {
        $("#name-template").val(this.value);
        editor2.setValue($(this).find('option:selected').attr('data-cs'));
    });
    $("#save_template").click(function (event) {
        event.preventDefault();
        var name = $("#name-template").val();
        if (name == "") {
            $("#name-template").addClass("is-invalid");
        } else {
            var code = JSON.stringify(editor2.getValue());

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
                contentType: "application/json",
                url: "/api/ressources",
                data: `{"name":"${name}","type":"html","content":${code},"mustache": "/api/mustaches/${mustache_id}"}`,
                dataType: "json"
                , success: function (resp) {
                    $("#select-template").append(
                            `<option data-cs=${code} value="${name}" data-id="${resp.id}">${name}</option>`
                            );
                    $("#select-template").val(name);
                    if ($("#name-template").hasClass("is-invalid")) {
                        $("#name-template").removeClass("is-invalid")
                    }
                }
            });
        }
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
                editor2.setValue("");
            }
        });
    });
    // Exécution de editeur
    $("#btn-run").click(function (event) {
        event.preventDefault();
        var css = editor.getValue();
        var data = editor1.getValue();
        var template = editor2.getValue();
        rendered = Mustache.render(template, JSON.parse(data));
        $('#renderFrame').contents().find('body').html(rendered);
        $('#renderFrame').contents().find('head').html('<style>' + css + '</style>');
    });
});
// Exporter en image
$("#btn-image").click(function (event) {
    event.preventDefault();
    $('#renderFrame').contents().find('body').html2canvas({
        onrendered: function (canvas) {
            var img = canvas.toDataURL("image/png");
            $('#img').html('');
            $('#img').prepend('<img src="' + img + '" />');
            $('#modalImg').modal('show');
        }
    });
});
