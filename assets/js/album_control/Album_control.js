function Album_control()
{
    var _self = this;

    /*
    var _state = History.getState();

    if (_state.data)
    {
        if (_state.data.action && _state.data.action=="add_parent_album")
        {
            $(".albumList tbody").empty().html(_state.data.album_list_data);

        }
        else
        {
            if (_state.data.action && _state.data.action=="edit_album_info")
            {
                $(".albumList tbody").empty().html(_state.data.updated_data);
                console.log(_state.data.updated_data);
            }
        }
    }

    History.Adapter.bind(window,'statechange',function()
    {
        var State = History.getState();
        console.log("aaaa");
        //History.log('statechange:', State.data, State.title, State.url);
    });
    */

    this.init_ui();
    this.submit_handler();

    if ($("#page_album_list").size())
    {
        this.get_all_parent_albums();
    }
}


Album_control.prototype.init_ui = function()
{
    $(".albumList tbody").sortable();

}

Album_control.prototype.submit_handler = function()
{
    var _self = this;

    $("#formAlbumList, #formSubAlbumList").on
    (
        "submit",
        function(pEvent)
        {
            pEvent.preventDefault();

            var _formInstance = $(this);
            var _del_count = $("input[name='del_id[]']:checked", _formInstance).size();
            var _isConfirmUpdate = true;

            if (_del_count > 0)
            {
                if (confirm("Confirm delete the selected album(s)?"))
                {
                    _isConfirmUpdate = true;
                }
                else
                {
                    _isConfirmUpdate = false;
                }


            }

            if (_isConfirmUpdate)
            {
                var _postData = $(this).serializeArray();

                $.ajax(
                    {
                        url: _formInstance.attr("action"),
                        data: _postData,
                        type: "POST",
                        dataType: "json",
                        success: function (pData)
                        {

                            if (pData["successcode"] && pData["successcode"] == 1)
                            {
                                _self.refresh_album_list_on_updated();
                               // History.pushState({"album_list_data": $(".albumList tbody").html()}, document.title, null);
                            }
                        },
                        error: function (jqxhr, status)
                        {

                        }
                    }
                );
            }
        }
    );

    $("#formAddAlbum, #formAddSubAlbum").on
    (
        "submit",
        function(pEvent)
        {
            pEvent.preventDefault();

            var _postData = $(this).serializeArray();
            var _formInstance = $(this);
            var _formId = _formInstance.attr("id");

            $.ajax(
                {
                    url: _formInstance.attr("action"),
                    data : _postData,
                    type: "POST",
                    dataType: "json",
                    success: function(pData)
                    {

                        _formInstance.find(".error").empty();

                        if (pData["successcode"] && pData["successcode"] == 1)
                        {
                            _self.append_added_parent_album_record(pData["response"]["insert_id"], _formId);

                            if (_formId == "formAddAlbum")
                            {
                                /*
                                History.pushState
                                (
                                    {
                                        "album_list_data": $(".albumList tbody").html(),
                                        "action":"add_parent_album"
                                    },
                                    document.title,
                                    null
                                );
                                */
                            }

                        }
                    },
                    error: function(pData, jqxhr, status)
                    {
                        _formInstance.find(".error").empty();

                        if (pData["responseJSON"]["error_messages"]["validation_error"])
                        {
                            for (var err_label in pData["responseJSON"]["error_messages"])
                            {
                                if (err_label != "validation_error")
                                {
                                    _formInstance.find("input[name='" + err_label + "']").next(".error").text(pData["responseJSON"]["error_messages"][err_label]);
                                }
                            }
                        }
                    }
                }
            );
        }
    );

    $("#formUpdateAlbumInfo").on
    (
        "submit",
        function(pEvent)
        {
            pEvent.preventDefault();

            var _postData = $(this).serializeArray();
            var _formInstance = $(this);

            $.ajax(
                {
                    url: _formInstance.attr("action"),
                    data: _postData,
                    type: "POST",
                    dataType: "json",
                    success: function (pData)
                    {
                        _formInstance.find(".error").empty();

                        if (pData["successcode"] && pData["successcode"] == 1)
                        {
                            console.log("update suc");

                            /*
                            History.replaceState
                            (
                                {
                                    "updated_data":
                                    {
                                        "name": $("input[name='name']", _formInstance).val(),
                                        "label": $("input[name='label']", _formInstance).val(),
                                        "intro": $("textarea[name='intro']", _formInstance).val(),
                                        "id":  $("input[name='id']", _formInstance).val()
                                    },
                                    "action": "edit_album_info"
                                },
                                document.title,
                                null
                            );
                            */

                        }

                    },
                    error: function (pData, jqxhr, status)
                    {
                        _formInstance.find(".error").empty();
                        if (pData["responseJSON"]["error_messages"]["validation_error"])
                        {
                            for (var err_label in pData["responseJSON"]["error_messages"])
                            {
                                if (err_label != "validation_error")
                                {
                                    _formInstance.find("input[name='" + err_label + "']").next(".error").text(pData["responseJSON"]["error_messages"][err_label]);
                                }
                            }
                        }
                    }
                }
            );
        }
    )
}

Album_control.prototype.get_all_parent_albums = function()
{

    var _self = this;

    $.ajax
    (
        {
            url: "album_control/get_all_parent_albums",
            type: "POST",
            dataType: "json",
            success: function (pData)
            {
                if (pData["successcode"] && pData["successcode"] == 1)
                {
                    if (pData["response"]["parent_albums"].length)
                    {
                        _self.refresh_parent_album_list(pData["response"]["parent_albums"]);
                    }
                    else
                    {
                        $(".firstAdded").addClass("hide");
                        $(".formAlbumList").hide();
                        $(".label_no_album").show();

                        if (!$(".firstAdded").size())
                        {
                            $(".formAlbumList").before("<p class='label_no_album'>There is no album</p>");
                        }
                    }
                }
                else
                {

                }
            },
            error: function()
            {
            }
        }
    );
}


Album_control.prototype.refresh_album_list_on_updated = function()
{

    console.log("a");

    $(".albumList input[name='del_id[]']").each
    (
        function(i,e)
        {
            if ($(this).is(":checked"))
            {
                $(this).parents("tr").remove();
            }

            if (!$(".albumList tbody tr").size())
            {

                $(".firstAdded").addClass("hide");
                $(".formAlbumList").hide();
                $(".label_no_album").show();

                if (!$(".firstAdded").size())
                {
                    $(".formAlbumList").before("<p class='label_no_album'>There is no album</p>");
                }
            }
        }
    )

    $(".albumList input[name='order[]']").each(
        function(i,e)
        {
            $(e).val(i);
        }
    )

}

Album_control.prototype.append_added_parent_album_record = function(pInsert_id, pFormId)
{

    var _album_name = $("#" + pFormId + " input[name='name']").val();
    var _album_label = $("#" + pFormId + " input[name='label']").val();
    var _album_intro = $("#" + pFormId + " textarea[name='intro']").val();
    var _total_rows_before_added = $(".albumList input[name='order[]']").size();

    var _new_album_html = "";

    _new_album_html += "<tr class='ui-sortable-handle'>"
    _new_album_html += "<td>" + _album_name +  "</td>";
    _new_album_html += "<td>" + _album_label +  "</td>";
    _new_album_html += "<td>" + _album_intro +  "</td>";
    _new_album_html += "<td align='center'>";
    _new_album_html += "<input name='id[]' type='hidden' value='" + pInsert_id + "'>";
    _new_album_html += "<input name='del_id[]' type='checkbox' value='" + pInsert_id + "'>";
    _new_album_html += "<input name='order[]' type='hidden' value='" + _total_rows_before_added + "'>";
    _new_album_html += "</td>";
    _new_album_html += "<td align='center'><input name='edit' type='button' value='Edit' onclick='location.href=&#39;album_control/album_details/" + pInsert_id + "&#39;'></td>";
    _new_album_html += "</tr>";

    $("#formAlbumList table tbody").append(_new_album_html);

    $(".formAlbumList").show();
    $(".label_no_album").hide();
    $(".firstAdded").removeClass("hide");

    document.getElementById(pFormId).reset();
}


Album_control.prototype.refresh_parent_album_list = function(pData)
{
    var _album_html = "";

    for (var _i=0; _i< pData.length; _i++)
    {
        $("#formAlbumList table tbody").empty();

        _album_html += "<tr class='ui-sortable-handle'>"
        _album_html += "<td>" + pData[_i]["name"] +  "</td>";
        _album_html += "<td>" + pData[_i]["label"] +  "</td>";
        _album_html += "<td>" + pData[_i]["intro"] +  "</td>";
        _album_html += "<td align='center'>";
        _album_html += "<input name='id[]' type='hidden' value='" + pData[_i]["id"] + "'>";
        _album_html += "<input name='del_id[]' type='checkbox' value='" + pData[_i]["id"] + "'>";
        _album_html += "<input name='order[]' type='hidden' value='" + pData[_i]["order"] + "'>";
        _album_html += "</td>";
        _album_html += "<td align='center'><input name='edit' type='button' value='Edit' onclick='location.href=&#39;album_control/album_details/" +  pData[_i]["id"] + "&#39;'></td>";
        _album_html += "</tr>";
    }

    $("#formAlbumList table tbody").append(_album_html);

    $(".formAlbumList").show();
    $(".label_no_album").hide();
    $(".firstAdded").removeClass("hide");

}