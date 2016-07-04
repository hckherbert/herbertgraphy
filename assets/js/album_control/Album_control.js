Album_control.prototype.mParentId = null;
Album_control.prototype.mQueueItemCount = 0;
Album_control.prototype.mIsValidatedUpload = true;
Album_control.prototype.mSimUploadLimit = 10;
Album_control.prototype.mFileSizeLimit = "2MB";
Album_control.prototype.mErrorMsgUpload = "";
Album_control.prototype.mUploadFormData = null;
Album_control.prototype.mOriginalPhotoData = null;

function Album_control(pAlbumId, pParentId)
{
    this.init_ui();

    //Case for all album listings
    if (pAlbumId==undefined && pParentId==undefined)
    {
        this.get_all_parent_albums();
    }
    else
    {
        //case for adding sub album page or getting sub album details page
        if (pParentId != null && pParentId != "" && pParentId != undefined)
        {
            this.mParentId = pParentId;
        }
        //case for parent album details
        else
        {
            this.get_sub_album_list(pAlbumId);
        }
    }

    if ($(".formUpdatePhotoData").size())
    {
        this.mOriginalPhotoData = new OriginalPhotoData($(".formUpdatePhotoData"));
    }

    this.init_upload();
    this.prepare_listeners();
    this.submit_handler();
}


Album_control.prototype.init_ui = function()
{
    $(".albumList tbody").sortable();

}

Album_control.prototype.init_upload = function()
{
    var _self = this;
    var _itemToUploadCount = 0;
    var _itemTemplate = "";
    var _uploadButtonText = "";
    var _isQueueCleared = false;
    var _onCancelCount = 0;

    _itemTemplate += "<div class='uploadifive-queue-item'>";
    _itemTemplate += "<span class='filename'></span>";
    _itemTemplate += "<span class='fileinfo'></span>";
    _itemTemplate += "<div class='close'></div><div class='progress'><div class='progress-bar'></div></div>";
    _itemTemplate += "<div class='imgPreview'></div>";
    _itemTemplate += "<input name='new_filename' value='' type='text' placeholder='Rename me if possible' pattern='^[a-zA-Z0-9-_]+$' maxlength='50'>";
    _itemTemplate += "<span class='error hide'>Number, letters and hyphens only</span>";
    _itemTemplate += "<input name='title' value='' type='text' placeholder='Give me a title if you wish' maxlength='100'>";
    _itemTemplate += "<textarea name='desc' value='' placeholder='Say something about me if you wish' maxlength='500'></textarea>";
	_itemTemplate += "<label><input type='radio' name='featured' value='1'>Featured</label>";
    _itemTemplate += "</div>";

    this.mErrorMsgUpload = "Upload cannot be started. Please check that: <br> - Each file is under " + _self.mFileSizeLimit + ".<br> - Each time only " + _self.mSimUploadLimit + " photos can be selected.<br>- Files are image type.<br>Also check the error notices (if any) about the input fields.";

    if ($("#page_album_list").size() || $("#page_add_subalbum").size())
    {
        _uploadButtonText = "Drop files to me or click me. You can skip photos and add later.";
    }
    else if ($("#page_album_details").size())
    {
        if ($(".photo_data").size())
        {
            _uploadButtonText = "Drop files to me or click me to make me richer.";
        }
        else
        {
            _uploadButtonText = "Drop files to me or click me. You can skip photos and add later.";
        }
    }

    $('#file_upload').uploadifive({
        'auto'             : false,
        'buttonText'		: _uploadButtonText,
        'buttonClass'		:  "dropButton",
        //'checkScript'      : 'check-exists.php',
        //'checkScript'      : '<?php echo site_url(); ?>admin/album_control/check_exist',
        'dnd': true,
        'fileSizeLimit': _self.mFileSizeLimit,
        'formData'         : _self.mUploadFormData,
        'itemTemplate'	   : _itemTemplate,
        'queueID'          : 'queue',
        'uploadScript'     : GLOBAL_SITE_URL + "admin/album_control/upload/",
        'simUploadLimit'      : _self.mSimUploadLimit,
        'fileType'         : "image/png, image/gif, image/jpg",
        'removeCompleted': true,
        'onAddQueueItem'       : function(file)
        {
            console.log("onAddQueueItem");

            $("#uploadifive-file_upload-file-" + _self.mQueueItemCount).attr("data-filename", file.name);

            if (!_self.isValidUploadFileExtension(file["name"]))
            {
                $("#uploadifive-file_upload-file-" + _self.mQueueItemCount).find(".fileinfo").text(" - File type not allowed");
                $("#uploadifive-file_upload-file-" + _self.mQueueItemCount).addClass("error");
                _self.mIsValidatedUpload = false;
            }

            //note that mQueueItemCount will KEEP accmulating for every batch upload
            _self.mQueueItemCount++;

            var reader = new FileReader();
            reader.onload = function(e)
            {
                $(".uploadifive-queue-item[data-filename='" + e.target.filename + "'] .imgPreview").append("<img class='uploadImgPreview' src='" + e.target.result + "' /></p>");
            }

            reader.filename = file.name;
            reader.readAsDataURL(file);

        },
        'onUploadComplete' : function(file, data)
        {
            console.log("onuploadcomplete");

        },
        'onClearQueue': function(queue)
        {
            console.log("cleared");
            _isQueueCleared = true;
        },
        'onError': function(errorType, files)
        {
            console.log("onError");
            _self.mIsValidatedUpload = false;
        },
        'onCancel': function(file)
        {
            console.log("onCancel: " + file.name);

            if (_isQueueCleared)
            {
                _onCancelCount++;

                if (_onCancelCount == _itemToUploadCount && !$("#page_album_list").size())
                {
                    _self.displaySuccess("Photos are uploaded successfully.", "_self");
                }
            }

        },
        'onQueueComplete':function(pUploads)
        {
            console.log("onQueueComplete; " + pUploads["attempted"] + "; " +  pUploads["successful"]);

            console.log(pUploads);

            if (pUploads["errors"] == 0)
            {
                //reset isvalidateUpload
                _self.mIsValidatedUpload = true;

                if ($("#page_album_list").size() || $("#page_add_subalbum").size())
                {
                    $("#formAddAlbum").submit();
                }

                $('#file_upload').uploadifive('clearQueue');
            }
            else
            {
                _self.displayFail(_self.mErrorMsgUpload);
            }

        },
        'onUpload': function()
        {
			console.log("onuploadFile");

            var _albumId = 0;
            var _album_label = "";
            var _photo_user_data = {};
            _photo_user_data["new_filename"] = [];
            _photo_user_data["original_filename"] = [];
            _photo_user_data["desc"] = [];
            _photo_user_data["title"] = [];
			_photo_user_data["featured"] = [];

            $(".uploadifive-queue-item").each(
                function(i,e)
                {
                    _photo_user_data["new_filename"].push($(e).find("input[name='new_filename']").val());
                    _photo_user_data["original_filename"].push($(e).find(".filename").text());
                    _photo_user_data["desc"].push($(e).find("textarea[name='desc']").val());
                    _photo_user_data["title"].push($(e).find("input[name='title']").val());
					if ($(e).find("input[name='featured']").is(":checked"))
					{
						_photo_user_data["featured"].push("1");
					}
					else
					{
						_photo_user_data["featured"].push("0");
					}
                }
            );

            _photo_user_data = JSON.stringify(_photo_user_data);

            if ($("#page_album_list").size() || $("#page_add_subalbum").size())
            {
                _album_label = $("#formAddAlbum").find("input[name='label']").val();
            }
            else if ($("#page_album_details").size())
            {
                _album_label = $("#uploaderWrapper input[name='existing_label']").val();
                _albumId = $("#uploaderWrapper input[name='albumId']").val();
            }

            _self.mUploadFormData =
            {
                "albumId":_albumId,
                "timestamp": mTimeStamp,
                "token": mToken,
                "photo_user_data": _photo_user_data,
                "album_label":_album_label
            };

            $("#file_upload").data("uploadifive").settings.formData = _self.mUploadFormData;

            _itemToUploadCount =  $(".uploadifive-queue-item").size();

        }
    });

    $(document).on(
        "keyup",
        ".uploadifive-queue-item input[name='new_filename']",
        function()
        {
            var _pattern = $(this).attr('pattern');
            var _value =$(this).val();

            if (_value.match( new RegExp(_pattern)) || _value=="")
            {
                $(this).next(".error").addClass("hide");
            }
            else
            {
                $(this).next(".error").removeClass("hide");
            }
        }
    )
}

Album_control.prototype.isValidUploadFileExtension = function(pFileName)
{
    var _lastDotIndex = pFileName.lastIndexOf(".");

    if (!_lastDotIndex)
    {
        return;
    }

    var _extension = pFileName.substr(_lastDotIndex+1).toLowerCase();

    if (_extension!= "jpg" &&  _extension !="gif" && _extension !="png")
    {
        return;
    }

    return true;
}

Album_control.prototype.check_is_unique_new_photo_filenames = function(pSelectorString)
{
    var _new_filenames_occurances = [];
    var _duplicated_filenames_found = false;

    $(pSelectorString).each
    (
        function(i,e)
        {
            var _key = $.trim($(e).val()).toLowerCase();
            if (!_new_filenames_occurances[_key])
            {
                _new_filenames_occurances[_key] = 1;
            }
            else
            {
                _new_filenames_occurances[_key]++;
            }

            console.log(_key);
        }
    );

    $(pSelectorString).each
    (
        function(i,e)
        {
            var _filename = $.trim($(e).val()).toLowerCase();

            if (_new_filenames_occurances[_filename] > 1 && _filename!="")
            {
                if ($('.formUpdatePhotoData').size())
                {
                    if ($(e).next(".error").hasClass("hide") && $(e).closest(".photo_data").find(".original_filename").text() != _filename)
                    {
                        $(e).next(".error").removeClass("hide").text("Filename duplicated");
                    }
                }
                else
                {
                    $(e).next(".error").removeClass("hide").text("Filename duplicated");
                }

                _duplicated_filenames_found = true;
            }
            else
            {
                $(e).next(".error").addClass("hide");
            }
        }
    );

    return !_duplicated_filenames_found;
}

//Used when uploading photos to new album, or when adding more photos to existing album
Album_control.prototype.is_validate_upload_new_photo_data = function()
{
    var _self = this;
    var _is_unique_filenames = true;
    var _is_photo_input_validated = true;

    //these errors are regarding the photo input fields;
    $(".uploadifive-queue-item .error").each(
        function(i,e)
        {
            if (!$(e).hasClass("hide"))
            {
                _is_photo_input_validated = false;
            }
        }
    );

    _is_unique_filenames = _self.check_is_unique_new_photo_filenames(".uploadifive-queue-item input[name='new_filename']");

    if (!_is_unique_filenames)
    {
        _is_photo_input_validated = false;
    }

    //these errors are those attached to photo queue item directly
    if (!$(".uploadifive-queue-item.error").size())
    {
        _self.mIsValidatedUpload = true;
    }

    if (_self.mIsValidatedUpload == false || _is_photo_input_validated == false)
    {
        _self.displayFail(_self.mErrorMsgUpload);
        return false;
    }

    return true;
}

Album_control.prototype.submit_handler = function()
{
    var _self = this;

    //Click the Add button, upload photos if any, or add direct album
    $("#sectionAddAlbum input[name='submit']").on("click", function()
    {
        if ($("#page_album_list").size() || $("#page_add_subalbum").size())
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

                       if ( _self.is_validate_upload_new_photo_data())
                       {
                           if ($(".uploadifive-queue-item").size())
                           {
                               $('#file_upload').uploadifive('upload');
                           }
                           else
                           {

                               $("#formAddAlbum").submit();
                           }
                       }
                    },
                    error: function(pData, jqxhr, status)
                    {
                        $("#formAddAlbum").find(".error").empty();

                        if (pData["responseJSON"]["error_messages"]["validation_error"])
                        {
                            for (var err_label in pData["responseJSON"]["error_messages"])
                            {
                                if (err_label != "validation_error")
                                {
                                    $("#formAddAlbum").find("input[name='" + err_label + "']").next(".error").text(pData["responseJSON"]["error_messages"][err_label]);
                                }
                            }

                            _self.displayFail(_self.mErrorMsgUpload);
                        }
                        else
                        {
                            _self.displayFail();
                        }
                    }
                }
            );
        }
        else if ($("#page_album_details").size())
        {
            if ( _self.is_validate_upload_new_photo_data())
            {
                var _i = 0;
                var _duplicated_index_array = [];
                var _new_file_names_array = [];

                $("input[name='new_filename']").each(
                    function(i,e)
                    {
                        _new_file_names_array.push($.trim($(e).val()).toLowerCase());
                    }
                )

                if (_self.mOriginalPhotoData)
                {
                    _duplicated_index_array = _self.mOriginalPhotoData.check_unique_with_new_filenames(_new_file_names_array);

                    if (_duplicated_index_array.length)
                    {
                        for (_i = 0; _i < _duplicated_index_array.length; _i++)
                        {
                            $("input[name='new_filename']:eq(" + _duplicated_index_array[_i] + ")").next(".error").removeClass("hide").text("Filename existed. Please use others.");
                        }

                        _self.displayFail(_self.mErrorMsgUpload);
                        return;
                    }
					
					if ($(".photo_data.featured").length)
					{
						
						$.ajax(
							{
								url: GLOBAL_SITE_URL + "admin/album_control/unset_featured",
								data: {"id":  $(".photo_data.featured").find("input[name='featured[]']").val()},
								type: "POST",
								dataType: "json",
								success: function (pData)
								{
									console.log("unset_featured done!");
								
									if ($(".uploadifive-queue-item").size())
									{
										$('#file_upload').uploadifive('upload');
									}	
								},
								error: function (jqxhr, status)
								{
									_self.displayFail();
								}
							}
						);
						
						return;
					}
					
                }

                if ($(".uploadifive-queue-item").size())
                {
                    $('#file_upload').uploadifive('upload');
                }
            }
        }
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
                            _self.displaySuccess("Operation is executed successfully.", "_self");
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

    $("#formAddAlbum").on
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
                            if ($("#page_album_list").size())
                            {
                                _self.displaySuccess("Album is added successfully.");
                                _formInstance.find(".error").empty();
                                _self.append_added_parent_album_record(pData["response"]["insert_id"], _formId);
                            }
                            else if ($("#page_add_subalbum").size())
                            {
                                var _location = GLOBAL_SITE_URL + "admin/album_control/album_details/" + pData["response"]["insert_id"];
                                _self.displaySuccess("Album is added successfully.", _location);
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
                            _self.displaySuccess("Album info is updated successfully.", "_self");
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
                            var _location;

                            if (_self.mParentId == null)
                            {
                                 _location =  GLOBAL_SITE_URL + "admin/album_control";
                            }
                            else
                            {
                                 _location = GLOBAL_SITE_URL + "admin/album_control/album_details/" + _self.mParentId;
                            }

                            _self.displaySuccess("Album is deleted succesfully.", _location);

                        }

                    },
                    error: function (pData, jqxhr, status)
                    {
                        _self.displayFail();
                    }
                }
            );
        }
    );

    $(".formUpdatePhotoData").on
    (
        "submit",
        function(pEvent)
        {
            pEvent.preventDefault();
            var _formInstance = $(this);
            var _postData = $(this).serializeArray();
            var _is_unique_filenames = _self.check_is_unique_new_photo_filenames(".photo_data input[name='new_filename[]']");

            if (! _is_unique_filenames)
            {
                _self.displayFail(_self.mErrorMsgUpload);
                console.log("not passed...");
                return;
            }

            $.ajax(
                {
                    url: _formInstance.attr("action") + "/" + mAlbum_id,
                    data: _postData,
                    type: "POST",
                    dataType: "json",
                    success: function (pData)
                    {
                        console.log(_postData);
                        _self.displaySuccess("Photo infos are updated successfully.", "_self");
                    },
                    error: function (jqxhr, status)
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

    $(".formInfo input[type='text'], .formInfo textarea").on("keydown, keyup", function(pEvent)
    {
        _self.onFormInfoFieldOnKeyDown(pEvent);
    });

    if ($("#formUpdatePhotoData").length)
    {
        $("#formUpdatePhotoData input[name='featured[]']").on("click", function(pEvent)
        {
            $("#formUpdatePhotoData input[name='featured[]']").val("0");
            $("#formUpdatePhotoData .photo_data.featured").removeClass("featured");

            if ($(this).is(":checked"))
            {
                console.log("photoid: " + $(this).closest(".photo_data").attr("data-photoId"));
                $(this).val($(this).closest(".photo_data").attr("data-photoId"));
                $(this).closest(".photo_data").addClass("featured");
            }
            else
            {
                $(this).val("0");
            }
        });
    }


}

Album_control.prototype.onFormInfoFieldOnKeyDown = function(pEvent)
{
    var _currentTarget = $(pEvent.currentTarget);

    if (_currentTarget.next(".error").text()!= "")
    {
        if (_currentTarget.val() != "")
        {
            _currentTarget.next(".error").text("");
        }
    }
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

    _new_album_html += "<tr class='ui-sortable-handle'>";
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

Album_control.prototype.displaySuccess = function(pMessage, pRedirectLocation)
{
    $(".ajaxSuccessDisplay p").empty().html(pMessage);
    $(".ajaxSuccessDisplay").removeClass("hide");

    setTimeout(function()
    {
        $(".ajaxSuccessDisplay").addClass("fadeIn");

        if (pRedirectLocation)
        {
            if (pRedirectLocation == "_self")
            {
                setTimeout(function ()
                {
                    location.reload();

                }, 1200);
            }
            else
            {
                setTimeout(function ()
                {
                    location.href = pRedirectLocation;

                }, 1200);
            }
        }

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
        $(".ajaxFailDisplay p").empty().html("Oops. Something went wrong. Please try again later.");
    }
    else
    {
        $(".ajaxFailDisplay p").empty().html(pMsg);
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
            2500
        )
    }
    else
    {
        $(".ajaxFailDisplay").addClass("hide");
    }
}