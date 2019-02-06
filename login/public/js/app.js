Vue.component('create-post', {
  data: function() {
    return {
      title: '',
      content: ''
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
    submit() {
      axios.post('/blog/make',this.$data);

      window.location.href = '/';
    }
  }
});
Vue.component('login-box', {
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
    <a href = "/create" class = "create-link">Create Account</a>
    </div>
  `,
  methods: {
    updateErrors: function(res) {
      if (res=="Incorrect username or password") {
        this.errors=res;
        this.username='';
        this.password='';
      }
      else window.location.href = '/profile';
    },
    submit() {
      axios.post('/login',this.$data)
      .then(response => (this.updateErrors(response.data)));
    }
  }
});
Vue.component('home-box', {
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
      info: {
        username: null
      }
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
    axios.get('/posts/get').then(response => (this.posts = response["data"]));
  }
});
Vue.component('create-account', {
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
      if (res=='success!') {
        window.location.href = '/profile';
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
      axios.post('/create',this.$data)
      .then(response => (this.updateErrors(response.data)));
    }
  }
});

let app=new Vue({
  el:"#app",
  data: function() {
    return {
      loading: false
    }
  }
});
