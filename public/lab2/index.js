
const menuItem = [
  {id: "form", display: "flex"},
  {id: "allFile", display: "flex", returnBtnData: {
    id: "viewFilesBtn",
    forwardText: "View Files",
    backwardText: "Hide Files",
  }},
  {id: "form2", display: "flex", returnBtnData: {
    id: "changeToWriteFormBtn",
    forwardText: "Write to text file",
    backwardText: "Back to Upload Form",
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

function viewFilesCOontroller(data){
  setMenu("allFile");

  const {data: files} = data;

  const allFile = document.getElementById('allFile');
  allFile.innerHTML = '';

  files.forEach(file => {
    allFile.innerHTML += getFileElement(file);
  })
}

function getFileElement(file){
  const {name, size, type, link} = file;

  return `
    <div class="fileContainer">
      <a href="${link}" class="fileLink" target="_blank">${name}</a>
      <span class="fileType">${type}</span>
      <span class="fileSize">${size}kb</span>
      <a href="${link}" class="downloadBtn" download>Download</a>
      ${type === "text/plain" 
        ? `<button class="openTextFileBtn" onclick="handleOpenTextFile('${name}')">Open</button>`
        : ''
      }
    </div>
  `
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

async function onViewBtnClick(e){
  if(e.target.textContent === 'View Files'){
    e.target.textContent = 'Hide Files';

    const response = await getFiles();

    viewFilesCOontroller(response);
  } else if (e.target.textContent === 'Hide Files'){
    e.target.textContent = 'View Files';

    setMenu("form")
  }
}

function changeToWriteForm(){
  if (changeToWriteFormBtn.textContent === "Back to Upload Form"){
    changeToWriteFormBtn.textContent = "Write to text file";
    setMenu("form");
  }else{
    changeToWriteFormBtn.textContent = "Back to Upload Form";
    setMenu("form2");
  }
}

async function handleFileUpload(e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  const response = await fetch('./uploadfile.php', {
    method: 'POST',
    body: formData
  })

  return response.json().then(data => {
    if (data.status === 'success') {
      alert(data.status);

      const fileInput = document.getElementById('fileInput');
      fileInput.value = '';

      return data.data;
    } else {
      alert(data.error);
    }
  });
}

async function getFiles() {
  const response = await fetch('./getFiles.php');

  return response.json().then(data => {
    return data;
  });
}

async function handleWriteToTxt(e){
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  const response = await fetch("./writeToTxt.php", {
    method: 'POST',
    body: formData
  })

  response.json().then(data => {
    if (data.status=== "success") {
      alert(`File ${data.data} has been created`);
      form.reset();
    }else {
      alert(data.error);
    }
  })

}

async function handleOpenTextFile(name){
  const fileNameInput = document.getElementById('fileNameInput');
  const textArea = document.getElementById('textArea');

  const response = await fetch(`./openTextFile.php?name=${name}`);

  response.json().then(data => {
    if (data.status === "success") {

      fileNameInput.value = name;
      textArea.value = data.data;

      setMenu("form2");
    }else {
      alert(data.error);
    }
  })
}

const form = document.getElementById('form');
const form2 = document.getElementById('form2');

const viewBtn = document.getElementById('viewFilesBtn');
const changeToWriteFormBtn = document.getElementById('changeToWriteFormBtn');

viewBtn.addEventListener('click', onViewBtnClick);
changeToWriteFormBtn.addEventListener('click', changeToWriteForm);

form.addEventListener('submit', handleFileUpload);
form2.addEventListener('submit', handleWriteToTxt);