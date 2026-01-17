document.addEventListener("DOMContentLoaded", function () {
    const photo = document.getElementById("photo");
    const preview = document.getElementById("preview");

    if (!photo || !preview) return;

    photo.addEventListener("change", function (e) {
        const file = e.target.files[0];
        if (!file) return;

        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
    });
});
