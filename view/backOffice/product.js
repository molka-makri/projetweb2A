
document.addEventListener("DOMContentLoaded", () => {


    const addForm = document.getElementById("addForm");
    const editForm = document.getElementById("editForm");

    
        addForm.addEventListener("submit", (event) => {
            // Prevent form submission
            event.preventDefault();
            
            let isValid = true; 
            let errorMessage = ""; 
            // console.log(errorMessage)
            const productId = addForm.querySelector("#productId")?.value.trim();
            const productName = addForm.querySelector("#productName")?.value.trim();
            const productDescription = addForm.querySelector("#productDescription")?.value.trim();
            const productPrice = addForm.querySelector("#productPrice")?.value.trim();

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
            
           

            if (!isValid) {
                alert(errorMessage); // Show errors in an alert
            } else {
                addForm.submit(); // Submit this specific form if validation passes
            }
        });

        editForm.addEventListener("submit", (event) => {
            event.preventDefault(); // Prevent form submission for validation
            console.log("aaaasba");
            let valid = true;
    
            // Get input values
            const productId = editForm.querySelector("#productId")?.value.trim();
            const productName = editForm.querySelector("#productName")?.value.trim();
            const productDescription = editForm.querySelector("#productDescription")?.value.trim();
            const productPrice = editForm.querySelector("#productPrice")?.value.trim();
            const productCategory = editForm.querySelector("#productCategory")?.value.trim();
            const productImage = editForm.querySelector("#productImage")?.value.trim();
    
            // Validation messages
            const errors = [];
    
            // Check if Product ID is filled
            if (!productId) {
                valid = false;
                errors.push("Product ID must be filled.");
            }
    
            // Check if at least one other field is modified (not empty)
            if (!productName && !productDescription && !productPrice && !productCategory && !productImage) {
                valid = false;
                errors.push("At least one field must be modified.");
            }
    
            // Display errors or submit form
            if (!valid) {
                alert(errors);
            } else {
                // Submit the form if validation passes
                editForm.submit();
            }
        });

    });




