const nameInput = document.getElementById('nameInput');
const userName = document.getElementById('userName');
const form = document.getElementById('form');
const deleteCookie = document.getElementById('deleteCookie');

async function sendData(e){
  e.preventDefault();

  try {
    const response = await fetch("index.php", {
      method: "POST",
      body: new FormData(form)
    });

    const data = await response.json();

    if(data.status === "success") {
      userName.textContent = `Hello, ${data.name}!`;
    }

  } catch (error) {
    console.error(error);
  }
}

async function getNameFromCookie(){
  try {
    const response = await fetch("index.php", {
      method: "GET",
    });

    const data = await response.json();

    if(data.status === "success") {
      userName.textContent = `Hello, ${data.name}!`;
    }

  } catch (error) {
    console.error(error);
  }
}

async function deleteCookieHandler(e){
  e.preventDefault();

  try {
    const response = await fetch("index.php", {
      method: "DELETE",
    });
    const data = await response.json();

    if(data.status === "success") {
      userName.textContent = `Hello, ${data.name}!`;
    }

  } catch (error) {
    console.error(error);
  }
}

form.addEventListener("submit", sendData);
deleteCookie.addEventListener("click", deleteCookieHandler);

const onStartClient = () => {
  getNameFromCookie();
}

onStartClient();
