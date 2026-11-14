
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Validade</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }
        header {
            background: #123c32;
            color: white;
            padding: 24px 6%;
        }
        header h1 { font-size: 25px; }
        header p { color: #cbd5e1; margin-top: 6px; }
        main { max-width: 1200px; margin: 35px auto; padding: 0 20px; }
        .topo {
            display: flex; justify-content: space-between;
            align-items: center; gap: 15px; margin-bottom: 25px;
        }
        .topo h2 { font-size: 23px; }
        .botao {
            display: inline-block; background: #15803d; color: white;
            padding: 12px 18px; border-radius: 8px;
            text-decoration: none; border: 0; cursor: pointer;
            font-weight: bold;
        }
        .cards {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 16px; margin-bottom: 28px;
        }
        .card {
            background: white; padding: 22px;
            border-radius: 12px; border: 1px solid #e2e8f0;
        }
        .card p { color: #64748b; font-size: 14px; }
        .card strong { display: block; font-size: 30px; margin-top: 12px; }
        .verde { border-left: 5px solid #16a34a; }
        .amarelo { border-left: 5px solid #eab308; }
        .vermelho { border-left: 5px solid #dc2626; }
        .azul { border-left: 5px solid #2563eb; }
        .painel {
            background: white; border-radius: 12px;
            padding: 22px; border: 1px solid #e2e8f0;
            overflow-x: auto;
        }
        table { width: 100%; border-collapse: collapse; min-width: 650px; }
        th, td { padding: 15px 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th { color: #64748b; font-size: 12px; text-transform: uppercase; }
        .status {
            display: inline-block; padding: 6px 10px;
            border-radius: 20px; font-size: 12px; font-weight: bold;
        }
        .status-verde { background: #dcfce7; color: #166534; }
        .status-amarelo { background: #fef9c3; color: #854d0e; }
        .status-vermelho { background: #fee2e2; color: #991b1b; }
        .acoes { display: flex; gap: 12px; align-items: center; }
        .editar { color: #2563eb; text-decoration: none; }
        .excluir { color: #dc2626; background: none; border: 0; cursor: pointer; }
        .mensagem {
            background: #dcfce7; color: #166534;
            padding: 14px; border-radius: 8px; margin-bottom: 20px;
        }
        .vazio { text-align: center; padding: 35px; color: #64748b; }
        @media(max-width: 800px) {
            .cards { grid-template-columns: repeat(2, 1fr); }
        }
        @media(max-width: 500px) {
            .cards { grid-template-columns: 1fr 1fr; gap: 9px; }
            .card { padding: 15px; }
            .card strong { font-size: 24px; }
            .topo { align-items: flex-start; flex-direction: column; }
        }
    </style>
</head>
<body>
<header>
    <h1>Controle de Validade</h1>
    <p>Gestão inteligente de produtos e prevenção de desperdícios</p>
</header>

<main>
    <div class="topo">
        <div>
            <h2>Painel de controle</h2>
            <p style="color:#64748b;margin-top:6px">Acompanhe seu estoque e as datas de validade.</p>
        </div>
        <a href="{{ route('produtos.create') }}" class="botao">+ Novo produto</a>
    </div>

    @if(session('sucesso'))
        <div class="mensagem">{{ session('sucesso') }}</div>
    @endif

    <section class="cards">
        <div class="card azul">
            <p>Total de produtos</p>
            <strong>{{ $total }}</strong>
        </div>
        <div class="card vermelho">
            <p>Produtos vencidos</p>
            <strong>{{ $vencidos }}</strong>
        </div>
        <div class="card amarelo">
            <p>Vencem em até 30 dias</p>
            <strong>{{ $proximos }}</strong>
        </div>
        <div class="card verde">
            <p>Produtos dentro da validade</p>
            <strong>{{ $validos }}</strong>
        </div>
    </section>

    <section class="painel">
        <h3 style="margin-bottom:20px">Produtos cadastrados</h3>

        @if($produtos->isEmpty())
            <div class="vazio">
                <h3>Nenhum produto cadastrado</h3>
                <p style="margin:10px 0 20px">Comece adicionando o primeiro produto ao estoque.</p>
                <a href="{{ route('produtos.create') }}" class="botao">Cadastrar produto</a>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Categoria</th>
                        <th>Quantidade</th>
                        <th>Validade</th>
                        <th>Situação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($produtos as $produto)
                    <tr>
                        <td><strong>{{ $produto->nome }}</strong></td>
                        <td>{{ $produto->categoria ?? 'Não informada' }}</td>
                        <td>{{ $produto->quantidade }}</td>
                        <td>{{ $produto->data_validade->format('d/m/Y') }}</td>
                        <td>
                            @if($produto->data_validade->lt(today()))
                                <span class="status status-vermelho">Vencido</span>
                            @elseif($produto->data_validade->lte(today()->addDays(30)))
                                <span class="status status-amarelo">Próximo do vencimento</span>
                            @else
                                <span class="status status-verde">Dentro da validade</span>
                            @endif
                        </td>
                        <td>
                            <div class="acoes">
                                <a class="editar" href="{{ route('produtos.edit', $produto) }}">Editar</a>
                                <form action="{{ route('produtos.destroy', $produto) }}" method="POST" onsubmit="return confirm('Deseja excluir este produto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="excluir" type="submit">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </section>
</main>
</body>
</html>
