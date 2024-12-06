<script src="https://cdn.jsdelivr.net/npm/vue-burger-menu@2.0.3/dist/vue-burger-menu.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>

<style>
    .bm-menu {
    background-color: purple !important;
    display: flex;
    flex-direction: column;
    height: 100vh; /* 画面全体の高さを確保（必要に応じて調整） */
}

.bm-item-list {
    display: flex;
    flex-direction: column;
    flex: 1; /* 高さを埋める */
    /* 他のスタイルがあれば残す */
}

.bm-item-list > * {
    display: flex;
    text-decoration: none;
    padding: 0.7em;
    color: #fff;
}

.logout-link {
    margin-top: auto; /* これによりログアウトリンクが下部に固定される */
    margin-bottom: 85px;
}

</style>

<div id="app">
        <div id="sidebar">
            <component :is="id">
            <a id="home" href="{{ route('index') }}">
                <span>Home</span>
            </a>
            <a id="about" href="{{ route('calendar') }}">
                <span>カレンダー</span>
            </a>
            <a id="contact" href="{{ route('balance') }}">
                <span>月間収支</span>
            </a>
            <a id="contact" href="{{ route('combined.meter') }}">
                <span>貯金・使用限度確認</span>
            </a>
            <a id="contact" href="{{ route('setting.index') }}">
                <span>設定</span>
            </a>
            
            <a id="" class="logout-link" href="{{ route('logout') }}">
                <span>ログアウト</span>
            </a>

            <!-- <div class="logout-link"> -->
                <!-- <div>
                    <a id="home" href="{{ route('index') }}">
                        <span>Home</span>
                    </a>
                    <a id="about" href="{{ route('calendar') }}">
                        <span>カレンダー</span>
                    </a>
                    <a id="contact" href="{{ route('balance') }}">
                        <span>月間収支</span>
                    </a>
                    <a id="contact" href="{{ route('setting.index') }}">
                        <span>設定</span>
                    </a>
                </div>
                <div>
                    <a id="" href="{{ route('logout') }}">
                        <span>ログアウト</span>
                    </a>
                </div> -->
            <!-- </div> -->
            </component>
        </div>
</div>

<script>
    const {
    Bubble,
    Elastic,
    FallDown,
    Push,
    PushRotate,
    Reveal,
    ScaleDown,
    ScaleRotate,
    Slide,
    Stack
    } = window['vue-burger-menu'];

    Vue.component('slide', Slide);
    Vue.component('bubble', Bubble);
    Vue.component('fall-down', FallDown);
    Vue.component('push', Push);
    Vue.component('push-rotate', PushRotate);
    Vue.component('reveal', Reveal);
    Vue.component('scale-down', ScaleDown);
    Vue.component('scale-rotate', ScaleRotate);
    Vue.component('stack', Stack);
    Vue.component('elastic', Elastic);

    let app = new Vue({
    el: '#app',
    data: {
        id: 'push'
    },
    methods: {
        onChange: function(id){
        this.id = id;
        }
    }
    });
</script>