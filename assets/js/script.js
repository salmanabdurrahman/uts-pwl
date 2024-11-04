document.addEventListener('DOMContentLoaded', function () {
	// scroll down button
	const scrollDownButton = document.getElementById('scroll-down');
	scrollDownButton.addEventListener('click', function () {
		window.scrollTo(0, 550);
	});

	// subscribe form
	const subscribeForms = document.querySelectorAll('#subscribeForm');

	subscribeForms.forEach(subscribeForm =>
		subscribeForm.addEventListener('submit', function (event) {
			event.preventDefault();

			const formData = new FormData(subscribeForm);

			fetch('../actions/subscribe_action.php', {
				method: 'POST',
				body: formData,
			})
				.then(response => response.json())
				.then(data => {
					if (data.status === 'success') {
						Swal.fire({
							icon: 'success',
							title: 'Success',
							text: data.message,
							confirmButtonText: 'OK',
						});
						subscribeForm.reset();
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: data.message,
							confirmButtonText: 'OK',
						});
					}
				})
				.catch(error => {
					console.error('Error:', error);
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'An unexpected error occurred. Please try again later.',
						confirmButtonText: 'OK',
					});
				});
		})
	);
});
