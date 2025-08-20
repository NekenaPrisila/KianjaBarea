<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggleSearchBtn');
    const searchForm = document.getElementById('searchForm');
    const toggleIcon = document.getElementById('toggleIcon');

    if(toggleBtn){
      toggleBtn.addEventListener('click', function () {
        if (searchForm.style.display === 'none') {
          searchForm.style.display = 'block';
          toggleIcon.classList.replace('bi-plus', 'bi-dash');
          toggleBtn.setAttribute('aria-expanded', 'true');
        } else {
          searchForm.style.display = 'none';
          toggleIcon.classList.replace('bi-dash', 'bi-plus');
          toggleBtn.setAttribute('aria-expanded', 'false');
        }
      });
    }
  });
</script>
