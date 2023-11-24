document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating');

    // stars.forEach(star => {
    //     star.addEventListener('click', function (e) {
    //         const selectedRating = this.dataset.rating;
    //         ratingInput.value = selectedRating;
    //         highlightStars(selectedRating);
    //     });
    // });

    // function highlightStars(rating) {
    //     stars.forEach(star => {
    //         if (star.dataset.rating <= rating) {
    //             star.innerHTML = '<i class="fas fa-star" style="font-size: 20px; color: orange;"></i>'; // Filled star
    //         } else {
    //             star.innerHTML = '<i class="fas fa-star" style="font-size: 20px;"></i>'; // Empty star
    //         }
    //     });
    // }

    // Get the default rating value (e.g., 3)
    let currentRating = parseInt(ratingInput.value);

    function highlightStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.innerHTML = '<i class="fas fa-star" style="font-size: 20px; color: orange;"></i>'; // Filled star
            } else {
                star.innerHTML = '<i class="fas fa-star" style="font-size: 20px;"></i>'; // Empty star
            }
        });
    }

    highlightStars(currentRating);

    stars.forEach(star => {
        star.addEventListener('click', function () {
            currentRating = this.dataset.rating;
            ratingInput.value = currentRating;
            highlightStars(currentRating);
        });
    });
});
