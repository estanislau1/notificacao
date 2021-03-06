@include('Default.head')

<body class="fundo">
    @include('Default.header')
    
    <div class="container" >
        <div class="card card-container">
            <!--<img class="profile-img-card" src="{{ asset("theme/images/logo_caixa_ceptibr.png") }}" alt="" /> -->
            <center><img src="{{ asset("theme/images/logo_caixa_ceptibr.png") }}" alt="" /></center>
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" enctype="multipart/form-data" action='{{ url("/inicio")}}' method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <span id="reauth-email" class="reauth-email"></span>
                <input name="user" type="text" id="inputEmail" class="form-control" placeholder="Matrícula" required autofocus>
                <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Senha" required>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Entrar!</button>
            </form><!-- /form -->
        @if ($status == 'negado')
        <div class="alert alert-danger center text-center" style="font-size: 14px;"> <strong>Credenciais Inválidas!</strong></div>
        @endif
        @if ($status == 'expirado')
        <div class="alert alert-danger center text-center" style="font-size: 14px;"> <strong>Sessão Expirada!</strong></div>
        @endif
        
        </div><!-- /card-container -->
        
    </div><!-- /container -->

</body>
<html></html>
