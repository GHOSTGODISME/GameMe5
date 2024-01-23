<style>
.half_logo{
width:80%;
height:100%;
background: linear-gradient(to right, #00C6FF, #0082FF, #0072FF);
display: flex;
justify-content: center;
align-items: center;
}

.logo_big{
width:600px;

}

@media only screen and (max-width: 768px) {
    .half_logo {
        height: 100vh; /* Adjust height for smaller screens */
        width:100vw;
        min-height:250px;
        max-height:250px;
    }

    .logo_big {
        max-width: 50%; /* Allow the logo to take up the full width of the container */
    }
    .logo_con{
        display: flex;
        justify-content: center;
        align-items: center;
    }

}

</style>
<div class = half_logo>
<div class="logo_con">
<img class=logo_big src = "img/logo_big.png" alt=logo/>
</div>
</div>