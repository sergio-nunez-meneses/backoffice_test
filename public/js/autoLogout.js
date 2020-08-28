let timer = setInterval(autoLogout, 1000000);

function resetTimer() {
  clearInterval(timer);
  timer = setInterval(autoLogout, 1000000);
}

function autoLogout() {
  if(confirm('wanna logout ? press OK to keep logged in')) {
    window.location='index.php?logout=yes';
  }
}

document.body.addEventListener('onkeypress', resetTimer);
document.body.addEventListener('onmousemove', resetTimer);
document.body.addEventListener('onscroll', resetTimer);
document.body.addEventListener('onclick', resetTimer);
