<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Formulário de Cadastro</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" required>
            </div>

            <div class="form-group">
                <label for="cep">CEP:</label>
                <input type="text" id="cep" name="cep" maxlength="9" required>
            </div>

            <div id="endereco-container" class="hidden">
                <div class="form-group">
                    <label for="endereco">Endereço:</label>
                    <input type="text" id="endereco" name="endereco" readonly required>
                </div>

                <div class="form-group">
                    <label for="numero">Número:</label>
                    <input type="text" id="numero" name="numero" required>
                </div>

                <div class="form-group">
                    <label for="bairro">Bairro:</label>
                    <input type="text" id="bairro" name="bairro" readonly required>
                </div>

                <div class="form-group">
                    <label for="cidade">Cidade:</label>
                    <input type="text" id="cidade" name="cidade" readonly required>
                </div>

                <div class="form-group">
                    <label for="estado">Estado:</label>
                    <input type="text" id="estado" name="estado" readonly required>
                </div>
            </div>

            <div class="form-group">
                <button type="submit">Enviar</button>
            </div>
        </form>
    </div>

    <script>
        const cep = document.querySelector("#cep");
        const enderecoContainer = document.querySelector("#endereco-container");
        
        cep.addEventListener('blur', (e) => {
            let cepValue = e.target.value;
            cepValue = cepValue.replace(/\D/g, '');
            
            if(cepValue.length !== 8) {
                alert('CEP inválido!');
                enderecoContainer.classList.remove('visible');
                enderecoContainer.classList.add('hidden');
                return;
            }
            
            fetch(`https://viacep.com.br/ws/${cepValue}/json/`)
            .then(response => response.json())
            .then(data => {
                if(data.erro) {
                    alert('CEP não encontrado!');
                    enderecoContainer.classList.remove('visible');
                    enderecoContainer.classList.add('hidden');
                    return;
                }
                
                document.querySelector("#endereco").value = data.logradouro;
                document.querySelector("#bairro").value = data.bairro;
                document.querySelector("#cidade").value = data.localidade;
                document.querySelector("#estado").value = data.uf;
                
               
                enderecoContainer.classList.remove('hidden');
                enderecoContainer.classList.add('visible');
            })
            .catch(error => {
                alert('Erro ao buscar CEP');
                console.error(error);
                enderecoContainer.classList.remove('visible');
                enderecoContainer.classList.add('hidden');
            });
        });

        cep.addEventListener('keypress', (e) => {
            let inputValue = e.target.value;
            inputValue = inputValue.replace(/\D/g, '');
            
            if(inputValue.length === 5) {
                e.target.value = inputValue + '-';
            }
        });
    </script>
</body>
</html>