<link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
<script src="https://cdn.jsdelivr.net/npm/vue-burger-menu@2.0.3/dist/vue-burger-menu.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>

<div id="app">
        <div id="sidebar">
            <component :is="id">
            <a id="home" href="#">
                <span>Home</span>
            </a>
            <a id="about" href="#">
                <span>About</span>
            </a>
            <a id="contact" href="#">
                <span>Contact</span>
            </a>
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
        id: 'stack'
    },
    methods: {
        onChange: function(id){
        this.id = id;
        }
    }
    });
</script>