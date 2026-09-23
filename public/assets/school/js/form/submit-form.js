$(document).ready(function () {
    $("form.submit-form").on("submit", async function (event) {
        event.preventDefault();

        const form = $(this); // Get the specific form
        const btn = form.find(".submit-btn"); // Get the submit button within the form
        const originalBtnText = btn.text();

        // Clear previous error messages inside this form only
        form.find(".error-message").remove();
        form.find(".is-invalid").removeClass("is-invalid");

        let isValid = true;
        const requiredFields = form.find(
            "input.required, textarea.required, select.required"
        ); // Select required fields within this form only

        let firstInvalidField = null;

        requiredFields.each(function () {
            const field = $(this);
            if (!field.val().trim()) {
                isValid = false;
                field.addClass("is-invalid");

                const errorMsg = $("<div>")
                    .addClass("error-message text-danger small mt-1")
                    .text("This field is required");
                field.after(errorMsg);

                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
            }
        });

        if (!isValid) {
            if (form.hasClass("scroll-top") && firstInvalidField) {
                $("html, body").animate(
                    {
                        scrollTop: firstInvalidField.offset().top - 100, // adjust offset as needed
                    },
                    500
                );
            }

            if (form.hasClass("show-swal")) {
                Swal.fire({
                    text: "Please fill all required fields.",
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                });
            } else {
                toastr.error("Please fill all required fields.");
            }
            return; // Stop submission if validation fails
        }

        // Prepare FormData for file upload support
        const formData = new FormData(this);

        try {
            btn.prop("disabled", true).html(
                `Please wait...    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>`
            );

            const response = await fetch(form.attr("action"), {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: formData, // Sends as multipart/form-data
            });

            const data = await response.json();

            if (response.ok) {
                if (form.hasClass("show-swal")) {
                    Swal.fire({
                        text: data.message,
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    });
                } else {
                    toastr.success(data.message);
                }

                const redirectUrl = form.attr("data-redirect");
                if (redirectUrl) {
                    window.location.href = redirectUrl;
                }

                if (!form.hasClass("edit-form")) {
                    form[0].reset(); // Reset the specific form
                }
                if (form.hasClass("reload")) {
                    window.location.reload();
                }
            } else if (response.status === 422) {
                // Validation errors
                $.each(data.errors, function (key, messages) {
                    const inputField = form.find(`[name="${key}"]`);
                    if (inputField.length) {
                        inputField.addClass("is-invalid");
                        const errorMessage = $("<div>")
                            .addClass("error-message text-danger small mt-1")
                            .text(messages[0]);
                        inputField.parent().append(errorMessage);
                    }
                });

                if (form.hasClass("show-swal")) {
                    Swal.fire({
                        text: "Please correct the errors and try again.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    });
                } else {
                    toastr.error("Please correct the errors and try again.");
                }
            } else {
                if (form.hasClass("show-swal")) {
                    Swal.fire({
                        text:
                            data.message ||
                            "Something went wrong. Please try again.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    });
                } else {
                    toastr.error(
                        data.message ||
                            "Something went wrong. Please try again."
                    );
                }
            }
        } catch (error) {
            if (form.hasClass("show-swal")) {
                Swal.fire({
                    text:
                        "Sorry, looks like there are some errors detected, please try again. \n" +
                        response.message,
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                });
            } else {
                toastr.error("An unexpected error occurred.");
            }

            console.error("Error:", error);
        } finally {
            btn.prop("disabled", false).text(originalBtnText);
        }
    });
});
