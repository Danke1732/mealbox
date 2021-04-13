<header class="fixed-top p-md-3 p-sm-1 px-md-4 bg-white border-bottom shadow-sm">
  <div class="d-md-flex flex-md-row align-items-center text-center">
    <h2 class="my-0 mr-md-auto font-weight-normal">MealBox</h2>
    <nav class="my-2 my-md-0 mr-md-3">
      <a class="p-2 text-dark" href="#">マイページ</a>
      @if (false == session()->get("admin_auth"))
        <a class="btn btn-outline-primary ml-1" href="{{ route('admin.showLogin') }}">管理者ページ</a>
      @endif
      @if (Auth::check())
        <a class="btn btn-outline-primary ml-2" href="{{ route('home') }}">商品一覧</a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline-block ml-1">
        @csrf
          <button class="btn btn-outline-primary">ログアウト</button>
        </form>
      @else
        <a class="btn btn-outline-primary ml-1" href="/">一般ログイン</a>
        <a class="btn btn-outline-primary ml-1" href="{{ route('signup.show') }}">会員登録</a>
      @endif
    </nav>
  </div>
</header>