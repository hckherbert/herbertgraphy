function Album_control()
{
    var _self = this;
    this.init_ui();
    this.submit_handler();
}


Album_control.prototype.init_ui = function()
{
    $(".albumList tbody").sortable();

}

Album_control.prototype.submit_handler = function()
{
    var _self = this;

    $("#formAlbumList").on
    (
        "submit",
        function(pEvent) {
            pEvent.preventDefault();

            if (confirm("Confirm delete the selected album(s)?"))
            {

                var _postData = $(this).serializeArray();

                $.ajax(
                    {
                        url: "album_control/update_album_list",
                        data: _postData,
                        type: "POST",
                        dataType: "json",
                        success: function (pData) {
                            if (pData["successcode"] && pData["successcode"] == 1) {
                                _self.refresh_album_list_on_updated();
                            }
                        },
                        error: function (jqxhr, status) {

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
                        }
                    },
                    error: function(pData, jqxhr, status)
                    {
                       console.log(pData);

                        _formInstance.find(".error").empty();

                        if (pData["responseJSON"]["error_messages"]["validation_error"])
                        {
                            for (var err_label in pData["responseJSON"]["error_messages"])
                            {
                                if (err_label != "validation_error")
                                {
                                    //console.log(pData["responseJSON"]["error_messages"][err_label]);
                                    _formInstance.find("input[name='" + err_label + "']").next(".error").text(pData["responseJSON"]["error_messages"][err_label]);
                                }
                            }
                        }
                    }
                }
            );
        }
    );
}


Album_control.prototype.refresh_album_list_on_updated = function()
{

    $(".albumList input[name='del_id[]']").each(
        function(i,e)
        {
            if ($(this).is(":checked"))
            {
                $(this).parents("tr").remove();
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

    document.getElementById(pFormId).reset();
}
