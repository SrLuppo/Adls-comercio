@extends('layout')

@section('content')
  @component('components.menu-home')
  @endcomponent

 <main id="main" class="main">
    <div class="pagetitle">
      <h1>Visualizar Vendas</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/index">Home</a></li>
          <li class="breadcrumb-item active">Vendas</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Histórico de Vendas</h5>
              <p>Lista de todas as vendas realizadas no sistema.</p>
              
              @if(session('error'))
                <div class="alert alert-danger">
                  {{ session('error') }}
                </div>
              @endif
              
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6>Total de Vendas: <span class="badge bg-primary">{{ $vendas->count() }}</span></h6>
              </div>

              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Data/Hora</th>
                      <th>Cliente</th>
                      <th>Vendedor</th>
                      <th>Forma Pagamento</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($vendas as $venda)
                    <tr>
                      <td>{{ $venda->id }}</td>
                      <td>{{ $venda->created_at->format('d/m/Y H:i') }}</td>
                      <td>{{ $venda->cliente ? $venda->cliente->nome : 'Cliente não encontrado' }}</td>
                      <td>{{ $venda->usuario ? $venda->usuario->name : 'Usuário não encontrado' }}</td>
                      <td>{{ $venda->tipoPagamento ? $venda->tipoPagamento->nome : 'Não informado' }}</td>
                      <td>R$ {{ number_format($venda->total, 2, ',', '.') }}</td>
                      <td>
                        @if($venda->status == 'Concluida')
                          <span class="badge bg-success">{{ $venda->status }}</span>
                        @else
                          <span class="badge bg-warning">{{ $venda->status }}</span>
                        @endif
                      </td>
                      <td>
                        <button class="btn btn-sm btn-info" onclick="visualizarVenda({{ $venda->id }})">
                          <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="excluirVenda({{ $venda->id }}, '{{ $venda->cliente ? $venda->cliente->nome : 'Cliente não encontrado' }}')">
                          <i class="bi bi-trash"></i>
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
    </section>
  </main>

  <!-- Modal Visualizar Venda -->
  <div class="modal fade" id="vendaModal" tabindex="-1" aria-labelledby="vendaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="vendaModalLabel">Detalhes da Venda</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="vendaModalBody">
          <!-- Conteúdo será carregado via AJAX -->
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de Confirmação de Exclusão -->
  <div class="modal fade" id="confirmacaoModal" tabindex="-1" aria-labelledby="confirmacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmacaoModalLabel">Confirmar Exclusão</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Tem certeza que deseja excluir a venda do cliente "<span id="clienteNome"></span>"?</p>
          <p class="text-danger"><small>Esta ação não pode ser desfeita e requer senha de administrador.</small></p>
          
          <div class="mb-3">
            <label for="senha_admin" class="form-label">Senha de Administrador *</label>
            <input type="password" class="form-control" id="senha_admin" placeholder="Digite a senha de administrador">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger" onclick="confirmarExclusao()">Excluir</button>
        </div>
      </div>
    </div>
  </div>
@endsection

  <!-- ======= Footer ======= -->
  @component('components.footer')
  @endcomponent

<script>
document.addEventListener('DOMContentLoaded', function() {
    let vendaIdParaExcluir = null;
    const vendaModalElement = document.getElementById('vendaModal');
    const confirmacaoModalElement = document.getElementById('confirmacaoModal');
    const vendaModalInstance = bootstrap.Modal.getOrCreateInstance(vendaModalElement);
    const confirmacaoModalInstance = bootstrap.Modal.getOrCreateInstance(confirmacaoModalElement);

    window.visualizarVenda = function(id) {
        fetch(`/vendas/${id}`)
        .then(response => response.json())
        .then(data => {
            const modalBody = document.getElementById('vendaModalBody');
            modalBody.innerHTML = `
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Cliente:</strong> ${data.cliente ? data.cliente.nome : 'Cliente não encontrado'}<br>
                        <strong>Vendedor:</strong> ${data.usuario ? data.usuario.name : 'Usuário não encontrado'}<br>
                        <strong>Data:</strong> ${new Date(data.created_at).toLocaleString('pt-BR')}
                    </div>
                    <div class="col-md-6">
                        <strong>Forma de Pagamento:</strong> ${data.tipo_pagamento ? data.tipo_pagamento.nome : 'Não informado'}<br>
                        <strong>Status:</strong> ${data.status}<br>
                        <strong>Total:</strong> R$ ${parseFloat(data.total).toFixed(2).replace('.', ',')}
                    </div>
                </div>
                
                ${data.observacoes ? `<div class="mb-3"><strong>Observações:</strong><br>${data.observacoes}</div>` : ''}
                
                <h6>Itens da Venda:</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Preço Unit.</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.itens.map(item => `
                                <tr>
                                    <td>${item.produto ? item.produto.nome + ' (' + item.produto.codigo + ')' : 'Produto não encontrado'}</td>
                                    <td>${item.quantidade}</td>
                                    <td>R$ ${parseFloat(item.preco_unitario).toFixed(2).replace('.', ',')}</td>
                                    <td>R$ ${parseFloat(item.subtotal).toFixed(2).replace('.', ',')}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `;
            vendaModalInstance.show();
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao carregar detalhes da venda');
        });
    }

    window.excluirVenda = function(id, clienteNome) {
        vendaIdParaExcluir = id;
        document.getElementById('clienteNome').textContent = clienteNome;
        document.getElementById('senha_admin').value = '';
        confirmacaoModalInstance.show();
    }

    window.confirmarExclusao = function() {
        const senhaAdmin = document.getElementById('senha_admin').value;
        if (!senhaAdmin) {
            alert('Digite a senha de administrador');
            return;
        }

        if (vendaIdParaExcluir) {
            fetch(`/vendas/${vendaIdParaExcluir}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ senha_admin: senhaAdmin })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message || 'Erro ao excluir venda');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao excluir venda');
            });
            confirmacaoModalInstance.hide();
            vendaIdParaExcluir = null;
        }
    }
});
</script> 