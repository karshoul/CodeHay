<script>
document.addEventListener("DOMContentLoaded", function () {
  const elements = document.querySelectorAll("[include-html]");
  elements.forEach(function(el) {
    const file = el.getAttribute("include-html");
    if (file) {
      fetch(file)
        .then(response => {
          if (!response.ok) throw new Error("Lỗi khi tải " + file);
          return response.text();
        })
        .then(data => {
          el.innerHTML = data;
          el.removeAttribute("include-html");
        })
        .catch(error => {
          el.innerHTML = "Không thể tải file " + file;
        });
    }
  });
});
</script>
