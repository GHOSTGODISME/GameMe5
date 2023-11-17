<style>
.header {
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    background: var(--Base, linear-gradient(90deg, #00C6FF 0%, #0082FF 80.73%, #0072FF 100%));
    width: 100%;

}

.header-small-block-style {
    border-radius: 10px;
    background: #55677B;
    display: block;
    padding: 10px 25px;
    color: white;
    font-size: 20px;
    margin-right: 20px;
    display: inline-block;
}

.header-quiz-title {
    font-weight: bold;
    font-size: 32px;
    color: white;
    margin: auto;
}

.header-time-remaining {
    color: white;
    font-size: 24px;
    display: inline-flex;
    text-align: right;

}

.header-setting {
    font-size: 24px;
    color: white;
    margin-left: auto;
}
</style>

<div class="header">
    <div>
        <div class="header-small-block-style">
            <i class="fa-solid fa-ranking-star"></i>
            <span class="ranking-text">1st</span>
        </div>

        <div class="header-small-block-style">
            <span class="num-ques-remaining">1/2</span>
        </div>
    </div>

    <div class="header-quiz-title">
        Basic Math
    </div>

    <div class="header-time-remaining">
        0:20
    </div>

    <div class="header-setting">
        <i class="fa-solid fa-gear"></i>
    </div>
</div>

