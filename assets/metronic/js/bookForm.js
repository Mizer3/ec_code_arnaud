document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('book-form');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(form);

        fetch(form.action, {
            method: form.method,
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Handle success (e.g., show a success message, update the UI, etc.)
                alert('Book read status updated successfully!');
                const modal = document.getElementById('book_modal');
                modal.style.display = 'none';
                // Optionally, reset the form
                form.reset();
            } else {
                // Handle error (e.g., show an error message)
                alert('An error occurred while updating the book read status.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the book read status.');
        });
    });
});