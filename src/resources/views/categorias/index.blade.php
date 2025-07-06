@extends('layout')

@section('content')
  @component('components.menu-home')
  @endcomponent

 <main id="main" class="main">

    <div class="pagetitle">
      <h1>Categorias</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/index">Home</a></li>
          <li class="breadcrumb-item active">Categorias</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    
  <section class="section dashboard">

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Gerenciamento de Categorias</h5>
            <p>Lista de todas as categorias cadastradas no sistema.</p>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6>Total de Categorias: <span class="badge bg-primary">{{ $categorias->count() }}</span></h6>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoriaModal" onclick="limparFormulario()">
                <i class="bi bi-plus-circle"></i> Nova Categoria
              </button>
            </div>

            <!-- Tabela de categorias -->
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
                <tbody id="categoriasTableBody">
                  @foreach($categorias as $categoria)
                  <tr>
                    <td>{{ $categoria->id }}</td>
                    <td>{{ $categoria->nome }}</td>
                    <td>{{ $categoria->descricao }}</td>
                    <td>
                      @if($categoria->status == 'Ativo')
                        <span class="badge bg-success">{{ $categoria->status }}</span>
                      @else
                        <span class="badge bg-warning">{{ $categoria->status }}</span>
                      @endif
                    </td>
                    <td>
                      <button class="btn btn-sm btn-primary" onclick="editarCategoria({{ $categoria->id }}, '{{ $categoria->nome }}', '{{ $categoria->descricao }}', '{{ $categoria->status }}')">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" onclick="excluirCategoria({{ $categoria->id }}, '{{ $categoria->nome }}')">
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

  <!-- Modal Categoria -->
  <div class="modal fade" id="categoriaModal" tabindex="-1" aria-labelledby="categoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="categoriaModalLabel">Nova Categoria</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="categoriaForm" method="POST">
          @csrf
          <div class="modal-body">
            <input type="hidden" id="categoria_id">
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
            <button type="submit" class="btn btn-primary" id="btnSalvarCategoria">Salvar</button>
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
          <p>Tem certeza que deseja excluir a categoria "<span id="categoriaNome"></span>"?</p>
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
    let categoriaIdParaExcluir = null;
    const categoriaModalElement = document.getElementById('categoriaModal');
    const confirmacaoModalElement = document.getElementById('confirmacaoModal');
    const categoriaModalInstance = bootstrap.Modal.getOrCreateInstance(categoriaModalElement);
    const confirmacaoModalInstance = bootstrap.Modal.getOrCreateInstance(confirmacaoModalElement);

    window.limparFormulario = function() {
        document.getElementById('categoriaForm').reset();
        document.getElementById('categoria_id').value = '';
        document.getElementById('categoriaModalLabel').textContent = 'Nova Categoria';
        document.getElementById('btnSalvarCategoria').textContent = 'Salvar';
        categoriaModalInstance.show();
    }

    window.editarCategoria = function(id, nome, descricao, status) {
        document.getElementById('categoria_id').value = id;
        document.getElementById('nome').value = nome;
        document.getElementById('descricao').value = descricao;
        document.getElementById('status').value = status;
        document.getElementById('categoriaModalLabel').textContent = `Editar Categoria (ID: ${id})`;
        document.getElementById('btnSalvarCategoria').textContent = 'Atualizar';
        categoriaModalInstance.show();
    }

    window.excluirCategoria = function(id, nome) {
        categoriaIdParaExcluir = id;
        document.getElementById('categoriaNome').textContent = nome;
        confirmacaoModalInstance.show();
    }

    window.confirmarExclusao = function() {
        if (categoriaIdParaExcluir) {
            fetch(`/categorias/${categoriaIdParaExcluir}`, {
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
                    alert('Erro ao excluir categoria');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao excluir categoria');
            });
            confirmacaoModalInstance.hide();
            categoriaIdParaExcluir = null;
        }
    }

    document.getElementById('categoriaForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('categoria_id').value;
        const form = document.getElementById('categoriaForm');
        const formData = new FormData(form);
        let url, method;
        if (id) {
            url = `/categorias/${id}`;
            method = 'POST';
            formData.append('_method', 'PATCH');
        } else {
            url = '/categorias';
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
                categoriaModalInstance.hide();
                setTimeout(() => window.location.reload(), 200);
            } else {
                alert('Erro ao salvar categoria');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao salvar categoria: ' + error.message);
        });
    });
});
</script> 