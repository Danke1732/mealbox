<header class="d-flex flex-column flex-md-row fixed-top align-items-center p-3 px-md-4 bg-white border-bottom shadow-sm">
  <h2 class="my-0 mr-md-auto font-weight-normal">MealBox</h2>
  <nav class="my-2 my-md-0 mr-md-3">
    <a class="p-2 text-dark" href="#">マイページ</a>
  </nav>
  @if (false == session()->get("admin_auth"))
    <a class="btn btn-outline-primary" href="{{ route('admin.showLogin') }}">管理者ページ</a>
  @endif
  @if (Auth::check())
    <a class="btn btn-outline-primary ml-3" href="{{ route('home') }}">商品一覧</a>
    <form action="{{ route('logout') }}" method="POST" >
    @csrf
    <button class="btn btn-outline-primary ml-3">ログアウト</button>
  </form>
  @else
    <a class="btn btn-outline-primary ml-3" href="/">一般ログイン</a>
    <a class="btn btn-outline-primary ml-3" href="{{ route('signup.show') }}">会員登録</a>
  @endif
</header>