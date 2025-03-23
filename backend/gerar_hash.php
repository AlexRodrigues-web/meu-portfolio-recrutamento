<?php
// Definindo a senha que você deseja hashear
$senha = "123456"; // Substitua por qualquer senha que você queira hashear

// Gerando o hash da senha usando o algoritmo padrão (bcrypt)
$hash = password_hash($senha, PASSWORD_DEFAULT);

// Exibindo a senha original e o hash gerado
echo "Senha: $senha<br>";
echo "Hash gerado: $hash<br>";

// Para verificar se a hash está funcionando corretamente
if (password_verify($senha, $hash)) {
    echo "A senha corresponde ao hash!";
} else {
    echo "A senha não corresponde ao hash.";
}
?>
