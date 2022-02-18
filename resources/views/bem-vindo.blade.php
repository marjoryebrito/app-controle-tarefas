<h1>Site da aplicação</h1>
<hr>

@auth
    <h2>Usuário autenticado:</h2>
    <p>ID: {{Auth::user()->id}}</p> 
    <p>Name: {{Auth::user()->name}}</p> 
    <p>E-mail: {{Auth::user()->email}}</p> 
@endauth

@guest
    <h2> Bem-vindo!</h2>
@endguest