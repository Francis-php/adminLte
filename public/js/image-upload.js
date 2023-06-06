function updateFileName(input) {
    let fileName = input.files[0].name;
    let label = input.nextElementSibling;
    label.innerHTML = fileName;
}
