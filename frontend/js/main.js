document.getElementById("formCadastro").addEventListener("submit", function(event) {
    event.preventDefault();

    // Obtendo os dados do formulário
    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;

    // Preparando o objeto para enviar via API
    const usuario = {
        nome: nome,
        email: email,
        senha: senha
    };

    // Enviando os dados para a API via POST
    fetch("http://localhost/meu-portfolio-recrutamento/backend/api/criarUsuario.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(usuario)
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
    })
    .catch(error => {
        console.error("Erro:", error);
    });
});
