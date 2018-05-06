function highlightEdit(editableObj) {
    $(editableObj).css("background", "#F9F9F9");
    $(editableObj).css("color", "#000");
}

function saveInlineEdit(editableObj, column, id) {
    // no change change made then return false
    if ($(editableObj).attr('data-old_value') === editableObj.innerHTML)
        return false;
    // send ajax to update value
    $(editableObj).css("background", "#F9F9F9 url(img/spinner.gif) no-repeat right");
    $(editableObj).css("color", "#000");
    $.ajax({
        url: "inlineedit.php",
        cache: false,
        data: 'column=' + column + '&value=' + editableObj.innerHTML + '&id=' + id,
        success: function(response) {
            console.log(response);
            // set updated value as old value
            $(editableObj).attr('data-old_value', editableObj.innerHTML);
            $(editableObj).css("background", "#F9F9F9");
            $(editableObj).css("color", "#2ECC71");
        }
    });
}
