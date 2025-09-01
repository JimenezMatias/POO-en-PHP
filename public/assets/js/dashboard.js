document.addEventListener("DOMContentLoaded", async () => {
    const token = localStorage.getItem("jwt");
    console.log("Token encontrado:", token);

    if (!token) {
        // Si no hay token, redirigir al login

        window.location.href = "/login.php";
        return;
    }
    try {
        
        const response  = await fetch("http://localhost/protegido", {
            method: 'GET',
            headers: {
                "Authorization": `Bearer ${token}`,
                "Content-Type": "application/json"
            }
        });
        
        if (!response.ok) {
            //token nvalido o expirado
            localStorage.removeItem("jwt");
            window.location.href = "/login.php";
            return;
        }
        const data = await response.json();
        // inyectar info del usuario en el DOM
        const userElement = document.getElementById("user-name");
        if (userElement) userElement.textContent = data.message;    

    } catch(err) {
        console.error("Error al conectar con el backend:", err);
        window.location.href = "/login.php";
    }

})

