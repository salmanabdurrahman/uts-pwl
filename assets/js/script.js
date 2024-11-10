/**
 * scroll down button
 */
// const scrollDownButton = document.getElementById('scroll-down');
// if (scrollDownButton) {
// 	scrollDownButton.addEventListener('click', function () {
// 		window.scrollTo({
// 			top: 550,
// 			behavior: 'smooth',
// 		});
// 	});
// }

/**
 * subscribe form
 */
// const subscribeForms = document.querySelectorAll('#subscribeForm');
// if (subscribeForms.length > 0) {
// 	subscribeForms.forEach(subscribeForm =>
// 		subscribeForm.addEventListener('submit', function (event) {
// 			event.preventDefault();

// 			const formData = new FormData(subscribeForm);

// 			fetch('../actions/subscribe_action.php', {
// 				method: 'POST',
// 				body: formData,
// 			})
// 				.then(response => {
// 					if (!response.ok) {
// 						throw new Error('Network response was not ok');
// 					}
// 					return response.json();
// 				})
// 				.then(data => {
// 					if (data.status === 'success') {
// 						Swal.fire({
// 							icon: 'success',
// 							title: 'Success',
// 							text: data.message || 'Subscription successful!',
// 							confirmButtonText: 'OK',
// 						});
// 						subscribeForm.reset();
// 					} else {
// 						Swal.fire({
// 							icon: 'error',
// 							title: 'Error',
// 							text: data.message || 'Something went wrong',
// 							confirmButtonText: 'OK',
// 						});
// 					}
// 				})
// 				.catch(error => {
// 					console.error('Error:', error);
// 					Swal.fire({
// 						icon: 'error',
// 						title: 'Error',
// 						text: 'An unexpected error occurred. Please try again later.',
// 						confirmButtonText: 'OK',
// 					});
// 				});
// 		})
// 	);
// }

/**
 * dashboard section
 */
// const dashboardSection = document.querySelectorAll('.dashboard-section');
// const dashboardParent = document.getElementById('dashboard-parent');

// if (dashboardParent && dashboardSection.length > 0) {
// 	const sections = {
// 		'dashboard-button': 'dashboard',
// 		'profile-button': 'update-profile',
// 		'content-button': 'update-content',
// 	};

// 	dashboardParent.addEventListener('click', function (event) {
// 		const targetId = event.target.id;

// 		if (sections[targetId]) {
// 			dashboardSection.forEach(section =>
// 				section.classList.add('hidden')
// 			);

// 			const targetSection = document.getElementById(sections[targetId]);
// 			if (targetSection) {
// 				targetSection.classList.remove('hidden');
// 			}
// 		}
// 	});
// }
