document.addEventListener('DOMContentLoaded', function () {
    const record = document.getElementById('record_review').value;
    for(i=0; i<record; i++) {
        const stars = document.querySelectorAll('.star-'+i);
        const ratingInput = document.getElementById('rating-'+i);

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
    }
});
