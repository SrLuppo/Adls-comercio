<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>   
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="collapse navbar-collapse" id="navbar">
                <a href="/" class="navbar-brand">
                    <img src="" alt="Imagem exemplo">
                </a>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="/" class="nav-link">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a href="/events/create" class="nav-link">Criar Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a href="/" class="nav-link">Entrar</a>
                    </li>
                    <li class="nav-item">
                        <a href="/" class="nav-link">Cadastrar</a>
                    </li>
                </ul>
            </div>

        </nav>                    
    </header>
   <main>
       <div class="container-fluid">
           <div class="row">
               @if (session('msg'))
                   <p class="msg">{{ session('msg') }}</p>
               @endif
               @yield('content')
           </div>
       </div>
   </main>
   <div class="container">
    <form>
        <div class="form-group">
          <label for="exampleInputEmail1">Endereço de email</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Seu email">
          <small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Senha</label>
          <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha">
        </div>
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Clique em mim</label>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
      </form>
      
 </div>
  <div class="container">
    <form>
        <div class="form-group">
          <label for="formGroupExampleInput">Label exemplo</label>
          <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Input exemplo">
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput2">Outra label</label>
          <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Outro input">
        </div>
      </form>   
      <form>
  </div>
    <div class="container">
    <div class="row">
      <div class="col">
        <input type="text" class="form-control" placeholder="Nome">
      </div>
      <div class="col">
        <input type="text" class="form-control" placeholder="Sobrenome">
      </div>
    </div>
  </form>
</div> 

</body>


<footer>
    <p>ADLS DEVELOPER &copy; 2022</p>
</footer>

</html>
