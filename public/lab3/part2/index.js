let userInfoContainer = document.querySelector(".userInfoContainer");
let userName = document.getElementById("userName");
let form = document.getElementById("form");
const logoutBtn = document.getElementById("logoutBtn");

function setLoginForm() {
  userInfoContainer.style.display = "none";
  form.style.display = "flex";
}

function setUserInfoContainer() {
  userInfoContainer.style.display = "flex";
  form.style.display = "none";
}


async function onLogout() {
  const response = await fetch("index.php", {
    method: "DELETE",
  });

  const data = await response.json();

  if(data.status === "success") {
    userName.textContent = "";

    setLoginForm();
  }

  alert(data.message);
}

async function onLogin(e) {
  e.preventDefault();

  const formData = new FormData(e.target);

  const response = await fetch("index.php", {
    method: "POST",
    body: formData,
  });

  const data = await response.json();

  if(data.status === "success") {
    userName.textContent = `Hello, ${data.name}!`;

    setUserInfoContainer();
  }

  alert(data.message);
}

async function refreshUserInfo() {
  const response = await fetch("index.php", {
    method: "GET",
  });
  
  const data = await response.json();

  if(data.status === "success") {
    userName.textContent = `Hello, ${data.name}!`;

    setUserInfoContainer();
  }
}



form.addEventListener("submit", onLogin);
logoutBtn.addEventListener("click", onLogout);


const onStartClient = () => {
  refreshUserInfo();
}

onStartClient();
