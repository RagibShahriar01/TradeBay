document.addEventListener("DOMContentLoaded", () => {

    // ================= TAB SWITCHING (JS ONLY) =================
    const tabs = document.querySelectorAll(".tab-btn");
    const contents = document.querySelectorAll(".tab-content");

    function resetAccountEditMode() {
        const editBtn = document.getElementById("editAccountBtn");
        const saveBtn = document.getElementById("saveAccountBtn");

        const nameInput = document.getElementById("nameInput");
        const phoneInput = document.getElementById("phoneInput");
        const emailInput = document.getElementById("emailInput");
        const genderInput = document.getElementById("genderInput");

        if (nameInput) nameInput.disabled = true;
        if (phoneInput) phoneInput.disabled = true;

        // extra safety
        if (emailInput) emailInput.disabled = true;
        if (genderInput) genderInput.disabled = true;

        if (editBtn) editBtn.classList.remove("save-hidden");
        if (saveBtn) saveBtn.classList.add("save-hidden");
    }

    tabs.forEach(tab => {
        tab.addEventListener("click", () => {
            tabs.forEach(t => t.classList.remove("active"));
            contents.forEach(c => c.classList.remove("active"));

            tab.classList.add("active");
            const target = tab.getAttribute("data-target");
            document.getElementById(target).classList.add("active");

            // if user leaves account tab, lock it again
            if (target !== "account") {
                resetAccountEditMode();
            }
        });
    });


    // ================= ACCOUNT EDIT/SAVE TOGGLE (JS ONLY) =================
    const editBtn = document.getElementById("editAccountBtn");
    const saveBtn = document.getElementById("saveAccountBtn");

    const nameInput = document.getElementById("nameInput");
    const phoneInput = document.getElementById("phoneInput");

    // must stay locked always
    const emailInput = document.getElementById("emailInput");
    const genderInput = document.getElementById("genderInput");

    if (editBtn && saveBtn && nameInput && phoneInput) {
        editBtn.addEventListener("click", () => {

            // enable only name + phone
            nameInput.disabled = false;
            phoneInput.disabled = false;

            // force lock
            if (emailInput) emailInput.disabled = true;
            if (genderInput) genderInput.disabled = true;

            // show save button, hide edit
            editBtn.classList.add("save-hidden");
            saveBtn.classList.remove("save-hidden");

            nameInput.focus();
        });
    }

});
