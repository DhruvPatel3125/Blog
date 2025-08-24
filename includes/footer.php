</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Theme toggle: store preference in localStorage
  (function() {
    var root = document.documentElement;
    var key = 'blog-theme';
    var current = localStorage.getItem(key);
    if (current === 'dark') {
      root.setAttribute('data-theme', 'dark');
    }
    var btn = document.getElementById('themeToggle');
    if (btn) {
      btn.addEventListener('click', function() {
        var isDark = root.getAttribute('data-theme') === 'dark';
        if (isDark) {
          root.removeAttribute('data-theme');
          localStorage.setItem(key, 'light');
        } else {
          root.setAttribute('data-theme', 'dark');
          localStorage.setItem(key, 'dark');
        }
      });
    }
  })();
</script>
</body>
</html>