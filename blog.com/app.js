//Going to try to rewrite this as seperate .vue files soon
Vue.use(VueRouter);
function cookieParse(cookie_raw) {
  let pat = /auth=([a-zA-Z0-9]+);?/;
  if (cookie_raw.match(pat)) {
    return cookie_raw.match(pat)[1];
  }
  else {
    return "";
  }
}
let Blog = {
  data: function() {
    return {
      title: '',
      content: '',
      cookie: cookieParse(document.cookie)
    }
  },
  template: `
  <div class="create-post">
  <h2 class="create-head">Create a post</h2>
  <form @submit.prevent="submit" class="create-form">

    <input class='create-title create-body' name="title" v-model='title' placeholder="Title" >
    <textarea rows = 20 class='create-content create-body' name='content' placeholder="Write your post here" v-model="content"></textarea>
    <button class='form-submit create-submit create-body' type="submit">Post</button>
  </form>
  </div>
  `,
  methods: {
    handle: function(res) {
      if (res == "success") {
        window.location.href = "/";
      }
      else {
        window.location.href = "/#/login";
      }
    },
    submit() {
      axios.post('http://localhost:8000/api/posts/make',this.$data).then(res => (this.handle(res)));
    }
  }
}
let Create = {
  data: function() {
    return {
      firstName: '',
      lastName: '',
      username: '',
      password: '',
      email: '',
      errors: ''
    }
  },
  template: `
  <div class='form-box'>
    <h1 class="header">Create Account</h1>
    <form @submit.prevent="submit" class="form-form">
      <p class='form-errors'>{{errors}}</p>

      <p class='form-label'>First Name</p>
      <input name = "firstName" v-model='firstName' class='form-input' placeholder="Enter your first name">

      <p class='form-label'>Last Name</p>
      <input name = "lastName" v-model='lastName' class='form-input' placeholder="Enter your last name">

      <p class='form-label'>Username</p>
      <input name = "username" v-model='username' class='form-input' placeholder="Enter your desired username" required>

      <p class='form-label'>Password</p>
      <input name = "password" v-model='password' class='form-input' placeholder="Enter your password" type="password" required>

      <p class='form-label'>Email</p>
      <input name = "email" v-model='email' class='form-input' placeholder="Enter your email" type = "email">

      <p></p><button class="form-submit">Submit</button>
    </form>
  </div>
  `,
  methods: {
    updateErrors: function(res) {
      if (!res.match(/too long/) && !res.match(/taken/)) { //This is sorta ugly but its easy so...
        document.cookie = "auth="+res;
        alert("Account created!");
        window.location.href = '/#/blog';
      }
      else {
        this.errors=res;
        this.firstName='';
        this.lastName='';
        this.email='';
        this.username='';
        this.password='';
      }
    },
    submit() {
      axios.post('http://localhost:8000/api/create',this.$data)
      .then(response => (this.updateErrors(response)));
    }
  }

}
let Home = {
data: function() {
    return {
      posts: [
        {
          username: '',
          time: '',
          title:'',
          content: ''
        }
      ],
      cookie: cookieParse(document.cookie)
    }
  },
  template: `
  <div class='home-box'>
    <!-- <ul>
      <li v-for="post in posts">{{post}}</li>
    </ul> -->
    <div class='post-box' v-for="post in posts">
    <p class='post-username'>{{post.username}}</p>
    <p class='post-time'>{{post.time}}</p>
    <h2 class='post-title'>{{post.title}}</h2>
    <p class='post-content'>{{post.content}}</p>
    </div>
  </div>
  `,
  mounted() {
    axios.get('http://localhost:8000/api/posts/get').then(response => (this.posts = response));
  }
};
let Login = {
  data: function() {
  return {
    username: '',
    password: '',
    errors: ''
  }
  },
  template: `
    <div class='form-box'>

    <h1 class="header">Login</h1>
    <form @submit.prevent="submit" class="form-form">
      <p class="form-errors">{{errors}}</p>
      <p class="form-label">Username</p>
      <input name="username" v-model=username class="form-input" placeholder="Enter your username" required>
      <p class="form-label">Password</p>
      <input name="password" v-model=password class="form-input" type = "password" placeholder="Enter your password" required>
      <p></p><button class="form-submit">Submit</button>
    </form>
    <a class = "create-link"><router-link to="/create">Create Account</router-link></a>
    </div>
  `,
  methods: {
    updateErrors: function(res) {
      if (res!="Incorrect username" && res!="Incorrect password") {document.cookie = "auth="+res;alert("Login successsful!");window.location.href="/";}
      else {
        this.errors=res;
        this.username='';
        this.password='';
      }
    },
    submit() {
      axios.post('http://localhost:8000/api/login',this.$data).then(response => (this.updateErrors(response)));
    }
  }
}
const NotFound = {
  template: `<div>
  <p>Page not found<p>
  <p>Try reloading the page or click <a href=/>here</a> to go home</p>
  </div>`
}

const routes = [
  { path: '/', component: Home},
  { path: '/blog', component: Blog},
  { path: '/create', component: Create},
  { path: '/login', component: Login},
  { path: '/*', component: NotFound}
]

const router = new VueRouter({
  routes
})


const app = new Vue({
  el:"#app",
  router,
  data: function() {
    return {
      loading: false,
      cookie: cookieParse(document.cookie),
      ver: null
    }
  },
  methods: {
    logout: function() {
      document.cookie = "auth=";
      alert("logged out");
      this.ver = false;
      location.reload();
    }
  },
  mounted() {
    axios.post('http://localhost:8000/api/ver',{cookie: cookieParse(document.cookie)}).then(res => (this.ver = res));
  }
}).$mount('#app')
