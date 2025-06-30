const flashMessage = document.getElementById("flash-message");
if (flashMessage !== null) {
    setTimeout(() => {
        flashMessage.remove();
    }, 3000);
}