document.addEventListener("DOMContentLoaded", () => {

    //  Tabs Switching
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {

            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));

            tab.classList.add('active');
            const target = tab.getAttribute('data-target');
            document.getElementById(target).classList.add('active');
        });
    });

    //  Password Form Toggle 
    const showBtn = document.getElementById("showPasswordForm");
    const cancelBtn = document.getElementById("cancelPassword");
    const passwordForm = document.getElementById("passwordForm");

    if (showBtn && passwordForm) {
        showBtn.addEventListener("click", () => {
            passwordForm.classList.add("show");
            showBtn.style.display = "none";
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener("click", () => {
            passwordForm.classList.remove("show");
            showBtn.style.display = "block";
        });
    }

    //  Account Information Edit Button 
    const editBtn = document.getElementById("editAccountBtn");
    const inputs = document.querySelectorAll("#account input, #account select");

    if (editBtn) {
        editBtn.addEventListener("click", () => {
            const isDisabled = inputs[0].disabled; 

            // Toggle inputs
            inputs.forEach(input => input.disabled = !input.disabled);

            // Toggle button text
            editBtn.textContent = isDisabled ? "Save" : "Edit";

        });
    }

});
