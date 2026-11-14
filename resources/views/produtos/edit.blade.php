
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar produto - Controle de Validade</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 30px 15px; font-family: Arial, sans-serif; background: #f1f5f9; color: #1e293b; }
        .container { max-width: 650px; margin: 20px auto; background: white; padding: 30px; border-radius: 14px; }
        h1 { color: #123c32; margin-top: 25px; }
        label { display: block; margin: 18px 0 7px; font-weight: bold; }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 7px; font-size: 15px; }
        textarea { resize: vertical; min-height: 90px; }
        .botao { background: #15803d; color: white; border: 0; padding: 13px 20px; border-radius: 7px; cursor: pointer; font-weight: bold; margin-top: 22px; }
        .voltar { color: #15803d; text-decoration: none; }
        .erro { color: #dc2626; }
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('produtos.index') }}" class="voltar">← Voltar ao painel</a>

    <h1>Editar produto</h1>
    <p>Atualize as informações do produto.</p>

    @if($errors->any())
        <div class="erro">
            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produtos.update', $produto) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nome do produto *</label>
        <input type="text" name="nome" value="{{ old('nome', $produto->nome) }}" required>

        <label>Categoria</label>
        <input type="text" name="categoria" value="{{ old('categoria', $produto->categoria) }}">

        <label>Quantidade em estoque *</label>
        <input type="number" name="quantidade" min="0" value="{{ old('quantidade', $produto->quantidade) }}" required>

        <label>Data de validade *</label>
        <input type="date" name="data_validade" value="{{ old('data_validade', $produto->data_validade->format('Y-m-d')) }}" required>

        <label>Descrição</label>
        <textarea name="descricao">{{ old('descricao', $produto->descricao) }}</textarea>

        <button type="submit" class="botao">Salvar alterações</button>
    </form>
</div>
</body>
</html>
