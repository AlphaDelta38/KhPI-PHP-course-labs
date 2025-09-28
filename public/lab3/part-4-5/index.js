const cartContainer = document.getElementById("cartContainer");
const viewCartBtn = document.getElementById("viewCartBtn");

const menuItem = [
  {id: "cartContainer", display: "flex"},
  {id: "catalogContainer", display: "flex", returnBtnData: {
    id: "viewCartBtn",
    forwardText: "Return to catalog",
    backwardText: "View my cart",
  }},
]

function changeVisibility(id, display) {
  const element = document.getElementById(id); 

  if (!element) return;

  element.style.display = display;
}

function changeBtnText(id, text) {
  const element = document.getElementById(id); 

  if (!element) return;

  element.textContent = text;
}

function setMenu(id) {
  menuItem.forEach(item => {
    isActiveItem = item.id === id;
    if (item?.returnBtnData) {
      changeBtnText(item.returnBtnData.id, isActiveItem ? item.returnBtnData.backwardText : item.returnBtnData.forwardText);
    }
    changeVisibility(item.id, isActiveItem ? item.display : "none");
  })
}

function onViewCartBtnClick() {
  if (viewCartBtn.textContent === "View my cart") {
    setMenu("cartContainer");
    handleItemsController();
  } else {
    setMenu("catalogContainer");
  }
}

function getItem(item){
  console.log(item, "11");
  if (!item) return "";

  return `
  	<div class="cartItem">
			<h2>${item.name}</h2>
			<p>Size: ${item.size}</p>
			<p>Price: ${item.price * item.size}</p>
			<button onclick="removeItem(${item.id})">Remove</button>
		</div>
  `
}

async function handleItemsController() {
  try {
    const response = await fetch("index.php", {
      method: "GET",
    });

    const data = await response.json();
    
    const products = Object.entries(data.products);

    if (data.status === "success" && products.length > 0) {
      const cartItemsContainer = document.getElementById("cartItems");
      cartItemsContainer.innerHTML = "";

      products.forEach(item => {
        cartItemsContainer.innerHTML += getItem(item[1]);
      })
    }
  } catch (error) {
    console.error(error);
  }
}

async function addItem(name, id, price) {
  try {
    const formData = new FormData();

    formData.append("product[name]", name);
    formData.append("product[id]", id);
    formData.append("product[price]", price);
    formData.append("product[size]", 1);


    const response = await fetch("index.php", {
      method: "POST",
      body: formData,
    });

    const data = await response.json();

    if (data.status === "success") {
      alert(data.message);
    }
    
  } catch (error) {
    console.error(error);
  }
}

async function removeItem(id) {
  try {
    const response = await fetch(`index.php?id=${id}`, {
      method: "DELETE",
    });

    const data = await response.json();

    if (data.status === "success") {
      alert(data.message);
    }
    
    handleItemsController();
  } catch (error) {
    console.error(error);
  }
}

viewCartBtn.addEventListener("click", onViewCartBtnClick);

const onClientLoad = () => {
  handleItemsController();
}

onClientLoad();

