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
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 40 41" fill="none">
                <g clip-path="url(#clip0_608_359)">
                    <path
                        d="M0.320312 3.9043C0.109375 3.5918 0 3.2168 0 2.8418C0 1.7793 0.859375 0.919922 1.92188 0.919922H10.4609C11.3359 0.919922 12.1563 1.38086 12.6016 2.13086L17.9531 11.0449C14.1875 11.5215 10.8203 13.2793 8.3125 15.8809L0.320312 3.9043ZM39.6719 3.9043L31.6875 15.8809C29.1797 13.2793 25.8125 11.5215 22.0469 11.0449L27.3984 2.13086C27.8516 1.38086 28.6641 0.919922 29.5391 0.919922H38.0781C39.1406 0.919922 40 1.7793 40 2.8418C40 3.2168 39.8906 3.5918 39.6797 3.9043H39.6719ZM6.25 27.1699C6.25 23.5232 7.69866 20.0258 10.2773 17.4472C12.8559 14.8686 16.3533 13.4199 20 13.4199C23.6467 13.4199 27.1441 14.8686 29.7227 17.4472C32.3013 20.0258 33.75 23.5232 33.75 27.1699C33.75 30.8166 32.3013 34.314 29.7227 36.8926C27.1441 39.4713 23.6467 40.9199 20 40.9199C16.3533 40.9199 12.8559 39.4713 10.2773 36.8926C7.69866 34.314 6.25 30.8166 6.25 27.1699ZM20.6562 19.7559C20.3906 19.209 19.6172 19.209 19.3438 19.7559L17.5937 23.3027C17.4844 23.5215 17.2812 23.6699 17.0469 23.7012L13.125 24.2715C12.5234 24.3574 12.2891 25.0918 12.7188 25.5215L15.5547 28.2871C15.7266 28.459 15.8047 28.6934 15.7656 28.9355L15.0937 32.834C14.9922 33.4277 15.6172 33.8887 16.1563 33.6074L19.6563 31.7637C19.8672 31.6543 20.125 31.6543 20.3359 31.7637L23.8359 33.6074C24.375 33.8887 25 33.4355 24.8984 32.834L24.2266 28.9355C24.1875 28.7012 24.2656 28.459 24.4375 28.2871L27.2734 25.5215C27.7109 25.0996 27.4687 24.3652 26.8672 24.2715L22.9531 23.7012C22.7187 23.6699 22.5078 23.5137 22.4062 23.3027L20.6562 19.7559Z"
                        fill="white" />
                </g>
                <defs>
                    <clipPath id="clip0_608_359">
                        <rect width="40" height="40" fill="white" transform="translate(0 0.919922)" />
                    </clipPath>
                </defs>
            </svg>
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

