<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::orderBy('data_validade')->get();
        $total = Produto::count();

        $vencidos = Produto::whereDate('data_validade', '<', today())->count();

        $proximos = Produto::whereBetween('data_validade', [
            today(),
            today()->addDays(30)
        ])->count();

        $validos = $total - $vencidos - $proximos;

        return view('produtos.index', compact(
            'produtos',
            'total',
            'vencidos',
            'proximos',
            'validos'
        ));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'nullable|string|max:255',
            'quantidade' => 'required|integer|min:0',
            'data_validade' => 'required|date',
            'descricao' => 'nullable|string',
        ]);

        Produto::create($dados);

        return redirect()->route('produtos.index')
            ->with('sucesso', 'Produto cadastrado com sucesso!');
    }

    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'nullable|string|max:255',
            'quantidade' => 'required|integer|min:0',
            'data_validade' => 'required|date',
            'descricao' => 'nullable|string',
        ]);

        $produto->update($dados);

        return redirect()->route('produtos.index')
            ->with('sucesso', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();

        return redirect()->route('produtos.index')
            ->with('sucesso', 'Produto excluído com sucesso!');
    }
}