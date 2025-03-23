<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Usuário</title>
  <style>
    .message {
      font-weight: bold;
      margin-top: 10px;
    }
    .message.success {
      color: green;
    }
    .message.error {
      color: red;
    }
  </style>
</head>
<body>
  <h2>Cadastro de Usuário</h2>
  <form id="formCadastro">
    <label for="nome">Nome:</label><br>
    <input type="text" id="nome" name="nome" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="senha">Senha:</label><br>
    <input type="password" id="senha" name="senha" required><br><br>

    <button type="submit">Cadastrar</button>
  </form>

  <div id="message" class="message"></div>

  <script>
    document.getElementById("formCadastro").addEventListener("submit", function(event) {
      event.preventDefault();

      var nome = document.getElementById("nome").value;
      var email = document.getElementById("email").value;
      var senha = document.getElementById("senha").value;

      if (!nome || !email || !senha) {
          document.getElementById("message").className = "message error";
          document.getElementById("message").innerHTML = `<p>Preencha todos os campos!</p>`;
          return;
      }

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
          document.getElementById("message").className = "message error";
          document.getElementById("message").innerHTML = `<p>Digite um email válido!</p>`;
          return;
      }

      var data = { nome, email, senha };

      fetch("http://localhost/backend/api/criarUsuario", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(data => {
        const messageDiv = document.getElementById("message");
        if (data.success) {
            messageDiv.className = "message success";
            messageDiv.innerHTML = `<p>${data.message}</p>`;
            document.getElementById("formCadastro").reset();
        } else {
            messageDiv.className = "message error";
            messageDiv.innerHTML = `<p>${data.message}</p>`;
        }
      })
      .catch(error => {
        document.getElementById("message").className = "message error";
        document.getElementById("message").innerHTML = `<p>Erro ao cadastrar usuário. Tente novamente.</p>`;
      });
    });
  </script>
</body>
</html>
