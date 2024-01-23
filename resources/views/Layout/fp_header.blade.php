<style>
.fp_header{
    width:100%;
    height:100px;
    background: linear-gradient(to right, #00C6FF, #0082FF, #0072FF);
    display: flex;
    align-content: center;

}    

.logo{
    width: 180px;
    height: 50px;
    flex-shrink: 0;
    margin-top:25px;
    margin-left:50px;
}



</style>
<div class="fp_header">
    <a href="{{ route('login') }}">
        <img class="logo" src="{{ asset('img/logo_header.png') }}" alt="Logo">
    </a>
</div>