
<div class="form-group">
    <label>CEP:</label>
    <input type="text" id="cep" name="cep" class="form-control" required>
    <small class="form-text text-muted" id="endereco-info"></small>
</div>

<script>
document.getElementById('cep').addEventListener('blur', function() {
    const cep = this.value.replace(/\D/g, '');
    if(cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if(!data.erro) {
                    document.getElementById('endereco-info').textContent = 
                        `${data.logradouro}, ${data.bairro}, ${data.localidade}/${data.uf}`;
                } else {
                    alert('CEP não encontrado!');
                }
            });
    }
});
</script>