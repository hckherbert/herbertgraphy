Album_control.prototype.mParentId = null;
Album_control.prototype.mQueueItemCount = 0;

function Album_control(pAlbumId, pParentId)
{
    this.init_ui();

    if (pAlbumId==undefined && pParentId==undefined)
    {
        this.get_all_parent_albums();
    }
    else
    {
        if (pParentId==undefined || pParentId=="")
        {
            this.get_sub_album_list(pAlbumId);
        }
        else
        {
            this.mParentId = pParentId;
        }
    }

    this.initUpload();
    this.prepare_listeners();
    this.submit_handler();
}


Album_control.prototype.init_ui = function()
{
    $(".albumList tbody").sortable();

}

Album_control.prototype.initUpload = function()
{
    var _self = this;
    var mUploadedCount = 0;


    $('#file_upload').uploadifive({
        'auto'             : false,
        'buttonText'		: "drop files to me or click me. You can skip photos and add later.",
        'buttonClass'		:  "dropButton",
        //'checkScript'      : 'check-exists.php',
        //'checkScript'      : '<?php echo site_url(); ?>admin/album_control/check_exist',
        'formData'         : {
            'timestamp' :  mTimeStamp,
            'token'     : mToken
        },
        'queueID'          : 'queue',
        'uploadScript'     : GLOBAL_SITE_URL + "admin/album_control/upload",
        'dnd': true,
        'itemTemplate'	   : "<div class='uploadifive-queue-item'><span class='filename'></span><span class='fileinfo'></span><div class='close'></div><div class='progress'><div class='progress-bar'></div></div></div>",
        'onAddQueueItem'       : function(file)
        {
            $("#uploadifive-file_upload-file-" + _self.mQueueItemCount).attr("data-filename", file.name);
            _self.mQueueItemCount++;

            var reader = new FileReader();
            reader.onload = function(e)
            {
                $(".uploadifive-queue-item[data-filename='" + e.target.filename + "']").append("<img class='uploadImgPreview' src='" + e.target.result + "' /></p>");
            }

            reader.filename = file.name
            reader.readAsDataURL(file);

        },
        'onUploadComplete' : function(file, data)
        {

        },
        'onQueueComplete':function(pUploads)
        {

            console.log(pUploads);

            if (pUploads["attempted"] == pUploads["successful"])
            {
                $("#formAddAlbum").submit();
            }
            else
            {
                _self.displayFail("Oops, some photos are not uploaded. Please try again.");
            }
        }
    });


}

Album_control.prototype.submit_handler = function()
{
    var _self = this;

    //Click the Add button, upload photos if any, or add direct album
    $("#sectionAddAlbum input[name='submit']").on("click", function()
    {
        $.ajax(
            {
                url: GLOBAL_SITE_URL + "admin/album_control/validate_add_album",
                data : $("#formAddAlbum").serializeArray(),
                type: "POST",
                dataType: "json",
                success: function(pData)
                {
                    //add album or start upload...
                    if ($(".uploadifive-queue-item").size())
                    {
                        _self.initUpload();
                        $('#file_upload').uploadifive('upload');
                    }
                    else
                    {
                        $("#formAddAlbum").submit();
                    }


                },
                error: function(pData, jqxhr, status)
                {
                    $("#formAddAlbum").find(".error").empty();

                    console.log(pData);

                    if (pData["responseJSON"]["error_messages"]["validation_error"])
                    {
                        for (var err_label in pData["responseJSON"]["error_messages"])
                        {
                            if (err_label != "validation_error")
                            {
                                $("#formAddAlbum").find("input[name='" + err_label + "']").next(".error").text(pData["responseJSON"]["error_messages"][err_label]);
                            }
                        }
                    }
                    else
                    {
                        _self.displayFail();
                    }
                }
            }
        );



    })

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
                var _confirmDelMsg = "";

                if (_formInstance.attr("id") == "formAlbumList")
                {
                    _confirmDelMsg = "Confirm delete the selected album(s)?";
                }
                else if (_formInstance.attr("id") == "formSubAlbumList")
                {
                    _confirmDelMsg = "Confirm delete the selected album(s)? Note that sub-album(s) will be deleted also";
                }


                if (confirm(_confirmDelMsg))
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

                console.log(_postData);

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
                            }

                            _self.displaySuccess("Operation is executed successfully.");
                        },
                        error: function (jqxhr, status)
                        {
                            _self.displayFail();
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
                        if (pData["successcode"] && pData["successcode"] == 1)
                        {
                            _self.displaySuccess("Album is added successfully.");
                            _formInstance.find(".error").empty();
                            _self.append_added_parent_album_record(pData["response"]["insert_id"], _formId);

                        }
                    },
                    error: function(pData, jqxhr, status)
                    {
                        _formInstance.find(".error").empty();

                        console.log(pData);

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
                        else
                        {
                            _self.displayFail();
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
                            _self.displaySuccess("Album info is updated successfully.");
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
                        else
                        {
                            _self.displayFail();
                        }

                    }
                }
            );
        }
    )


    $(".formDeleteAlbum").on
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

                        if (pData["successcode"] && pData["successcode"] == 1)
                        {
                            if (_self.mParentId == null)
                            {
                                location.href = GLOBAL_SITE_URL + "admin/album_control";
                            }
                            else
                            {
                                location.href = GLOBAL_SITE_URL + "admin/album_control/album_details/" + _self.mParentId;
                            }

                        }

                    },
                    error: function (pData, jqxhr, status)
                    {
                        _self.displayFail();
                    }
                }
            );
        }
    )
}


Album_control.prototype.prepare_listeners = function()
{
    var _self = this;

    $(".ajaxSuccessDisplay").on("transitionend", function()
    {
        _self.onAjaxSuccessDisplayTransEnd();
    });

    $(".ajaxFailDisplay").on("transitionend", function()
    {
        _self.onAjaxFailDisplayTransEnd();
    });

}


Album_control.prototype.get_all_parent_albums = function()
{
    var _self = this;

    $.ajax
    (
        {
            url: "../admin/album_control/get_all_parent_albums",
            type: "POST",
            dataType: "json",
            success: function (pData)
            {
                if (pData["successcode"] && pData["successcode"] == 1)
                {
                    if (pData["response"].length)
                    {
                        _self.render_album_list(pData["response"]);
                    }
                    else
                    {
                        $(".formAlbumList").addClass("hide");
                        $(".label_no_album").removeClass("hide");
                    }
                }
                else
                {

                }
            },
            error: function()
            {
                _self.displayFail();
            }
        }
    );
}


Album_control.prototype.get_sub_album_list = function(pAlbumId)
{
    var _self = this;

    $.ajax
    (
        {
            url: "../get_subalbum_list/" + pAlbumId,
            type: "POST",
            dataType: "json",
            success: function (pData)
            {
                if (pData["successcode"] && pData["successcode"] == 1)
                {
                    if (pData["response"].length)
                    {
                        _self.render_album_list(pData["response"]);
                    }
                    else
                    {
                        $(".formAlbumList").addClass("hide");
                        $(".label_no_album").removeClass("hide");
                    }
                }
                else
                {

                }
            },
            error: function()
            {
                _self.displayFail();
            }
        }
    );
}

Album_control.prototype.refresh_album_list_on_updated = function()
{

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
                $(".formAlbumList").addClass("hide");
                $(".label_no_album").removeClass("hide");
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
    _new_album_html += "<td align='center'><input name='edit' type='button' value='Edit' onclick='location.href=&#39;" + GLOBAL_SITE_URL + "admin/album_control/album_details/" + pInsert_id + "&#39;'></td>";
    _new_album_html += "</tr>";

    $(".formAlbumList table tbody").append(_new_album_html);
    $(".formAlbumList").removeClass("hide");
    $(".label_no_album").addClass("hide");

    document.getElementById(pFormId).reset();
}


Album_control.prototype.render_album_list = function(pData)
{
    var _album_html = "";

    for (var _i=0; _i< pData.length; _i++)
    {
        $(".formAlbumList table tbody").empty();

        _album_html += "<tr class='ui-sortable-handle'>"
        _album_html += "<td>" + pData[_i]["name"] +  "</td>";
        _album_html += "<td>" + pData[_i]["label"] +  "</td>";
        _album_html += "<td>" + pData[_i]["intro"] +  "</td>";
        _album_html += "<td align='center'>";
        _album_html += "<input name='id[]' type='hidden' value='" + pData[_i]["id"] + "'>";
        _album_html += "<input name='del_id[]' type='checkbox' value='" + pData[_i]["id"] + "'>";
        _album_html += "<input name='order[]' type='hidden' value='" + pData[_i]["order"] + "'>";
        _album_html += "</td>";
        _album_html += "<td align='center'><input name='edit' type='button' value='Edit' onclick='location.href=&#39;" + GLOBAL_SITE_URL + "admin/album_control/album_details/" +  pData[_i]["id"] + "&#39;'></td>";
        _album_html += "</tr>";
    }

    $(".formAlbumList table tbody").append(_album_html);

    $(".formAlbumList").removeClass("hide");
    $(".label_no_album").addClass("hide");

}

Album_control.prototype.displaySuccess = function(pMessage)
{
    $(".ajaxSuccessDisplay p").empty().text(pMessage);
    $(".ajaxSuccessDisplay").removeClass("hide");

    setTimeout(function()
    {
        $(".ajaxSuccessDisplay").addClass("fadeIn");

    }, 200);
}

Album_control.prototype.onAjaxSuccessDisplayTransEnd = function()
{
    if ($(".ajaxSuccessDisplay").hasClass("fadeIn"))
    {
        setTimeout(
            function()
            {
                $(".ajaxSuccessDisplay").removeClass("fadeIn");
                return;
            },
            1000
        )
    }
    else
    {
        $(".ajaxSuccessDisplay").addClass("hide");
    }
}

Album_control.prototype.displayFail = function(pMsg)
{
    if (!pMsg)
    {
        $(".ajaxFailDisplay p").empty().text("Oops. Something went wrong. Please try again later.");
    }
    else
    {
        $(".ajaxFailDisplay p").empty().text(pMsg);
    }
    $(".ajaxFailDisplay").removeClass("hide");

    setTimeout(function()
    {
        $(".ajaxFailDisplay").addClass("fadeIn");

    }, 200);
}



Album_control.prototype.onAjaxFailDisplayTransEnd = function()
{
    if ($(".ajaxFailDisplay").hasClass("fadeIn"))
    {
        setTimeout(
            function()
            {
                $(".ajaxFailDisplay").removeClass("fadeIn");
                return;
            },
            1000
        )
    }
    else
    {
        $(".ajaxFailDisplay").addClass("hide");
    }
}