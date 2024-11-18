document.addEventListener("DOMContentLoaded", () => {
    // Select all forms on the page
    const forms = document.querySelectorAll("form");

    forms.forEach((form) => {
        form.addEventListener("submit", (event) => {
            // Prevent form submission
            event.preventDefault();

            let isValid = true; 
            let errorMessage = ""; 

            const productId = form.querySelector("#productId")?.value.trim();
            const productName = form.querySelector("#productName")?.value.trim();
            const productDescription = form.querySelector("#productDescription")?.value.trim();
            const productPrice = form.querySelector("#productPrice")?.value.trim();
            const productCategory = form.querySelector("#productCategory")?.value.trim();

            if (!productName || productName.length < 3) {
                errorMessage += "Product Name must be filled with at least 3 characters.\n";
                isValid = false;
            }

            if (!productDescription || productDescription.length < 10) {
                errorMessage += "Product Description must be filled with at least 10 characters.\n";
                isValid = false;
            }

            if (!productPrice || isNaN(productPrice) || Number(productPrice) <= 0) {
                errorMessage += "Product Price must be filled with a valid positive number.\n";
                isValid = false;
            }

            if (!productCategory || productCategory.length < 3) {
                errorMessage += "Product Category must be filled with at least 3 characters.\n";
                isValid = false;
            }

            if (!isValid) {
                alert(errorMessage); // Show errors in an alert
            } else {
                form.submit(); // Submit this specific form if validation passes
            }
        });
    });
});
