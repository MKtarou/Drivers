<script src="https://cdn.jsdelivr.net/npm/vue-burger-menu@2.0.3/dist/vue-burger-menu.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>

<style>
    #app {
    padding-top:0px;
    padding-left:0px;
  }

/* button {
    float:left;
    height: 100px;
    width: 18%;
    margin: 3px;
    background-color: #62caaa;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    border: 2px solid #fff;
    font-size: 20px;
    border-radius: 10px;
  } */

.active {
outline: dashed red;
}

.bm-menu {
    background-color: purple !important;
}

#logout {
    display: block;
    margin-top: 20px;
    text-align: center;
    padding: 10px;
    background-color: #dc3545;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}

#logout:hover {
    background-color: #c82333;
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
            <a id="contact" href="{{ route('setting.index') }}">
                <span>設定</span>
            </a>
            <div style="margin-top: auto; padding: 10px;">
                <a id="logout" href="{{ route('logout') }}" class="btn btn-danger btn-block">
                    ログアウト
                </a>
            </div>
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