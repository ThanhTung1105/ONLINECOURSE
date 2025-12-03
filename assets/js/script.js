// assets/js/script.js

// Hàm xem trước ảnh khi upload
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
            document.getElementById(previewId).style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Tự động gán sự kiện cho các input có class 'img-upload'
document.addEventListener('DOMContentLoaded', function() {
    var uploadInputs = document.querySelectorAll('.img-upload-input');
    uploadInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            var targetId = this.getAttribute('data-target'); // Lấy ID của thẻ img preview
            previewImage(this, targetId);
        });
    });
});