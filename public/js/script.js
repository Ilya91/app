Dropzone.options.addImages = {
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 2, // MB
    acceptedFiles: 'image/*',
    success: function(file, response) {
        //console.log(file.name);
        //console.log(response);
        if (file.status == 'success'){
            handleDropzone.handleSuccess(file);
        }else {
            handleDropzone.handleError(response);
        }
    }
};


var handleDropzone = {
    handleError: function (response) {

    },

    handleSuccess: function (file) {
        //console.log(file.name);
        var time = Math.round(new Date().getTime() / 1000);
        var imageList = $('#uploadedImages');
        var imageName = '/images/' + file.name;
        $(imageList).append('<li><a href=""><img src="' + imageName + '" alt=""></a></li>');
    }
};