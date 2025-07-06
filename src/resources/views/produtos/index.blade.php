@extends('layout')

@section('content')
  @component('components.menu-home')
  @endcomponent

 <main id="main" class="main">

    <div class="pagetitle">
      <h1>Produtos</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/index">Home</a></li>
          <li class="breadcrumb-item active">Produtos</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    
  <section class="section dashboard">

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Gerenciamento de Produtos</h5>
            <p>Lista de todos os produtos cadastrados no sistema.</p>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6>Total de Produtos: <span class="badge bg-primary">{{ $produtos->count() }}</span></h6>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#produtoModal" onclick="limparFormulario()">
                <i class="bi bi-plus-circle"></i> Novo Produto
              </button>
            </div>

            <!-- Tabela de produtos -->
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Classificação</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Smartphone Galaxy S21</td>
                    <td>Eletrônicos</td>
                    <td>Premium</td>
                    <td>R$ 2.999,00</td>
                    <td><span class="badge bg-success">Ativo</span></td>
                    <td>
                      <button class="btn btn-sm btn-primary" onclick="editarProduto(1, 'Smartphone Galaxy S21', 'Eletrônicos', 'Premium', '2999.00', 'Ativo')">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" onclick="excluirProduto(1, 'Smartphone Galaxy S21')">
                        <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Camiseta Básica</td>
                    <td>Vestuário</td>
                    <td>Standard</td>
                    <td>R$ 49,90</td>
                    <td><span class="badge bg-success">Ativo</span></td>
                    <td>
                      <button class="btn btn-sm btn-primary" onclick="editarProduto(2, 'Camiseta Básica', 'Vestuário', 'Standard', '49.90', 'Ativo')">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" onclick="excluirProduto(2, 'Camiseta Básica')">
                        <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Vaso de Plástico</td>
                    <td>Casa e Jardim</td>
                    <td>Econômico</td>
                    <td>R$ 15,50</td>
                    <td><span class="badge bg-success">Ativo</span></td>
                    <td>
                      <button class="btn btn-sm btn-primary" onclick="editarProduto(3, 'Vaso de Plástico', 'Casa e Jardim', 'Econômico', '15.50', 'Ativo')">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" onclick="excluirProduto(3, 'Vaso de Plástico')">
                        <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Notebook Dell Inspiron</td>
                    <td>Eletrônicos</td>
                    <td>Premium</td>
                    <td>R$ 4.500,00</td>
                    <td><span class="badge bg-warning">Inativo</span></td>
                    <td>
                      <button class="btn btn-sm btn-primary" onclick="editarProduto(4, 'Notebook Dell Inspiron', 'Eletrônicos', 'Premium', '4500.00', 'Inativo')">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" onclick="excluirProduto(4, 'Notebook Dell Inspiron')">
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

  <!-- Modal Produto -->
  <div class="modal fade" id="produtoModal" tabindex="-1" aria-labelledby="produtoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="produtoModalLabel">Novo Produto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="produtoForm" method="POST">
          @csrf
          <div class="modal-body">
            <input type="hidden" id="produto_id" name="id">
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="nome" class="form-label">Nome *</label>
                  <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="categoria" class="form-label">Categoria *</label>
                  <select class="form-select" id="categoria" name="categoria" required>
                    <option value="">Selecione uma categoria</option>
                    <option value="Eletrônicos">Eletrônicos</option>
                    <option value="Vestuário">Vestuário</option>
                    <option value="Casa e Jardim">Casa e Jardim</option>
                  </select>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="classificacao" class="form-label">Classificação *</label>
                  <select class="form-select" id="classificacao" name="classificacao" required>
                    <option value="">Selecione uma classificação</option>
                    <option value="Premium">Premium</option>
                    <option value="Standard">Standard</option>
                    <option value="Econômico">Econômico</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="preco" class="form-label">Preço *</label>
                  <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input type="number" class="form-control" id="preco" name="preco" step="0.01" min="0" required>
                  </div>
                </div>
              </div>
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
            <button type="submit" class="btn btn-primary" id="btnSalvarProduto">Salvar</button>
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
          <p>Tem certeza que deseja excluir o produto "<span id="produtoNome"></span>"?</p>
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
    let produtoIdParaExcluir = null;
    const produtoModalElement = document.getElementById('produtoModal');
    const confirmacaoModalElement = document.getElementById('confirmacaoModal');
    const produtoModalInstance = bootstrap.Modal.getOrCreateInstance(produtoModalElement);
    const confirmacaoModalInstance = bootstrap.Modal.getOrCreateInstance(confirmacaoModalElement);

    window.limparFormulario = function() {
        document.getElementById('produtoForm').reset();
        document.getElementById('produto_id').value = '';
        document.getElementById('produtoModalLabel').textContent = 'Novo Produto';
        document.getElementById('btnSalvarProduto').textContent = 'Salvar';
        produtoModalInstance.show();
    }

    window.editarProduto = function(id, nome, categoria, classificacao, preco, status) {
        document.getElementById('produto_id').value = id;
        document.getElementById('nome').value = nome;
        document.getElementById('categoria').value = categoria;
        document.getElementById('classificacao').value = classificacao;
        document.getElementById('preco').value = preco;
        document.getElementById('status').value = status;
        document.getElementById('produtoModalLabel').textContent = `Editar Produto (ID: ${id})`;
        document.getElementById('btnSalvarProduto').textContent = 'Atualizar';
        produtoModalInstance.show();
    }

    window.excluirProduto = function(id, nome) {
        produtoIdParaExcluir = id;
        document.getElementById('produtoNome').textContent = nome;
        confirmacaoModalInstance.show();
    }

    window.confirmarExclusao = function() {
        if (produtoIdParaExcluir) {
            fetch(`/produtos/${produtoIdParaExcluir}`, {
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
                    alert('Erro ao excluir produto');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao excluir produto');
            });
            confirmacaoModalInstance.hide();
            produtoIdParaExcluir = null;
        }
    }

    document.getElementById('produtoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('produto_id').value;
        const form = document.getElementById('produtoForm');
        const formData = new FormData(form);
        let url, method;
        if (id) {
            url = `/produtos/${id}`;
            method = 'POST';
            formData.append('_method', 'PATCH');
        } else {
            url = '/produtos';
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
                produtoModalInstance.hide();
                setTimeout(() => window.location.reload(), 200);
            } else {
                alert('Erro ao salvar produto');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao salvar produto: ' + error.message);
        });
    });
});
</script> 