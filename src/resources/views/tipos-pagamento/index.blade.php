@extends('layout')

@section('content')
  @component('components.menu-home')
  @endcomponent

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Tipos de Pagamento</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/index">Home</a></li>
          <li class="breadcrumb-item active">Tipos de Pagamento</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title">Lista de Tipos de Pagamento</h5>
                <button type="button" class="btn btn-primary" onclick="limparFormulario()">
                  <i class="bi bi-plus-circle"></i> Novo Tipo de Pagamento
                </button>
              </div>

              @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ session('error') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Descrição</th>
                      <th>Status</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tiposPagamento as $tipo)
                      <tr>
                        <td>{{ $tipo->id }}</td>
                        <td>{{ $tipo->nome }}</td>
                        <td>{{ $tipo->descricao ?? '-' }}</td>
                        <td>
                          @if($tipo->status == 'Ativo')
                            <span class="badge bg-success">{{ $tipo->status }}</span>
                          @else
                            <span class="badge bg-warning">{{ $tipo->status }}</span>
                          @endif
                        </td>
                        <td>
                          <button class="btn btn-sm btn-primary" onclick="editarTipoPagamento({{ $tipo->id }}, '{{ $tipo->nome }}', '{{ $tipo->descricao ?? '' }}', '{{ $tipo->status }}')">
                            <i class="bi bi-pencil"></i>
                          </button>
                          <button class="btn btn-sm btn-danger" onclick="excluirTipoPagamento({{ $tipo->id }}, '{{ $tipo->nome }}')">
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

  <!-- Modal Tipo de Pagamento -->
  <div class="modal fade" id="tipoPagamentoModal" tabindex="-1" aria-labelledby="tipoPagamentoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tipoPagamentoModalLabel">Novo Tipo de Pagamento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="tipoPagamentoForm" method="POST">
          @csrf
          <div class="modal-body">
            <input type="hidden" id="tipo_pagamento_id">
            <div class="mb-3">
              <label for="nome" class="form-label">Nome *</label>
              <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
              <label for="descricao" class="form-label">Descrição</label>
              <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select class="form-select" id="status" name="status">
                <option value="Ativo">Ativo</option>
                <option value="Inativo">Inativo</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" id="btnSalvarTipoPagamento">Salvar</button>
          </div>
        </form>
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
          <p>Tem certeza que deseja excluir o tipo de pagamento "<span id="tipoPagamentoNome"></span>"?</p>
          <p class="text-danger"><small>Esta ação não pode ser desfeita.</small></p>
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
    let tipoPagamentoIdParaExcluir = null;
    const tipoPagamentoModalElement = document.getElementById('tipoPagamentoModal');
    const confirmacaoModalElement = document.getElementById('confirmacaoModal');
    const tipoPagamentoModalInstance = bootstrap.Modal.getOrCreateInstance(tipoPagamentoModalElement);
    const confirmacaoModalInstance = bootstrap.Modal.getOrCreateInstance(confirmacaoModalElement);

    window.limparFormulario = function() {
        document.getElementById('tipoPagamentoForm').reset();
        document.getElementById('tipo_pagamento_id').value = '';
        document.getElementById('tipoPagamentoModalLabel').textContent = 'Novo Tipo de Pagamento';
        document.getElementById('btnSalvarTipoPagamento').textContent = 'Salvar';
        tipoPagamentoModalInstance.show();
    }

    window.editarTipoPagamento = function(id, nome, descricao, status) {
        document.getElementById('tipo_pagamento_id').value = id;
        document.getElementById('nome').value = nome;
        document.getElementById('descricao').value = descricao;
        document.getElementById('status').value = status;
        document.getElementById('tipoPagamentoModalLabel').textContent = `Editar Tipo de Pagamento (ID: ${id})`;
        document.getElementById('btnSalvarTipoPagamento').textContent = 'Atualizar';
        tipoPagamentoModalInstance.show();
    }

    window.excluirTipoPagamento = function(id, nome) {
        tipoPagamentoIdParaExcluir = id;
        document.getElementById('tipoPagamentoNome').textContent = nome;
        confirmacaoModalInstance.show();
    }

    window.confirmarExclusao = function() {
        if (tipoPagamentoIdParaExcluir) {
            fetch(`/tipos-pagamento/${tipoPagamentoIdParaExcluir}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Erro ao excluir tipo de pagamento');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao excluir tipo de pagamento');
            });
            confirmacaoModalInstance.hide();
            tipoPagamentoIdParaExcluir = null;
        }
    }

    document.getElementById('tipoPagamentoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('tipo_pagamento_id').value;
        const form = document.getElementById('tipoPagamentoForm');
        const formData = new FormData(form);
        let url, method;
        if (id) {
            url = `/tipos-pagamento/${id}`;
            method = 'POST';
            formData.append('_method', 'PATCH');
        } else {
            url = '/tipos-pagamento';
            method = 'POST';
        }
        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                tipoPagamentoModalInstance.hide();
                setTimeout(() => window.location.reload(), 200);
            } else {
                alert('Erro ao salvar tipo de pagamento');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao salvar tipo de pagamento: ' + error.message);
        });
    });
});
</script> 