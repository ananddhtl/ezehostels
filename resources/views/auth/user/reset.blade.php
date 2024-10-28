@extends('front.layouts.master')
@section('css')
<style>
.register{
    background: -webkit-linear-gradient(left, #f00, #ff6262);
    
    padding: 3%;
    
}
.register-left{
    text-align: center;
    color: #fff;
    margin-top: 4%;
}
.register-left input{
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    width: 60%;
    background: #f8f9fa;
    font-weight: bold;
    color: #383d41;
    margin-top: 30%;
    margin-bottom: 3%;
    cursor: pointer;
}
.register-right{
    background: #f8f9fa;
    border-top-left-radius: 10% 50%;
    border-bottom-left-radius: 10% 50%;
}
.register-left img{
    margin-top: 15%;
    margin-bottom: 5%;
    width: 25%;
    -webkit-animation: mover 2s infinite  alternate;
    animation: mover 1s infinite  alternate;
}
@-webkit-keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
@keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
.register-left p{
    font-weight: lighter;
    padding: 12%;
    margin-top: -9%;
}
.register .register-form{
    padding: 10% 10% 5% 10%;
    
    
   
    /* background-color: #f8f9fa;
    border-radius: 10%;
    width: 100%;
    margin-left: 5px; */
     
}
.btnRegister{
    float: right;
    margin-top: 10%;
    border: none;
    padding: 2%;
    background: #f00;
    color: #fff;
    font-weight: 600;
    width: 50%;
    cursor: pointer;
}
.register .nav-tabs{
    margin-top: 3%;
    border: none;
    background: #0062cc;
    border-radius: 1.5rem;
    width: 28%;
    float: right;
}
.register .nav-tabs .nav-link{
    padding: 2%;
    height: 34px;
    font-weight: 600;
    color: #fff;
    border-top-right-radius: 1.5rem;
    border-bottom-right-radius: 1.5rem;
}
.register .nav-tabs .nav-link:hover{
    border: none;
}
.register .nav-tabs .nav-link.active{
    width: 100px;
    color: #0062cc;
    border: 2px solid #0062cc;
    border-top-left-radius: 1.5rem;
    border-bottom-left-radius: 1.5rem;
}
.register-heading{
    text-align: center;
    margin-top: 8%;
    margin-bottom: -15%;
    color: #495057;
}
.log-btn{
    border: none;
    padding: 2%;
    width: 60%;
    background: #1c1c1c;
    font-weight: bold;
    color: #fff;
    margin-top: 22%;
    margin-bottom: 3%;
    cursor: pointer;
}
a.registerasvendor{
    text-decoration: none;
    color: #0062cc;
}
</style>
@endsection
@section('content')
<div class="main-content">
<div class="container-fluid register">
    <div class="row">
        <div class="col-md-3 register-left">
            <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
            <h3>Welcome</h3>
            <p>Already Have Account?</p>
            <a class="btn  log-btn" href="{{ route('login') }}" >Login </a><br/>
        </div>
        <div class="col-md-9 register-right">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="row register-form">
                <div class="col-md-8 offset-md-2">
                   
                    <div class="form-group">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" placeholder="Your Email *" />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"  value="{{ old('password') }}"  autocomplete="password" placeholder="Password *" name="password" />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control"  placeholder="Confirm Password *" name="password_confirmation" />
                    </div>
                    <input type="submit" class="btnRegister"  value="Reset Password"/>
                    
                    
                    
                </div>
                
            </div>
        </form>
        </div>
    </div>
</div>
</div>
@endsection
@section('js')
<script>
$(document).ready(function(){
    $('input[name="registerasvendor]').on('click', function (e) {
        e.preventDefault();
        if( $('input[name="registerasvendor"]').is(':checked') ){
            alert('hello');
        });
    });
});
</script>
@endsection