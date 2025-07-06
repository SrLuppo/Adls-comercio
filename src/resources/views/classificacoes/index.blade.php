@extends('layout')

@section('content')
  @component('components.menu-home')
  @endcomponent

 <main id="main" class="main">

    <div class="pagetitle">
      <h1>Classificações</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/index">Home</a></li>
          <li class="breadcrumb-item active">Classificações</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    
  <section class="section dashboard">

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Gerenciamento de Classificações</h5>
            <p>Lista de todas as classificações cadastradas no sistema.</p>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6>Total de Classificações: <span class="badge bg-primary">{{ $classificacoes->count() }}</span></h6>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#classificacaoModal" onclick="limparFormulario()">
                <i class="bi bi-plus-circle"></i> Nova Classificação
              </button>
            </div>

            <!-- Tabela de classificações -->
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
                <tbody id="classificacoesTableBody">
                  @foreach($classificacoes as $classificacao)
                  <tr>
                    <td>{{ $classificacao->id }}</td>
                    <td>{{ $classificacao->nome }}</td>
                    <td>{{ $classificacao->descricao }}</td>
                    <td>
                      @if($classificacao->status == 'Ativo')
                        <span class="badge bg-success">{{ $classificacao->status }}</span>
                      @else
                        <span class="badge bg-warning">{{ $classificacao->status }}</span>
                      @endif
                    </td>
                    <td>
                      <button class="btn btn-sm btn-primary" onclick="editarClassificacao({{ $classificacao->id }}, '{{ $classificacao->nome }}', '{{ $classificacao->descricao }}', '{{ $classificacao->status }}')">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" onclick="excluirClassificacao({{ $classificacao->id }}, '{{ $classificacao->nome }}')">
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

  </main><!-- End #main -->

  <!-- Modal Classificação -->
  <div class="modal fade" id="classificacaoModal" tabindex="-1" aria-labelledby="classificacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="classificacaoModalLabel">Nova Classificação</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="classificacaoForm" method="POST">
          @csrf
          <div class="modal-body">
            <input type="hidden" id="classificacao_id">
            
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
            <button type="submit" class="btn btn-primary" id="btnSalvarClassificacao">Salvar</button>
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
          <p>Tem certeza que deseja excluir a classificação "<span id="classificacaoNome"></span>"?</p>
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
    let classificacaoIdParaExcluir = null;
    const classificacaoModalElement = document.getElementById('classificacaoModal');
    const confirmacaoModalElement = document.getElementById('confirmacaoModal');
    const classificacaoModalInstance = bootstrap.Modal.getOrCreateInstance(classificacaoModalElement);
    const confirmacaoModalInstance = bootstrap.Modal.getOrCreateInstance(confirmacaoModalElement);

    window.limparFormulario = function() {
        document.getElementById('classificacaoForm').reset();
        document.getElementById('classificacao_id').value = '';
        document.getElementById('classificacaoModalLabel').textContent = 'Nova Classificação';
        document.getElementById('btnSalvarClassificacao').textContent = 'Salvar';
        classificacaoModalInstance.show();
    }

    window.editarClassificacao = function(id, nome, descricao, status) {
        document.getElementById('classificacao_id').value = id;
        document.getElementById('nome').value = nome;
        document.getElementById('descricao').value = descricao;
        document.getElementById('status').value = status;
        document.getElementById('classificacaoModalLabel').textContent = `Editar Classificação (ID: ${id})`;
        document.getElementById('btnSalvarClassificacao').textContent = 'Atualizar';
        classificacaoModalInstance.show();
    }

    window.excluirClassificacao = function(id, nome) {
        classificacaoIdParaExcluir = id;
        document.getElementById('classificacaoNome').textContent = nome;
        confirmacaoModalInstance.show();
    }

    window.confirmarExclusao = function() {
        if (classificacaoIdParaExcluir) {
            fetch(`/classificacoes/${classificacaoIdParaExcluir}`, {
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
                    alert('Erro ao excluir classificação');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao excluir classificação');
            });
            confirmacaoModalInstance.hide();
            classificacaoIdParaExcluir = null;
        }
    }

    document.getElementById('classificacaoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('classificacao_id').value;
        const form = document.getElementById('classificacaoForm');
        const formData = new FormData(form);
        let url, method;
        if (id) {
            url = `/classificacoes/${id}`;
            method = 'POST';
            formData.append('_method', 'PATCH');
        } else {
            url = '/classificacoes';
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
                classificacaoModalInstance.hide();
                setTimeout(() => window.location.reload(), 200);
            } else {
                alert('Erro ao salvar classificação');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao salvar classificação: ' + error.message);
        });
    });
});
</script> 