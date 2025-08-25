</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Theme toggle: store preference in localStorage
  (function() {
    var root = document.documentElement;
    var key = 'blog-theme';
    var iconMoon = document.getElementById('iconMoon');
    var iconSun = document.getElementById('iconSun');

    function applyTheme(theme) {
      if (theme === 'dark') {
        root.setAttribute('data-theme', 'dark');
        if (iconMoon && iconSun) {
          iconMoon.classList.add('d-none');
          iconSun.classList.remove('d-none');
        }
      } else {
        root.removeAttribute('data-theme');
        if (iconMoon && iconSun) {
          iconMoon.classList.remove('d-none');
          iconSun.classList.add('d-none');
        }
      }
    }

    var current = localStorage.getItem(key) || 'light';
    applyTheme(current);

    var btn = document.getElementById('themeToggle');
    if (btn) {
      btn.addEventListener('click', function() {
        var newTheme = (root.getAttribute('data-theme') === 'dark') ? 'light' : 'dark';
        localStorage.setItem(key, newTheme);
        applyTheme(newTheme);
      });
    }
  })();
</script>
</body>
</html>