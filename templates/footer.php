<?php
// templates/footer.php
?>
    </main>  <!-- .main-content -->
  </div>    <!-- .container -->

  <footer class="main-footer">
    <p>&copy; <?= date('Y') ?> Tu Organizador</p>
  </footer>
  <script src="assets/js/app.js"></script>
  <script>
  document.getElementById('mobileToggle').addEventListener('click', () => {
    // Toggle sidebar
    document.querySelector('.sidebar').classList.toggle('open');
    // Toggle top-nav
    document.querySelector('.top-nav').classList.toggle('open');
  });
</script>
</body>
</html>
