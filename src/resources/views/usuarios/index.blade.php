@extends('layout')

@section('content')
  @component('components.menu-home')
  @endcomponent

 <main id="main" class="main">

    <div class="pagetitle">
      <h1>Usuários</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/index">Home</a></li>
          <li class="breadcrumb-item active">Usuários</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    
  <section class="section dashboard">

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Gerenciamento de Usuários</h5>
            <p>Lista de todos os usuários cadastrados no sistema.</p>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6>Total de Usuários: <span class="badge bg-primary">{{ $usuarios->count() }}</span></h6>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#usuarioModal" onclick="limparFormulario()">
                <i class="bi bi-plus-circle"></i> Novo Usuário
              </button>
            </div>

            <!-- Tabela de usuários -->
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Perfil</th>
                    <th>Status</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>João Silva</td>
                    <td>joao@email.com</td>
                    <td><span class="badge bg-primary">Administrador</span></td>
                    <td><span class="badge bg-success">Ativo</span></td>
                    <td>
                      <button class="btn btn-sm btn-primary" onclick="editarUsuario(1, 'João Silva', 'joao@email.com', 'Administrador', 'Ativo')">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" onclick="excluirUsuario(1, 'João Silva')">
                        <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Maria Santos</td>
                    <td>maria@email.com</td>
                    <td><span class="badge bg-info">Vendedor</span></td>
                    <td><span class="badge bg-success">Ativo</span></td>
                    <td>
                      <button class="btn btn-sm btn-primary" onclick="editarUsuario(2, 'Maria Santos', 'maria@email.com', 'Vendedor', 'Ativo')">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" onclick="excluirUsuario(2, 'Maria Santos')">
                        <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Pedro Costa</td>
                    <td>pedro@email.com</td>
                    <td><span class="badge bg-secondary">Estoquista</span></td>
                    <td><span class="badge bg-warning">Inativo</span></td>
                    <td>
                      <button class="btn btn-sm btn-primary" onclick="editarUsuario(3, 'Pedro Costa', 'pedro@email.com', 'Estoquista', 'Inativo')">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" onclick="excluirUsuario(3, 'Pedro Costa')">
                        <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>

  </section>

  </main><!-- End #main -->

  <!-- Modal Usuário -->
  <div class="modal fade" id="usuarioModal" tabindex="-1" aria-labelledby="usuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="usuarioModalLabel">Novo Usuário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="usuarioForm" method="POST">
          @csrf
          <div class="modal-body">
            <input type="hidden" id="usuario_id" name="id">
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="nome" class="form-label">Nome Completo *</label>
                  <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="email" class="form-label">Email *</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="senha" class="form-label">Senha *</label>
                  <input type="password" class="form-control" id="senha" name="senha">
                  <small class="form-text text-muted">Deixe em branco para manter a senha atual (ao editar)</small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="confirmar_senha" class="form-label">Confirmar Senha</label>
                  <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="perfil" class="form-label">Perfil *</label>
                  <select class="form-select" id="perfil" name="perfil" required>
                    <option value="">Selecione um perfil</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Vendedor">Vendedor</option>
                    <option value="Estoquista">Estoquista</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-select" id="status" name="status">
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                  </select>
                </div>
              </div>
            </div>
            
            <div class="mb-3">
              <label for="observacoes" class="form-label">Observações</label>
              <textarea class="form-control" id="observacoes" name="observacoes" rows="3"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" id="btnSalvarUsuario">Salvar</button>
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
          <p>Tem certeza que deseja excluir o usuário "<span id="usuarioNome"></span>"?</p>
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
    let usuarioIdParaExcluir = null;
    const usuarioModalElement = document.getElementById('usuarioModal');
    const confirmacaoModalElement = document.getElementById('confirmacaoModal');
    const usuarioModalInstance = bootstrap.Modal.getOrCreateInstance(usuarioModalElement);
    const confirmacaoModalInstance = bootstrap.Modal.getOrCreateInstance(confirmacaoModalElement);

    window.limparFormulario = function() {
        document.getElementById('usuarioForm').reset();
        document.getElementById('usuario_id').value = '';
        document.getElementById('usuarioModalLabel').textContent = 'Novo Usuário';
        document.getElementById('btnSalvarUsuario').textContent = 'Salvar';
        document.getElementById('senha').required = true;
        document.getElementById('confirmar_senha').required = true;
        usuarioModalInstance.show();
    }

    window.editarUsuario = function(id, nome, email, perfil, status) {
        document.getElementById('usuario_id').value = id;
        document.getElementById('nome').value = nome;
        document.getElementById('email').value = email;
        document.getElementById('perfil').value = perfil;
        document.getElementById('status').value = status;
        document.getElementById('usuarioModalLabel').textContent = `Editar Usuário (ID: ${id})`;
        document.getElementById('btnSalvarUsuario').textContent = 'Atualizar';
        document.getElementById('senha').required = false;
        document.getElementById('confirmar_senha').required = false;
        usuarioModalInstance.show();
    }

    window.excluirUsuario = function(id, nome) {
        usuarioIdParaExcluir = id;
        document.getElementById('usuarioNome').textContent = nome;
        confirmacaoModalInstance.show();
    }

    window.confirmarExclusao = function() {
        if (usuarioIdParaExcluir) {
            fetch(`/usuarios/${usuarioIdParaExcluir}`, {
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
                    alert('Erro ao excluir usuário');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao excluir usuário');
            });
            confirmacaoModalInstance.hide();
            usuarioIdParaExcluir = null;
        }
    }

    document.getElementById('usuarioForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('usuario_id').value;
        const form = document.getElementById('usuarioForm');
        const formData = new FormData(form);
        let url, method;
        if (id) {
            url = `/usuarios/${id}`;
            method = 'POST';
            formData.append('_method', 'PATCH');
        } else {
            url = '/usuarios';
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
                usuarioModalInstance.hide();
                setTimeout(() => window.location.reload(), 200);
            } else {
                alert('Erro ao salvar usuário');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao salvar usuário: ' + error.message);
        });
    });
});
</script> 