@extends('layout')

@section('content')
  @component('components.menu-home')
  @endcomponent

 <main id="main" class="main">
    <div class="pagetitle">
      <h1>Clientes</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/index">Home</a></li>
          <li class="breadcrumb-item active">Clientes</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Gerenciamento de Clientes</h5>
              <p>Lista de todos os clientes cadastrados no sistema.</p>
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6>Total de Clientes: <span class="badge bg-primary">{{ $clientes->count() }}</span></h6>
                <button type="button" class="btn btn-primary" onclick="limparFormulario()">
                  <i class="bi bi-plus-circle"></i> Novo Cliente
                </button>
              </div>
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Email</th>
                      <th>Telefone</th>
                      <th>Rua</th>
                      <th>Número</th>
                      <th>Bairro</th>
                      <th>CPF</th>
                      <th>Referência</th>
                      <th>Status</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($clientes as $cliente)
                    <tr>
                      <td>{{ $cliente->id }}</td>
                      <td>{{ $cliente->nome }}</td>
                      <td>{{ $cliente->email }}</td>
                      <td>{{ $cliente->telefone }}</td>
                      <td>{{ $cliente->rua }}</td>
                      <td>{{ $cliente->numero }}</td>
                      <td>{{ $cliente->bairro }}</td>
                      <td>{{ $cliente->cpf }}</td>
                      <td>{{ $cliente->referencia }}</td>
                      <td>
                        @if($cliente->status == 'Ativo')
                          <span class="badge bg-success">{{ $cliente->status }}</span>
                        @else
                          <span class="badge bg-warning">{{ $cliente->status }}</span>
                        @endif
                      </td>
                      <td>
                        <button class="btn btn-sm btn-primary" onclick="editarCliente({{ $cliente->id }}, '{{ $cliente->nome }}', '{{ $cliente->email }}', '{{ $cliente->telefone }}', '{{ $cliente->status }}', '{{ $cliente->rua }}', '{{ $cliente->numero }}', '{{ $cliente->bairro }}', '{{ $cliente->cpf }}', '{{ $cliente->referencia }}')">
                          <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="excluirCliente({{ $cliente->id }}, '{{ $cliente->nome }}')">
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

  <!-- Modal Cliente -->
  <div class="modal fade" id="clienteModal" tabindex="-1" aria-labelledby="clienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="clienteModalLabel">Novo Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="clienteForm" method="POST">
          @csrf
          <div class="modal-body">
            <input type="hidden" id="cliente_id">
            <div class="mb-3">
              <label for="nome" class="form-label">Nome *</label>
              <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
              <label for="telefone" class="form-label">Telefone</label>
              <input type="text" class="form-control" id="telefone" name="telefone">
            </div>
            <div class="mb-3">
              <label for="rua" class="form-label">Rua</label>
              <input type="text" class="form-control" id="rua" name="rua">
            </div>
            <div class="mb-3">
              <label for="numero" class="form-label">Número</label>
              <input type="text" class="form-control" id="numero" name="numero">
            </div>
            <div class="mb-3">
              <label for="bairro" class="form-label">Bairro</label>
              <input type="text" class="form-control" id="bairro" name="bairro">
            </div>
            <div class="mb-3">
              <label for="cpf" class="form-label">CPF</label>
              <input type="text" class="form-control" id="cpf" name="cpf">
            </div>
            <div class="mb-3">
              <label for="referencia" class="form-label">Referência</label>
              <input type="text" class="form-control" id="referencia" name="referencia">
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
            <button type="submit" class="btn btn-primary" id="btnSalvarCliente">Salvar</button>
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
          <p>Tem certeza que deseja excluir o cliente "<span id="clienteNome"></span>"?</p>
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
    let clienteIdParaExcluir = null;
    const clienteModalElement = document.getElementById('clienteModal');
    const confirmacaoModalElement = document.getElementById('confirmacaoModal');
    const clienteModalInstance = bootstrap.Modal.getOrCreateInstance(clienteModalElement);
    const confirmacaoModalInstance = bootstrap.Modal.getOrCreateInstance(confirmacaoModalElement);

    window.limparFormulario = function() {
        document.getElementById('clienteForm').reset();
        document.getElementById('cliente_id').value = '';
        document.getElementById('clienteModalLabel').textContent = 'Novo Cliente';
        document.getElementById('btnSalvarCliente').textContent = 'Salvar';
        clienteModalInstance.show();
    }

    window.editarCliente = function(id, nome, email, telefone, status, rua, numero, bairro, cpf, referencia) {
        document.getElementById('cliente_id').value = id;
        document.getElementById('nome').value = nome;
        document.getElementById('email').value = email;
        document.getElementById('telefone').value = telefone;
        document.getElementById('rua').value = rua;
        document.getElementById('numero').value = numero;
        document.getElementById('bairro').value = bairro;
        document.getElementById('cpf').value = cpf;
        document.getElementById('referencia').value = referencia;
        document.getElementById('status').value = status;
        document.getElementById('clienteModalLabel').textContent = `Editar Cliente (ID: ${id})`;
        document.getElementById('btnSalvarCliente').textContent = 'Atualizar';
        clienteModalInstance.show();
    }

    window.excluirCliente = function(id, nome) {
        clienteIdParaExcluir = id;
        document.getElementById('clienteNome').textContent = nome;
        confirmacaoModalInstance.show();
    }

    window.confirmarExclusao = function() {
        if (clienteIdParaExcluir) {
            fetch(`/clientes/${clienteIdParaExcluir}`, {
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
                    alert('Erro ao excluir cliente');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao excluir cliente');
            });
            confirmacaoModalInstance.hide();
            clienteIdParaExcluir = null;
        }
    }

    document.getElementById('clienteForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('cliente_id').value;
        const form = document.getElementById('clienteForm');
        const formData = new FormData(form);
        let url, method;
        if (id) {
            url = `/clientes/${id}`;
            method = 'POST';
            formData.append('_method', 'PATCH');
        } else {
            url = '/clientes';
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
                clienteModalInstance.hide();
                setTimeout(() => window.location.reload(), 200);
            } else {
                alert('Erro ao salvar cliente');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao salvar cliente: ' + error.message);
        });
    });
});
</script> 