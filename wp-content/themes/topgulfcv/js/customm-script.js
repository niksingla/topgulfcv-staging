document.addEventListener('change', function (e) {
    var inputFile = e.target;
    if (inputFile.type === 'file' && inputFile.files.length > 0) {
        var fileNameContainer = document.getElementById('selected-file-name');
        if (fileNameContainer) {
            fileNameContainer.textContent = inputFile.files[0].name;
        }
    }
});
