
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar produto - Controle de Validade</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 30px 15px;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }
        .container {
            max-width: 650px;
            margin: 20px auto;
            background: white;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 4px 15px #0000000d;
        }
        h1 { color: #123c32; margin-top: 0; }
        label { display: block; margin: 18px 0 7px; font-weight: bold; }
        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 15px;
        }
        textarea { resize: vertical; min-height: 90px; }
        .botao {
            background: #15803d;
            color: white;
            border: 0;
            padding: 13px 20px;
            border-radius: 7px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 22px;
        }
        .voltar { color: #15803d; text-decoration: none; }
        .erro { color: #dc2626; font-size: 13px; margin-top: 5px; }
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('produtos.index') }}" class="voltar">← Voltar ao painel</a>

    <h1 style="margin-top:25px">Cadastrar produto</h1>
    <p>Preencha os dados para adicionar um produto ao estoque.</p>

    @if($errors->any())
        <div class="erro">
            <strong>Verifique os campos:</strong>
            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produtos.store') }}" method="POST">
        @csrf

        <label>Nome do produto *</label>
        <input type="text" name="nome" value="{{ old('nome') }}" required>

        <label>Categoria</label>
        <input type="text" name="categoria" value="{{ old('categoria') }}" placeholder="Ex.: Alimentos, bebidas">

        <label>Quantidade em estoque *</label>
        <input type="number" name="quantidade" min="0" value="{{ old('quantidade', 1) }}" required>

        <label>Data de validade *</label>
        <input type="date" name="data_validade" value="{{ old('data_validade') }}" required>

        <label>Descrição</label>
        <textarea name="descricao" placeholder="Informações adicionais sobre o produto">{{ old('descricao') }}</textarea>

        <button type="submit" class="botao">Salvar produto</button>
    </form>
</div>
</body>
</html>
