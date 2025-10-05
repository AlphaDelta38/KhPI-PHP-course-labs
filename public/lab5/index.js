function getBankAccountUI({id, currency, balance}) {
  return `
    <div class="bankAccount">
      <h2>Bank Account id ${id}</h2>
      <p>Currency: <span id="currency">${currency}</span></p>
      <p>Balance: <span id="balance">${balance}</span></p>
      <p>Type: <span id="type">BankAccount</span></p>
      <button onclick="depositPopup(${id})">Deposit</button>
      <button onclick="withDrawPopup(${id})">Withdraw</button>
    </div>
  `
}

function getSavingBankAccountUI({ id, currency, balance, interestRate }) {
  return `
    <div class="SavingBankAccount">
      <h2>Bank Account id ${id}</h2>
      <p>Currency: <span id="currency">${currency}</span></p>
      <p>Balance: <span id="balance">${balance}</span></p>
      <p>Type: <span id="type">SavingAccount</span></p>
      <p>Interest Rate: <span id="interestRate">${interestRate}</span></p>
      <button onclick="depositPopup(${id})">Deposit</button>
      <button onclick="withDrawPopup(${id})">Withdraw</button>
      <button onclick="applyInterest(${id})">Apply Interest</button>
    </div>
  `
}

function renderBankAccounts(bankAccounts) {
  const bankAccountsContainer = document.getElementById('bankAccountsContainer');

  bankAccountsContainer.innerHTML = '';

  bankAccounts.forEach(bankAccount => {
    if (bankAccount.type === 'SavingAccount') {
      bankAccountsContainer.innerHTML += getSavingBankAccountUI(bankAccount);
    } else {
      bankAccountsContainer.innerHTML += getBankAccountUI(bankAccount);
    }
  });
}

function closePopup(popup) {
  const depositPopup = document.getElementById('depositPopup');
  const withdrawPopup = document.getElementById('withdrawPopup');

  depositPopup.style.display = 'none';
  withdrawPopup.style.display = 'none';
}

function depositPopup(id) {
  const depositPopup = document.getElementById('depositPopup');
  const depositForm = document.getElementById('depositForm');

  depositPopup.style.display = 'flex';
  depositForm.querySelector('input[name="id"]').value = id;
}

function withDrawPopup(id) {
  const withdrawPopup = document.getElementById('withdrawPopup');
  const withdrawForm = document.getElementById('withdrawForm');

  withdrawPopup.style.display = 'flex';
  withdrawForm.querySelector('input[name="id"]').value = id;
}

async function fetchBankAccounts() {
  try {
    const response = await fetch('index.php', {
      method: 'GET',
    });

    const data = await response.json();

    if (data.bankAccounts.length > 0) {
      renderBankAccounts(data.bankAccounts);
    } else {
      console.error(data.processData?.message || 'No bank accounts found');
    }
  } catch (error) {
    console.error(error);
  }
}

async function balanceController(type, e) {
  e.preventDefault();
  const formData = new FormData(e.target);
  
  formData.append('action', type);

  if (!formData.get('amount')) {
    alert('Please fill all fields');
    closePopup();
    return;
  }

  const response = await fetch('index.php', {
    method: 'POST',
    body: formData,
  });

  const data = await response.json();

  if (data.processData?.success) {
    closePopup();
    renderBankAccounts(data.bankAccounts);
  } else {
    alert(data.processData?.message);
    closePopup();
  }
  
}

async function applyInterest(id) {
  const formData = new FormData();

  formData.append('action', 'applyInterest');
  formData.append('id', id);

  const response = await fetch('index.php', {
    method: 'POST',
    body: formData,
  });

  const data = await response.json();

  if (data.processData?.success) {
    closePopup();
    renderBankAccounts(data.bankAccounts);
  } else {
    alert(data.processData?.message);
    closePopup();
  }
}


const createAccountForm = document.getElementById('createAccountForm');

const depositForm = document.getElementById('depositForm');
const withdrawForm = document.getElementById('withdrawForm');

const closeDepositForm = document.getElementById('closeDepositForm');
const closeWithdrawForm = document.getElementById('closeWithdrawForm');

depositForm.addEventListener('submit', (e) => balanceController('deposit', e));
withdrawForm.addEventListener('submit', (e) => balanceController('withdraw', e));

closeDepositForm.addEventListener('click', (e) => {
  e.preventDefault();
  closePopup();
});
closeWithdrawForm.addEventListener('click', (e) => {
  e.preventDefault();
  closePopup();
});;

createAccountForm.addEventListener('submit', (e) => {
  e.preventDefault();

  const formData = new FormData(createAccountForm);
  const data = Object.fromEntries(formData);

  formData.append('action', 'createAccount'); 

  if (!data.type || !data.currency || (!data.interestRate && data.type === 'SavingAccount')) {
    alert('Please fill all fields');
    return;
  }

  fetch('index.php', {
    method: 'POST',
    body: formData,
  }).then(response => response.json()).then(data => {
    renderBankAccounts(data.bankAccounts);
  });
});

const onStartClient = () => {
  fetchBankAccounts();
}

onStartClient();