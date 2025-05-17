document.addEventListener("DOMContentLoaded", function () {
    const postText = document.getElementById("postText");
    const toggleBtn = document.getElementById("toggleBtn");
  
    // Проверка, превышает ли текст 2 строки
    const isOverflowing = () => {
      const lineHeight = parseFloat(getComputedStyle(postText).lineHeight);
      const maxLines = 2;
      return postText.scrollHeight > lineHeight * maxLines;
    };
  
    if (isOverflowing()) {
      toggleBtn.style.display = "inline";
    }
  
    toggleBtn.addEventListener("click", function () {
      const expanded = postText.classList.toggle("expanded");
      toggleBtn.textContent = expanded ? "свернуть" : "ещё";
    });
  });
  