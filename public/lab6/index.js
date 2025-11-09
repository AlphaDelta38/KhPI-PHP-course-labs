



const RegisterForm = document.getElementById('RegisterForm');
const LoginForm = document.getElementById('LoginForm');

const directToLogin = document.getElementById('directToLogin');
const directToRegister = document.getElementById('directToRegister');

const userInfoContainer = document.getElementById('userInfoContainer');
const userName = document.getElementById('userName');
const logoutBtn = document.getElementById('logoutBtn');

const errorMessageContainer = document.getElementById('errorMessageContainer');
const errorMessage = document.getElementById('errorMessage');

let timeOutRef = null;

function setUserInfoContainer(user) {
  userInfoContainer.style.display = 'flex';

  LoginForm.style.display = 'none';
  RegisterForm.style.display = 'none';
  errorMessage.textContent = '';
  errorMessageContainer.style.display = 'none !important';

  userName.textContent = `Hello, ${user.name}`;
}

const onLogin = async (e) => {
  e.preventDefault();
  const formData = new FormData(e.target);

  const response = await fetch("login.php", {
    method: "POST",
    body: formData,
  });
  

  const data = await response.json();

  if(data.status === 'success') {
    setUserInfoContainer(data.user);
  } else {
    errorMessage.textContent = data.message;

    if(timeOutRef) {
      clearTimeout(timeOutRef);
    }

    timeOutRef = setTimeout(() => {
      errorMessage.textContent = '';
    }, 3000);
  }

}

const onRegister = async (e) => {
  try {
    e.preventDefault();
    const formData = new FormData(e.target);
  
    const response = await fetch("register.php", {
      method: "POST",
      body: formData,
    });

    const data = await response.json();

    if(data.status === 'success') {
      setUserInfoContainer(data.user);
    } else {
      errorMessage.textContent = data.message;
      
      if(timeOutRef) {
        clearTimeout(timeOutRef);
      }

      timeOutRef = setTimeout(() => {
        errorMessage.textContent = '';
      }, 3000);
    }
  } catch (error) {
    console.error(error);
  }
}

const refreshLogin = async () => {
  const response = await fetch("refresh-login.php", {
    method: "POST",
  });
  
  const data = await response.json();

  if(data.status === 'success') {
    setUserInfoContainer(data.user);
  } else {
    console.error(data.message);
  }
}

directToLogin.addEventListener('click', () => {
  LoginForm.style.display = 'flex';
  RegisterForm.style.display = 'none';
});

directToRegister.addEventListener('click', () => {
  LoginForm.style.display = 'none';
  RegisterForm.style.display = 'flex';
});

logoutBtn.addEventListener('click', () => {
  userInfoContainer.style.display = 'none';
  LoginForm.style.display = 'flex';
  RegisterForm.style.display = 'none';
  errorMessage.textContent = '';
  errorMessageContainer.style.display = 'flex';

  fetch("exit.php", {
    method: "POST",
  });
});

refreshLogin();

RegisterForm.addEventListener('submit', onRegister);
LoginForm.addEventListener('submit', onLogin);