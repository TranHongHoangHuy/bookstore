<footer class="bg-dark text-center text-white">
    <!-- Grid container -->
    <div class="p-4 pb-0">
        <!-- Section: Social media -->
        <section class="mb-4">
            <!-- Facebook -->
            <a class="btn btn-outline-light btn-floating m-1" href="https://www.facebook.com" role="button"><i class="fab fa-facebook-f"></i></a>

            <!-- Twitter -->
            <a class="btn btn-outline-light btn-floating m-1" href="https://twitter.com" role="button"><i class="fab fa-twitter"></i></a>

            <!-- Google -->
            <a class="btn btn-outline-light btn-floating m-1" href="https://www.google.com.vn" role="button"><i class="fab fa-google"></i></a>

            <!-- Instagram -->
            <a class="btn btn-outline-light btn-floating m-1" href="https://www.instagram.com/" role="button"><i class="fab fa-instagram"></i></a>

            <!-- Github -->
            <a class="btn btn-outline-light btn-floating m-1" href="https://github.com/TranHongHoangHuy/CT428" role="button"><i class="fab fa-github"></i></a>

            <!-- Admin -->
            <a class="btn btn-outline-light btn-floating m-1" href="../php/admin.php" role="button"><i class="fa-solid fa-a"></i></a>
        </section>
        <!-- Section: Social media -->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        <a class="text-white" href="../php/admin.php" style="text-decoration: none;">Đăng nhập trang quản lý</a>
    </div>
    <!-- Copyright -->

</footer>

<script>
    const scrollToTopButton = document.getElementById("scroll-to-top");

    // Khi người dùng cuộn trang, hiển thị hoặc ẩn button
    window.onscroll = function() {
        scrollFunction();
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            scrollToTopButton.style.display = "block";
        } else {
            scrollToTopButton.style.display = "none";
        }
    }

    // Khi người dùng ấn vào button, cuộn lên đầu trang
    scrollToTopButton.addEventListener("click", function() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });
</script>
</body>

</html>