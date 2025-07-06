@extends('layout')

@section('content')
  @component('components.menu-home')
  @endcomponent

 <main id="main" class="main">
    <div class="pagetitle">
      <h1>PDV - Ponto de Venda</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/index">Home</a></li>
          <li class="breadcrumb-item active">PDV</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    
    <section class="section">
      <div class="row">
        <!-- Coluna da Esquerda - Produtos e Carrinho -->
        <div class="col-lg-8">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Adicionar Produtos</h5>
              
              <!-- Busca de Produtos -->
              <div class="row mb-3">
                <div class="col-md-8">
                  <div class="input-group">
                    <input type="text" class="form-control" id="codigoProduto" placeholder="Digite o código do produto ou nome...">
                    <button class="btn btn-primary" type="button" onclick="buscarProduto()">
                      <i class="bi bi-search"></i> Buscar
                    </button>
                  </div>
                </div>
                <div class="col-md-4">
                  <button class="btn btn-outline-primary w-100" onclick="abrirModalProdutos()">
                    <i class="bi bi-list"></i> Lista de Produtos
                  </button>
                </div>
              </div>

              <!-- Resultado da Busca -->
              <div id="resultadoBusca" class="mb-3" style="display: none;">
                <div class="alert alert-info">
                  <div class="row">
                    <div class="col-md-8">
                      <h6 id="nomeProduto"></h6>
                      <small>Código: <span id="codigoProdutoResultado"></span> | Preço: R$ <span id="precoProduto"></span></small>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <input type="number" class="form-control" id="quantidadeProduto" value="1" min="1">
                        <button class="btn btn-success" onclick="adicionarAoCarrinho()">
                          <i class="bi bi-plus"></i> Adicionar
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Carrinho de Compras -->
              <div class="card">
                <div class="card-header">
                  <h6 class="mb-0"><i class="bi bi-cart"></i> Carrinho de Compras</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-sm" id="tabelaCarrinho">
                      <thead>
                        <tr>
                          <th>Produto</th>
                          <th>Qtd</th>
                          <th>Preço Unit.</th>
                          <th>Subtotal</th>
                          <th>Ações</th>
                        </tr>
                      </thead>
                      <tbody id="carrinhoItens">
                        <!-- Itens do carrinho serão inseridos aqui -->
                      </tbody>
                    </table>
                  </div>
                  
                  <div class="text-end">
                    <h5>Total: R$ <span id="totalCarrinho">0,00</span></h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Coluna da Direita - Cliente e Finalização -->
        <div class="col-lg-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Informações da Venda</h5>
              
              <!-- Seleção de Cliente -->
              <div class="mb-3">
                <label for="cliente_id" class="form-label">Cliente (Opcional)</label>
                <select class="form-select" id="cliente_id" name="cliente_id">
                  <option value="">Cliente não identificado</option>
                  @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                  @endforeach
                </select>
              </div>

              <!-- Tipos de Pagamento -->
              <div class="mb-3">
                <label for="tipo_pagamento_id" class="form-label">Forma de Pagamento *</label>
                <select class="form-select" id="tipo_pagamento_id" name="tipo_pagamento_id" required>
                  <option value="">Selecione a forma de pagamento...</option>
                  @foreach($tiposPagamento as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                  @endforeach
                </select>
              </div>

              <!-- Observações -->
              <div class="mb-3">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea class="form-control" id="observacoes" rows="3" placeholder="Observações da venda..."></textarea>
              </div>

              <!-- Botões de Ação -->
              <div class="d-grid gap-2">
                <button class="btn btn-success btn-lg" onclick="finalizarVenda()">
                  <i class="bi bi-check-circle"></i> Finalizar Venda
                </button>
                <button class="btn btn-outline-secondary" onclick="limparCarrinho()">
                  <i class="bi bi-trash"></i> Limpar Carrinho
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Modal Lista de Produtos -->
  <div class="modal fade" id="modalProdutos" tabindex="-1" aria-labelledby="modalProdutosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalProdutosLabel">Lista de Produtos</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Código</th>
                  <th>Nome</th>
                  <th>Preço</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                @foreach($produtos as $produto)
                <tr>
                  <td>{{ $produto->codigo }}</td>
                  <td>{{ $produto->nome }}</td>
                  <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                  <td>
                    <button class="btn btn-sm btn-primary" onclick="selecionarProduto({{ $produto->id }}, '{{ $produto->codigo }}', '{{ $produto->nome }}', {{ $produto->preco }})">
                      <i class="bi bi-plus"></i> Adicionar
                    </button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de Confirmação -->
  <div class="modal fade" id="confirmacaoModal" tabindex="-1" aria-labelledby="confirmacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmacaoModalLabel">Confirmar Venda</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Tem certeza que deseja finalizar esta venda?</p>
          <div id="resumoVenda"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-success" onclick="confirmarVenda()">Confirmar</button>
        </div>
      </div>
    </div>
  </div>
@endsection

  <!-- ======= Footer ======= -->
  @component('components.footer')
  @endcomponent

<script>
let carrinho = [];
let produtoAtual = null;

document.addEventListener('DOMContentLoaded', function() {
    const modalProdutosElement = document.getElementById('modalProdutos');
    const confirmacaoModalElement = document.getElementById('confirmacaoModal');
    window.modalProdutosInstance = bootstrap.Modal.getOrCreateInstance(modalProdutosElement);
    window.confirmacaoModalInstance = bootstrap.Modal.getOrCreateInstance(confirmacaoModalElement);

    // Permitir busca por Enter
    document.getElementById('codigoProduto').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            buscarProduto();
        }
    });
});

window.buscarProduto = function() {
    const codigo = document.getElementById('codigoProduto').value.trim();
    if (!codigo) {
        alert('Digite um código ou nome de produto');
        return;
    }

    fetch('{{ route("pdv.buscar-produto") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ codigo: codigo })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            produtoAtual = data.produto;
            document.getElementById('nomeProduto').textContent = data.produto.nome;
            document.getElementById('codigoProdutoResultado').textContent = data.produto.codigo;
            document.getElementById('precoProduto').textContent = parseFloat(data.produto.preco).toFixed(2).replace('.', ',');
            document.getElementById('resultadoBusca').style.display = 'block';
        } else {
            alert(data.message || 'Produto não encontrado');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao buscar produto');
    });
}

window.adicionarAoCarrinho = function() {
    if (!produtoAtual) {
        alert('Nenhum produto selecionado');
        return;
    }

    const quantidade = parseInt(document.getElementById('quantidadeProduto').value);
    if (quantidade <= 0) {
        alert('Quantidade deve ser maior que zero');
        return;
    }

    // Verificar se o produto já está no carrinho
    const index = carrinho.findIndex(item => item.produto_id === produtoAtual.id);
    if (index !== -1) {
        carrinho[index].quantidade += quantidade;
        carrinho[index].subtotal = carrinho[index].quantidade * carrinho[index].preco_unitario;
    } else {
        carrinho.push({
            produto_id: produtoAtual.id,
            nome: produtoAtual.nome,
            codigo: produtoAtual.codigo,
            quantidade: quantidade,
            preco_unitario: parseFloat(produtoAtual.preco),
            subtotal: quantidade * parseFloat(produtoAtual.preco)
        });
    }

    atualizarCarrinho();
    limparBusca();
}

window.selecionarProduto = function(id, codigo, nome, preco) {
    produtoAtual = { id: id, codigo: codigo, nome: nome, preco: preco };
    document.getElementById('nomeProduto').textContent = nome;
    document.getElementById('codigoProdutoResultado').textContent = codigo;
    document.getElementById('precoProduto').textContent = parseFloat(preco).toFixed(2).replace('.', ',');
    document.getElementById('resultadoBusca').style.display = 'block';
    window.modalProdutosInstance.hide();
}

window.atualizarCarrinho = function() {
    const tbody = document.getElementById('carrinhoItens');
    tbody.innerHTML = '';

    carrinho.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.nome} (${item.codigo})</td>
            <td>
                <input type="number" class="form-control form-control-sm" style="width: 80px" 
                       value="${item.quantidade}" min="1" 
                       onchange="alterarQuantidade(${index}, this.value)">
            </td>
            <td>R$ ${item.preco_unitario.toFixed(2).replace('.', ',')}</td>
            <td>R$ ${item.subtotal.toFixed(2).replace('.', ',')}</td>
            <td>
                <button class="btn btn-sm btn-danger" onclick="removerItem(${index})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });

    const total = carrinho.reduce((sum, item) => sum + item.subtotal, 0);
    document.getElementById('totalCarrinho').textContent = total.toFixed(2).replace('.', ',');
}

window.alterarQuantidade = function(index, quantidade) {
    quantidade = parseInt(quantidade);
    if (quantidade <= 0) {
        removerItem(index);
        return;
    }

    carrinho[index].quantidade = quantidade;
    carrinho[index].subtotal = quantidade * carrinho[index].preco_unitario;
    atualizarCarrinho();
}

window.removerItem = function(index) {
    carrinho.splice(index, 1);
    atualizarCarrinho();
}

window.limparCarrinho = function() {
    if (confirm('Tem certeza que deseja limpar o carrinho?')) {
        carrinho = [];
        atualizarCarrinho();
    }
}

window.limparBusca = function() {
    document.getElementById('codigoProduto').value = '';
    document.getElementById('resultadoBusca').style.display = 'none';
    produtoAtual = null;
}

window.abrirModalProdutos = function() {
    window.modalProdutosInstance.show();
}

window.finalizarVenda = function() {
    if (carrinho.length === 0) {
        alert('Adicione produtos ao carrinho antes de finalizar a venda');
        return;
    }

    const tipoPagamentoId = document.getElementById('tipo_pagamento_id').value;
    if (!tipoPagamentoId) {
        alert('Selecione uma forma de pagamento');
        return;
    }

    const clienteId = document.getElementById('cliente_id').value;
    const observacoes = document.getElementById('observacoes').value;
    const total = carrinho.reduce((sum, item) => sum + item.subtotal, 0);

    // Mostrar resumo da venda
    const clienteNome = document.getElementById('cliente_id').selectedOptions[0].text;
    const tipoPagamentoNome = document.getElementById('tipo_pagamento_id').selectedOptions[0].text;
    
    const resumo = `
        <div class="alert alert-info">
            <strong>Cliente:</strong> ${clienteNome}<br>
            <strong>Forma de Pagamento:</strong> ${tipoPagamentoNome}<br>
            <strong>Total:</strong> R$ ${total.toFixed(2).replace('.', ',')}<br>
            <strong>Itens:</strong> ${carrinho.length}
        </div>
    `;
    document.getElementById('resumoVenda').innerHTML = resumo;
    window.confirmacaoModalInstance.show();
}

window.confirmarVenda = function() {
    const clienteId = document.getElementById('cliente_id').value;
    const tipoPagamentoId = document.getElementById('tipo_pagamento_id').value;
    const observacoes = document.getElementById('observacoes').value;
    const total = carrinho.reduce((sum, item) => sum + item.subtotal, 0);

    const dadosVenda = {
        cliente_id: clienteId || null,
        tipo_pagamento_id: tipoPagamentoId,
        observacoes: observacoes,
        itens: carrinho,
        total: total
    };

    fetch('{{ route("pdv.finalizar-venda") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(dadosVenda)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Venda finalizada com sucesso! ID: ' + data.venda_id);
            carrinho = [];
            atualizarCarrinho();
            document.getElementById('cliente_id').value = '';
            document.getElementById('tipo_pagamento_id').value = '';
            document.getElementById('observacoes').value = '';
            window.confirmacaoModalInstance.hide();
        } else {
            alert(data.message || 'Erro ao finalizar venda');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao finalizar venda');
    });
}
</script> 