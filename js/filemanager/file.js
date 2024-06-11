// function attachEventListeners() {
//     jQuery(document).ready(function () {
//         jQuery('#filePathSelect').change(function () {
//             var selectedValue = jQuery(this).val();
//             if (selectedValue) {
//                 jQuery.ajax({
//                     type: 'POST',
//                     url: "http://localhost/1SBMAGENTO/index.php/admin/filemanager/index", // Change this to your server-side script URL
//                     data: {
//                         filePath: selectedValue,
//                         form_key: FORM_KEY,
//                     },
//                     success: function (response) {
//                         $('gridContainer').update(response);
//                         attachEventListeners();
//                     },
//                     error: function (xhr, status, error) {
//                         console.error('AJAX Error:', status, error);
//                     }
//                 });
//             }
//         });
//     });
// }
// jQuery(document).ready(function () {
//     attachEventListeners();
// });

function loadData() {
    var filemanager = document.getElementById("filePathSelect").value;
    var url = "http://localhost/1SBMAGENTO/index.php/admin/filemanager/grid";
    var parameters = {
      filePath: btoa(filemanager),
    };
    new Ajax.Request(url, {
      method: "post",
      evalScripts: true,
      parameters: parameters,
      onSuccess: function (response) {
        $('gridContainer').update(response.responseText);
      },
    });
  }

jQuery(document).ready(function () {

    jQuery('body').on('click', '.editable', function () {
        var value = jQuery(this).text();
        var element = jQuery(this);
        // console.log(value);
        var url = jQuery(this).data('url');
        var fullpath = jQuery(this).data('fullpath');
        // console.log(fullpath);

        var textarea = jQuery('<textarea></textarea>').val(value);

        // Create save button
        var saveButton = jQuery('<button>save</button>').on('click', function (e) {
            e.preventDefault();
            var newValue = textarea.val();
            // console.log(newValue);            
            handleFileNameClick(fullpath, newValue, url,value);
        });

        // Create cancel button
        var cancelButton = jQuery('<button>cancle</button>').on('click', function () {
            // Restore the original value
            element.html(value);
        });

        // Clear the content of the element and append textarea and buttons
        element.empty().append(textarea).append(saveButton).append(cancelButton);

        // Focus on the textarea
        textarea.focus();

    });

    function handleFileNameClick(fullpath, newValue, url,value) {
        var redirectUrl = url + "?fullpath=" + encodeURIComponent(fullpath) + "&newValue=" + encodeURIComponent(newValue) +"&value=" + encodeURIComponent(value);
        window.location.href = redirectUrl;
    }
});
