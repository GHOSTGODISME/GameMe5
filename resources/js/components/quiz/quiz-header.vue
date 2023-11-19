<template>
    <div class="header-container">
        <img src="img/logo_header.png" alt="Logo">
        <span class="header-quiz-title">Basic Math</span>
        <a class="header-setting"><i class="fa-solid fa-gear"></i></a>
    </div>
</template>

<script>
export default{

}
</script>


<style>
    .header-container {
        width: 100%;
        height: 100px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(to right, #00C6FF, #0082FF, #0072FF);
        color: white;
        padding: 30px;
        flex-wrap: wrap;
    }

    .header-quiz-title {
        font-weight: bold;
        font-size: 32px;
    }

    .header-setting {
        font-size: 24px;
        color: white;
    }
</style>