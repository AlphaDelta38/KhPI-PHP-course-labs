
const getBtn = document.getElementById("getBtn");


getBtn.addEventListener("click", () => {
  fetch("index.php", {
    method: "POST",
  })
    .then(response => response.json())
    .then(data => {
      const infoContainer = document.getElementById("infoContainer");
      infoContainer.innerHTML = `
        <p>Client IP: ${data.client_ip}</p>
        <p>User Agent: ${data.user_agent}</p>
        <p>Current Script: ${data.current_script}</p>
        <p>Request Method: ${data.request_method}</p>
        <p>Script Path: ${data.script_path}</p>
      `;
    });
});

