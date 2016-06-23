/**
 * Created by HerbertHo on 5/11/2016.
 */
OriginalPhotoData.prototype.mPhotoDataForm = null;
OriginalPhotoData.prototype.mData_array = null;


function OriginalPhotoData(pPhotoDataForm)
{
    var _self = this;

    this.mPhotoDataForm = pPhotoDataForm;
    this.mData_array = [];

    $(".photo_data", this.mPhotoDataForm).each(
        function(i,e)
        {
            var _data_obj = {};
            _data_obj["original_file_name"] = $("input[name='new_filename[]']", $(e)).val();
            _self.mData_array.push(_data_obj);
        }
    );

    $("input[name='del_id[]']", this.mPhotoDataForm).on("change", function(pEvent)
    {
        _self.toggleRemove(pEvent);
    });
}

OriginalPhotoData.prototype.toggleRemove = function(pEvent)
{
    //console.log($(pEvent.currentTarget).is(":checked"));
    var _current_index = $(pEvent.currentTarget).index("input[name='del_id[]']", this.mPhotoDataForm);

}

OriginalPhotoData.prototype.check_unique_with_new_filenames = function(pNew_file_name_array)
{
    var _i = 0;
    var _j = 0;
    var _totalPhoto =  pNew_file_name_array.length;
    var _duplicated_index_array = [];

    for (_i = 0; _i < _totalPhoto; _i++)
    {
         for (_j = 0; _j < this.mData_array.length; _j++)
         {
             if (pNew_file_name_array[_i]!="" && this.mData_array[_j]["original_file_name"]==pNew_file_name_array[_i])
             {
                 _duplicated_index_array.push(_i);
             }
         }
    }

    console.log("@OriginalPhotoData check_unique_with_new_filenames: " + _duplicated_index_array);

    return _duplicated_index_array;
}
